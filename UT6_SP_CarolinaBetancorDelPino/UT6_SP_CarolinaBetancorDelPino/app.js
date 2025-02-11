function votarLibro(IDLibro, calificacion) {
    axios.post('miVoto.php', { id_libro: IDLibro, calificacion: calificacion })
        .then(response => {
            if (response.data.success) {
                actualizarEstrellas(IDLibro, response.data.valoracion_media, response.data.total_votos);
                mostrarBotonBorrarVoto(true, IDLibro);
            } else {
                alert(response.data.message || 'Error al votar.');
            }
        })
        .catch(error => console.error('Error:', error));
}
function mostrarBotonBorrarVoto(existeVoto, IDLibro) {
    let botonEliminarVoto = document.querySelector(`#borrar-voto-btn-${IDLibro}`);
    if (!botonEliminarVoto) {
        botonEliminarVoto = document.createElement('button');
        botonEliminarVoto.id = `borrar-voto-btn-${IDLibro}`;
        botonEliminarVoto.classList.add('borrar-voto-btn');
        botonEliminarVoto.textContent = 'Eliminar voto';
        botonEliminarVoto.onclick = function () {
            borrarVoto(IDLibro);
        };
        const contenedor = document.querySelector(`#borrarBoton-${IDLibro}`);
        if (contenedor) {
            contenedor.appendChild(botonEliminarVoto);
        }
    }
    if (existeVoto) {
        botonEliminarVoto.style.display = 'block';
    } else {
        botonEliminarVoto.style.display = 'none';
    }
}
function borrarVoto(IDLibro) {
    axios.post('borrarVoto.php', { id_libro: IDLibro })
        .then(response => {
            console.log(response.data);
            if (response.data.success) {
                actualizarEstrellas(IDLibro, response.data.valoracion_media, response.data.total_votos);
                mostrarBotonBorrarVoto(false, IDLibro)
            } else {
                alert(response.data.message || 'Error al eliminar voto.');
            }
        })
        .catch(error => console.error('Error:', error));
}
function actualizarEstrellas(IDLibro, valoracionMedia, totalVotos) {
    const estrellasDiv = document.getElementById(`estrellas-${IDLibro}`);
    estrellasDiv.innerHTML = generarHtmlEstrellas(valoracionMedia) + `<span> (${totalVotos} votos)</span>`;
}
function generarHtmlEstrellas(valoracionMedia) {
    let html = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= valoracionMedia) {
            html += '<i class="fas fa-star"></i>';
        } else if (i - valoracionMedia < 1) {
            html += '<i class="fas fa-star-half-alt"></i>';
        } else {
            html += '<i class="far fa-star"></i>';
        }
    }
    return html;
}