<?php
class DB{
  private $connection;
  private static $instance = null;

  private function __construct(){
    //si connette al DB
    $self->$connection = new PDO('dblib:host=your_hostname;dbname=your_db;charset=UTF-8', $user, $pass);
  }

  public static function getIstance(){
    if(self->$instance == null){
         self->$instance = new DB();
      }

      return self->$instance;
  }

  public function emailExists($email){
    //Cerca sul DB se c'è un cliente fedeltà con quella email
    //ritorna boolean
  }

} ?>
