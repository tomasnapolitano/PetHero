<?php 
    namespace DAO;

    use Models\Pet as Pet;
    use Models\Dog as Dog;

    interface IPetDAO
    {
        function add(Dog $dog);
        function getAll();
    }

?>