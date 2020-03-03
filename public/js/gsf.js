// Scripts jQuery / JavaScript généraux

$(document).ready(function() { // Une fois que le document (base.html.twig) HTML/CSS a bien été complètement chargé...

    // add-collection-widget.js : fonction permettant d'ajouter un nouveau bloc "programme" au sein d'une session (pour agrandir la collection)
    $('.add-another-collection-widget').click(function (e) {
        var list = $($(this).attr('data-list-selector'))
        // Récupération du nombre actuel d'élément "programme" dans la collection (à défaut, utilisation de la longueur de la collection)
        var counter = list.data('widget-counter') || list.children().length
        // Récupération de l'identifiant de la session concernée, en cours de création/modification
        var session = list.data('session')
        // Extraction du prototype complet du champ (que l'on va adapter ci-dessous)
        var newWidget = list.attr('data-prototype')
        // Remplacement des séquences génériques "__name__" utilisées dans les parties "id" et "name" du prototype
        // par un numéro unique au sein de la collection de "programmes" : ce numéro sera la valeur du compteur
        // courant (équivalent à l'index du prochain champ, en cours d'ajout).
        // Au final, l'attribut ressemblera à "session[programmes][n°]"
        newWidget = newWidget.replace(/__name__/g, counter)
        // Ajout également des attributs personnalisés "class" et "value", qui n'apparaissent pas dans le prototype original 
        newWidget = newWidget.replace(/><input type="hidden"/, ' class="borders"><input type="hidden" value="'+session+'"')
        // Incrément du compteur d'éléments et mise à jour de l'attribut correspondant
        counter++
        list.data('widget-counter', counter)
        // Création d'un nouvel élément (avec son bouton de suppression), et ajout à la fin de la liste des éléments existants
        var newElem = $(list.attr('data-widget-tags')).html(newWidget)
        addDeleteLink($(newElem).find('div.borders'))
        newElem.appendTo(list)
    })

    // anonymize-collection-widget.js : fonction permettant de supprimer un bloc "programme" existant au sein d'une session
    $('.remove-collection-widget').find('div.borders').each(function() {
        addDeleteLink($(this))
    })

    // fonction permettant l'ajout d'un bouton "Supprimer ce module" dans un bloc "programme", et d'enregistrer l'évenement "click" associé
    function addDeleteLink($moduleForm) {
        var $removeFormButton = $('<div class="block"><button type="button" class="button">Supprimer ce module</button></div>');
        $moduleForm.append($removeFormButton)
    
        $removeFormButton.on('click', function(e) {
            $moduleForm.remove()
        })
    }

    // remove-session.js : fonction permettant de demander la confirmation de suppression d'une session
    $('.remove-session-confirm').on('click', function(e) {
        e.preventDefault()

        let id=$(this).data('id')
        let href=$(this).attr('href')

        showModalConfirm(id, href, "Confirmation de suppression d'une session")
    })

    // remove-stagiaire.js : fonction permettant de demander la confirmation de suppression d'un stagiaire
    $('.remove-stagiaire-confirm').on('click', function(e) {
        e.preventDefault()

        let id=$(this).data('id')
        let href=$(this).attr('href')

        showModalConfirm(id, href, "Confirmation de suppression d'un stagiaire")
    })

    // anonymize-stagiaire.js : fonction permettant de demander la confirmation d'anonymisation d'un stagiaire
    $('.anonymize-stagiaire-confirm').on('click', function(e) {
        e.preventDefault()

        let id=$(this).data('id')
        let href=$(this).attr('href')

        showModalConfirm(id, href, "Confirmation de l'anonymisation d'un stagiaire")
    })

    // Fonction permettant l'affichage de la fenêtre modale de confirmation pour chaque situation
    function showModalConfirm($id, $href, $title) {
        console.log("id   = "+$id)
        console.log("href = "+$href)

        $('#modalPopup .modal-title').html($title)
        $('#modalPopup .modal-body').html("<p class='center no-mg-bottom'><i class='fas fa-spinner fa-spin fa-4x'></i></p>")

        $.get(
            "confirm", // La route doit toujours être accessible au moyen du chemin "confirm" dans le contrôleur associé à l'entité concernée 
            {
                'id' : $id
            },
            function(resView) {
                $('#modalPopup .modal-body').html(resView)
            }
        )

        $('#modalConfirm').on('click', function(e){
            window.location.href = $href
        })

        // La ligne suivante a été supprimée, car on utilise désormais l'attribut "data-toggle" plutôt que "data-modal" sur les liens d'appel
        // $('#modalPopup').modal('show') 
    }
    
    // Fonction permettant dans le formulaire de saisie des informations d'un stagiaire, de mettre à jour la liste des villes en fonction du code postal donné précédemment
    $('.code-postal').on('change', function () {
        let code=$(this).val()
        console.log("Code Postal : "+code)

        const baseUrl="https://geo.api.gouv.fr/communes?codePostal="
        const argsUrl="&fields=nom&format=json"

        let apiUrl=baseUrl+code+argsUrl
        console.log("API URL : "+apiUrl)

        fetch(apiUrl, {method: 'get'}).then(response => response.json()).then(result => {
            $('.choix-ville').find('option').remove()
            if(result.length) {
                $.each(result, function(key, commune) {
                    // $.each(commune, function(champ, valeur) {
                        // console.log("Résultat : "+champ+" "+valeur)
                        // if (champ == 'nom') {
                            // $('.choix-ville').append('<option value="'+valeur+'">'+valeur+'</option>')
                        // }
                    // })
                    console.log("Résultat : "+commune.nom)
                    $('.choix-ville').append('<option value="'+commune.nom+'">'+commune.nom+'</option>')
                })
            } else {
                console.log("Résultats : CODE POSTAL INVALIDE !!!")
                $('.choix-ville').append('<option value="-">---</option>')
            }
        }).catch(err => {
            console.log("Erreur (API Geo) :"+err)
        })
    })

})