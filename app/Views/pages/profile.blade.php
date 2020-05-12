@extends('templates.default')

@section('title', 'Profil')

@section('body-class', 'class="profile-page"')

@section('content')
<form id="profileUpdate" action="{{ \App\Core\Route::getUrl('profileAPI', ['id' => $user->getId(), 'redirect_path' => \App\Core\Route::find('profile')->getPath(['id' => $user->getId()])]) }}" method="POST" enctype="multipart/form-data" onsubmit="window.onbeforeunload = null; return true;">
    @csrf
    <input type="hidden" name="MAX_FILE_SIZE" value="{{ MAX_FILE_UPLOAD }}" />
    <div class="page-header page-header-small" filter-color="primary">
        <div id="bgPictureDisplay" class="page-header-image" data-parallax="true"></div>
        <div class="content-center">
            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                <div class="photo-container fileinput-new">
                    <img src="@asset($user->getPPPath())" alt="Image de profil">
                </div>
                @if($canEdit)
                <div class="photo-container fileinput-preview fileinput-exists"></div>
                <a class="btn btn-primary btn-round btn-sm btn-file" style="margin-top: -0.9em" onclick="modifiedData();">
                    <i class="now-ui-icons arrows-1_cloud-upload-94 fileinput-new"></i>
                    <i class="now-ui-icons arrows-1_cloud-upload-94 fileinput-exists"></i>
                    <input type="file" name="profilePicture" accept="image/*">
                </a>
                @endif
            </div>
            <h3 class="title" data-toggle="modal" data-target="#pseudoModal">
                <span id="usernameDisplay">{{ $user->getUsername() }}</span>
                @if($canEdit)
                    <button type="button" class="btn btn-primary btn-round btn-sm"><i class="now-ui-icons text_caps-small"></i></button>
                @endif
            </h3>
            <p class="category">{{ $user->getRoleName() }}</p>
            <div class="content">
                <div class="social-description">
                    <h2>{{ $comPosted }}</h2>
                    <p> @if($comPosted > 1)
                            Commentaires
                        @else
                            Commentaire
                        @endif </p>
                </div>
                <div class="social-description">
                    <h2>{{ count($favWines) }}</h2>
                    <p> @if(count($favWines) > 1)
                            Vins favoris
                        @else
                            Vin favori
                        @endif </p>
                </div>
                <div class="social-description">
                    <h2>{{ $wineProposed }}</h2>
                    <p> @if($wineProposed > 1)
                            Vins proposés
                        @else
                            Vin proposé
                        @endif </p>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            @if($canEdit)
                <div class="button-container">
                    <button type="button" class="btn btn-primary btn-round btn-lg" data-toggle="modal" data-target="#bgModal"><i class="fal fa-lg fa-image-polaroid"></i> Éditer</button>
                    <button type="button" class="btn btn-dark btn-round btn-lg" data-toggle="modal" data-target="#deleteModal"><i class="now-ui-icons ui-1_simple-remove"></i> Supprimer</button>
                </div>
            @endif
            <h3 class="title" style="margin-top: 2em">A propos</h3>
            <h5 class="description text-center" data-toggle="modal" data-target="#descriptionModal">
                <span id="descriptionDisplay">{{ $user->getDescription() }}</span>
                @if($canEdit)
                    <br><button type="button" class="btn btn-primary btn-round btn-sm"><i class="now-ui-icons text_caps-small"></i></button>
                @endif
            </h5>
        </div>
    </div>
    @if($canEdit)
    <div id="pseudoModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modification du pseudo</h5>
                    <button type="button" class="close" onclick="updatePseudo(true);" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="username">Entrez le nouveau pseudo :</label>
                    <input class="form-control" type="text" id="username" name="username"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="updatePseudo(true);">Rétablir</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="updatePseudo(false);">Ok !</button>
                </div>
            </div>
        </div>
    </div>
    <div id="descriptionModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modification de la description</h5>
                    <button type="button" class="close" onclick="updateDescription(true);" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="description">Entrez la nouvelle description :</label>
                    <textarea class="form-control" style="height: 200%" placeholder="Votre description..." id="description" name="description" rows="10">
                    </textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="updateDescription(true);">Rétablir</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="updateDescription(false);">Ok !</button>
                </div>
            </div>
        </div>
    </div>
    <div id="bgModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modification de la bannière</h5>
                    <button type="button" class="close" onclick="updateBg(true);" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="description">Entrez la nouvelle description :</label>
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail img-raised">
                            <img src="@asset($user->getBGPath())" alt="">
                        </div>
                        <div id="bgPicturePreview" class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                        <div>
                            <span class="btn btn-raised btn-round btn-default btn-file">
                               <span class="fileinput-new">Sélectionner une image</span>
                               <span class="fileinput-exists">Changer</span>
                               <input type="file" name="bgPicture" id="bgPicture" accept="image/*"/>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="updateBg(true);">Rétablir</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="updateBg(false);">Ok !</button>
                </div>
            </div>
        </div>
    </div>
    <div id="submitBtn" class="fixed-bottom text-center d-none">
        <input type="submit" class="btn btn-round btn-lg btn-success" value="Valider les changements"/>
    </div>
    @endif
