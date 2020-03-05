<?php

require_once "../app/models/volo/Volo.php";


class RegistroVoli{

    public static $AVVISAMODIFICAVOLO='MODIFICA';
    public static $AVVISACANCELLAZIONEVOLO='CANCELLAZIONE';

    public function inserisciVolo($dataOraArrivo, $dataOraPart, $OIDAereoportoPart, $OIDAereoportArr, $OIDAereo){
        //controllo che i dati forniti siano validi
        //$codiceVolo = $this -> generaCodiceVolo($datiVolo); //Come viene generato? A questo punto ha senso generarlo?

        //Recupero gli oggetti dal db
        $database = DB::getIstance();
        $aereoportoPart = $database->get($OIDAereoportoPart);
        $aereoportoArr = $database->get($OIDAereoportArr);
        $aereo = $database->get($OIDAereo);

        $nuovoVolo = new Volo($dataOraPart, $dataOraArrivo,$aereoportoPart, $aereoportoArr, $aereo);
        DB::getInstance() -> put($nuovoVolo);
    }

    public function modificaVolo($OIDVolo, $nuovaDataOraPart, $nuovaDataOraArr){
        $voloMod = DB::getIstance()->get($OIDVolo);
        $voloMod->setDataOraPartenza($nuovaDataOraPart);
        $voloMod->setDataOraArrivo($nuovaDataOraArr);
        DB::getIstance()->update($voloMod);
        return true; //ritornare esito
    }

    public function rimuoviVolo($OIDVolo){
        $database = DB::getIstance();
        $volo = $database ->get($OIDVolo);
        $volo->setStato('CANCELLATO');
        $database->update($volo);
        //ritorna esito
        return true;
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
		//$voli = DBFacade::getIstance()->cercaVoli($partenza, $destinazione, $data, $nPosti);
        $voli = array(new Volo("1", "1", "1", "1", "1", "1"),
                new Volo("2", "2", "2", "2", "2", "2"),
                new Volo("3", "3", "3", "3", "3", "3"));
		return $voli;
	}
	
	public function cercaDateDisponibili($idVolo, $nPosti) {
		$voli = DB::getIstance()->cercaDateDisponibili($idVolo, $nPosti);
		return $voli;
	}
	
	public function getVolo($idVolo) {
		//$volo = DB::getIstance()->getVolo($idVolo);
        $volo = new Volo("1", "1", "1", "1", "1", "1");
		return $volo;
	}
	
	public function aggiornaVolo($idVolo) {
		DB::getIstance()->aggiornaVolo($idVolo);
	}

    //public function avvisaPasseggeri($OIDVolo, )

}