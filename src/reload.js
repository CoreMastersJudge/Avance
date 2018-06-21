var msg = 0;
var rld  = 0;
var selecionando = 0;
var seg = 120;
function recarregar() {
	if (rld) {
		clearTimeout(rld);
        	rld  = 0;
        }
        if ((document.form1 && document.form1.message && document.form1.message.value) ||
            (document.form1 && document.form1.sourcefile && document.form1.sourcefile.value) ||
            (document.form1 && document.form1.answer && document.form1.answer.value) ||
            (document.form2 && document.form2.answer && document.form2.answer.value) ||
            (document.form2 && document.form2.message && document.form2.message.value) ||
            (document.form2 && document.form2.sourcefile && document.form2.sourcefile.value) ||
            selecionando == 1) {
            if (msg<5) {
				msg++;
			}
			else {
				alert("This page tried to reload, but it seems that you are filling\nthe form. To update, click on Reload button in your\nbrowser. This message will not be displayed again.");
            }
        } else
            document.location.reload();
    rld = setTimeout("recarregar()", seg * 1000);
}
function Comecar() {
	rld = setTimeout("recarregar()", seg * 1000);
}
function Parar() {
	if (rld) {
		clearTimeout(rld);
		rld  = 0;
	}
}
function Arquivo() {
	selecionando = 1;
}
