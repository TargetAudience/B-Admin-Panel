<?php
require_once 'PhpMailer/class.phpmailer.php';

class Mail extends PHPMailer {

    public $body;

    function __construct() {
        parent::__construct();
        $this->CharSet = 'UTF-8';
    }

    private function reset() {
        $this->ClearAddresses();
        $this->ClearAllRecipients();
        $this->ClearAttachments();
        $this->ClearBCCs();
        $this->ClearCCs();
        $this->ClearCustomHeaders();
        $this->ClearReplyTos();
    }

    public function prepare($subject, $body, $sTo, $sFrom = "", $sFromName = "") {
        $this->reset();
        $this->IsHTML(true);

        if (!$body || !$sTo)
            return false;
        $this->AddAddress($sTo);

        $this->From = $sFrom;
        $this->FromName = $sFromName;

        $this->SMTPDebug = 1;
        $this->isSMTP();
        $this->Mailer = "smtp";
        $this->Host = 'smtp.sparkpostmail.com';
        $this->SMTPAuth = true;
        $this->Username = 'SMTP_Injection';
        $this->Password = '318b0236457da360ab35cbc141fa6c9a5f2cf8af';
        $this->SMTPSecure = 'tls';
        $this->Port = 587;

        $this->Subject = $subject;
        $this->body = $body;
        $this->AltBody = strip_tags($body);
        return true;
    }

    public function replace($search, $replace) {
        $this->Subject = str_replace("[*$search*]", $replace, $this->Subject);
        $this->body = str_replace("[*$search*]", $replace, $this->body);
    }

    public function Send() {
        $this->body = stripslashes($this->body);
        $this->MsgHTML($this->body);
        $esito = parent::Send();
        if(!$esito) {
            error_log(print_R("Message could not be sent.",TRUE));
            error_log(print_R($this->ErrorInfo,TRUE));
            error_log(print_R($esito,TRUE));

        } else {
            error_log(print_R("Message has been sent",TRUE));
        }
        $this->reset();
        //error_log(print_R($this,TRUE));
        return $esito;
    }
}
?>