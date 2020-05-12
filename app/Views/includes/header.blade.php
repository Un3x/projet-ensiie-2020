<div class="fixed-bottom">
    @if(\App\Core\Session::has('success'))
        @foreach(\App\Core\Session::get('success', []) as $success)
            @include('components.notification', [
                'alertClass' => 'alert-success',
                'icon' => 'ui-2_like',
                'catchPhrase' => 'Bien joué !',
                'msg' => $success])
        @endforeach
    @endif

    @if(\App\Core\Session::has('notifs'))
        @foreach(\App\Core\Session::get('notifs', []) as $notif)
            @include('components.notification', [
                'alertClass' => 'alert-warning',
                'icon' => 'ui-1_bell-53',
                'catchPhrase' => 'Information !',
                'msg' => $notif])
        @endforeach
    @endif

    @if(\App\Core\Session::has('warnings'))
        @foreach(\App\Core\Session::get('warnings', []) as $warning)
            @include('components.notification', [
                'alertClass' => 'alert-warning',
                'icon' => 'ui-1_bell-53',
                'catchPhrase' => 'Attention !',
                'msg' => $warning])
        @endforeach
    @endif

    @if(\App\Core\Session::has('errors'))
        @foreach(\App\Core\Session::get('errors', []) as $error)
            @include('components.notification', [
                'alertClass' => 'alert-danger',
                'icon' => 'objects_support-17',
                'catchPhrase' => 'Oh zut !',
                'msg' => $error])
        @endforeach
    @endif

</div>
<nav class="navbar navbar-expand-lg bg-white fixed-top navbar-transparent" color-on-scroll="500">
    <div class="container">
        <div class="navbar-translate">
            <a class="navbar-brand" href="/" rel="tooltip" title="Le site du club OenologIIE de l'ENSIIE" data-placement="bottom">
                Ton nez dans mon vin
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" data-nav-image="@asset('img/header/mobile-header-background.jpg')" data-color="purple">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown">
                        <i class="far fa-lg fa-search" aria-hidden="true"></i>
                        <p>Recherche</p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{ \App\Core\Route::getUrl('search', ['action' => 'vins']) }}">
                            <i class="fal fa-lg fa-wine-glass"></i>  Vins
                        </a>
                        <a class="dropdown-item" href="{{ \App\Core\Route::getUrl('search', ['action' => 'domaines']) }}">
                            <i class="fal fa-lg fa-mountains"></i> Domaines
                        </a>
                        <a class="dropdown-item" href="{{ \App\Core\Route::getUrl('search', ['action' => 'annees']) }}">
                            <i class="fal fa-lg fa-calendar-alt"></i>  Années
                        </a>
                        <a class="dropdown-item" href="{{ \App\Core\Route::getUrl('search', ['action' => 'types']) }}">
                            <i class="fad fa-lg fa-wine-bottle"></i>  Types
                        </a>
                        <a class="dropdown-item" href="{{ \App\Core\Route::getUrl('search', ['action' => 'utilisateurs']) }}">
                            <i class="now-ui-icons users_single-02"></i>  Utilisateurs
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ \App\Core\Route::getUrl('wineAddPage') }}" class="nav-link">
                        <i class="now-ui-icons ui-1_simple-add" aria-hidden="true"></i>
                        <p>Ajouter un vin</p>
                    </a>
                </li>

                @if(!\App\Core\Auth::isLogged())
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white" data-toggle="modal" data-target="#loginModal">
                            <p>Se connecter</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-simple" href="{{ \App\Core\Route::getUrl('register') }}">
                            <p>Créer un compte</p>
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link btn btn-primary text-white dropdown-toggle" id="navbarDropdownUser" data-toggle="dropdown">
                            <i class="now-ui-icons users_single-02"></i>
                            <p>{{ \App\Core\Auth::loggedUser()->getUsername() }}</p>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownUser">
                            <a class="dropdown-item" href="/profil">
                                <i class="now-ui-icons users_single-02" aria-hidden="true"></i>
                                Mon profil
                            </a>
                            <a class="dropdown-item" href="/user/logout?redirect_path={{ \App\Core\Request::pathUrl() }}">
                                <i class="now-ui-icons media-1_button-power" aria-hidden="true"></i>
                                Se déconnecter
                            </a>
                        </div>
                    </li>

                @endif
                <!-- <li class="nav-item">
                <a class="nav-link" rel="tooltip" title="Follow us on Twitter" data-placement="bottom" href="https://twitter.com/CreativeTim" target="_blank">
                    <i class="fa fa-twitter"></i>
                    <p class="hidden-lg-up">Twitter</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" rel="tooltip" title="Like us on Facebook" data-placement="bottom" href="https://www.facebook.com/CreativeTim" target="_blank">
                    <i class="fa fa-facebook-square"></i>
                    <p class="hidden-lg-up">Facebook</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" rel="tooltip" title="Follow us on Instagram" data-placement="bottom" href="https://www.instagram.com/CreativeTimOfficial" target="_blank">
                    <i class="fa fa-instagram"></i>
                    <p class="hidden-lg-up">Instagram</p>
                </a>
            </li> -->
            </ul>
        </div>
    </div>
</nav>

<div class="modal fade modal-primary" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="Se connecter" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-login">
        <div class="modal-content">
            <div class="card card-login card-plain">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="now-ui-icons ui-1_simple-remove"></i>
                    </button>
                    <div class="header header-primary text-center">
                        <div class="logo-container">
                            <img src="@asset('img/logo.png')" alt="" title="" style="">
                        </div>
                    </div>
                </div>
                <form id="loginForm" class="form" method="POST" action="{{ \App\Core\Route::getUrl('loginAPI', ['redirect_path' => \App\Core\Request::pathUrl()]) }}" data-form-on>
                    @csrf
                    <div class="modal-body">
                        <div class="card-content">
                            <div class="input-group form-group-no-border input-lg">
                                        <span class="input-group-addon">
                                            <i class="now-ui-icons users_circle-08"></i>
                                        </span>
                                <input name="usernameOrEmail" id="usernameOrEmail" type="text" class="form-control" placeholder="Pseudo ou adresse email..." data-form-min="2" data-form-field>
                            </div>
                            <div class="input-group form-group-no-border input-lg">
                                        <span class="input-group-addon">
                                            <i class="now-ui-icons ui-1_lock-circle-open"></i>
                                        </span>
                                <input name="password" id="password" type="password" placeholder="Mot de passe..." class="form-control" data-form-min="8" data-form-field>
                            </div>
                            <small><a class="text-white" href="{{ \App\Core\Route::getUrl('register') }}">Pas de compte ?</a></small>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <input type="submit" class="btn btn-neutral btn-round btn-lg btn-block" value="Se connecter">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
