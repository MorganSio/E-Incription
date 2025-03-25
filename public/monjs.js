// Form register
document.addEventListener('DOMContentLoaded', function () {
    // Fonction suivant pour naviguer entre les sections
    function suivant(nb) {
        if (nb == 1) {
            document.getElementById('RegistrationFirst').style.display = 'block';
            document.getElementById('RegistrationFourth').style.display = 'none';
        }
        if (nb == 2) {
            document.getElementById('RegistrationFirst').style.display = 'none';
            document.getElementById('RegistrationSecond').style.display = 'block';
        } else if (nb == 3) {
            document.getElementById('RegistrationSecond').style.display = 'none';
            document.getElementById('RegistrationThird').style.display = 'block';
        } else if (nb == 4) {
            document.getElementById('RegistrationThird').style.display = 'none';
            document.getElementById('RegistrationFourth').style.display = 'block';
        }
    }
 
    // Fonction pour enregistrer l'utilisateur (actuellement vide, à compléter selon besoin)
    function registerUser() {
        var mail;
        var password;
        var role = document.querySelector('input[name="role"]:checked')?.value;
        var nom;
        var prenom;
 
        // Ajoute la logique de traitement des valeurs ici (ex : envoyer à un serveur, validation, etc.)
    }
});
// Form mdl
document.addEventListener('DOMContentLoaded', function () {
    // Gestion du bouton de validation de la première section
    const validateFirstBtn = document.getElementById('validateFirst');
    if (validateFirstBtn) {
        validateFirstBtn.addEventListener('click', function () {
            const acceptYes = document.getElementById('acceptYes').checked;
            const acceptNo = document.getElementById('acceptNo').checked;
 
            // Si "Oui" est sélectionné, afficher la deuxième section
            if (acceptYes) {
                document.getElementById('mdlFirst').style.display = 'none';
                document.getElementById('mdlSecond').style.display = 'block';
            }
 
            // Si "Non" est sélectionné, afficher une alerte et rester sur intFirst
            if (acceptNo) {
                // Récupérer le formulaire parent du bouton
                const form = document.querySelector('form');
                if (form) {
                    form.submit();
                }
            }
        });
    }
 
    // Gestion du bouton de validation de la deuxième section
    const validateSecondBtn = document.getElementById('validateSecond');
    if (validateSecondBtn) {
        validateSecondBtn.addEventListener('click', function () {
            const paymentMethodCheque = document.getElementById('radio-rich-payment-1').checked;
            const paymentMethodCash = document.getElementById('radio-rich-payment-2').checked;
            const imageRightsAuthorize = document.getElementById('radio-rich-image-1').checked;
            const imageRightsDoNotAuthorize = document.getElementById('radio-rich-image-2').checked;
 
            // Vérifier que le mode de paiement a été sélectionné
            if (!paymentMethodCheque && !paymentMethodCash) {
                alert("Veuillez sélectionner un mode de paiement.");
                return;
            }
 
            // Vérifier que le choix concernant le droit à l'image a été fait
            if (!imageRightsAuthorize && !imageRightsDoNotAuthorize) {
                alert("Veuillez indiquer votre choix pour le droit à l'image.");
                return;
            }
 
            // Soumettre le formulaire ou afficher un message de confirmation
            // alert("Merci ! Votre formulaire a été soumis.");
            // document.getElementById('mdlSecondForm').submit(); // Décommentez pour envoyer le formulaire
        });
    }
});
 
// Form self
document.addEventListener('DOMContentLoaded', function () {
    const validFirstBtn = document.getElementById('validFirst');
   
    // Vérifier si l'élément existe
    if (validFirstBtn) {
        validFirstBtn.addEventListener('click', function () {
            const acceptYes = document.getElementById('acceptYes').checked;
            const acceptNo = document.getElementById('acceptNo').checked;
 
            // Si "Oui" est sélectionné, afficher la deuxième section
            if (acceptYes) {
                document.getElementById('intFirst').style.display = 'none';
                document.getElementById('intSecond').style.display = 'block';
            }
 
            // Si "Non" est sélectionné, afficher une alerte et rester sur intFirst
            if (acceptNo) {
                alert("Vous avez refusé l'inscription à l'Intendance BTS.");
            }
        });
    }
 
    const validSecondBtn = document.getElementById('validSecond');
    if (validSecondBtn) {
        validSecondBtn.addEventListener('click', function () {
            // Récupérer les éléments du formulaire
            const regimeForfait5Days = document.getElementById('regime-5-days').checked;
            const regimeForfait4Days = document.getElementById('regime-4-days').checked;
            const regimeTickets = document.getElementById('regime-tickets').checked;
            const regimeExterne = document.getElementById('regime-externe').checked;
 
            const paymentCheque = document.getElementById('payment-cheque').checked;
            const paymentCard = document.getElementById('payment-card').checked;
            const paymentCash = document.getElementById('payment-cash').checked;
 
            // Vérifier que le régime a été sélectionné
            if (!regimeForfait5Days && !regimeForfait4Days && !regimeTickets && !regimeExterne) {
                alert("Veuillez sélectionner un régime.");
                return;
            }
 
            // Vérifier que le mode de paiement a été sélectionné
            if (!paymentCheque && !paymentCard && !paymentCash) {
                alert("Veuillez sélectionner un mode de paiement.");
                return;
            }
 
            // Si toutes les conditions sont remplies, soumettre le formulaire ou afficher un message de confirmation
            alert("Merci ! Votre formulaire a été soumis.");
            // document.getElementById('mdlSecondForm').submit(); // Décommentez pour envoyer le formulaire
        });
    }
});
 
// Form représentant légal
document.addEventListener("DOMContentLoaded", function () {
    console.log("JavaScript chargé, vérification des formulaires...");
 
    // Vérifie que les formulaires sont bien détectés
    document.querySelectorAll("form[id^='represantant']").forEach(form => {
        console.log("Formulaire détecté :", form.id);
    });
 
    // Vérifie que les boutons de validation sont bien détectés
    document.querySelectorAll("[id^='validateRepresentantLegaux']").forEach(button => {
        console.log("Bouton détecté :", button.id);
 
        button.addEventListener("click", function () {
            console.log("Bouton cliqué :", button.id);
 
            let index = button.dataset.index;
            let form = document.getElementById("representant" + index);
 
            if (!form) {
                console.error("Formulaire representant" + index + " non trouvé !");
                return;
            }
 
            console.log("Formulaire récupéré :", form.id);
 
            let formData = new FormData(form);
            let data = {};
           
            console.log(form);
            data['repNumber']=index
 
 
            formData.forEach((value, key) => {
                data[key] = value;
            });
 
            if (typeof data["lien"+index] !== 'undefined' && data["lien"+index] == "autre" )
            {
                data["lien"+index] = data["preciser"+index];
            }
 
            // data["addresse"+index] = data["addresse-voie"+index]+data["postal-code"+index]+data["addresse-city"+index]
 
            console.log("Données du formulaire envoyées :", data);
 
            fetch("/representant/legal/save", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert("Identité " + index + " enregistrée !");
                } else {
                    alert("Erreur : " + result.message);
                }
            })
            .catch(error => {
                console.error("Erreur d'envoi des données :", error);
               
                alert("Erreur de connexion avec le serveur.");
            });
        });
    });
});