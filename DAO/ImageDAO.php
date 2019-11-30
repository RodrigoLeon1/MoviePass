<?php

    namespace DAO;

    use \Exception as Exception;
	use DAO\Connection as Connection;
    use DAO\IImageDAO as IImageDAO;
    use DAO\QueryType as QueryType;
    use Models\Image as Image;
    use Models\User as User;

    class ImageDAO {
        
        private $connection;
        private $tableName = "images";
        
        public function add(Image $image) {
            try {
                $query = "CALL images_add(?, ?);";                
                $parameters["name"] = $image->getName();
                $parameters["dni_user"] = $image->getUser()->getDni();
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
                return true;
            } catch(Exception $ex) {
                return false;
            }
        }

        public function getImageByUser(User $user) {
            try {
                $image = null;
                $query = "CALL images_getByUser(?)";
                $parameters["dni"] = $user->getDni();
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);                
                foreach ($resultSet as $row) {                
                    $image = new Image();
                    $image->setImageId($row["imageId"]);
                    $image->setName($row["name"]);
                }                
                return $image;
            } catch(Exception $ex) {
                return false;
            }
        }

    }
?>