<?php

require_once "../app/models/servizi/DBFacade.php";
require_once "../app/models/servizi/Mailer.php";
require_once "../app/models/cliente/Cliente.php";

abstract class TipologiaAvviso{
    public static $AVVISA_PROMOZIONI = "PROMOZIONI";
    public static $AVVISA_MODIFICA_VOLO='MODIFICA';
    public static $AVVISA_CANCELLAZIONE_VOLO='CANCELLAZIONE';
}

class RegistroClienti
{


    public $mailer;

    //lista clienti

    public function __construct(){
        $this->mailer = new Mailer();
    }

    public function checkEmailClienteFedelta($email){
        return DBFacade::getIstance() -> emailFedeltaExists($email);
    }

    public function nuovoClienteFedelta($nome, $cognome, $email, $dataNascita, $indirizzo, $password){
        $mailExists = DBFacade::getIstance()->emailFedeltaExists($email);
        if(!$mailExists){
            $cliente = new Cliente($nome, $cognome, $email, $dataNascita, $indirizzo, md5($password), true);
            $esito = DBFacade::getIstance()->put($cliente);
            if ($esito) {
                $this->mailer->inviaEmailCodiceFedelta($email, $cliente->getCodiceFedelta());
            }
        }
        return $esito;
    }

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

    public function avvisaClientiFedelta($object, $tipo){
        if($tipo == TipologiaAvviso::$AVVISA_PROMOZIONI && $object!=null && get_class($object[0]) == Promozione::class) {
                $listaClienti = DBFacade::getIstance()->getClientiFedelta();
                $this->mailer->avvisaClientiPromozioni($listaClienti, $object);
        }
    }

    public function avvisaPasseggeri($listaPasseggeri, $volo, $tipologiaAvviso){
        switch ($tipologiaAvviso){
            case TipologiaAvviso::$AVVISA_MODIFICA_VOLO:
                $this->mailer->inviaEmailModificaVolo($listaPasseggeri, $volo);
                break;
            case TipologiaAvviso::$AVVISA_CANCELLAZIONE_VOLO:
                $this->mailer->inviaEmailCancellazioneVolo($listaPasseggeri, $volo);
                break;
            default:
                return false;
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

    public function avvisaClientePrenotazione($email,$OIDPrenotazione){
        $this->mailer->inviaInformazioniPrenotazione($email,$OIDPrenotazione);
    }


	public function getCliente($idCliente) {
        return DBFacade::getIstance()->get($idCliente, 'Cliente');
	}
		
	public function aggiornaCliente($cliente) {
		DBFacade::getIstance()->update($cliente);
	}

	public function login($email, $password) {
        return DBFacade::getIstance()->userLogin($email, md5($password));
    }

}

