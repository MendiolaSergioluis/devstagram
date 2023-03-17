// ################# Dropzone #################
import Dropzone from 'dropzone';

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('.dropzone', {
    dictDefaultMessage: 'Sube aquí tu imagen',
    acceptedFiles: ".png,.jpg,.jpeg,.gif,.webp",
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar Archivo',
    maxFiles: 1,
    uploadMultiple: false,

    // Función para recuperar la información en caso de fallas en la validación del formulario
    init: function() {
        if(document.querySelector('[name="imagen"]').value.trim()){
            const imagenPublicada = {}
            imagenPublicada.size = 70000;
            imagenPublicada.name = document.querySelector('[name="imagen"]').value;

            this.options.addedfile.call(this, imagenPublicada);
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);

            imagenPublicada.previewElement.classList.add('dz-success','dz-complete');
        }
    },
});

// Muestra toda la información del archivo
dropzone.on('sending', function(file, xhr, formData){
    console.log(file);
});

/*
dropzone.on('sending', function(file, xhr, formData){
    console.log(formData);
});
*/

// Muestra mensajes de error para poder debuguear
dropzone.on('error', function(file, message){
    console.log(message);
});

// Envía un mensaje cuando todo marcha bien
dropzone.on('success', function(file, response){
    // console.log(response.imagen);
    document.querySelector('[name="imagen"]').value = response.imagen;
});

// Muestra un archivo por consola cuando se elimina un archivo.
dropzone.on('removedfile', function(){
    // console.log('Archivo Eliminado');
    // Eliminando valor del archivo si es que se borra el archivo
    document.querySelector('[name="imagen"]').value = '';
});

// ############################################