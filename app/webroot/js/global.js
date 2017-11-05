// JavaScript Document
function validchars(evt,allowedchars) {
	kcode=(evt.keyCode>0)?evt.keyCode:evt.charCode;
	if(allowedchars.indexOf(String.fromCharCode(kcode))==-1&&kcode!=8&&kcode!=9&&kcode!=13)
		return false;
	else 
		return true;
}

var numpunto = "1234567890.";
var num = "1234567890";
var nums = "1234567890Kk";
var notas = "1234567890";
var numDireccion = "1234567890SNsn/";
var numsCuentaBancaria = "1234567890-";

function verificaRut(rut, dv) {
    var caracteres = new Array();
    var serie = new Array(2, 3, 4, 5, 6, 7);
    var dig = dv;

    for (var i = 0; i < rut.length; i++) {
        caracteres[i] = parseInt(rut.charAt((rut.length - (i + 1))));
    }

    var sumatoria = 0;
    var k = 0;
    var resto = 0;

    for (var j = 0; j < caracteres.length; j++) {
        if (k == 6) {
            k = 0;
        }
        sumatoria += parseInt(caracteres[j]) * parseInt(serie[k]);
        k++;
    }

    resto = sumatoria % 11;
    dv = 11 - resto;

    if (dv == 10) {
        dv = "K";
    }
    else if (dv == 11) {
        dv = 0;
    }

    if (dv.toString().trim().toUpperCase() == dig.toString().trim().toUpperCase())
        return true;
    else
        return false;
    
}