<?php
    namespace DAO;

    use Models\User as User;

    interface IUserDAO {
        
        function add(User $user);
        function getByMail(User $user);
        function getAll();
        function enableByDni(User $user);
        function disableByDni(User $user);
        function updateUser(User $user);
        
    }

?>