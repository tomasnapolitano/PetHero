<?php 
    namespace DAO;

    use Models\Pet as Pet;

    interface IPetDAO
    {
        function add(Pet $pet);
        function getAll();
    }

?>