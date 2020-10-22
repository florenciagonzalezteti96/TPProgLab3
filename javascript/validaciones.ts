function AdministrarValidaciones(): void {
  let form = <HTMLFormElement>document.getElementById("form");

  if (form.name == "formLogin") {
    let camposLogin: Array<string> = ["Dni", "Apellido"];
    for (let i: number = 0; i < camposLogin.length; i++) {
      if (ValidarCamposVacios("txt" + camposLogin[i]) == false) {
        // alert("El campo " + camposLogin[i] + " se encuentra vacio!");
        AdministrarSpanError("txt" + camposLogin[i] + "Span", false);
      } else {
        AdministrarSpanError("txt" + camposLogin[i] + "Span", true);
      }
    }
  } else if (form.name == "formAlta" || form.name == "formModificar") {
    let camposAlta: Array<string> = [
      "Dni",
      "Apellido",
      "Nombre",
      "Legajo",
      "Sueldo",
      "Foto",
    ];

    for (let i: number = 0; i < camposAlta.length; i++) {
      if (ValidarCamposVacios("txt" + camposAlta[i]) == false) {
        // alert("El campo " + camposAlta[i] + " se encuentra vacio!");
        AdministrarSpanError("txt" + camposAlta[i] + "Span", false);
      } else {
        AdministrarSpanError("txt" + camposAlta[i] + "Span", true);
      }
    }

    let opcionesCboSexo = <HTMLSelectElement>document.getElementById("cboSexo");
    for (let i: number = 0; i < opcionesCboSexo.length; i++) {
      if (opcionesCboSexo.options[i].selected) {
        if (!ValidarCombo(opcionesCboSexo.options[i].value, "---")) {
          AdministrarSpanError("cboSexoSpan", false);
        } else {
          AdministrarSpanError("cboSexoSpan", true);
        }
      }
    }

    let resultado: boolean = ValidarRangoNumerico(
      parseInt((<HTMLInputElement>document.getElementById("txtSueldo")).value),
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

function ValidarCamposVacios(valorRecibido: string): boolean {
  let valor = <HTMLInputElement>document.getElementById(valorRecibido);
  var retorno: boolean = false;
  if (valor != null && typeof valor != "undefined") {
    if (valor.value != "") {
      retorno = true;
    }
  }
  return retorno;
}

function ValidarRangoNumerico(
  valorRecibido: number,
  min: number,
  max: number
): boolean {
  var retorno: boolean = true;
  if (valorRecibido != null && min != null && max != null) {
    if (valorRecibido < min || valorRecibido > max) {
      retorno = false;
    }
  }

  return retorno;
}

function ValidarCombo(valorRecibido: string, valorIncorrecto: string): boolean {
  var retorno: boolean = false;
  if (valorRecibido != null && valorIncorrecto != null) {
    if (valorRecibido != valorIncorrecto) {
      retorno = true;
    }
  }

  return retorno;
}

function ObtenerTurnoSeleccionado(): string {
  let turnos: NodeListOf<HTMLElement> = document.getElementsByName("rdoTurno");
  var retorno: string = "";
  if (turnos != null && typeof turnos != "undefined") {
    for (let i: number = 0; i < turnos.length; i++) {
      if ((<HTMLInputElement>turnos[i]).checked) {
        retorno += (<HTMLInputElement>turnos[i]).value;
        break;
      }
    }
  }

  return retorno;
}

function ObtenerSueldoMaximo(valorRecibido: string): number {
  var retorno: number = 0;
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

function AdministrarSpanError(id: string, display: boolean): void {
  let span = <HTMLSpanElement>document.getElementById(id);
  if (span != null) {
    if (!display) {
      span.style.display = "block";
    } else {
      span.style.display = "none";
    }
  }
}

function VerificarValidacionesLogin(): boolean {
  let spans: NodeListOf<HTMLElement> = document.getElementsByName("span");
  var retorno = true;
  for (let i: number = 0; i < spans.length; i++) {
    if ((<HTMLSpanElement>spans[i]).style.display == "block") {
      retorno = false;
      break;
    }
  }

  return retorno;
}

function AdministrarModificar(dni: string): void {
  (<HTMLInputElement>document.getElementById("Modificar")).value = dni;
  (<HTMLFormElement>document.getElementById("form")).submit();
}
