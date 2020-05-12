@extends('templates.default')

@section('title', 'Vin')

@section('body-class', 'class="item-page"')

@section('custom-header')
    <style>
        .fileinput-preview img{
            max-height: 40em;
        }
    </style>
@endsection

@section('content')
    <div class="page-header page-header-small">
        <div class="page-header-image" data-parallax="true" style="background-image: url('@asset('img/pages/wine/header.jpg')') ;">
        </div>
        @if(isset($isCreating) && $isCreating)
        <div class="content-center">
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto">
                    <h1 class="title">Création d'un vin</h1>
                </div>
            </div>
        </div>
        @endif
    </div>
    <form id="wineUpdate" action="@if(isset($isCreating) && $isCreating) {{ \App\Core\Route::getUrl('winesNewAPI') }} @else {{ \App\Core\Route::getUrl('winesEditAPI', ['id' => $wine->getId()]) }} @endif" method="POST" enctype="multipart/form-data" onsubmit="return prepareSubmit();">
    @csrf
    <input type="hidden" name="MAX_FILE_SIZE" value="{{ MAX_FILE_UPLOAD }}" />
        <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div id="image" class="text-center" style="margin-top: -10em;">
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            <div class="photo-container fileinput-new">
                                <img src="@asset($wine->getImagePath())" style="max-height: 40em;">
                            </div>
                            @if($editMode || $isCreating)
                            <div class="photo-container fileinput-preview fileinput-exists"></div>
                            <button type="button" class="btn btn-primary btn-round btn-sm btn-file" style="margin-top: -0.9em" onclick="modifiedData();">
                                <i class="now-ui-icons arrows-1_cloud-upload-94 fileinput-new"></i>
                                <i class="now-ui-icons arrows-1_cloud-upload-94 fileinput-exists"></i>
                                <input type="file" name="winePicture" accept="image/*">
                            </button>
                            @endif
                        </div>
                    </div>
                    <p class="blockquote blockquote-primary">
                        « @if(isset($topCom)) {{ $topCom->getMsg() }} @else Semblable à la rosée d’un bois normand qui, délaissé depuis des années, se serait mis à pourrir @endif »
                        <br>
                        <br>
                        <small>@if(isset($topCom)) {{ $topCom->getUser()->getUsername() }} @else Inako @endif</small>
                    </p>
                </div>
                <div class="col-md-6 ml-auto mr-auto">
                    <div class="d-inline">
                        <button type="button" id="like-wine" @if(\App\Core\Auth::isLogged() && $wine->{'isLiked'}) data-liked @endif class="btn btn-default btn-neutral btn-lg" @can @isset($wid) onclick="toggleWineLike();" @endisset data-original-title="Ajouter ou supprimer des favoris" @endcan @cannot data-original-title="Vous devez être connecté pour effectuer cette action" @endcan data-toggle="tooltip" data-placement="bottom" data-animation="true">
                            <span data-like-num>{{ $wine->{'likes'} }}</span> <i class="fal fa-wine-glass"></i>
                        </button>
                        @if($editMode && !$isCreating)
                        <button type="button" class="btn btn-danger btn-lg" id="removeBtn" data-toggle="modal" data-target="#deleteModal">
                            <i class="now-ui-icons ui-1_simple-remove"></i> Supprimer
                        </button>
                        <button type="button" class="btn btn-simple btn-lg" id="backBtn" onclick="window.onbeforeunload = null; window.location = '{{ \App\Core\Route::getUrl('winePage', ['id' => $wine->getId()]) }}'">
                            <i class="fal fa-undo fa-lg"></i> Annuler
                        </button>
                        @endif
                        @if(isset($canEdit) && $canEdit && !$isCreating)
                        <a type="button" class="btn btn-simple btn-lg" id="editBtn" href="{{ \App\Core\Route::getUrl('wineEditPage', ['id' => $wine->getId()]) }}">
                            <i class="fal fa-pencil-alt fa-lg"></i> Éditer
                        </a>
                        @endif
                    </div>
                    <h2 class="title" data-toggle="modal" data-target="#nameModal"><span id="nameDisplay">{{ $wine->getName() }}</span>
                        @if($editMode)
                            <button type="button" class="btn btn-primary btn-round btn-sm"><i class="now-ui-icons text_caps-small"></i></button>
                        @endif
                    </h2>

                    <h5 class="category">
                        <strong>
                            <a class="text-dark-gray" target="_blank" href="{{ \App\Core\Route::getUrl('domainPage', ['id' => $domain->getId()]) }}">
                                <span id="domainDisplay">{{ $domain->getName() }}</span>
                            </a>
                            @if($editMode)
                            <button type="button" data-toggle="modal" data-target="#domainModal" class="btn btn-primary btn-round btn-sm"><i class="now-ui-icons text_caps-small"></i></button>
                            @endif
                        </strong>
                        •
                        <a class="text-dark-gray" target="_blank" href="{{ \App\Core\Route::getUrl('typePage', ['id' => $type->getId()]) }}">
                            <span id="typeDisplay">{{ $type->getName() }}</span>
                        </a>
                        @if($editMode)
                        <button type="button" data-toggle="modal" data-target="#typeModal" class="btn btn-primary btn-round btn-sm"><i class="now-ui-icons text_caps-small"></i></button>
                        @endif
                    </h5>
                    <h2 class="main-price">
                        <a class="text-dark" target="_blank" href="{{ \App\Core\Route::getUrl('yearPage', ['id' => $year->getId()]) }}">
                            <span id="yearDisplay">{{ $year->getYear() }}</span>
                        </a>
                        @if($editMode)
                        <button type="button" data-toggle="modal" data-target="#yearModal" class="btn btn-primary btn-round btn-sm"><i class="now-ui-icons text_caps-small"></i></button>
                        @endif
                    </h2>
                    <div id="tagsContainer">
                        <input @if(!$editMode && !$isCreating) disabled @endif id="tags" name="tags" type="text" value="{{ $wine->getTags(false) }}" class="tagsinput" data-role="tagsinput" data-color="primary" />
                    </div>
                    <div id="accordion" role="tablist" aria-multiselectable="true" class="card-collapse">
                        <div class="card card-plain">
                            <div class="card-header" role="tab" id="headingOne">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Description
                                    <i class="now-ui-icons arrows-1_minimal-down"></i>
                                </a>
                            </div>
                            <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                                <div class="card-body" data-toggle="modal" data-target="#descriptionModal">
                                    <p><span id="descriptionDisplay">{{ $wine->getDescription() }}</span>
                                    @if($editMode)
                                        <button type="button" class="btn btn-primary btn-round btn-sm"><i class="now-ui-icons text_caps-small"></i></button>
                                    @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="media justify-content-md-end justify-content-center align-items-center">
                        <a class="pull-left" href="{{ \App\Core\Route::getUrl('profile', ['id' => $wine->getProposedBy()->getId()]) }}" target="_blank">
                            <div class="avatar">
                                <img class="media-object rounded-circle img-raised" alt="Photo de profil" src="@asset(\App\Models\User::getPPPathFromId($wine->getProposedBy()->getId()))">
                            </div>
                        </a>
                        <h5 style="margin: 0;">Proposé par <a href="{{ \App\Core\Route::getUrl('profile', ['id' => $wine->getProposedBy()->getId()]) }}" target="_blank">{{ $wine->getProposedBy()->getUsername() }}</a></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="submitBtn" class="fixed-bottom text-center d-none">
        <input type="submit" class="btn btn-round btn-lg btn-success w-100" value="Valider les changements"/>
    </div>
    @if($editMode || $isCreating)
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
        <div id="nameModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modification du nom</h5>
                        <button type="button" class="close" onclick="updateName(true);" data-dismiss="modal" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="name">Entrez le nouveau nom :</label>
                        <input class="form-control" type="text" id="name" name="name"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="updateName(true);">Rétablir</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="updateName(false);">Ok !</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="domainModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modification du domaine</h5>
                        <button type="button" class="close" onclick="updateDomain(true);" data-dismiss="modal" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mb-5">
                        <label for="name">Entrez un domaine :</label>
                        <input class="form-control" type="text" id="domain" name="domain" autocomplete="off"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="updateDomain(true);">Rétablir</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="updateDomain(false);">Ok !</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="typeModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modification du type</h5>
                        <button type="button" class="close" onclick="updateType(true);" data-dismiss="modal" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mb-5">
                        <label for="name">Entrez un type :</label>
                        <input class="form-control" type="text" id="type" name="type" autocomplete="off"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="updateType(true);">Rétablir</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="updateType(false);">Ok !</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="yearModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modification de l'année</h5>
                        <button type="button" class="close" onclick="updateYear(true);" data-dismiss="modal" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mb-5">
                        <label for="name">Entrez une année :</label>
                        <input class="form-control" type="text" id="year" name="year" autocomplete="off"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="updateYear(true);">Rétablir</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="updateYear(false);">Ok !</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </form>
    @if($editMode)
        <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
            <form action="{{ \App\Core\Route::getUrl('winesDeleteAPI', ['id' => $wine->getId()]) }}" method="POST" onsubmit="window.onbeforeunload = null; return true;">
                <input type="hidden" name="_method" value="DELETE">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Supression du vin</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h4><i class="fal fa-lg fa-exclamation-triangle"></i> Attention !</h4>
                            <br>
                            <p>Si vous supprimez ce vin, tous ses commentaires et favoris seront supprimés</p>
                            <br>
                            <p>Confirmez-vous cette action ?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary btn-lg">Confirmer !</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
    @if(!$isCreating)
    <div class="section">
        <div class="container">
            @include('components.comments')
        </div>
    </div>
    @endif
    @include('components.fav-wines-section')
    <script type="text/javascript">

        function updateName(updateFromDisplay){
            if(updateFromDisplay){
                $('#name').val($('#nameDisplay').text());
            }else{
                modifiedData();
                $('#nameDisplay').text($('#name').val());
            }
        }

        function updateDescription(updateFromDisplay){
            if(updateFromDisplay){
                $('#description').val($('#descriptionDisplay').html().replace(/<br>/g, '').trim());
            }else{
                modifiedData();
                $('#descriptionDisplay').html($('#description').val().replace(/\n/g, '<br>\n').trim());
            }
        }

        function updateDomain(updateFromDisplay){
            if(updateFromDisplay){
                $('#domain').val($('#domainDisplay').text());
            }else{
                modifiedData();
                $('#domainDisplay').text($('#domain').val());
            }
        }

        function updateType(updateFromDisplay){
            if(updateFromDisplay){
                $('#type').val($('#typeDisplay').text());
            }else{
                modifiedData();
                $('#typeDisplay').text($('#type').val());
            }
        }

        function updateYear(updateFromDisplay){
            if(updateFromDisplay){
                $('#year').val($('#yearDisplay').text());
            }else{
                modifiedData();
                $('#yearDisplay').text($('#year').val());
            }
        }

        @if($editMode)
        // On empêche de quitter la page si des données non enregistrées sont présentes
        function modifiedData(){
            window.onbeforeunload = function() {
                return "Des données peuvent ne pas être enregistrées !";
            }
            $('#submitBtn').removeClass('d-none');
        }
        @endif

        function prepareSubmit(){
            window.onbeforeunload = null;
            var tags = $("#tags")
            tags.val(tags.val());
            return true;
        }

        function toggleWineLike(){
            var elem = $('#like-wine');
            var wantToLike = !elem[0].hasAttribute('data-liked');
            $.post(
                '{{ \App\Core\Route::getUrl('winesLike') }}'.replace(/{id}/g, {{ $wine->getId() }}),
                {
                    liked : wantToLike ? 1 : 0,
                    _token: '@csrfvalue'
                }
            ).done(function(data) {
                if(data.type === "ok"){
                    toggleLikedDisplay(elem, wantToLike, data.content.count);
                }else{
                    console.log(data);
                    alert('Un problème est survenue pendant le like du commentaire : \n' + JSON.stringify(data));
                }
            }).fail(function(xhr, status, error) {
                alert(JSON.stringify(xhr));
            });
        }
        if(typeof toggleLikedDisplay !== 'function'){
            window.toggleLikedDisplay =     function toggleLikedDisplay(elem, isLiked, newCount){
                if(isLiked){
                    elem.removeClass('btn-default').removeClass('btn-neutral').addClass('btn-primary');
                    elem.attr('data-liked', '');
                }else{
                    elem.removeClass('btn-primary').addClass('btn-default').addClass('btn-neutral');
                    elem.removeAttr('data-liked');
                }
                if(newCount !== undefined){
                    elem.find('[data-like-num]').text(newCount);
                }
            }
        }
    </script>
