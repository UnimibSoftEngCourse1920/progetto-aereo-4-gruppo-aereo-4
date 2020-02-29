<?php


namespace controller;


class ClienteController{
    private $archivioClienti;

    function iscrizioneFedelta($datiCliente){
        $mail_exists = $this->$archivioClienti->checkEmailClienteFedelta($datiCliente->$mail);
        if (!$mail_exists) {
            $archivioClienti->nuovoClienteFedelta($datiCliente);
            //mettere un esito operazione?
        }
        else {
            //mostra errore sulla view (manca anche sul diagrm. di seq)
        }
  }
}
