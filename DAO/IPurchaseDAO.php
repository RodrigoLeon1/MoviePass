<?php

    namespace DAO;

    use Models\Purchase as Purchase;
    use Models\User as User;

    interface IPurchaseDAO {
        
        function add(Purchase $purchase);        
        function getAll();
        function getById(Purchase $purchase);
        function getByDni(User $user);        
        
    }

?>