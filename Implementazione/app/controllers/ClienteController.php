<?php

require_once "../app/models/servizi/Mailer.php";
require_once "../app/models/cliente/RegistroClienti.php";
require_once "../app/models/prenotazione/RegistroPrenotazioni.php";
require_once "../app/core/Controller.php";
require_once "../app/models/cliente/Cliente.php";
require_once "../app/models/cliente/ClienteFedelta.php";
require_once "../app/models/prenotazione/Prenotazione.php";
//require_once "../app/models/prenotazione/RegistroPromozioni.php";

class ClienteController extends Controller{

    private $registroClienti;
    private $registroPrenotazioni;
    //private $registroPromozioni;
    private $mailer;

    public function __construct(){
        $this->mailer = new Mailer();
        $this->registroClienti = new RegistroClienti();
        $this->registroPrenotazioni = new RegistroPrenotazioni();
        //$this->registroPromozioni = new RegistroPromozioni();
    }

    public function annullaIscrizione($codiceFedelta){
        $cliente = $this->registroClienti -> annullaIscrizione($codiceFedelta);
        if($cliente != null)
            $this->mailer -> inviaEmailConfermaCancellazione($cliente);
        else
            $error = 'ERRORE'; //Da implementare errori
    }

    public function ricercaClientiInfedeli(){
        $clientePrenotazione = $this->registroPrenotazioni->getFedeltaUltimaPrenotazione();
        foreach ($clientePrenotazione as $CliData) {
            $anniPassati = $this->anniPassati($clientePrenotazione[1]);
            if($anniPassati == 3)
                $this->registroClienti->annullaIscrizione($clientePrenotazione[0]);
            else if ($anniPassati == 2){
                $this->registroClienti->setClienteInfedele($clientePrenotazione[0]);
            }
        }
    }

    private function anniPassati($data){
        $data = new DateTime($data);
        $oggi = new DateTime(date('Y-m-d'));
        return ($oggi->diff($data)) -> y;
    }

    public function avvisaPromozioniFedelta() {
        $listaClienti = DBFacade::getIstance()->getClientiFedelta();
        $listaPromozioni = $this->registroPromozioni->getPromozioniFedelta();
        $this->mailer->avvisaClientiPromozioni($listaClienti, $listaPromozioni);
    }

    public function accedi($email = "", $password = "") {
        $error = "";
        if($email != "" && $password != "") {
            $esitoLogin = $this->login($email, $password);
            if($esitoLogin) {
                header("Location: /");
            } else {
                $error = "Combinazione email/password non trovata.";
            }
        }
        $this->view('cliente/login', ["error" => $error]);
    }

    public function login($email, $password) {
        $registroClienti = $this->model('cliente/RegistroClienti');
        $cliente = $registroClienti->login($email, $password);
        if ($cliente->getOID()) {
            $_SESSION['id_cliente'] = $cliente->getOID();
            $_SESSION['nome_cliente'] = $cliente->getNome() . " " . $cliente->getCognome();
            return true;
        } else {
            return false;
        }
    }

    public function esci() {
        session_destroy();
        header('Location: /');
    }

    public function registrati($nome = "", $cognome = "", $indirizzo = "", $dataNascita = "", $email = "", $password = "", $confermaPassword = "") {
        $error = "";
        if($nome != "" && $cognome != "" && $indirizzo != "" && $dataNascita != "" && $email != "" && $password != "") {
            if($password == $confermaPassword) {
                $esitoRegistrazione = $this->iscrizioneFedelta($nome, $cognome, $indirizzo, $dataNascita, $email, $password, $confermaPassword);
                if ($esitoRegistrazione) {
                    header("Location: /public/cliente/accedi");
                } else {
                    $error = "L'indirizzo e-mail è già registrato.";
                }
            } else {
                $errore = "Le due password non coincidono.";
            }
        }
        $this->view('cliente/registrazione', ["error" => $error]);
    }

    public function iscrizioneFedelta($nome, $cognome, $indirizzo, $dataNascita, $email, $password, $confermaPassword) {
        $registroClienti = $this->model('cliente/RegistroClienti');
        $mail_exists = $registroClienti->checkEmailClienteFedelta($email);
        if (!$mail_exists) {
            $nuovoCliente = $registroClienti->nuovoClienteFedelta($nome, $cognome, $email, $dataNascita, $indirizzo, $password);
            if ($nuovoCliente != null) {
                $this->mailer->inviaEmailCodiceFedelta($email, $nuovoCliente->getCodiceFedelta());
                return true;
            }
        }
        return false;
    }

    /*
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
    }*/

    public function prenotazioni() {
        $prenotazioni = array(new Prenotazione("1", "1", "1", "1", "1"),
                                new Prenotazione("1", "1", "1", "1", "1"),
                                new Prenotazione("1", "1", "1", "1", "1"),
                                new Prenotazione("1", "1", "1", "1", "1"));
        $cliente = new Cliente("test", "test", "test", "test", "test");
        $this->view('cliente/fedelta', ["prenotazioni" => $prenotazioni, "cliente" => $cliente]);
    }

}
