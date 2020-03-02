<?php


namespace controller;

use model\cliente\RegistroClienti;
use model\servizi\Mailer;


class ClienteController extends Controller{

    private $registroClienti;
    private $mailer;

    public function __construct(){
        $this->mailer = new Mailer();
        $this->registroClienti = new RegistroClienti();
    }

    public function iscrizioneFedelta($nome, $cognome, $email, $dataNascita, $indirizzo, $username, $password){
        $mail_exists = $this -> registroClienti -> checkEmailClienteFedelta(mail);
        if (!$mail_exists) {
            $nuovoCliente = $this -> $registroClienti -> nuovoClienteFedelta($nome, $cognome, $email, $dataNascita, $indirizzo, $username, $password);
            if ($nuovoCliente != null) {
                $this -> mailer -> inviaEmailCodiceFedelta($email, $nuovoCliente->codiceFedelta);
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
        $cliente = $this->registroClienti  ->  annullaIscrizione($codiceFedelta);
        if($cliente != null)
            $this->mailer -> inviaEmailConfermaCancellazione($cliente);
        else
            $error = 'ERRORE'; //Da implementare errori
    }

}
