document.addEventListener("DOMContentLoaded", function() {
    // Afficher la page de connexion après 3 secondes
    setTimeout(function() {
        document.querySelector(".loader-container").classList.add("loaded");
        document.querySelector(".login-container").classList.add("show");
    }, 500);
});

function toggleCommentSection(id) {
    const commentSection = document.getElementById(`comment-section-${id}`);
    commentSection.classList.toggle('hidden');
}

function toggleCommentAble(commentId) {
    const inputElement = document.getElementById('comment-input-' + commentId);
    const submitBtn = document.getElementById('submit-btn-' + commentId);
    
    // Activer le champ d'input en enlevant l'attribut disabled et afficher le bouton d'envoi
    if (inputElement.disabled) {
        inputElement.disabled = false;
        inputElement.classList.remove('bg-gray-100');
        inputElement.classList.add('bg-white');
        submitBtn.classList.remove('hidden');  
    } else {
        inputElement.disabled = true;
        inputElement.classList.remove('bg-white');
        inputElement.classList.add('bg-gray-100');
        submitBtn.classList.add('hidden'); 
    }
}
let lastClickedReaction = null;

function toggleReaction(publicationId, reaction) {
    const hiddenInput = document.getElementById('hidden-reaction-' + publicationId);
    const form = document.getElementById('reactionForm-' + publicationId);
    
    if (lastClickedReaction === reaction) {
        // Si on clique sur la même réaction, réinitialiser à la valeur vide
        hiddenInput.value = ''; 
        lastClickedReaction = null;

        // Réafficher toutes les réactions
        document.querySelectorAll('.reaction-label-' + publicationId).forEach(label => label.classList.remove('hidden'));
    } else {
        // Si c'est une nouvelle réaction, la sélectionner et cacher les autres
        hiddenInput.value = reaction;
        lastClickedReaction = reaction;

        document.querySelectorAll('.reaction-label-' + publicationId).forEach(label => {
            if (!label.id.includes(reaction)) {
                label.classList.add('hidden');  
            }
        });
    }
    
}
function previewImage(event) {
    var image = document.getElementById('image_preview');
    var reader = new FileReader();
    
    reader.onload = function() {
        image.src = reader.result;  // Remplace l'image par celle téléchargée
    }

    reader.readAsDataURL(event.target.files[0]);
}
function toggleSetting() {
    const commentSection = document.getElementById(`settingUsers`);
    commentSection.classList.toggle('hidden');
}
function toggleSearch() {
    const commentSection = document.getElementById(`searchinput`);
    commentSection.classList.toggle('hidden');
}

$(document).ready(function(){

    // Créer une publication
    $('#createForm').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            url: '../../controllers/publicationsController.php?action=create',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                $('#message').html('<div class="alert alert-success">Publication créée avec succès !</div>');
                fetchPublications();
            },
            error: function(xhr, status, error){
                $('#message').html('<div class="alert alert-danger">Erreur: ' + xhr.responseText + '</div>');
            }
        });
    });

    // Lire les publications
    function fetchPublications(){
        console.log("ito le");
        $.ajax({
            url: '../../controllers/publicationsController.php?action=read',
            type: 'GET',
            success: function(data){
                $('#publicationList').html(data);
            }
        });
    }
    fetchPublications();

    // Supprimer une publication
    $(document).on('click', '.deleteBtn', function(){
        var publicationId = $(this).data('id');
        if(confirm('Voulez-vous vraiment supprimer cette publication?')){
            $.ajax({
                url: '../../controllers/publicationsController.php?action=delete&id=' + publicationId,
                type: 'GET',
                success: function(response){
                    $('#message').html('<div class="alert alert-success">Publication supprimée avec succès !</div>');
                    fetchPublications();
                },
                error: function(xhr, status, error){
                    $('#message').html('<div class="alert alert-danger">Erreur: ' + xhr.responseText + '</div>');
                }
            });
        }
    });

    // Mettre à jour une publication
    $(document).on('click', '.editBtn', function(){
        var publicationId = $(this).data('id');
        $.ajax({
            url: '../../display/publications/update.php?id=' + publicationId,
            type: 'GET',
            success: function(data){
                $('#updateForm').html(data);
            }
        });
    });

    $('#updateForm').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);
        var publicationId = $('#publicationId').val();

        $.ajax({
            url: '../../controllers/publicationsController.php?action=update&id=' + publicationId,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                $('#message').html('<div class="alert alert-success">Publication mise à jour avec succès !</div>');
                fetchPublications();
            },
            error: function(xhr, status, error){
                $('#message').html('<div class="alert alert-danger">Erreur: ' + xhr.responseText + '</div>');
            }
        });
    });

});
