<?php

class Date 
{
    static function get_month_num(string  $m){
        $m = strtolower(substr($m, 0, 3));

        switch ($m) {
            case 'ene':
                $ret = 1;
                break;
            case 'feb':
                $ret = 2;
                break;
            case 'mar':
                $ret = 3;
                break; 
            case 'abr':
                $ret = 4;
                break;
            case 'may':
                $ret = 5;
                break;
            case 'jun':
                $ret = 6;
                break;
            case 'jul':
                $ret = 7;
                break;
            case 'ago':
                $ret = 8;
                break;       
            case 'sep':
                $ret = 9;
            case 'set':
                $ret = 9;
                break;
            case 'oct':
                $ret = 10;
                break;    
            case 'nov':
                $ret = 11;
                break;
            case 'dic':
                $ret = 12;
                break;        

            default:
                throw new Exception("Mes desconocido", 1);
        }

        return $ret;
    }


    static function extract_date(string $date){
        $ret = false;
        if (preg_match('/([0-9]{1,2}) de (ene|enero|feb|febrero|mar|marzo|abr|abril|may|mayo|jun|junio|jul|julio|ago|agosto|set|sep|setiembre|septiembre|oct|octubre|nov|noviembre|dic|diciembre) de ([0-9]{4})/i', $date, $matches)){

            $dd = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
            $mm = str_pad((string) self::get_month_num($matches[2]), 2, '0', STR_PAD_LEFT);
            $yyyy = $matches[3];

            $ret = "$yyyy-$mm-$dd";
        }

        return $ret;
    }
}

    