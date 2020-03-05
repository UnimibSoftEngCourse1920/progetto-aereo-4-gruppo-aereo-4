<?php

require_once __DIR__ . "/../models/servizi/Mailer.php";
require_once __DIR__ . "/../models/cliente/RegistroClienti.php";
require_once __DIR__ . "/../models/prenotazione/RegistroPrenotazioni.php";
require_once __DIR__ . "/../core/Controller.php";

class ClienteController extends Controller{

    private $registroClienti;
    private $registroPrenotazioni;
    private $registroPromozioni;
    private $mailer;

    public function __construct(){
        $this->mailer = new Mailer();
        $this->registroClienti = new RegistroClienti();
        $this->registroPrenotazioni = new RegistroPrenotazioni();
        $this->registroPromozioni = new RegistroPromozioni();
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
        $cliente = $this->registroClienti -> annullaIscrizione($codiceFedelta);
        if($cliente != null)
            $this->mailer -> inviaEmailConfermaCancellazione($cliente);
        else
            $error = 'ERRORE'; //Da implementare errori
    }

    public function ricercaClientiInfedeli(){
        //ricerca 3 anni
        $listaOIDCli = $this->registroPrenotazioni -> getFedeltaUltimaPrenotazione(3);
        foreach ($listaOIDCli as $OIDcliente){
            $esito = $this->registroClienti -> annullaIscrizione($OIDcliente);
            if($esito)
                $this->registroClienti->avvisaCliente($OIDcliente, RegistroClienti::$AVVISACANCELLAZIONEFEDELTA);
            else
                $x='ERRORE';
        }
        //ricerca 2 anni
        $listaOIDCli = $this->registroPrenotazioni -> getFedeltaUltimaPrenotazione(2);
        foreach ($listaOIDCli as $OIDcliente){
            $esito = $this->registroClienti -> setClienteInfedele($OIDcliente);
            if($esito)
                $this->registroClienti->avvisaCliente($OIDcliente, RegistroClienti::$AVVISACANCELLAZIONEFEDELTA);
            else
                $x='ERRORE';
        }
    }

    public function avvisaPromozioniFedelta() {
        $listaClienti = DB::getIstance()->getClientiFedelta();
        $listaPromozioni = $this->registroPromozioni->getPromozioniFedelta();
        $this->mailer->avvisaClientiPromozioni($listaClienti, $listaPromozioni);
    }

    public function login() {
        $this->view('cliente/login');
    }

    public function registrazione() {
        $this->view('cliente/registrazione');
    }

}
