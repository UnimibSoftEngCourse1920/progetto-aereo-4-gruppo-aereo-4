<?php

require_once "../app/models/servizi/DBFacade.php";
require_once "../app/models/servizi/Mailer.php";
require_once "../app/models/cliente/Cliente.php";


class RegistroClienti
{
    public static $AVVISACANCELLAZIONEFEDELTA = "CANCELLAZIONEFEDELTA";
    public static $AVVISACLIENTEINFEDELE = "CLIENTEINFEDELE";

    public $mailer;

    //lista clienti

    public function __construct(){
        $this->mailer = new Mailer();
    }

    public function checkEmailClienteFedelta($email){
        return DBFacade::getIstance() -> emailFedeltaExists($email);
    }

    private function generaCodiceFedelta(){
        //La generazione del codice è ancora da vedere
        //Chiede al DB oppure lui sa qual'è l'ultimo (Attenzione! Se sono più di uno è un macello)

        $ultimoCodice = DBFacade::getIstance()->getUltimoCodiceFedelta();
        return "F" . sprintf('%07d', substr($ultimoCodice, 1) + 1);
    }

    public function nuovoClienteFedelta($nome, $cognome, $email, $dataNascita, $indirizzo, $password){
        $mailExists = DBFacade::getIstance()->emailFedeltaExists($email);
        if(!$mailExists){
            $codice = $this->generaCodiceFedelta();
            $cliente = new Cliente($nome, $cognome, $email, $dataNascita, $codice, $indirizzo, md5($password));
            $esito = DBFacade::getIstance()->put($cliente);
            if ($esito) {
                $this->mailer->inviaEmailCodiceFedelta($email, $codice);
            }
        }
        return $esito;
    }

    /*public function getCliente($codiceFedelta){
        //per ora è deprecated
        return DBFacade::getIstance() -> get($codiceFedelta);
    }*/

    public function annullaIscrizione($OIDCliente){
        $db = DBFacade::getIstance();
        $cliente = $db->get($OIDCliente, Cliente::class);
        if ($cliente != null) {
            $cliente->annullaIscrizioneFedelta();
            $esito = DBFacade::getIstance()->update($cliente);
            if($esito){
                $this->mailer->inviaCancellazioneFedelta($cliente);
            }
            return $esito;
        }
        return false;
    }

    public function avvisaPasseggeri($OID, $tipologiaAvviso){
        $cliente = DBFacade::getIstance()->get($OID, Cliente::class);

        switch ($tipologiaAvviso){
            case RegistroClienti::$AVVISACANCELLAZIONEFEDELTA:
                $this->mailer->inviaCancellazioneFedelta($cliente);
                break;
            case RegistroClienti::$AVVISACLIENTEINFEDELE:
                $this->mailer->inviaComunicazioneInfedelta($cliente);
                break;
            default:
                return false;
                //TODO vedere questo return
        }
    }

    public function setClienteInfedele($OID){
        $cliente = DBFacade::getIstance()->get($OID, Cliente::class);
        if($cliente!=null) {
            $cliente->setStato(Cliente::$STATO_INFEDELE);
            $esito = DBFacade::getIstance()->update($cliente);
            if($esito) {
                $this->mailer->inviaComunicazioneInfedelta($cliente);
            }
            return $esito;
        }
        return false;
    }

	public function getCliente($idCliente) {
        return DBFacade::getIstance()->get($idCliente, 'Cliente');
	}
		
	public function aggiornaCliente($cliente) {
        //TODO a cosa serve?
		DBFacade::getIstance()->aggiornaCliente($cliente);
	}

	public function login($email, $password) {
        return DBFacade::getIstance()->userLogin($email, md5($password));
    }

}

