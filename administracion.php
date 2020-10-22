<?php

require('./clases/fabrica.php');

$_pathMostrar = '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>HTML5 - Empleados</title>
                    </head>
                    <body>
                    <a href="./backend/mostrar.php">Mostrar Empleados</a>
                    </body>
                    </html>';

$_pathIndex = '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>HTML5 - Empleados</title>
                    </head>
                    <body>
                    <a href="./index.php">Volver al alta</a>
                    </body>
                    </html> ';

$_pathArchivoEmpleados = "./archivos/empleados.txt";


//chequeo valores de datos empleado
$todoBien = FALSE;

if (isset($_POST["txtNombre"]) && isset($_POST["txtApellido"]) && isset($_POST["txtDni"]) && isset($_POST["cboSexo"]) && isset($_POST["txtLegajo"]) && isset($_POST["txtSueldo"]) && isset($_POST["rdoTurno"])) {

    if (isset($_POST["hdnModificar"])) {
        $fabrica = new Fabrica("Fabrica HTML5");
        $fabrica->TraerDeArchivo($_pathArchivoEmpleados);
        $empleadosEnFabrica = $fabrica->GetEmpleados();
        for ($i = 0; $i < count($empleadosEnFabrica); $i++) {
            if ($empleadosEnFabrica[$i]->GetDni() == $_POST["txtDni"]) {
                $modificar = TRUE;
                $fabrica->EliminarEmpleado($empleadosEnFabrica[$i]);
                $fabrica->GuardarEnArchivo($_pathArchivoEmpleados);
                break;
            }
        }
    }

    $_nuevoEmpleado = new Empleado($_POST["txtNombre"], $_POST["txtApellido"], $_POST["txtDni"], $_POST["cboSexo"], $_POST["txtLegajo"], $_POST["txtSueldo"], $_POST["rdoTurno"]);

    $tiposDeArchivos = array('image/jpg', 'image/bmp', 'image/gif', 'image/png', 'image/jpeg');
    //chequeo valores del input FILE
    if (!isset($_FILES['txtFoto'])) {
        echo "No se ha subido la foto del empleado";
    } else if (!is_uploaded_file($_FILES['txtFoto']['tmp_name'])) {
        echo "Error al subir la foto del empleado";
    } else if (!array_search($_FILES['txtFoto']['type'], $tiposDeArchivos)) {
        echo "El formato de la foto del empleado es incorrecto. Solo se aceptan los siguientes formatos: <br>JPG, BMP, GIF, PNG, JPEG";
    } else if ($_FILES['txtFoto']['size'] > 10485760) {
        echo "El tamaño de la foto del empleado es demasiado grande.";
    } else {
        $pathFotoEmpleado = "./fotos/" . $_nuevoEmpleado->GetDni() . "-" . $_nuevoEmpleado->GetApellido() . '.' . pathinfo($_FILES['txtFoto']['name'], PATHINFO_EXTENSION);
        $_nuevoEmpleado->SetPathFoto($pathFotoEmpleado);
        if (file_exists($pathFotoEmpleado)) {
            echo "La foto del empleado ya ha sido subida";
        } else if (!move_uploaded_file($_FILES['txtFoto']['tmp_name'], $pathFotoEmpleado)) {
            echo "Ha ocurrido un error al subir la foto del empleado";
        } else {
            $_nuevaFabrica = new Fabrica("Fabrica HTML5");

            $_nuevaFabrica->TraerDeArchivo($_pathArchivoEmpleados);

            if ($_nuevaFabrica->AgregarEmpleado($_nuevoEmpleado)) {
                $_nuevaFabrica->GuardarEnArchivo($_pathArchivoEmpleados);
                $todoBien = TRUE;
            }
        }
    }
}

if (!$todoBien) {
    echo "<br>No pudo agregarse al siguiente empleado a la fabrica: <br>" . $_nuevoEmpleado->ToString() . "<br>";
    echo $_pathIndex;
} else {
    echo "<br>Se pudo agregar al empleado a la empresa!<br>";
    echo $_pathMostrar;
}
