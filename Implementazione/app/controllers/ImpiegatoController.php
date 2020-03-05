<?php

class ImpiegatoController extends Controller {

    public function login($name = '') {
        $this->view('impiegato/login');
    }

    public function admin($name = '') {
        $this->view('impiegato/admin');
    }

    public function voli($name = '') {
        $this->view('impiegato/voli');
    }

    public function promozioni($name = '') {
        $this->view('impiegato/promozioni');
    }

}