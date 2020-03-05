<?php

require_once "../app/models/servizi/Mailer.php";
require_once "../app/models/cliente/RegistroClienti.php";
require_once "../app/models/prenotazione/RegistroPrenotazioni.php";
require_once "../app/core/Controller.php";
require_once "../app/models/cliente/Cliente.php";
require_once "../app/models/prenotazione/Prenotazione.php";
//require_once "../app/models/prenotazione/RegistroPromozioni.php";

class ClienteController extends Controller{

    private $registroClienti;
    private $registroPrenotazioni;
    private $registroPromozioni;
    private $mailer;

    public function __construct(){
        $this->mailer = new Mailer();
        $this->registroClienti = new RegistroClienti();
        $this->registroPrenotazioni = new RegistroPrenotazioni();
        //$this->registroPromozioni = new RegistroPromozioni();
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

    public function login($email = "", $password = "") {
        $error = "";
        if($email == "test" && $password == "test") {
            //Cliente che verrà preso dal db (?), per ora è fake
            $cliente = new Cliente("test", "test", "test", "test", "test");
            $_SESSION['id_cliente'] = $cliente->getOID();
            $_SESSION['nome_cliente'] = $cliente->getNome() . " " . $cliente->getCognome();
            header('Location: /');
        } else if ($email != "" && $email != "") {
            $error = "Credenziali Errate";
        }
        $this->view('cliente/login', ["error" => $error]);
    }

    public function registrazione() {
        $this->view('cliente/registrazione');
    }

    public function prenotazioni() {
        $prenotazioni = array(new Prenotazione("1", "1", "1", "1", "1"),
                                new Prenotazione("1", "1", "1", "1", "1"),
                                new Prenotazione("1", "1", "1", "1", "1"),
                                new Prenotazione("1", "1", "1", "1", "1"));
        $cliente = new Cliente("test", "test", "test", "test", "test");
        $this->view('cliente/fedelta', ["prenotazioni" => $prenotazioni, "cliente" => $cliente]);
    }

}
