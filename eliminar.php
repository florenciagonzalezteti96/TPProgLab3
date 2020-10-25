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
                    <a href="./index.html">Mostrar Empleados</a>
                    </body>
                    </html> ';

$_archivoEmpleados = "./archivos/empleados.txt";

if (isset($_GET["txtLegajo"])) {
    if ($archivo = fopen($_archivoEmpleados, 'r+')) {
        while (!feof($archivo)) {
            $empleado = fgets($archivo);

            if (strpos($empleado, $_GET["txtLegajo"]) !== false) {
                $datosEmpleado = explode(" - ", $empleado);
                $datosEmpleado[0] = trim($datosEmpleado[0]);

                if ($datosEmpleado[0] != '') {
                    $datosEmpleado[7] = trim($datosEmpleado[7], "\r\n");

                    $empleadoNuevo = new Empleado($datosEmpleado[0], $datosEmpleado[1], $datosEmpleado[2], $datosEmpleado[3], $datosEmpleado[4], $datosEmpleado[5], $datosEmpleado[6]);
                    $empleadoNuevo->SetPathFoto($datosEmpleado[7]);

                    if ($empleadoNuevo->GetLegajo() == $_GET["txtLegajo"]) {
                        $nuevaFabrica = new Fabrica("Fabriquita", 10);
                        $nuevaFabrica->TraerDeArchivo($_archivoEmpleados);
                        $pathFotoEmpleado = $empleadoNuevo->GetPathFoto();
                        if (!$nuevaFabrica->EliminarEmpleado($empleadoNuevo)) {
                            echo "NO se pudo eliminar al empleado";
                            echo $_pathIndex;
                        } else {
                            echo "Se elimino al empleado";
                            $nuevaFabrica->ToString();
                            $nuevaFabrica->GuardarEnArchivo($_archivoEmpleados);
                            echo $_pathMostrar;
                        }
                    }
                }
            }
        }
        fclose($archivo);
    } else {
        echo "No se pudo abrir el archivo";
        echo $_pathIndex;
    }
}
