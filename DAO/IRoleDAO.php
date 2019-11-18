<?php
    namespace DAO;

    use Models\Role as Role;

    interface IRoleDAO {
        
        function getById($id);
        function getAll();
        
    }

?>