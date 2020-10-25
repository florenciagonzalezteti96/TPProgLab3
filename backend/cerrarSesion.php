<?php

unset($_SESSION['DNIEmpleado']);
        if(!isset($_SESSION['DNIEmpleado']))
        {
                header("Location: /login.html");       
        }
        
   
