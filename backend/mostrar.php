<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML 5 – Listado de Empleados</title>
    <script src="../funciones.js"></script>
</head>

<body>
    <header>
        <h2>Listado de Empleados</h2>
    </header>
    <form name="formModificar" id="form" action="../index.php" method="POST">
        <table>
            <thead>
                <th>
                    <h4>Info</h4>
                </th>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <hr>
                    </td>
                </tr>
                <tr>
                    <?php
                    require('../clases/empleado.php');
                    include('./validarSesion.php');

                    $_pathDirectorioEmpleados = "../archivos";
                    $_pathArchivoEmpleados = $_pathDirectorioEmpleados . "/empleados.txt";

                    if (is_dir($_pathDirectorioEmpleados)) {
                        if ($_archivoEmpleados = fopen($_pathArchivoEmpleados, "r+")) {
                            if ('' != file_get_contents($_pathArchivoEmpleados)) {
                                while (!feof($_archivoEmpleados)) {
                                    $empleadoEnArchivo  = fgets($_archivoEmpleados);

                                    $datosEmpleado = explode(" - ", $empleadoEnArchivo);

                                    $datosEmpleado[0] = trim($datosEmpleado[0]);

                                    if ($datosEmpleado[0] != '') {
                                        $datosEmpleado[7] = trim($datosEmpleado[7], "\r\n");

                                        $empleadoNuevo = new Empleado($datosEmpleado[0], $datosEmpleado[1], $datosEmpleado[2], $datosEmpleado[3], $datosEmpleado[4], $datosEmpleado[5], $datosEmpleado[6]);
                                        $empleadoNuevo->SetPathFoto($datosEmpleado[7]);
                                        $turno = "";
                                        switch ($empleadoNuevo->GetTurno()) {
                                            case "mañana":
                                                $turno = 'M';
                                                break;
                                            case "tarde":
                                                $turno = 'T';
                                                break;
                                            case "noche":
                                                $turno = 'N';
                                                break;
                                        }

                                        echo "<td>" .
                                            $empleadoNuevo->GetNombre() . " - " .
                                            $empleadoNuevo->GetApellido() . " - " .
                                            $empleadoNuevo->GetDni() . " - " .
                                            $empleadoNuevo->GetSexo() . " - " .
                                            $empleadoNuevo->GetLegajo() . " - " .
                                            $empleadoNuevo->GetSueldo() . " - " .
                                            $turno . " - " .
                                            $empleadoNuevo->GetPathFoto() .
                                            "</td>
                                ";
                                        echo "
                                <td> 
                                <img src='." . $empleadoNuevo->GetPathFoto() . "' alt='Foto de empleado' width='90px' height='90px'>
                                </td>
                                <td> 
                                <a href='../eliminar.php?txtLegajo=" . $datosEmpleado[4] . "' method='GET'> Eliminar </a> 
                                </td>
                                <td> 
                                <button id='btnModificar' name='btnModificar' type='button' onclick='AdministrarModificar(" . $empleadoNuevo->GetDni() . ")'>Modificar
                                </button>
                                </td> 
                                </tr>";
                                    }
                                }
                            }
                            fclose($_archivoEmpleados);
                        } else {
                            echo "Error al abrir el archivo de empleados";
                        }
                    } else {
                        echo "Error al acceder al directorio del archivo de empleados";
                    }
                    ?>
                <tr>
                    <td>
                        <hr>
                    </td>
                </tr>
            </tbody>
        </table>
        <input type='hidden' id='hdnModificar' name='hdnModificar' value='vacio' />
    </form>
    <a href="../index.php">Alta de Empleados</a>
    <a href='./cerrarSesion.php'>Desloguearse</a>
</body>


</html>