require('./bootstrap');

window.addEventListener('DOMContentLoaded', (event) => {
    if(document.querySelector('#summernote')){
        $('#summernote').summernote();
    }
});