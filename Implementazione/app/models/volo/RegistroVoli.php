<?php

require_once "Volo.php";
require_once "Aeroporto.php";
require_once "../app/models/servizi/DBFacade.php";
require_once "../app/models/servizi/Mailer.php";
require_once "../app/models/prenotazione/RegistroPrenotazioni.php";


class RegistroVoli{

    public static $AVVISAMODIFICAVOLO='MODIFICA';
    public static $AVVISACANCELLAZIONEVOLO='CANCELLAZIONE';

    private $mailer;
    private $registroPrenotazioni;

    public function __construct(){
        $this->mailer = new Mailer();
        $this->registroPrenotazioni = new RegistroPrenotazioni();
    }

    public function inserisciVolo($dataOraPart, $dataOraArr, $OIDAeroportoPart, $OIDAeroportoDest, $OIDAereo)
    {
        $database = DBFacade::getIstance();
        if($this->validaDate($dataOraPart, $dataOraArr)){
            if($database->isAereoDisponibile($dataOraPart, $dataOraArr, $OIDAereo)){
                //genero codice del volo
                $aeroportoPart = $database->get($OIDAeroportoPart,Aeroporto::class);
                $aeroportoDest = $database->get($OIDAeroportoDest, Aeroporto::class);
                $aereo = $database->get($OIDAereo,Aereo::class);
                if($aereo!=null and $aeroportoDest!=null and $aeroportoPart!=null) {
                    $nuovoVolo = new Volo($dataOraPart, $dataOraArr, $aeroportoPart, $aeroportoDest, $aereo);
                    $this->salvaPosti($nuovoVolo->getPosti()); //salvo sul DB i posti che sono stati creati col costruttore
                    $esito = $database->put($nuovoVolo);
                    return $esito;
                }
            }
        }
        return false;
    }

    private function salvaPosti($listaPosti){
        //Mettere esito anche qui?
        $db = DBFacade::getIstance();
        foreach ($listaPosti as $posto){
            $db->put($posto);
        }
    }

    public function modificaVolo($OIDVolo, $nuovaDataoraPart, $nuovaDataoraArr){
        $db = DBFacade::getIstance();
        if($this->validaDate($nuovaDataoraPart, $nuovaDataoraArr)) {
            $volo = $db -> get($OIDVolo, Volo::class);
            if($db->isAereoDisponibile($nuovaDataoraPart, $nuovaDataoraArr, $volo->getAereo()->getOID())) {
                $voloMod = DBFacade::getIstance()->get($OIDVolo, Volo::class);
                $voloMod->setDataOraPartenza($nuovaDataoraPart);
                $voloMod->setDataOraArrivo($nuovaDataoraArr);
                $esito = DBFacade::getIstance()->update($voloMod);
                return $esito;
            }
        }
        return false;
    }

    public function rimuoviVolo($OIDVolo){
        $database = DBFacade::getIstance();
        $volo = $database ->get($OIDVolo, Volo::class);
        if($volo != null) {
            $volo->setStato(Volo::$STATO_CANCELLATO);
            $esito = $database->update($volo);
            return $esito;
        }
        return false;
    }

    public function avvisaPasseggeri($OIDVolo, $tipologiaAvviso){
        $volo = DBFacade::getIstance() ->get($OIDVolo, Volo::class);
        //TODO perchè passo dal registro Voli ?? Devo fare come prima e passare dal controller?
        $listaClienti = $this->registroPrenotazioni->getListaClientiVolo($OIDVolo);
        switch ($tipologiaAvviso){
            case self::$AVVISAMODIFICAVOLO:
                $this->mailer->inviaEmailModificaVolo($listaClienti, $volo);
                break;
            case self::$AVVISACANCELLAZIONEVOLO:
                $this->mailer->inviaEmailCancellazioneVolo($listaClienti, $volo);
                break;
            default:
                return false;
        }
    }

    private function validaDate($data1, $data2){
        //TODO deve esserci un minimo di tot minuti tra le due date?
        $formato = strtotime($data1) && strtotime($data2);
        $date = $data1 < $data2;
        return $formato && $date;
    }

    private function generaCodiceVolo($datiVolo){
        return '';
        //E' un campo autoincrement dal DB o lo genero secondo una logica?
    }

    public function checkDisponibilitaPosti($numPosti, $codVolo){
        $v = $this->getVolo($codVolo);
        return $v->getDisponibilitaPosti($numPosti);
    }
	
	public function cercaVoli($partenza, $destinazione, $data, $nPosti) {
		$voli = DBFacade::getIstance()->cercaVoli($partenza, $destinazione, $data, $nPosti);
		return $voli;
	}
	
	public function cercaDateDisponibili($idVolo, $nPosti) {
		$voli = DBFacade::getIstance()->cercaDateDisponibili($idVolo, $nPosti);
		return $voli;
	}
	
	public function getVolo($idVolo) {
		$volo = DBFacade::getIstance()->get($idVolo,"Volo");
		return $volo;
	}
	
	public function aggiornaVolo($idVolo) {
		DBFacade::getIstance()->aggiornaVolo($idVolo);
	}

	//TODO funzione getAll per tutti?

	public function getAeroporti(){
        return DBFacade::getIstance()->getAll(Aeroporto::class);
    }
    public function getVoli(){
        return DBFacade::getIstance()->getAll(Volo::class);
    }
    public function getAerei(){
        return DBFacade::getIstance()->getAll(Aereo::class);
    }

    //public function avvisaPasseggeri($OIDVolo, )

}