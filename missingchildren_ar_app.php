<?php

include "debug.php";
include "interfaces/Parser.php";

class MissingChildrenArgentina implements IParser
{
    static function countPages() : int {
    	// no está paginada en este caso particular
    	return 1;		
    }

    static function getPage() : mixed {
    	return null;
    }

    static function getRecord() : mixed {
    	return null;
    }
}