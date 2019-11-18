<?php
    namespace DAO;

    use Models\User as User;

    interface IUserDAO {
        
        function add(User $user);
        function getByMail($mail);
        function getAll();
        function deleteByDni($dni);
        function updateUser(User $user);
        
    }

?>