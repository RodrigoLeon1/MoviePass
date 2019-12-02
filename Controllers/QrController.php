<?php

    namespace Controllers;
        
    require 'Views/assets/libs/phpqrcode/phpqrcode.php';
    
    class QrController {
        
        public function index() {

            $content = 'prubea-ticket-qr';                    
            QRcode::png($content);

        }
        
    }
?>
