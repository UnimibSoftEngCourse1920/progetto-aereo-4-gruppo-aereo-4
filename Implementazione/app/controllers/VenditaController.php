<?php

require_once "../app/core/Controller.php";
require_once "../app/models/servizi/DBFacade.php";

class VenditaController extends Controller
{
	//TODO: DB e controllo
	public function consultaVoli($partenza, $destinazione, $data, $nPosti) {
        $aeroporti = DBFacade::getIstance()->getAll("Aeroporto");
		$registro = $this->model('volo/RegistroVoli');
		$voli = $registro->cercaVoli($partenza, $destinazione, $data, $nPosti);
		$this->view('vendita/consulta', ["voli" => $voli, "partenza" => $partenza, "destinazione" => $destinazione,
                                                "data" => $data, "viaggiatori" => $nPosti, "aeroporti" => $aeroporti]);
	}
	
	//TODO: DB e restituire voli anziché date
	public function cercaDateDisponibili($idVolo, $nPosti) {
		$registro = $this->model('RegistroVoli');
		$voli = $registro->cercaDateDisponibili($idVolo, $nPosti);
		$this->view('vendita/cambiaprenotazione', $voli);
	}
	
	//TODO: DB
	public function cambiaData($idPrenotazione, $idCliente, $idNuovoVolo, $nuovaTariffa, $metodoPagamento, $carta = "") {
		$registroPrenotazioni = $this->model('RegistroPrenotazioni');
		$registroClienti = $this->model('RegistroClienti');
		$registroVoli = $this->model('RegistroVoli');
		$cliente = $registroClienti->getCliente($idCliente);
		$prenotazione = $registroPrenotazioni->getPrenotazione($idPrenotazione);
		$volo = $prenotazione->getVolo();
		$nuovoVolo = $registroVoli->getVolo($idNuovoVolo);
		$esitoCambioData = $registroPrenotazioni->cambiaData($prenotazione, $cliente, $nuovoVolo, $nuovaTariffa, $metodoPagamento, $carta);
		if($esitoCambioData) {
			//Aggiornare prenotazione (anche biglietti e acquisto), cliente, volo vecchio e volo nuovo per i posti
            $registroPrenotazioni->generaBiglietti($prenotazione, $cliente);
			$registroPrenotazioni->aggiornaPrenotazione($prenotazione);
			$registroClienti->aggiornaCliente($cliente);
			$registroVoli->aggiornaVolo($volo);
			$registroVoli->aggiornaVolo($nuovoVolo);
			//TODO: view con successo
		} else {
			//TODO: view con errore
		}
	}

	//TODO: DB
	public function acquistaPrenotazione($idPrenotazione, $idCliente, $metodoPagamento, $carta = "") {
		$registroPrenotazioni = $this->model('prenotazione/RegistroPrenotazioni');
		$registroClienti = $this->model('cliente/RegistroClienti');
		$cliente = $registroClienti->getCliente($idCliente);
		$prenotazione = $registroPrenotazioni->getPrenotazione($idPrenotazione);
		$esitoPagamento = $registroPrenotazioni->acquistaPrenotazione($prenotazione, $cliente, $metodoPagamento, $carta);
        var_dump($esitoPagamento);
        exit;
		if($esitoPagamento) {
            $registroPrenotazioni->generaBiglietti($prenotazione, $cliente);
			$registroPrenotazioni->aggiornaPrenotazione($prenotazione);
			$registroClienti->aggiornaCliente($cliente);
			//TODO: view con successo
		} else {
			//TODO: view con errore
		}
	}

	public function acquista($idPrenotazione = "", $idCliente = "") {
        $this->view('vendita/acquisto', ["id_prenotazione" => $idPrenotazione, "id_cliente" => $idCliente]);
    }
}