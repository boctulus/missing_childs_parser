Estimados: ya les voy a decir como quedan los grupos pero pueden comenzar con haciendo las vistas.

Los campos que van a recibir de la API son:

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

Descripción de los campos:

fullname: nombre completo
file_url: url de la imágen
data_missing: fecha en de la desaparición
age_photo:	años de edad en la foto
location: array asociativo con la localización de donde fue la desaparición o bien lugar de residencia
ori_data: dominio del sitio orígen donde está la ficha de la persona desaparecida
ori_id: el id de la persona desaparecida en el sitio orígen
found: boolean que nos dice si la persona fue encontrada.
extras: array asociativo con campos extras que pudieran recuperarse.

Ejemplo:

fullname  		MILAGROS DE LOS ANGELES NUNEZ
file_url  		http://www.missingchildren.org.ar
				/imagench/nunezmilagrodelosangeles1.jpg
date_missing  	2009-12-17
age_photo  		2
location  		Escobar, Buenos Aires					 
ori_data  		missingchildren.org.ar
ori_id  		395
found  			false
extras 			

La duración del Hackaton va a ser de laxa, no se preocupen.

Sitios de referencia independientemente del país con el que vayan a trabajar son:

http://www.missingchildren.org.ar/listado.php?categoria=perdidos
https://www.argentina.gob.ar/seguridad/personasextraviadas