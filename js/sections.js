document.addEventListener('DOMContentLoaded', () => {

    loadSection('header', '/header.html');
    loadSection('footer', '/footer.html');

});


function loadSection(id, file) {

    fetch(file)
        .then(response => response.text())
        .then(data => {
            document.getElementById(id).innerHTML = data;
        })
        .catch(error => {
            console.error(`Error loading ${file}:`, error);
        });

}