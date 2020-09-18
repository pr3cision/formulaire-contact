//initialisation du document
$(function(){
    //definition de la fonction lors de l'execution du formulaire
    $('#contact-form').submit(function(e){
        e.preventDefault(); //previent comportement par default lors soumission formulaire
        $('.comments').empty(); //reinitialise la boite commentaire
        var postData = $('#contact-form').serialize(); //compilation des donne du formulaire a l'interieur d'une variable

        $.ajax({
            type: 'POST',
            url: './php/contact.php',
            data: postData,
            dataType: 'json',
            //implemente le message d'envoi lorsque client
            //soumet formulaire sans erreur
            success: function(result){
                //ensemble de fonction suivant l'envoi du formulaire
                //avec success
                if (result.isSuccess) {
                    $("#contact-form").append("<p class='thank-you'>Votre message a bien ete envoye. Merci de nous avoir contacte</p>");
                    //fonction permettant le reset du formulaire de contact
                    //lorsque le forms a ete envoye avec success
                    $("#contact-form")[0].reset();
                }
                //imbrique les message d'erreur lorsque le formulaire
                //comporte des erreurs
                else {
                    $("#firstname +.comments").html(result.firstnameError);
                    $("#name +.comments").html(result.nameError);
                    $("#email +.comments").html(result.emailError);
                    $("#phone +.comments").html(result.phoneError);
                    $("#message +.comments").html(result.messageError);
                }
            }
        });
    });
})