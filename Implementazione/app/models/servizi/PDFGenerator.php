<?php

    class PDFGenerator {
        private static $instance = null;

        public static function getInstance() {
            if (self::$instance == null) {
                self::$instance = new PDFGenerator();
            }

            return self::$instance;
        }

        public function generaBiglietti($biglietti) {
            $numBiglietti = count($biglietti);
            $html = "";
            for($i = 0; $i < $numBiglietti; $i++) {
                $html .= "<h2>Biglietto ".($i + 1)."</h2>";
                $html .= "<b>Nomativo: </b>" . $biglietti[$i]->getNominativo();
                $html .= "<br>";
                $html .= "<b>Tariffa: </b>" . $biglietti[$i]->getTariffa();
                $html .= "<br>";
                $html .= "<b>Numero di posto: </b>" . $biglietti[$i]->getNumPosto();
                $html .= "<br>";
                $html .= "<b>PNR: </b>" . $biglietti[$i]->getOID();
                if($i != $numBiglietti - 1) {
                    $html .= "<br><br><hr>";
                }
            }
            return $this->creaPDF($html);
        }

        private function creaPDF($html) {
            $nome = time().".pdf";
            $data = [
                'html' => $html,
                'apiKey' => '51ee0943e64af4a9139f10cd7388aabeb6c2f55f13e26c34a4b04f8aa73f184d',
            ];
            $dataString = json_encode($data);
            $ch = curl_init('https://api.html2pdf.app/v1/generate');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
            ]);
            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);
            if (!$err) {
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="your-file-name.pdf"');
                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
                file_put_contents($nome, $response);
            }
            return $nome;
        }

        public function cancellaPDF($pdf) {
            if($this->isPDF($pdf)) {
                unlink($pdf);
            }
        }

        public function scaricaPDF($pdf) {
            if($this->isPDF($pdf)) {
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename= " . $pdf);
                header("Content-Transfer-Encoding: binary");
                readfile($pdf);
            }
        }

        public function isPDF($file) {
            return strpos($file, ".pdf") == strlen($file) - 4;
        }
    }