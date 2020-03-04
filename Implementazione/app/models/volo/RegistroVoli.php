<?php


namespace model\volo;

use model\servizi\DB;


class RegistroVoli{

    public static $AVVISAMODIFICAVOLO='MODIFICA';
    public static $AVVISACANCELLAZIONEVOLO='CANCELLAZIONE';

    public function inserisciVolo($orarioPartenza, $orarioArrivo, $data, $OIDAereoportoPart, $OIDAereoportArr, $OIDAereo){
        //controllo che i dati forniti siano validi
        //$codiceVolo = $this -> generaCodiceVolo($datiVolo); //Come viene generato? A questo punto ha senso generarlo?

        //Recupero gli oggetti dal db
        $database = DB::getIstance();
        $aereoportoPart = $database->get($OIDAereoportoPart);
        $aereoportoArr = $database->get($OIDAereoportArr);
        $aereo = $database->get($OIDAereo);

        $nuovoVolo = new Volo($orarioPartenza, $orarioArrivo, $data,$aereoportoPart, $aereoportoArr, $aereo);
        DB::getInstance() -> put($nuovoVolo);
    }

    public function modificaVolo($OIDVolo, $nuovaData, $nuovoOrarioPart, $nuovoOrarioArr){
        $voloMod = DB::getIstance()->get($OIDVolo);
        $voloMod->setData($nuovaData);
        $voloMod->setOrarioPartenza($nuovoOrarioPart);
        $voloMod->setOrarioArrivo($nuovoOrarioArr);
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
		$voli = DB::getIstance()->cercaVoli($partenza, $destinazione, $data, $nPosti);
		return $voli;
	}
	
	public function cercaDateDisponibili($idVolo, $nPosti) {
		$voli = DB::getIstance()->cercaDateDisponibili($idVolo, $nPosti);
		return $voli;
	}
	
	public function getVolo($idVolo) {
		$volo = DB::getIstance()->getVolo($idVolo);
		return $volo;
	}
	
	public function aggiornaVolo($idVolo) {
		DB::getIstance()->aggiornaVolo($idVolo);
	}

    //public function avvisaPasseggeri($OIDVolo, )

}