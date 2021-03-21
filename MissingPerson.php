<?php declare( strict_types = 1 );

/*
	Interfaz para el parser

	Notar que hay una propiedad file_url
	en vez de file_id y no hay id porque
	el id sería el asignado a posteriori

	En cambio ori_data y ori_id son se 
	refieren al dominio y al id de la 
	persona buscada o sea son fragmentos
	de la url del sitio scrapeado.
*/
class MissingPerson {
	const props = [
		'fullname',
		'file_url',
		'age_photo',
		'date_missing',
		'age_missing',
		'location',
		'ori_data',
		'ori_id',
		'found',
		'extras'
	];

	private $data = array();

	public function __set($name, $value)
    {
    	if (!in_array($name, static::props)){ 
    		throw new InvalidArgumentException("Property $name is invalid", 1);
    	}

        $this->data[$name] = $value;
    }

    public function __get($name)
    {
    	return $this->data[$name];
    }

    public function getData(){
    	return $this->data;
    }
}