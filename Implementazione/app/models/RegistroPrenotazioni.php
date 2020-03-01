<?php

//Classe rappresentativa, non funzionante e non testata

class RegistroPrenotazioni extends Database {
	
	public function getPrenotazione($id) {
		$result = $this->query("SELECT * FROM prenotazione WHERE idprenotazione = '".$id."')";
	}

}