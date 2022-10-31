<?php 
    namespace DAO;

    use Models\PetSpecies as PetSpecies;

    interface IPetSpeciesDAO
    {
        function add(PetSpecies $petSpecies);
        function getAll();
    }

?>