@endsection

@section('custom-foot')
    <script type="text/javascript">
        $('#tagsContainer').click(function(e){
            modifiedData();
        });

        $('#wineUpdate').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#wineUpdate input').keydown(function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                switch($(this).attr('id')){
                    case 'name':
                        updateName(false);
                        $('#nameModal').modal('hide');
                        break;
                    case 'description':
                        updateDescription(false);
                        $('#descriptionModal').modal('hide');
                        break;
                }
                return false;
            }
        });

        $('#domain').autoComplete({
            resolverSettings: {
                url: '{{ \App\Core\Route::getUrl('domainSearch') }}'
            },
            minLength: 0,
            noResultsText: "Ajouter comme nouveau domaine"
        });

        $('#type').autoComplete({
            resolverSettings: {
                url: '{{ \App\Core\Route::getUrl('typeSearch') }}'
            },
            minLength: 0,
            noResultsText: "Ajouter comme nouveau type"
        });

        $('#year').autoComplete({
            resolverSettings: {
                url: '{{ \App\Core\Route::getUrl('yearSearch') }}'
            },
            minLength: 0,
            noResultsText: "Ajouter comme nouvelle année"
        });

        updateDescription(true);
        updateName(true);
        updateDomain(true);
        updateType(true);
        updateYear(true);
    </script>
@endsection