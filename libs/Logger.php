<?php

/*
	https://github.com/thielicious/Logger
*/
class Logger {
    static private
        $file,
        $timestamp;

    public static function setFile($filename) {
        self::$file = $filename;
    }

    public static function setTimestamp($format) {
        self::$timestamp = date($format)." ~ ";
    }

    public static function putLog($insert) {
        if (isset(self::$timestamp)) {
            file_put_contents(self::$file, self::$timestamp.$insert. PHP_EOL, FILE_APPEND);
        } else {
            trigger_error("Timestamp not set", E_USER_ERROR);
        }
    }

    public static function getLog() {
        $content = file_get_contents(self::$file);
        return $content;
    }

}