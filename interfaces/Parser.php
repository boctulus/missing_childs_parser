<?php

interface IParser {
	static function countPages() : int;

    static function getPage() : mixed;

    static function getRecord() : mixed;
}