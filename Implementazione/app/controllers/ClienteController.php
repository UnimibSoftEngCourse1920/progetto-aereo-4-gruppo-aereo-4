<?php


namespace controller;


class ClienteController{

    private $registroClienti;
    private $mailer;

    public function iscrizioneFedelta($datiCliente){
        $mail_exists = $this -> registroClienti -> checkEmailClienteFedelta($datiCliente->mail);
        if (!$mail_exists) {
            $nuovoCliente = $this -> $registroClienti -> nuovoClienteFedelta($datiCliente);
            //mettere un esito operazione?
            if ($nuovoCliente != null) {
                $this -> mailer -> inviaEmailCodiceFedelta($datiCliente->mail, $nuovoCliente -> codiceFedelta);
            }
            else{
                //Scrive operazione non andata a buon fine e l'user deve rifare tutta la trafila
            }
        }
        else {
            //mostra errore sulla view (manca anche sul diagrm. di seq)
        }
    }

    public function annullaIscrizione($codiceFedelta){
        $cliente = $this -> registroClienti  ->  getCliente($codiceFedelta); //da implementare
        if ($cliente != null) {
            $cliente->annullaIscrizioneFedelta();
            DB::getIstance()->update($cliente);
        }
        //bisogna sempre controllare se è andato tutto a buon fine
        $this -> mailer -> inviaEmailConfermaCancellazione($cliente);
    }

}
