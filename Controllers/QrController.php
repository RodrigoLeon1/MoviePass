<?php

    namespace Controllers;

    use views\assets\libs\qrcode\QrCode;

    class QrController {

        public function Index() {
            $qrCode = new QrCode();

            var_dump($qrCode);
        }
        
    }
?>
