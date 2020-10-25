<?php

        session_unset();
        session_destroy();
        if(!isset($_SESSION))
        {
                header("Location: /login.html");       
        }
        
   
