<?php

require_once "../app/core/Controller.php";
require_once "../app/models/volo/RegistroVoli.php";
require_once "../app/models/prenotazione/RegistroPrenotazioni.php";
require_once "../app/models/cliente/RegistroClienti.php";

class VenditaController extends Controller {

    private $registroPrenotazioni;
    private $registroVoli;
    private $registroClienti;

    public function __construct() {
        $this->registroPrenotazioni = new RegistroPrenotazioni();
        $this->registroVoli = new RegistroVoli();
        $this->registroClienti = new RegistroClienti();
    }

	public function consultaVoli($partenza, $destinazione, $data, $nPosti) {
		$aeroporti = $this->registroVoli->getAeroporti();
		$voli = $this->registroVoli->cercaVoli($partenza, $destinazione, $data, $nPosti);
		$this->view('vendita/consulta', ["voli" => $voli, "partenza" => $partenza, "destinazione" => $destinazione,
                                                "data" => $data, "viaggiatori" => $nPosti, "aeroporti" => $aeroporti]);
	}

	public function cercaDateDisponibili($idPrenotazione, $nuovaData = "") {
		$prenotazione = $this->registroPrenotazioni->getPrenotazione($idPrenotazione);
        $volo = $prenotazione->getVolo();
        if($nuovaData != "") {
            $voli = $this->registroVoli->cercaVoli($volo->getAeroportoPartenza()->getOID(),
                $volo->getAeroportoDestinazione()->getOID(), $nuovaData,
                count($prenotazione->getListaPosti()));
        } else {
            $voli = null;
        }
        $tariffa = $prenotazione->getListaBiglietti()[0]->getTariffa();
		$this->view('vendita/cercadate', ["id_prenotazione" => $idPrenotazione, "volo" => $volo, "voli" => $voli,
                                                "tariffa" => $tariffa]);
	}
	
	//TODO: DB
	public function cambiaData($idPrenotazione, $idCliente, $idNuovoVolo, $nuovaTariffa, $metodoPagamento = "", $carta = "") {
        $nuovoVolo = $this->registroVoli->getVolo($idNuovoVolo);
        $prenotazione = $this->registroPrenotazioni->getPrenotazione($idPrenotazione);
        $tariffa = $prenotazione->getListaBiglietti()[0]->getTariffa();
        $tassaCambio = $this->registroPrenotazioni->calcolaTassa($tariffa, $nuovaTariffa);
        if($metodoPagamento != "" || $tassaCambio == 0) {
            $cliente = $prenotazione->getCliente();
            if ($idCliente == $cliente->getOID()) {
                $volo = $prenotazione->getVolo();
                $nuovoVolo = $this->registroVoli->getVolo($idNuovoVolo);
                $esitoCambioData = $this->registroPrenotazioni->cambiaData($prenotazione, $cliente, $nuovoVolo, $nuovaTariffa,
                                                                            $metodoPagamento, $carta, $tassaCambio);
                var_dump($esitoCambioData);
                exit;
                if ($esitoCambioData) {
                    //Aggiornare prenotazione (anche biglietti e acquisto), cliente, volo vecchio e volo nuovo per i posti
                    $this->registroPrenotazioni->generaBiglietti($prenotazione, $cliente);
                    $this->registroPrenotazioni->aggiornaPrentoazione($prenotazione);
                    $this->registroClienti->aggiornaCliente($cliente);
                    $this->registroVoli->aggiornaVolo($volo);
                    $this->registroVoli->aggiornaVolo($nuovoVolo);
                    //TODO: view con successo
                } else {
                    //TODO: view con errore
                }
            }
        }
        $nPosti = count($prenotazione->getListaPosti());
        $this->view('vendita/acquisto', ["id_prenotazione" => $idPrenotazione, "id_cliente" => $idCliente,
                                                "volo" => $nuovoVolo, "pass" => $nPosti, "tariffa" => $nuovaTariffa,
                                                "tassa_cambio" => $tassaCambio]);
	}

	public function acquistaPrenotazione($idPrenotazione, $idCliente, $metodoPagamento = "", $carta = "") {
        $prenotazione = $this->registroPrenotazioni->getPrenotazione($idPrenotazione);
        if($metodoPagamento != "") {
            $cliente = $prenotazione->getCliente();
            if ($idCliente == $cliente->getOID()) {
                $esitoPagamento = $this->registroPrenotazioni->acquistaPrenotazione($prenotazione, $cliente, $metodoPagamento, $carta);
                if ($esitoPagamento) {
                    //TODO: Testare queste istruzioni
                    //$this->registroPrenotazioni->generaBiglietti($prenotazione, $cliente);
                    $this->registroPrenotazioni->aggiornaAcquisti($prenotazione);
                    $this->registroClienti->aggiornaCliente($cliente);
                    //TODO: view con successo
                } else {
                    //TODO: view con errore
                }
            }
        }
        $nPosti = count($prenotazione->getListaPosti());
        $tariffa = $prenotazione->getListaBiglietti()[0]->getTariffa();
        $this->view('vendita/acquisto', ["id_prenotazione" => $idPrenotazione, "id_cliente" => $idCliente,
                                                "volo" => $prenotazione->getVolo(),
                                                "pass" => $nPosti,
                                                "tariffa" => $tariffa]);
	}

    public function confermaPrenotazione() {
        $this->view('vendita/conferma', ["success" => "La tua prenotazione è stata confermata!"]);
    }

    public function confermaAcquisto() {
        $this->view('vendita/conferma', ["success" => "Il tuo acquisto è stato confermato!"]);
    }
}