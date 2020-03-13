<?php

    require_once('../app/core/phpToPDF.php');

    class PDFGenerator {
        private static $instance = null;

        public static function getInstance() {
            if (self::$instance == null) {
                self::$instance = new PDFGenerator();
            }

            return self::$instance;
        }

        public function generaBiglietti($biglietti) {
            $html = "<html><head></head><body>";

            $numBiglietti = count($biglietti);
            for($i = 0; $i < $numBiglietti; $i++) {
                $html .= $biglietti[$i]->getNominativo();
                $html .= "<br>";
                $html .= $biglietti[$i]->getTariffa();
                $html .= "<br>";
                $html .= $biglietti[$i]->getNumPosto();
                if($i != $numBiglietti - 1) {
                    $html .= "<div class=\"phpToPDF-page-break\"></div>";
                }
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

        public function cancellaPDF($pdf) {
            if(strpos($pdf, ".pdf") == strlen($pdf) - 4) {
                unlink($pdf);
            }
        }
    }