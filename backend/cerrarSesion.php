<?php

session_start();

if(isset($_SESSION['DNIEmpleado']))
{
    $_SESSION['v'] = array();
    unset($_SESSION['DNIEmpleado']);
          
}
header("Location: /login.html"); 
        
   
