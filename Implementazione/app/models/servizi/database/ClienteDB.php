<?php


namespace model\servizi;

use model\cliente\Cliente;
use model\cliente\ClienteFedelta;


class ClienteDB extends AbstractDB
{
    public function __construct(){
        parent::__construct();
    }

    public function create($cliente){
        //genero la query in base ai dati
        $query = "SELECT from Cliente where OID = " . $cliente -> OID;
    }

    public function read($OID){
        //effettua query al DB
        //controllo se è fedelta
        if($isClienteFedelta)
            $cliente = new Cliente('','','','');
        else
            $cliente = new ClienteFedelta('','');

        return $cliente;
    }

    public function update(){}

    public function delete(){}

}