<?php

require_once $_SERVER['DOCUMENT_ROOT']."/app/models/servizi/OIDGenerator.php";


class IstitutoDiCredito
{

    private $OID;
    private $nome;

    public function __construct($nome)
    {
        $this->nome = $nome;
        $this->OID = OIDGenerator::getIstance()->getNewOID();
    }

    public function getOID(){
        return $this->OID;
    }

    public function getNome()
    {
        return $this->nome;
    }



    public function autorizzaPagamento($carta) {
		if(mt_rand() / mt_getrandmax() <= 0.8) {
			return true;
		} else {
			return false;
		}
	}
}


