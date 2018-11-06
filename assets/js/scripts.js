/**
 * <p>Mostra o tooltipo no rodapé</p>
 * @param {type} texto
 * @param {type} tempo
 * @returns {undefined}
 */
function mostrasSnackbar(texto, tempo) {
    //Define o valor padrão para 3000
    tempo = tempo || 3000;

    // Get the snackbar DIV

    var x = document.getElementById("snackbar");

    x.innerHTML = texto;

    // Add the "show" class to DIV
    x.className = "show";

    // After 3 seconds, remove the show class from DIV
    setTimeout(function () {
        x.className = x.className.replace("show", "");
    }, tempo);
    
}


$(document).ready(function () {

    $('.sair-sistema').click(function () {
        if (confirm('Deseja realmente sair do sistema?')) {
            window.location.href = "../../_sistema/funcoes-global/sair.php"
        }
    });

});
