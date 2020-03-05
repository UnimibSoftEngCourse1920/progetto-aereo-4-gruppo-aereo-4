<?php

class ImpiegatoController extends Controller {

    public function login($name = '') {
        $this->view('impiegato/login');
    }

}