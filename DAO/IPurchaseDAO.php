<?php
    namespace DAO;

    use Models\Purchase as Purchase;

    interface IPurchaseDAO {
        
        function add(Purchase $purchase);
        function getId($ticket_quantity, $discount, $date, $total, $dni);
        function getAll();
        function getById($id);
        function getByDni($dni);        
        
    }

?>