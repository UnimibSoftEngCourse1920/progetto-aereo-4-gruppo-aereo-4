<?php


namespace controller;


class ClientiController{
    private $archivio_clienti

    function iscrizioneFedelta(datiCliente){
        $mail_exists = $archivio_clienti->checkEmailClienteFedelta(datiCliente->mail)
        if (!$mail_exists) {
            $archivio_clienti->nuovoClienteFedelta(datiCliente);
            //mettere un esito operazione?
        }
        else {
            //mostra errore sulla view (manca anche sul diagrm. di seq)
        }
  }
}
