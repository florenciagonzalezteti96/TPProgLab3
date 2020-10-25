<?php

require('./clases/fabrica.php');
include('./backend/validarSesion.php');

$_archivoEmpleados = "./archivos/empleados.txt";
$modificar = FALSE;
$rdoTurno = "<input type='radio' name='rdoTurno' value='mañana' checked/>
              <label>Mañana</label><br />
              <input type='radio'  name='rdoTurno' value='tarde' />
              <label>Tarde</label><br />
              <input type='radio'  name='rdoTurno' value='noche' />
              <label>Noche</label>";
$cboSexo = "<select name='cboSexo' id='cboSexo' name='cboSexo'>
            <option value='---' selected>Seleccione</option>
            <option value='M'>Masculino</option>
            <option value='F'>Femenino</option>
            </select>";


if (isset($_POST['hdnModificar'])) {
  if ($_POST['hdnModificar'] != "vacio") {
    $fabrica = new Fabrica("Fabrica HTML5");
    $fabrica->TraerDeArchivo($_archivoEmpleados);
    $empleadosEnFabrica = $fabrica->GetEmpleados();
    for ($i = 0; $i < count($empleadosEnFabrica); $i++) {
      if ($empleadosEnFabrica[$i]->GetDni() == $_POST["hdnModificar"]) {
        $modificar = TRUE;
        $empleado = new Empleado($empleadosEnFabrica[$i]->GetNombre(), $empleadosEnFabrica[$i]->GetApellido(), $empleadosEnFabrica[$i]->GetDni(), $empleadosEnFabrica[$i]->GetSexo(), $empleadosEnFabrica[$i]->GetLEgajo(), $empleadosEnFabrica[$i]->GetSueldo(), $empleadosEnFabrica[$i]->GetTurno());
        $empleado->SetPathFoto($empleadosEnFabrica[$i]->GetPathFoto());
        switch ($empleado->GetTurno()) {
          case "tarde":
            $rdoTurno = "<input type='radio' name='rdoTurno' value='mañana' />
              <label>Mañana</label><br />
              <input type='radio'  name='rdoTurno' value='tarde' checked/>
              <label>Tarde</label><br />
              <input type='radio'  name='rdoTurno' value='noche' />
              <label>Noche</label>";
            break;
          case "noche":
            $rdoTurno = "<input type='radio' name='rdoTurno' value='mañana' />
              <label>Mañana</label><br />
              <input type='radio'  name='rdoTurno' value='tarde' />
              <label>Tarde</label><br />
              <input type='radio'  name='rdoTurno' value='noche' checked/>
              <label>Noche</label>";
            break;
        }
        switch ($empleado->GetSexo()) {
          case "M":
            $cboSexo = "<select name='cboSexo' id='cboSexo' name='cboSexo'>
            <option value='---' >Seleccione</option>
            <option value='M' selected>Masculino</option>
            <option value='F'>Femenino</option>
            </select>";
            break;
          case "F":
            $cboSexo = "<select name='cboSexo' id='cboSexo' name='cboSexo'>
            <option value='---' >Seleccione</option>
            <option value='M' >Masculino</option>
            <option value='F'selected>Femenino</option>
            </select>";
            break;
        }
        break; //for
      }
    }
  }
}

