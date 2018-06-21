
var hexchr="0123456789abcdef";
function bighexsoma (hex1, hex2){
	if (hex1.length > hex2.length) {
		a = hex2;
		hex2 = hex1;
		hex1 = a;
	}
	while (hex1.length < hex2.length)
		hex1 = '0' + hex1;

	sobra = 0;
	resultado = "";
	for(x = hex1.length-1; x>=0; x--) {
		if (hex1.charAt(x) > '9') op1 = hex1.charCodeAt(x)-hexchr.charCodeAt(10)+10;
		else			  op1 = hex1.charCodeAt(x)-hexchr.charCodeAt(0);
		if (hex2.charAt(x) > '9') op2 = hex2.charCodeAt(x)-hexchr.charCodeAt(10)+10;
		else			  op2 = hex2.charCodeAt(x)-hexchr.charCodeAt(0);

		r = op1 + op2 + sobra;
		if (r > 15) {
			r -= 16;
			sobra = 1;
		} else sobra = 0;

		resultado = hexchr.charAt(r) + resultado;
	}
	if (sobra == 1)
		resultado = "1" + resultado;
	return resultado;
}
/*
 *hex1 e hex2 sao strings hexa
 *devolve a string que representa hex2 - hex1
 */
function bighexsub (hex1, hex2) {
	if (hex1.length == hex2.length) {
		i=0;
		while (hex1.charAt(i) == hex2.charAt(i) && i<hex1.length) i++;

		if (i>=hex1.length) return 0;
		if (hex1.charAt(i) > hex2.charAt(i)) {
			sinal="";
			a = hex2;
			hex2 = hex1;
			hex1 = a;
		} else sinal = "-";
	}
	else {
		if (hex1.length < hex2.length) sinal="-";
		else {
			sinal="";
			a = hex2;
			hex2 = hex1;
			hex1 = a;
		}
		while (hex1.length < hex2.length)
			hex1 = "0" + hex1;
	}

	sobra = 0;
	resultado = "";
	for(x=hex1.length-1; x>=0; x--) {
		if (hex1.charAt(x) > '9') op1 = hex1.charCodeAt(x)-hexchr.charCodeAt(10)+10;
		else			  op1 = hex1.charCodeAt(x)-hexchr.charCodeAt(0);
		if (hex2.charAt(x) > '9') op2 = hex2.charCodeAt(x)-hexchr.charCodeAt(10)+10;
		else			  op2 = hex2.charCodeAt(x)-hexchr.charCodeAt(0);

		r = op2 - op1 - sobra;
		if (r < 0) {
			r += 16;
			sobra = 1;
		} else sobra = 0;

		resultado = hexchr.charAt(r) + resultado;
	}
	return sinal + resultado;
}
