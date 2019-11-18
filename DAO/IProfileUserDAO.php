<?php
    namespace DAO;

    use Models\User as User;

    interface IProfileUserDAO {
        
        function add(User $user);
        
    }

?>