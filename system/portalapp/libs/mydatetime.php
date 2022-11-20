<?php
class mydatetime extends DateTime
{
    public static function createFromFormat($format, $time, $timezone = null)
    {
        $version = explode('.', phpversion());
        if(!$timezone) $timezone = new DateTimeZone(date_default_timezone_get());
        /*if(((int)$version[0] >= 5 && (int)$version[1] >= 2 && (int)$version[2] > 17)){
        	error_log(print_R('josh version: above 5.2.17 ', TRUE));
            return parent::createFromFormat($format, $time, $timezone);
        }
        error_log(print_R('josh version: below 5.2.17 ', TRUE));*/
        return new DateTime(date($format, strtotime($time)), $timezone);
    }
}
?>