function AdministrarValidaciones() {
  var form = document.getElementById("form");
  if (form.name == "formLogin") {
    var camposLogin = ["Dni", "Apellido"];
    for (var i = 0; i < camposLogin.length; i++) {
      if (ValidarCamposVacios("txt" + camposLogin[i]) == false) {
        // alert("El campo " + camposLogin[i] + " se encuentra vacio!");
        AdministrarSpanError("txt" + camposLogin[i] + "Span", false);
      } else {
        AdministrarSpanError("txt" + camposLogin[i] + "Span", true);
      }
    }
  } else if (form.name == "formAlta" || form.name == "formModificar") {
    var camposAlta = ["Dni", "Apellido", "Nombre", "Legajo", "Sueldo", "Foto"];
    for (var i = 0; i < camposAlta.length; i++) {
      if (ValidarCamposVacios("txt" + camposAlta[i]) == false) {
        // alert("El campo " + camposAlta[i] + " se encuentra vacio!");
        AdministrarSpanError("txt" + camposAlta[i] + "Span", false);
      } else {
        AdministrarSpanError("txt" + camposAlta[i] + "Span", true);
      }
    }
    var opcionesCboSexo = document.getElementById("cboSexo");
    for (var i = 0; i < opcionesCboSexo.length; i++) {
      if (opcionesCboSexo.options[i].selected) {
        if (!ValidarCombo(opcionesCboSexo.options[i].value, "---")) {
          AdministrarSpanError("cboSexoSpan", false);
        } else {
          AdministrarSpanError("cboSexoSpan", true);
        }
      }
    }
    var resultado = ValidarRangoNumerico(
      parseInt(document.getElementById("txtSueldo").value),
      8000,
      ObtenerSueldoMaximo(ObtenerTurnoSeleccionado())
    );
    if (!resultado) {
      AdministrarSpanError("txtSueldoSpan", false);
    }
  }
  if (VerificarValidacionesLogin()) {
    form.submit();
  }
}
function ValidarCamposVacios(valorRecibido) {
  var valor = document.getElementById(valorRecibido);
  var retorno = false;
  if (valor != null && typeof valor != "undefined") {
    if (valor.value != "") {
      retorno = true;
    }
  }
  return retorno;
}
function ValidarRangoNumerico(valorRecibido, min, max) {
  var retorno = true;
  if (valorRecibido != null && min != null && max != null) {
    if (valorRecibido < min || valorRecibido > max) {
      retorno = false;
    }
  }
  return retorno;
}
function ValidarCombo(valorRecibido, valorIncorrecto) {
  var retorno = false;
  if (valorRecibido != null && valorIncorrecto != null) {
    if (valorRecibido != valorIncorrecto) {
      retorno = true;
    }
  }
  return retorno;
}
function ObtenerTurnoSeleccionado() {
  var turnos = document.getElementsByName("rdoTurno");
  var retorno = "";
  if (turnos != null && typeof turnos != "undefined") {
    for (var i = 0; i < turnos.length; i++) {
      if (turnos[i].checked) {
        retorno += turnos[i].value;
        break;
      }
    }
  }
  return retorno;
}
function ObtenerSueldoMaximo(valorRecibido) {
  var retorno = 0;
  if (valorRecibido != null) {
    if (valorRecibido == "mañana") {
      retorno = 20000;
    } else if (valorRecibido == "tarde") {
      retorno = 18500;
    } else if (valorRecibido == "noche") {
      retorno = 25000;
    }
  }
  return retorno;
}
function AdministrarSpanError(id, display) {
  var span = document.getElementById(id);
  if (span != null) {
    if (!display) {
      span.style.display = "block";
    } else {
      span.style.display = "none";
    }
  }
}
function VerificarValidacionesLogin() {
  var spans = document.getElementsByName("span");
  var retorno = true;
  for (var i = 0; i < spans.length; i++) {
    if (spans[i].style.display == "block") {
      retorno = false;
      break;
    }
  }
  return retorno;
}
function AdministrarModificar(dni) {
  document.getElementById("hdnModificar").value = dni;
  document.getElementById("form").submit();
}
