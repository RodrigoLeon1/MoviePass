<?php

    namespace DAO;

    use Models\Role as Role;

    interface IRoleDAO {
        
        function getById(Role $role);
        function getAll();
        
    }

?>