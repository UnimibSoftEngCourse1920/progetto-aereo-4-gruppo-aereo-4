<?php

require_once "../app/models/servizi/Mailer.php";
require_once "../app/models/cliente/RegistroClienti.php";
require_once "../app/models/prenotazione/RegistroPrenotazioni.php";
require_once "../app/core/Controller.php";
require_once "../app/models/cliente/Cliente.php";
require_once "../app/models/prenotazione/Prenotazione.php";

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
        $esito = $this->registroClienti -> annullaIscrizione($codiceFedelta);
        if($esito) {
            //TODO esito positivo
        }
        else {
            //TODO esito negativo
        }
    }

    public function iscrizioneFedelta($nome = "", $cognome = "", $email = "", $dataNascita = "", $indirizzo = "",
                                        $password = "", $confermaPassword = "") {
        //$registroClienti = $this->model('cliente/RegistroClienti');
        $error = "";
        if($nome != "" && $cognome != "" && $indirizzo != "" && $dataNascita != "" && $email != "" && $password != "") {
            if($password == $confermaPassword) {
                //Converto il formato della data
                $esito = $this->registroClienti ->nuovoClienteFedelta($nome, $cognome, $email, $dataNascita, $indirizzo,
                                                                        $password);
                if ($esito) {
                    header("Location: /public/cliente/registrato");
                } else {
                    $error = "L'indirizzo e-mail è già registrato.";
                }
            } else {
                $error = "Le due password non coincidono.";
            }
        }
        $this->view('cliente/registrazione', ["error" => $error]);
    }

    public function ricercaClientiInfedeli(){
        $clientePrenotazione = $this->registroPrenotazioni->getFedeltaUltimaPrenotazione();
        foreach ($clientePrenotazione as $CliData) {
            $anniPassati = $this->anniPassati($clientePrenotazione[1]);
            if($anniPassati == 3) {
                $this->registroClienti->annullaIscrizione($clientePrenotazione[0]);
            }
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

    public function registrato() {
        $this->accedi("", "", "Account registrato! Accedi compilando il form.");
    }

    public function accedi($email = "", $password = "", $success = "") {
        $error = "";
        if($email != "" && $password != "") {
            $esitoLogin = $this->login($email, $password);
            if($esitoLogin) {
                header("Location: /");
            } else {
                $error = "Combinazione email/password non trovata.";
            }
        }
        $this->view('cliente/login', ["error" => $error, "success" => $success]);
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

    public function registrati($nome = "", $cognome = "", $email = "", $dataNascita = "", $indirizzo = "", $citta = "",
                                $cap = "", $password = "", $confermaPassword = "") {
        $error = "";
        if($nome != "" && $cognome != "" && $indirizzo != "" && $citta != "" && $cap != "" && $dataNascita != "" &&
            $email != "" && $password != "") {
            if($password == $confermaPassword) {
                //Converto il formato della data
                $esitoRegistrazione = $this->iscrizioneFedelta($nome, $cognome, $indirizzo." ".$citta." ".$cap,
                                                                $dataNascita, $email, $password, $confermaPassword);
                if ($esitoRegistrazione) {
                    header("Location: /public/cliente/registrato");
                } else {
                    $error = "L'indirizzo e-mail è già registrato.";
                }
            } else {
                $error = "Le due password non coincidono.";
            }
        }
        $this->view('cliente/registrazione', ["error" => $error]);
    }

    public function prenotazioni() {
        $prenotazioni = array();
        $cliente = new Cliente("test", "test", "test", "test", "test");
        $this->view('cliente/fedelta', ["prenotazioni" => $prenotazioni, "cliente" => $cliente]);
    }

}
