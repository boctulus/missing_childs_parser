<?php declare( strict_types = 1 );

include 'libs/Debug.php';
include 'libs/Strings.php';
include 'libs/Date.php';
include 'libs/Logger.php';
include 'MissingPerson.php';

if (php_sapi_name() != 'cli'){
    logger("App solo de terminal", 1);
}

$id = $argv[1] ?? null;

if ($id === null){
    logger("Id es requerido", 1);    
}

Logger::setFile("log.txt");
Logger::setTimestamp("D M d 'y h.i A");


$html = trim(file_get_contents('http://www.missingchildren.org.ar/datos.php?action=view&id='.$id));

// Record not found
if ($html == 'No ha sido encontrada la persona en la base de datos'){
    exit(127);
}


libxml_use_internal_errors(true);

function logger(string $msg, $exit = false){
    Logger::putLog($msg);

    if ($exit){
        die;
    }
}

function get_year_diff(string $date_ini, string $date_end = null){
    $ini = new DateTime($date_ini); // formato: aaaa-mm-dd
    $fin = new DateTime($date_end); // now

    $intervalo = $ini->diff($fin);
    $ys_diff = floor($intervalo->format('%a') / 365);

    return $ys_diff;
}


$doc = new DOMDocument();
$doc->loadHTML('<?xml encoding="UTF-8">' . $html);


$textos = [];
$imgsrc = null;

$tb = null;
$tables = $doc->getElementsByTagName('table');
foreach($tables as $table) {
    $content = $doc->saveHTML($table);

    if (preg_match('/ id[ ]*=[ ]*["|\']table5["|\']/', $content)){
        //dd($content);
        $rows = $table->getElementsByTagName('tr');
        foreach ($rows as $rix => $row) {
            $cols = $row->getElementsByTagName('td');

            if ($rix == 0) {
                # Busco imágenes
                $imgtags = $cols[0]->getElementsByTagName('img');
                
                if ($imgtags->length != 1){
                    logger("Id $id - Número inesperado de imágenes", 1);
                }

               $imgsrc = trim($imgtags->item(0)->getAttribute('src'));
               $imgsrc = 'http://www.missingchildren.org.ar/' . $imgsrc;
           }

            foreach ($cols as $col) {
                $text = trim($col->textContent);
                $text = str_replace(["\t",  json_decode('"'."\u00a0".'"')], ['', ''],$text);
                $textos[] = $text;                
            }            
        }
        break;
    }
}


// Record not found
if (count($textos) < 17){
    exit(127);
}

/*
foreach ($textos as $i => $tx) {
    dd($tx, "TEXTO $i");
}
*/

$found = false;

if (Strings::endsWith(' FUE ENCONTRADA', $textos[3])){
    Strings::replace(' FUE ENCONTRADA', '', $textos[3]);
    $found = true;
}

if (Strings::endsWith('bandera.jpg', $imgsrc)){
    $imgsrc = null;
    $found  = true;
}


function debug(Array $data){
    foreach ($data as $key => $dato) {
        if (is_bool($dato)){
            $dato = ($dato === false ? 'false' : 'true');
        }

        echo "$key  $dato\r\n";
    }
}


// Datos extraidos (más o menos crudos)

try {
    $fullname   = Strings::matchOrFail($textos[3], '/([a-z ]{3,})/i', 'Nombre no encontado');
    $fromdate   = Date::extract_date($textos[5]);
    $age_photo  = Strings::match($textos[8],'/([0-9]{1,2}) años/',  'Edad en la foto no encontrada');
    $age_now    = Strings::match($textos[10],'/([0-9]{1,2}) años/', 'Edad actual no encontrada');
    $location   = $textos[16];
} catch (Exception $e){
    logger("Id $id - ". $e->getMessage());
    exit;
}
    

// Reacomodo datos como deben presentarse a la interfaz

$person     = new MissingPerson();
$person->fullname        = $fullname;
$person->file_url        = $imgsrc; 
$person->date_missing    = $fromdate  ?? null;
$person->age_photo       = $age_photo ?? null;
$person->location        = $location  ?? null;
$person->ori_data        = 'missingchildren.org.ar';
$person->ori_id          = $id;   
$person->found           = $found ?? false;
$person->extras          = [];  // empty JSON


// Genero respuesta

$data = $person->getData();
echo json_encode($data);

