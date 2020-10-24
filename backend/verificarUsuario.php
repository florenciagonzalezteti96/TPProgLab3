<?php

require('/clases/fabrica.php');
require('/validarSesion.php');

$_pathDirectorioEmpleados = "/archivos";
$_pathArchivoEmpleados = $_pathDirectorioEmpleados . "/empleados.txt";

$_pathMostrar = "/mostrar.php";

$_pathLogin= "/login.html";

$existe = FALSE;

if(isset($_POST["txtDni"]) && isset($_POST["txtApellido"]))
{
    $dniEmpleado = $_POST["txtDni"];
    $apellidoEmpleado = $_POST["txtApellido"];

    if(is_dir($_pathDirectorioEmpleados))
    {
        if($_archivoEmpleados = fopen($_pathArchivoEmpleados, "r+"))
        {
            if ('' != file_get_contents($_pathArchivoEmpleados))
            {
                while(!feof($_archivoEmpleados))
                {
                    $empleado = fgets($_archivoEmpleados);

                    $datosEmpleado = explode(" - ", $empleado);
                    $datosEmpleado[0] = trim($datosEmpleado[0]);

                    if($datosEmpleado[0] != '')
                    {
                        $datosEmpleado[6] = trim($datosEmpleado[6], "\r\n");

                        $empleado = new Empleado($datosEmpleado[0], $datosEmpleado[1], $datosEmpleado[2], $datosEmpleado[3],$datosEmpleado[4],$datosEmpleado[5],$datosEmpleado[6]);

                        if($empleado->GetDni() == $dniEmpleado && $empleado->GetApellido() == $apellidoEmpleado)
                        {
                            $existe = TRUE;
                            break;
                        }
                        else
                        {
                            header("refresh:5;url=".$_pathLogin); 
                        }
                    }
                }
                if($existe)
                {
                    $_SESSION["DNIEmpleado"] = $dniEmpleado;
                    header("Location: /index.html");
                }
             
            fclose($_archivoEmpleados)
            }
          }
        }
      }
