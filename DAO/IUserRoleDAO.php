<?php 
    namespace DAO;

    use Models\UserRole as UserRole;

    interface IUserRoleDAO
    {
        //function add(UserRole $userRole);
        function getAll();
    }

?>