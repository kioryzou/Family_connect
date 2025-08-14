
function mostrarInputArchivo(tipo) {
    const inputArchivo = document.getElementById('input-archivo');
    const inputMensaje = document.getElementById('input-mensaje');
    if(tipo === 'mensaje'){
        inputArchivo.style.display = 'none';
        inputMensaje.style.display = 'block';
    } else {
        inputArchivo.style.display = 'block';
        inputMensaje.style.display = 'none';
    }
}


document.addEventListener('DOMContentLoaded', function() {
    mostrarInputArchivo('<?= $tipoSeleccionado ?>');
});
