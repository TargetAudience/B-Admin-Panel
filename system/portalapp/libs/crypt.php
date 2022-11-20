<?php
class Crypt {
    public static function enc_encrypt($string, $key = 'encrypt_anything.app') {
        $result = '';
        for($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result .= $char;
        }
        return strtr(base64_encode($result), '+/=', '-_,');
        //return base64_encode($result);
    }

    public static function enc_decrypt($string, $key = 'encrypt_anything.app') {
        $result = '';
        $string = base64_decode(strtr($string, '-_,', '+/='));

        for($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char) - ord($keychar));
            $result .= $char;
        }
        return $result;
    }
}
?>