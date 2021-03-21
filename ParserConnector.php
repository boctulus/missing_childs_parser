<?php

class ParserConnector implements IParser
{
	private $callbacks = [];

	static function countPages() : int {

	}

    static function getPage() : mixed {

    }

    static function getRecord() : mixed {

    }

    static function register(string $method, callback $fn){
    	if (!in_array($method, ['countPages', 'getPage', 'getRecord'])){
    		throw new Exception("Method $method is invalid", 1);  
    	}

    	$callbacks[$method] = $fn; 
    }
}