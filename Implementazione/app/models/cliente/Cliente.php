<?php

require_once $_SERVER['DOCUMENT_ROOT']."/app/models/servizi/OIDGenerator.php";

class Cliente{
    public static $STATO_OSPITE= 'OSPITE';
    public static $STATO_FEDELE = 'FEDELE';
    public static $STATO_INFEDELE = 'INFEDELE';
    public static $STATO_CANCELLATO = 'CANCELLATO';

    private $OID;
    private $nome;
    private $cognome;
    private $email;
    private $dataNascita;
    private $indirizzo;
    private $codiceFedelta;
    private $password;
    private $stato;
    private $saldoPunti;

    public function __construct($nome, $cognome, $email, $dataNascita, $indirizzo=null, $password = null, $fedelta = false){
        $this->OID = OIDGenerator::getIstance()->getNewOID();
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->email = $email;
        $this->dataNascita = $dataNascita;

        if($fedelta){
            $this->codiceFedelta = base_convert($this->OID, 10, 32);
            $this->indirizzo = $indirizzo;
            $this->password = $password;
            $this->stato = self::$STATO_FEDELE;
            $this->saldoPunti = 0;
        }
        else{
            $this->codiceFedelta = null;
            $this->indirizzo = null;
            $this->password = null;
            $this->saldoPunti = null;
            $this->stato = self::$STATO_OSPITE;
        }
    }

    public function getOID()
    {
        return $this->OID;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getCognome()
    {
        return $this->cognome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getDataNascita()
    {
        return $this->dataNascita;
    }

    public function getIndirizzo()
    {
        return $this->indirizzo;
    }

    public function getCodiceFedelta()
    {
        return $this->codiceFedelta;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getStato()
    {
        return $this->stato;
    }

    public function getSaldoPunti() {
        return $this->saldoPunti;
    }

    public function annullaIscrizioneFedelta(){
        $this->indirizzo = null;
        $this->codiceFedelta = null;
        $this->saldoPunti = 0;
        $this->password = null;
        $this->stato = self::$STATO_CANCELLATO;
    }

    public function setStato($stato){
        $this->stato = $stato;
    }

    public function isFedelta(){
        //Fatto così e non controllando direttamente == OSPITE perchè se un giorno si aggiungono nuovi stati questo funziona comunque
        return ($this->stato == self::$STATO_FEDELE) || ($this->stato == self::$STATO_INFEDELE);
    }

    public function sottraiPunti($punti)
    {
        if ($this->saldoPunti >= $punti) {
            $this->saldoPunti = $this->saldoPunti - $punti;
            return true;
        }
        return false;
    }

    public function aggiungiPunti($punti) {
        $this->saldoPunti = $this->saldoPunti + $punti;
        return true;
    }

}

 ?>
