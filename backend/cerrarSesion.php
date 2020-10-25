<?php

if (isset($_SESSION) && isset($_SESSION['DNIEmpleado'])) {
    
        session_unset();
        session_destroy();
        header("Location: /login.html");
   
}
