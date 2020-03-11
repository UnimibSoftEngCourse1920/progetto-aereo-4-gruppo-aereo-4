<?php

require_once $_SERVER['DOCUMENT_ROOT']."/app/models/servizi/OIDGenerator.php";

class Cliente{
    //TODO:: Spostare in un'altra classe
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
    private $punti;

    public function __construct($nome, $cognome, $email, $dataNascita, $codiceFedelta=null, $indirizzo=null, $password = null){
        $this->OID = OIDGenerator::getIstance()->getNewOID();
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->email = $email;
        $this->dataNascita = $dataNascita;

        if($codiceFedelta!=null){
            $this->codiceFedelta = $codiceFedelta;
            $this->indirizzo = $indirizzo;
            $this->password = $password;
            $this->stato = self::$STATO_FEDELE;
            $this->punti = 0;
        }
        else{
            $this->codiceFedelta = null;
            $this->indirizzo = null;
            $this->password = null;
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

    public function getPunti() {
        return $this->punti;
    }

    public function annullaIscrizioneFedelta(){
        $this->indirizzo = null;
        $this->codiceFedelta = null;
        $this->username = null;
        $this->password = null;
        //TODO:: se si cancella imposto solamente lo stato 'Cancellato' ?
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
        if ($this->punti >= $punti) {
            $this->punti = $this->punti - $punti;
            return true;
        }
        return false;
    }

    public function aggiungiPunti($punti) {
        $this->punti = $this->punti + $punti;
        return true;
    }

}

 ?>
