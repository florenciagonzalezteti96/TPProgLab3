<?php

if(!isset($_SESSION))
{
    session_start();
}
else if(!isset($_SESSION['DNIEmpleado']))
{
    "El login ha fallado, redirigiendo al login...";
    header("refresh:5;url= ../login.html");
}
