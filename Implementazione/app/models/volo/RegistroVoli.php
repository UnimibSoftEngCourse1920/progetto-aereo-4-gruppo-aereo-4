<?php

require_once "../app/models/volo/Volo.php";
require_once "../app/models/servizi/DBFacade.php";
require_once "../app/models/volo/Aeroporto.php";

class RegistroVoli{

    public static $AVVISAMODIFICAVOLO='MODIFICA';
    public static $AVVISACANCELLAZIONEVOLO='CANCELLAZIONE';

    public function __construct(){}

    public function inserisciVolo( $dataOraPart, $dataOraArrivo, $OIDaeroportoPartenza, $OIDAereoportArr, $OIDAereo)
    {
        $database = DBFacade::getIstance();
        if($database->isAereoDisponibile($dataOraPart, $dataOraArrivo, $OIDAereo)){
            //genero codice del volo
            $aeroportoPartenza = $database->get($OIDaeroportoPartenza,Aeroporto::class);
            $aeroportoDestinazione = $database->get($OIDAereoportArr, Aeroporto::class);
            $aereo = $database->get($OIDAereo,Aereo::class);
            if($aereo!=null and $aeroportoDestinazione!=null and $aeroportoPartenza!=null) {
                $nuovoVolo = new Volo($dataOraPart, $dataOraArrivo, $aeroportoPartenza, $aeroportoDestinazione, $aereo);
                $esito = $database->put($nuovoVolo);
                return $esito;
            }
        }
        return false;
    }

    public function modificaVolo($OIDVolo, $nuovaDataOraPart, $nuovaDataOraArr){
        $voloMod = DBFacade::getIstance()->get($OIDVolo);
        $voloMod->setDataOraPartenza($nuovaDataOraPart);
        $voloMod->setDataOraArrivo($nuovaDataOraArr);
        DBFacade::getIstance()->update($voloMod);
        return true; //ritornare esito
    }

    public function rimuoviVolo($OIDVolo){
        $database = DBFacade::getIstance();
        $volo = $database ->get($OIDVolo,"Volo");
        $volo->setStato('CANCELLATO');
        $database->update($volo);
        //ritorna esito
        return $volo;
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
        /*$voli = array(new Volo("1", "1", "1", "1", "1", "1"),
                new Volo("2", "2", "2", "2", "2", "2"),
                new Volo("3", "3", "3", "3", "3", "3"));*/
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

    //public function avvisaPasseggeri($OIDVolo, )

}