</form>
@if($canEdit)
    <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
        <form action="{{ \App\Core\Route::getUrl('deleteProfileAPI', ['id' => $user->getId()]) }}" method="POST" onsubmit="if(document.getElementById('confirmDelete').value === 'CONFIRM-{{ $user->getId() }}'){window.onbeforeunload = null; return true;}else{return false;}">
            <input type="hidden" name="_method" value="DELETE">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Supression de l'utilisateur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4><i class="fal fa-lg fa-exclamation-triangle"></i> Attention !</h4>
                        <br>
                        <p>Si vous supprimez cet utilisateur, tous ses commentaires, favoris, et même les vins qu'il a proposé seront supprimés !</p>
                        <br>
                        <p><strong>Ce n'est pas une décision à prendre à la légère</strong></p>
                        <br>
                        <p>Entrez <code>CONFIRM-{{ $user->getId() }}</code> dans la boîte ci-dessous pour valider la suppression :</p>
                        <input class="form-control" type="text" id="confirmDelete" name="confirmDelete"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ok !</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endif
<div class="section related-items" data-background-color="black">
    <div class="container">
        <h3 class="title text-center">@if($favWines !== null && count($favWines) > 0) @if(\App\Core\Auth::isLogged() && \App\Core\Auth::loggedUser()->getId() === $user->getId()) Vos vins favoris @else Ses vins favoris @endif @else Aucun vin favori @endif</h3>
        <div class="row">
            @foreach($favWines as $wine)
                <div class="col-sm-6 col-md-3">
                    @component('components.wine.card', ['wine' => $wine])
                    @endcomponent
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('custom-foot')
    <script type="text/javascript">
        function updatePseudo(updateFromDisplay){
            if(updateFromDisplay){
                $('#username').val($('#usernameDisplay').text());
            }else{
                $('#usernameDisplay').text($('#username').val());
            }
        }

        function updateDescription(updateFromDisplay){
            if(updateFromDisplay){
                $('#description').val($('#descriptionDisplay').html().replace(/<br>/g, '').trim());
            }else{
                $('#descriptionDisplay').html($('#description').val().replace(/\n/g, '<br>\n').trim());
            }
        }

        function updateBg(reset){
            if(reset){
                $('#bgPictureDisplay').css("background-image", "url('@asset($user->getBGPath())')");
                $('#bgPicture').val('');
            }else{
                var preview = $('#bgPicturePreview :first-child');
                if(preview.length){
                    $('#bgPictureDisplay').css("background-image", "url(" +
                        $('#bgPicturePreview :first-child').attr('src') +
                        ")");
                }
            }
        }

        // On empêche de quitter la page si des données non enregistrées sont présentes
        function modifiedData(){
            window.onbeforeunload = function() {
                return "Des données peuvent ne pas être enregistrées !";
            }
            $('#submitBtn').removeClass('d-none');
        }
        $(document).on('show.bs.modal', '.modal', function () {
            modifiedData();
        });

        //Ici, on supprime l'autosubmit quand on appuie sur Entrée
        $('#profileUpdate input').keydown(function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                switch($(this).attr('id')){
                    case 'username':
                        updatePseudo(false);
                        $('#pseudoModal').modal('hide');
                        break;
                    case 'description':
                        updateDescription(false);
                        $('#descriptionModal').modal('hide');
                        break;
                }
                return false;
            }
        });
        updatePseudo(true);
        updateDescription(true);
        updateBg(true);
    </script>
@endsection