if ($modificar) {
  echo "<!DOCTYPE html>
  <html lang='en'>
    <head>
      <meta charset='UTF-8' />
      <meta name='viewport' content='width=device-width, initial-scale=1.0' />
      <title>HTML5 Formulario Modificar Empleado</title>
      <script src='./funciones.js'></script>
    </head>
    <body>
      <header>
        <h2>Modificacion de empleado</h2>
      </header>
      <form name='formAlta' id='form'
        style='
          justify-content: center;
          box-sizing: border-box;
          padding: 10px;
          margin: 2% 35%;
        '
        enctype='multipart/form-data'
  
        action='./administracion.php'
  
        method='POST'
      >
        <table>
          <thead>
            <h4>Datos Personales</h4>
          </thead>
          <hr />
          <tbody>
            <tr>
              <td>DNI:</td>
              <td>
                <input type='numbers' min='1000000' max='55000000' id='txtDni' name='txtDni' value='" . $empleado->GetDni() . "' readonly/>
                <span name='span' id='txtDniSpan' style='display: none'>*</span>
              </td>
            </tr>
            <tr>
              <td>Apellido:</td>
              <td>
                <input type='text' id='txtApellido' name='txtApellido' value='" . $empleado->GetApellido() . "'/>
                <span name='span' id='txtApellidoSpan' style='display: none'>*</span>
              </td>
              
            </tr>
            <tr>
              <td>Nombre:</td>
              <td>
                <input type='text' id='txtNombre' name='txtNombre' value='" . $empleado->GetNombre() . "'/>
                <span name='span' id='txtNombreSpan' style='display: none'>*</span>
              </td>
            </tr>
            <tr>
              <td>Sexo:</td>
              <td>
              " . $cboSexo . "
                <span name='span' id='cboSexoSpan' style='display: none'>*</span>
              </td>
            </tr>
          </tbody>
        </table>
        <table>
          <thead>
            <h4>Datos Laborales</h4>
          </thead>
          <hr />
          <tbody>
            <tr>
              <td>Legajo:</td>
              <td>
                <input type='numbers' min='100' max='550' id='txtLegajo' name='txtLegajo' value='" . $empleado->GetLegajo() . "' readonly/>
                <span name='span' id='txtLegajoSpan' style='display: none'>*</span>
              </td> 
            </tr>
            <tr>
              <td>Sueldo:</td>
              <td>
                <input type='number' min='8000' max='25000' step='500' id='txtSueldo' name='txtSueldo' value='" . $empleado->GetSueldo() . "'/>
                <span name='span' id='txtSueldoSpan' style='display: none'>*</span>
              </td>
            </tr>
            <tr>
              <td>Turno:</td>
              <tr>
                <td>
                " . $rdoTurno . "
                </td>
              </tr>
            </tr>
            <tr>
              <td>
                Foto:
              </td>
              <td>
                <input type='file' id='txtFoto' name='txtFoto' accept='image/jpg, image/bmp, image/gif, image/png, image/jpeg' value='" . $empleado->GetPathFoto() . "'>
                <span name='span' id='txtFotoSpan' style='display: none'>*</span>
              </td>
            </tr>
          </tbody>
        </table>
        <hr>
        <button id='btnLimpiar' type='reset' style='margin-left: 80%; margin-top: 2%; margin-bottom: 2%;'>Limpiar</button>
        <button id='btnEnviar' name='btnEnviar' type='button' onclick='AdministrarValidaciones()' style='margin-left: 80%; margin-top: 1%; margin-bottom: 1%;'>Modificar</button>
        <input type='hidden' id='hdnModificar' name='hdnModificar' value='vacio' />
      </form>
    </body>
  </html>";
} else {
  echo "<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='UTF-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <title>HTML5 - Formulario Alta Empleado</title>
    <script src='./funciones.js'></script>
  </head>
  <body>
    <header>
      <h2>Alta de empleados</h2>
    </header>
    <form name='formAlta' id='form'
      style='
        justify-content: center;
        box-sizing: border-box;
        padding: 10px;
        margin: 2% 35%;
      '
      enctype='multipart/form-data'

      action='./administracion.php'

      method='POST'
    >
      <table>
        <thead>
          <h4>Datos Personales</h4>
        </thead>
        <hr />
        <tbody>
          <tr>
            <td>DNI:</td>
            <td>
              <input type='numbers' min='1000000' max='55000000' id='txtDni' name='txtDni'/>
              <span name='span' id='txtDniSpan' style='display: none'>*</span>
            </td>
          </tr>
          <tr>
            <td>Apellido:</td>
            <td>
              <input type='text' id='txtApellido' name='txtApellido'/>
              <span name='span' id='txtApellidoSpan' style='display: none'>*</span>
            </td>
            
          </tr>
          <tr>
            <td>Nombre:</td>
            <td>
              <input type='text' id='txtNombre' name='txtNombre'/>
              <span name='span' id='txtNombreSpan' style='display: none'>*</span>
            </td>
          </tr>
          <tr>
            <td>Sexo:</td>
            <td>
              " . $cboSexo . "
              </select>
              <span name='span' id='cboSexoSpan' style='display: none'>*</span>
            </td>
          </tr>
        </tbody>
      </table>
      <table>
        <thead>
          <h4>Datos Laborales</h4>
        </thead>
        <hr />
        <tbody>
          <tr>
            <td>Legajo:</td>
            <td>
              <input type='numbers' min='100' max='550' id='txtLegajo' name='txtLegajo'/>
              <span name='span' id='txtLegajoSpan' style='display: none'>*</span>
            </td> 
          </tr>
          <tr>
            <td>Sueldo:</td>
            <td>
              <input type='number' min='8000' max='25000' step='500' id='txtSueldo' name='txtSueldo' />
              <span name='span' id='txtSueldoSpan' style='display: none'>*</span>
            </td>
          </tr>
          <tr>
            <td>Turno:</td>
            <tr>
              <td>
              " . $rdoTurno . "
              </td>
            </tr>
          </tr>
          <tr>
            <td>
              Foto:
            </td>
            <td>
              <input type='file' id='txtFoto' name='txtFoto' accept='image/jpg, image/bmp, image/gif, image/png, image/jpeg'>
              <span name='span' id='txtFotoSpan' style='display: none'>*</span>
            </td>
          </tr>
        </tbody>
      </table>
      <hr>
      <button id='btnLimpiar' type='reset' style='margin-left: 80%; margin-top: 2%; margin-bottom: 2%;'>Limpiar</button>
      <button id='btnEnviar' name='btnEnviar' type='button' onclick='AdministrarValidaciones()' style='margin-left: 80%; margin-top: 1%; margin-bottom: 1%;'>Enviar</button>
    </form>
  </body>
</html>";
}
