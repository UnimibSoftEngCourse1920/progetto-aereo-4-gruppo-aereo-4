<?php

abstract class Pagamento{
	
    private $idPagamento;
    private $data;
    protected $importo;

	public abstract function effettua($cliente);
	
} 
