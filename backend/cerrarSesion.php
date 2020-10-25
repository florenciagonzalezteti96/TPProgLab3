<?php

if (isset($_SESSION)) {
    if (isset($_SESSION['DNIEmpleado'])) {
        session_unset();
        session_destroy();
        header("Location: ./login.html");
    }
}
