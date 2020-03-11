<?php


require_once __DIR__ . "/../core/Controller.php";
require_once __DIR__ . "/../models/volo/RegistroVoli.php";
require_once __DIR__ . "/../models/prenotazione/RegistroPrenotazioni.php";
require_once __DIR__ . "/../models/volo/RegistroPromozioni.php";


class VoloController extends Controller {

    private $registroVoli;
    private $registroPromozioni;
    private $registroPrenotazioni;

    public function __construct(){
        $this->registroVoli = new RegistroVoli();
        $this->registroPromozioni = new RegistroPromozioni();
        $this->registroPrenotazioni = new RegistroPrenotazioni();
    }


    public function login($name = '') {
        $this->view('impiegato/login');
    }

    public function admin($name = '') {
        $this->view('impiegato/admin');
    }

    public function voli($name = '') {
        $aeroporti = $this->registroVoli->getAeroporti();
        $aerei = $this->registroVoli->getAerei();
        $voli = $this->registroVoli->getVoli();
        $this->view('impiegato/voli',["aeroporti"=>$aeroporti,"aerei"=>$aerei,"voli"=>$voli]);
    }

    public function modifica($OIDVolo){
        $v = $this->registroVoli->getVolo($OIDVolo);
        $this->view('impiegato/modifica', ["volo"=>$v]);
    }

    public function promozioni($name = '') {
        $promozioni = $this->registroPromozioni->getPromozioni();
        $voli = $this->registroVoli->getVoli();
        $this->view('impiegato/promozioni', ["promozioni"=>$promozioni,"voli"=>$voli]);
    }

    public function modificaVolo($OIDVolo, $nuovaDataoraPart, $nuovaDataoraDest){
        //TODO richiamare modifica e basta??
        $esito = $this->registroVoli -> modificaVolo($OIDVolo, $nuovaDataoraPart, $nuovaDataoraDest);
        if($esito){
            $this->registroVoli->avvisaPasseggeri($OIDVolo, RegistroVoli::$AVVISAMODIFICAVOLO);
        }
        header("Location: /public/volo/voli");
    }

    public function inserisciVolo($dataoraPart, $dataoraArr, $OIDAeroportoPart, $OIDAeroportoDest, $OIDAereo){
        $esito = $this->registroVoli -> inserisciVolo($dataoraPart, $dataoraArr,  $OIDAeroportoPart, $OIDAeroportoDest, $OIDAereo);
        //TODO esito??
        header("Location: /public/volo/voli");
    }

    public function cancellaVolo($OIDVolo){
        $esito = $this->registroVoli->rimuoviVolo($OIDVolo);
        if($esito){
            $this->registroVoli->avvisaPasseggeri($OIDVolo, RegistroVoli::$AVVISACANCELLAZIONEVOLO);
        }
        header("Location: /public/volo/voli");
    }

    public function inserisciPromozione($nome, $sconto, $dataInizio,$dataFine, $codVolo, $promozioneFedelta){
        $this->registroPromozioni->creaPromozione((int)$sconto, $dataInizio, $dataFine, $nome, $codVolo, (int)$promozioneFedelta);
        header("Location: /public/volo/promozioni");
    }

    public function cancellaPromozione($OIDPromozione){
        $this->registroPromozioni->cancellaPrenotazione($OIDPromozione);
        header("Location: /public/volo/promozioni");
    }

}