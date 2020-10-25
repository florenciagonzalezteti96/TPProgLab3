<?php

if(!isset($_SESSION))
{
    session_start();
}
if(!isset($_SESSION['DNIEmpleado']))
{
    header("Location: /login.html");
}
