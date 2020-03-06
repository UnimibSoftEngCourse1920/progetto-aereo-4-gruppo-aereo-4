<?php



require_once __DIR__ . "/../core/Controller.php";
require_once __DIR__ . "/../models/volo/RegistroVoli.php";
require_once __DIR__ . "/../models/prenotazione/RegistroPrenotazioni.php";
require_once __DIR__ . "/../models/servizi/Mailer.php";
require_once __DIR__ . "/../models/servizi/DBFacade.php";
require_once __DIR__ . "/../models/volo/Aeroporto.php";
class VoloController extends Controller {

    private $registroVoli;
    private $registroPrenotazioni;
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
        $this->view('impiegato/promozioni');
    }

    public function __construct(){
        $this->registroVoli = new RegistroVoli();
        $this->registroPrenotazioni = new RegistroPrenotazioni();
        $this->mailer = new Mailer();
    }

    public function modificaVolo($OIDVolo, $nuovaData, $nuovoOrarioPart, $nuovoOrarioArr){
        $voloMod = $this->registroVoli -> modificaVolo($OIDVolo, $nuovaData, $nuovoOrarioPart, $nuovoOrarioArr);
        // vedo esito delle op. prima
        //
        $listaClienti = $this->registroPrenotazioni -> getClientiVolo($voloMod -> OIDVolo);
        $this->mailer -> inviaEmailModificaVolo($listaClienti, $voloMod);
    }

    public function inserisciVolo($giornopartenza, $giornoarrivo, $OIDAereoportoPart, $OIDAereoportArr, $OIDAereo){
        //manca esito operazione
        $this->registroVoli -> inserisciVolo($giornopartenza, $giornoarrivo,  $OIDAereoportoPart, $OIDAereoportArr, $OIDAereo);
        $this->voli();
    }

    public function cancellaVolo($OIDVolo){
        $volo = $this->registroVoli -> rimuoviVolo($OIDVolo);
        $listaClienti = $this->registroPrenotazioni -> getClientiVolo($volo -> OIDVolo);
        $this->mailer -> inviaEmailCancellazioneVolo($listaClienti, $volo);
    }


}