<?php


require_once __DIR__ . "/../core/Controller.php";
require_once __DIR__ . "/../models/volo/RegistroVoli.php";
require_once __DIR__ . "/../models/prenotazione/RegistroPrenotazioni.php";
require_once __DIR__ . "/../models/volo/RegistroPromozioni.php";

define("LOCATIONVOLI","Location: /public/volo/voli");
define("LOCATIONPROMOZIONI","Location: /public/volo/promozioni");

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
        if(isset($_SESSION["admin"])){
            $this->view('impiegato/voli',["aeroporti"=>$aeroporti,"aerei"=>$aerei,"voli"=>$voli]);
        } else {
            header("Location: /public/volo/login");
        }
    }

    public function modifica($OIDVolo){
        $v = $this->registroVoli->getVolo($OIDVolo);
        if(isset($_SESSION["admin"])){
            $this->view('impiegato/modifica', ["volo"=>$v]);
        } else {
            header("Location: /public/volo/login");
        }
    }

    public function promozioni($name = '') {
        $promozioni = $this->registroPromozioni->getPromozioni();
        $voli = $this->registroVoli->getVoli();
        if(isset($_SESSION["admin"])){
            $this->view('impiegato/promozioni', ["promozioni"=>$promozioni,"voli"=>$voli]);
        } else {
            header("Location: /public/volo/login");
        }

    }

    public function modificaVolo($OIDVolo, $nuovaDataoraPart, $nuovaDataoraDest){
        $esito = $this->registroVoli -> modificaVolo($OIDVolo, $nuovaDataoraPart, $nuovaDataoraDest);
        if($esito){
            $listaClienti = $this->registroPrenotazioni->getListaClientiVolo($OIDVolo);
            $this->registroVoli->avvisaPasseggeri($listaClienti, $OIDVolo, RegistroVoli::$AVVISAMODIFICAVOLO);
        }
        header(LOCATIONVOLI);
    }

    public function autenticazioneImpiegato($username,$password){
        if($username=="admin" && $password=="admin"){
            $_SESSION["admin"] = "logged";
            header("Location: /public/volo/admin");
        } else {
            header("Location: /public/volo/login");
        }
    }

    public function inserisciVolo($dataoraPart, $dataoraArr, $OIDAeroportoPart, $OIDAeroportoDest, $OIDAereo){
        $esito = $this->registroVoli -> inserisciVolo($dataoraPart, $dataoraArr,  $OIDAeroportoPart, $OIDAeroportoDest, $OIDAereo);
        if($esito){
            header(LOCATIONVOLI);
        }
    }

    public function cancellaVolo($OIDVolo){
    $esito = $this->registroVoli->rimuoviVolo($OIDVolo);
    if($esito){
        $listaClienti = $this->registroPrenotazioni->getListaClientiVolo($OIDVolo);
        $this->registroVoli->avvisaPasseggeri($listaClienti, $OIDVolo, RegistroVoli::$AVVISACANCELLAZIONEVOLO);
    }
    header(LOCATIONVOLI);
}

    public function inserisciPromozione($nome, $sconto, $dataInizio,$dataFine, $codVolo, $promozioneFedelta){
        $this->registroPromozioni->creaPromozione((int)$sconto, $dataInizio, $dataFine, $nome, $codVolo, (int)$promozioneFedelta);
        header(LOCATIONPROMOZIONI);
    }

    public function cancellaPromozione($OIDPromozione){
        $this->registroPromozioni->cancellaPromozione($OIDPromozione);
        header(LOCATIONPROMOZIONI);
    }

}
