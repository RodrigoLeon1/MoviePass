<?php
    
    namespace Controllers;
    
    use Models\User as User;
    use Models\Image as Image;
    use DAO\ImageDAO as ImageDAO;
    use Controllers\UserController as UserController;   
    
    class ImageController {

        private $imageDAO;

        public function __construct() {
            $this->imageDAO = new ImageDAO();
        }
        
        public function upload($file) {
            try {                
                $fileName = $file["name"];
                $tempFileName = $file["tmp_name"];
                $type = $file["type"];
                
                $filePath = UPLOADS_PATH.basename($fileName);            
                $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                $imageSize = getimagesize($tempFileName);
                if ($imageSize !== false) {
                    if (move_uploaded_file($tempFileName, $filePath)) {
                        $image = new Image();
                        $image->setName($fileName);
                        $user = $_SESSION["loggedUser"];
                        $image->setUser($user);

                        if ($this->imageDAO->add($image)) {
                            $message = "Imagen subida correctamente";
                        } else {
                            $message = "Error en la base de datos";
                        }
                    } else {
                        $message = "Ocurrió un error al intentar subir la imagen";
                    }
                } else {
                    $message = "El archivo no corresponde a una imágen";
                }
            } catch(Exception $ex) {
                $message = $ex->getMessage();
            }
            
            $userController = new UserController();
            return $userController->myAccountPath($message);            
        } 
        
        public function getProfileImageUser(User $user) {            
            return $this->imageDAO->getImageByUser($user);
        }
    }
?>