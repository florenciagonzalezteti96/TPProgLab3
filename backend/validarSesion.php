<?php

if(!isset($_SESSION))
{
    session_start();
}
else if(!isset($_SESSION['DNIEmpleado']))
{
    header("Location: ./login.html"); 
}
