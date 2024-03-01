import './bootstrap';
// import 'bootstrap';
import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;
// import './bootstrap.bunddle.js';


const deleteModal = document.getElementById("deleteModal");
let myModal = null;

// Fonction pour mettre à jour l'action du formulaire de suppression avec le controller PostController et la méthode destroy
const formAction = (postHref) => {
    const deleteForm = document.getElementById("deleteForm");

    // Injecter les informations dans le formulaire de suppression
    const url = new URL(window.location.href)

    const params = new URLSearchParams(url.search);

    deleteForm.setAttribute("action", `${postHref}'?page=${params.get('page')}`)

}
window.addEventListener("open-modal", (event) => {
    console.log("open-modal event received", event);

    // Récupérer les informations depuis event.detail
    const {deleteUrl} = event.detail;
    // Mettre à jour l'action du formulaire de suppression avec les données nécessaires
    //formAction(deleteUrl)

    myModal = new bootstrap.Modal(deleteModal);
    myModal.show();
});

window.addEventListener("close-modal", (event) => {
    console.log("close-modal event received", event);
    //const myModalEl = document.getElementById("deleteModal");
    let modal = bootstrap.Modal.getInstance(deleteModal);
    modal.hide();
});


