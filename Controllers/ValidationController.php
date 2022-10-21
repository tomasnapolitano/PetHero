<?php
    namespace Controllers;
    class ValidationController {

        public function validateUserName($userName)
        {
            if(preg_match('/^[a-z][0-9a-z_.]{4,23}[0-9a-z]$/', $userName))
            { /* valida:
                - que comience con letra
                - que solo contenga números, letras minusculas, _ ó .
                - que termine en numero o letra
              */  
              return true;
            }else{ return false; };
        }
        public function validatePassword($password)
        {
            if(preg_match('/[0-9a-zA-Z_.*!?-]{6,15}/', $password))
            { /* valida:
                - que contenga solo numeros, letras minusculas, letras mayus, y algunos caracteres
                - que tenga entre 6 y 15 caracteres
              */  
              return true;
            }else{ return false; };
        }

        public function validateName($name)
        {
            if(preg_match('/^[a-zA-Z][a-zA-Z ]{0,25}[a-z]$/', $name))
            { /* valida:
                - que comience con letra min o mayus
                - que solo contenga letras y espacios
                - que termine en letra
              */  
              return true;
            }else{ return false; };
        }
    }
?>