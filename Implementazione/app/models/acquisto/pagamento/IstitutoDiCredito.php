<?php

class IstitutoDiCredito
{
	public function autorizzaPagamento($carta) {
		if(mt_rand() / mt_getrandmax() <= 0.8) {
			return true;
		} else {
			return false;
		}
	}
}


