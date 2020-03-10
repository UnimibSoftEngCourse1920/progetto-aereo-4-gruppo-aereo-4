<?php



require_once __DIR__ . "/../core/Controller.php";
require_once __DIR__ . "/../models/volo/RegistroVoli.php";
require_once __DIR__ . "/../models/prenotazione/RegistroPrenotazioni.php";
require_once __DIR__ . "/../models/volo/RegistroPromozioni.php";
require_once __DIR__ . "/../models/servizi/Mailer.php";
require_once __DIR__ . "/../models/servizi/DBFacade.php";
require_once __DIR__ . "/../models/volo/Aeroporto.php";

class VoloController extends Controller {

    private $registroVoli;
    private $registroPromozioni;
    private $mailer;

    public function login($name = '') {
        $this->view('impiegato/login');
    }

    public function admin($name = '') {
        $this->view('impiegato/admin');
    }

    public function voli($name = '') {
        $aeroporti = DBFacade::getIstance()->getAll("Aeroporto");
        $aerei = DBFacade::getIstance()->getAll("Aereo");
        $voli = DBFacade::getIstance()->getAll("Volo");
        //var_dump($voli);
        $this->view('impiegato/voli',["aeroporti"=>$aeroporti,"aerei"=>$aerei,"voli"=>$voli]);
    }

    public function promozioni($name = '') {
        $promozioni = DBFacade::getIstance()->getAll("Promozione");
        $voli = DBFacade::getIstance()->getAll("Volo");
        $this->view('impiegato/promozioni', ["promozioni"=>$promozioni,"voli"=>$voli]);
    }

    public function __construct(){
        $this->registroVoli = new RegistroVoli();
        $this->registroPromozioni = new RegistroPromozioni();
        $this->mailer = new Mailer();
    }

    public function modificaVolo($OIDVolo, $nuovaDataoraPart, $nuovaDataoraDest){
        $esito = $this->registroVoli -> modificaVolo($OIDVolo, $nuovaDataoraPart, $nuovaDataoraDest);
        if($esito){
            $this->registroVoli->avvisaPasseggeri($OIDVolo, RegistroVoli::$AVVISAMODIFICAVOLO);
        }
    }

    public function inserisciVolo($dataoraPartenza, $dataoraArrivo, $OIDAeroportoPart, $OIDAeroportoDest, $OIDAereo){
        //manca esito operazione
        $esito = $this->registroVoli -> inserisciVolo($dataoraPartenza, $dataoraArrivo,  $OIDAeroportoPart, $OIDAeroportoDest, $OIDAereo);
        //TODO esito??
        header("Location: /public/volo/voli");
    }

    public function cancellaVolo($OIDVolo){
        $volo = $this->registroVoli->rimuoviVolo($OIDVolo);
        $listaClienti = $this->registroPrenotazioni->getClientiVolo($volo->getOID());
        $this->mailer -> inviaEmailCancellazioneVolo($listaClienti, $volo);
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