<?php

    require_once('../app/core/phpToPDF.php');

    class PDFGenerator {
        private static $instance = null;

        public static function getInstance() {
            if (self::$instance == null) {
                self::$instance = new Singleton();
            }

            return self::$instance;
        }

        public function generaBiglietti($biglietti) {
            $html = "<html><head></head><body>";
            foreach($biglietti as $biglietto) {
                $html .= $biglietto->getNominativo();
                $html .= "<br>";
                $html .= $biglietto->getTariffa();
                $html .= "<br>";
                $html .= $biglietto->getNumPosto();
                $html .= "<div class=\"phpToPDF-page-break\"></div>";
            }
            $html .= "</body></html>";
            return $this->creaPDF($html);
        }

        private function creaPDF($html) {
            $nome = time().".pdf";
            $pdf_options = array(
                "source_type" => 'html',
                "source" => $html,
                "action" => 'save',
                "file_name" => $nome);
            phptopdf($pdf_options);
            return $nome;
        }
    }