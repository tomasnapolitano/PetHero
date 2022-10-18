<?php 
    namespace DAO;

    use Models\Pet as Pet;
    use Models\Dog as Dog;

    interface IDogDAO
    {
        function add(Dog $dog);
        function getAll();
    }

?>