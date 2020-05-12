@extends('templates.default')

@section('title', 'Création de compte')

@section('body-class', 'class="signup-page"')

@section('content')
<div class="page-header section-image">
    <div class="page-header-image" style="background-image:url('@asset('img/pages/signup/background.jpg')')"></div>
    <div class="content-center">
        <div class="container">
            <div class="row">
                <div class="col-md-5 ml-auto mr-auto d-none d-md-block">
                    <div class="info info-horizontal">
                        <div class="icon icon-primary">
                            <i class="now-ui-icons ui-2_favourite-28"></i>
                        </div>
                        <div class="description">
                            <h5 class="info-title">Favoris</h5>
                            <p class="description">
                                Vous deviendrez un membre éminent d'OenologIIE en proposant vos meilleurs vins
                            </p>
                        </div>
                    </div>
                    <div class="info info-horizontal">
                        <div class="icon icon-primary">
                            <i class="now-ui-icons ui-1_calendar-60"></i>
                        </div>
                        <div class="description">
                            <h5 class="info-title">Organisation</h5>
                            <p class="description">
                                Vous pourrez participer à des événements ou même les créer
                            </p>
                        </div>
                    </div>
                    <div class="info info-horizontal">
                        <div class="icon icon-info">
                            <i class="now-ui-icons users_single-02"></i>
                        </div>
                        <div class="description">
                            <h5 class="info-title">Communauté</h5>
                            <p class="description">
                                Vous pourrez poster des nouveaux vins et commenter ceux des autres !
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card card-signup">
                        <div class="card-body">
                            <h4 class="card-title text-center">Création de votre compte</h4>
                            <br>
                            <form id="signupForm" class="form" method="POST" action="{{ \App\Core\Route::getUrl('registerAPI', ['redirect_path' => '/']) }}" data-form-on>
                                <input type="hidden" name="_method" value="PUT" />
                                @csrf
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="now-ui-icons users_circle-08"></i>
                                        </span>
                                    <input id="signupPseudo" type="text" name="pseudo" class="form-control" placeholder="Votre pseudo ..." value="{{\App\Core\Response::old('pseudo')}}" data-form-min="1" data-form-field>
                                </div>
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="now-ui-icons ui-1_email-85"></i>
                                        </span>
                                    <input id="signupEmail" type="email" name="email" placeholder="Votre Email ..." class="form-control" value="{{\App\Core\Response::old('email')}}" data-form-field>
                                </div>
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="now-ui-icons ui-1_lock-circle-open"></i>
                                        </span>
                                    <input id="signupPassword" type="password" name="password" class="form-control" placeholder="Mot de passe ..." data-form-min="8" data-form-field data-form-match="pass">
                                </div>
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="now-ui-icons ui-1_lock-circle-open"></i>
                                        </span>
                                    <input id="signupPasswordConfirm" type="password" name="password_confirmation" class="form-control" placeholder="Confirmer le mot de passe ..." data-form-min="8" data-form-field data-form-match="pass">
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input id="signupAgreement" name="agreement" class="form-check-input" type="checkbox" data-form-checked data-form-field>
                                        <span class="form-check-sign"></span>
                                        J'accepte les <strong><a data-toggle="modal" data-target="#termsModal">termes et conditions</a></strong>.
                                    </label>
                                </div>
                                <div class="card-footer text-center">
                                    <button id="signupSubmit" type="submit" class="btn btn-primary btn-round btn-lg">S'enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModal" aria-hidden="true">
    <div class="modal-dialog modal-notice">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="now-ui-icons ui-1_simple-remove"></i>
                </button>
                <h5 class="modal-title" id="myModalLabel">Termes et conditions</h5>
            </div>
            <div class="modal-body">
                <div class="instruction">
                    <div class="row">
                        <div class="col-md-8">
                            <strong>Collecte de données</strong>
                            <p class="description">
                                Aucune information personnelle n'est collectée à votre insu. <br>
                                Aucune information personnelle n'est cédée à un tiers. <br>
                                Conformément à la loi du 6 janvier 1978 relative à l'informatique, aux fichiers et aux libertés, vous disposez d'un droit d'accès, de modification, de rectification et de suppression des données vous concernant. <br>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <div class="picture">
                                <img src="@asset('img/pages/signup/data-privacy.jpg')" alt="Data privacy" class="rounded img-raised" title="" style="">
                            </div>
                        </div>
                    </div>
                </div>
                <p>Si vous avez d'autres questions, n'hésitez pas à nous contacter sur <strong><a href="mailto:eleves@iiens.net" target="_blank">eleves@iiens.net</a></strong>.<br>Nous sommes là pour vous aider !</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="w-100 btn btn-info btn-round" data-dismiss="modal">Ok !</button>
            </div>
        </div>
    </div>
</div>
@endsection
