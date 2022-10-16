<?php 
    namespace DAO;

    use Models\Owner as Owner;

    interface IOwnerDAO
    {
        function add(Owner $owner);
        function getAll();
    }

?>