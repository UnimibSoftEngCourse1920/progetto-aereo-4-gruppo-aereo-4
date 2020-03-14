<?php

require_once __DIR__."/Volo.php";
require_once __DIR__."/Aeroporto.php";
require_once "../app/models/servizi/DBFacade.php";
require_once "../app/models/servizi/Mailer.php";


class RegistroVoli{

    private $mailer;

    public function __construct(){
        $this->mailer = new Mailer();
    }

    public function inserisciVolo($dataOraPart, $dataOraArr, $OIDAeroportoPart, $OIDAeroportoDest, $OIDAereo)
    {
        $database = DBFacade::getIstance();
        if($this->validaDate($dataOraPart, $dataOraArr) && $database->isAereoDisponibile($dataOraPart, $dataOraArr, $OIDAereo)){
            $codiceVolo = $this->generaCodiceVolo();
            $aeroportoPart = $database->get($OIDAeroportoPart,Aeroporto::class);
            $aeroportoDest = $database->get($OIDAeroportoDest, Aeroporto::class);
            $aereo = $database->get($OIDAereo,Aereo::class);
            if($aereo!=null && $aeroportoDest!=null && $aeroportoPart!=null) {
                $nuovoVolo = new Volo($dataOraPart, $dataOraArr, $aeroportoPart, $aeroportoDest, $aereo, $codiceVolo);
                $this->salvaPosti($nuovoVolo->getPosti()); //salvo sul DB i posti che sono stati creati col costruttore
                return $database->put($nuovoVolo);
            }
        }
        return false;
    }

    private function salvaPosti($listaPosti){
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
                DBFacade::getIstance()->update($voloMod);
                //TODO esito
                return $voloMod;
            }
        }
        return null;
    }

    public function rimuoviVolo($OIDVolo){
        $database = DBFacade::getIstance();
        $volo = $database ->get($OIDVolo, Volo::class);
        if($volo != null) {
            $volo->setStato(Volo::$STATO_CANCELLATO);
            $database->update($volo);
            return $volo;
            //TODO esito
        }
        return null;
    }

    private function validaDate($data1, $data2){
        $formato = strtotime($data1) && strtotime($data2);
        $date = $data1 < $data2;
        return $formato && $date;
    }

    private function generaCodiceVolo(){
        return sprintf("%04d",rand(1,1000));
    }

    public function checkDisponibilitaPosti($numPosti, $codVolo){
        $v = $this->getVolo($codVolo);
        return $v->getDisponibilitaPosti($numPosti);
    }

	public function cercaVoli($partenza, $destinazione, $data, $nPosti) {
        return DBFacade::getIstance()->cercaVoli($partenza, $destinazione, $data, $nPosti);
    }

	public function getVolo($idVolo) {
		return DBFacade::getIstance()->get($idVolo,"Volo");
	}

	public function aggiornaVolo($idVolo) {
        //TODO vedere se serve o meno
        //TODO chiamare la update
		DBFacade::getIstance()->aggiornaVolo($idVolo);
	}

	public function getAeroporti(){
        return DBFacade::getIstance()->getAll(Aeroporto::class);
    }
    public function getVoli(){
        return DBFacade::getIstance()->getAll(Volo::class);
    }
    public function getAerei(){
        return DBFacade::getIstance()->getAll(Aereo::class);
    }


}
