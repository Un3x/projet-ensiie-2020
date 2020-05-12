@extends('templates.default')

@section('title', 'Accueil')

@section('body-class', 'class="presentation-page"')

@section('content')

    <div class="page-header clear-filter">
        <div class="rellax-header rellax-header-sky" data-rellax-speed="-2">
            <div class="page-header-image" style="background-image: url('@asset('img/pages/home/sky.jpg')')">
            </div>
        </div>
        <div class="rellax-header rellax-header-wine-bottles" data-rellax-speed="0">
            <div class="page-header-image page-header-city" style="background-image: url('@asset('img/pages/home/wine-bottles.png')')">
            </div>
        </div>
        <div class="rellax-text-container rellax-text" data-rellax-speed="-2">
            <h1 class="h1-seo"><span class="bordeaux-shadow">Oenolog</span><span class="bordeaux-inverted-shadow">IIE</span></h1>
        </div>
        <h3 class="h3-description rellax-text" data-rellax-speed="1">
            <a class="btn btn-round btn-primary" href="#derniere-reunion">
                <i class="now-ui-icons education_paper"></i>
                &ensp;La dernière réunion
            </a>
        </h3>
    </div>
    <div class="section section-testimonials" data-background-color="black" style="margin-top: 20vh;">
        <div class="row">
            <div class="col-md-8 ml-auto mr-auto text-center">
                <h2 class="title">Best of Commentaires</h2>
                <h5 class="description">Ici se retrouvent les meilleurs commentaires :
                    <b>la crème de la crème</b></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="testimonials-people">
                    <img class="left-first-person img-raised rellax" data-rellax-speed="1" src="@asset($randomFunc())" alt="">
                    <img class="left-second-person img-raised rellax" data-rellax-speed="3" src="@asset($randomFunc())"  alt="">
                    <img class="left-third-person img-raised rellax" data-rellax-speed="2" src="@asset($randomFunc())"  alt="">
                    <img class="left-fourth-person img-raised rellax" data-rellax-speed="5" src="@asset($randomFunc())"  alt="">
                    <img class="left-fifth-person img-raised rellax" data-rellax-speed="7" src="@asset($randomFunc())"  alt="">
                </div>
            </div>
            <div class="col-md-8">
                <div id="carouselExampleIndicators2" class="carousel slide">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators2" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators2" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators2" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" id="carouselContainer" role="listbox">

                        @foreach($tabCom as $com)
                            @include('components.home-best-com', ['com'=>$com])
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                        <i class="now-ui-icons arrows-1_minimal-left"></i>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next">
                        <i class="now-ui-icons arrows-1_minimal-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-2">
                <div class="testimonials-people">
                    <img class="right-first-person img-raised rellax" data-rellax-speed="5" src="@asset($randomFunc())" alt="">
                    <img class="right-second-person img-raised rellax" data-rellax-speed="1" src="@asset($randomFunc())" alt="">
                    <img class="right-fourth-person img-raised rellax" data-rellax-speed="7" src="@asset($randomFunc())" alt="">
                    <img class="right-fifth-person img-raised rellax" data-rellax-speed="3" src="@asset($randomFunc())" alt="">
                    <img class="right-sixth-person img-raised rellax" data-rellax-speed="5" src="@asset($randomFunc())" alt="">
                </div>
            </div>
        </div>
    </div>
    <div id="derniere-reunion" class="section section-components" data-background-color="dark-red">
        <div class="container">
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto">
                    <h2 class="text-center title">Les vins de la dernière réunion
                        <br>
                        <small class="description">Ils étaient tous horribles. Merci à vous :)</small>
                    </h2>
                    <!--
                    <h5 class="text-center description">
                        <a href="" class="btn btn-neutral btn-link">Compte-Rendu</a>
                    </h5>
                    -->
                    <div class="space-25"></div>
                </div>
            </div>
            <div class="row">
                @foreach($tabWines as $wine)
                    @include('components.home-wines', ['wine'=>$wine])
                @endforeach
            </div>
        </div>
    </div>
    <!--
    <div class="section">
        <img src="/assets/img/pages/home/tonneau.png" class="front tonneau img-fluid" alt="Responsive image" style="width: 100%;">
    </div>
    -->
    <div class="section section-sections" data-background-color="black">
        <div class="container" style="margin-top: -20vh;">
            <div class="col-md-8 ml-auto mr-auto">
                <div class="section-description text-center">
                    <!--
                    <h2 class="title">Les Réunions</h2>
                    <h5 class="description"> Un instant de convivialité où la rigueur est de mise lorsqu'il s'agit de noter un vin :mdr:</h5>
                    -->
                    <h2 class="title">Les Commentaires</h2>
                    <h5 class="description"> Fruits des esprits éveillés par l'instant de clarté qui suit le verre de trop </h5>

                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row m-2">
                @foreach($allCom as $com)
                    @include('components.home-com', ['com'=>$com])
                @endforeach
            </div>
        </div>
        <!--
        <img class="rellax" data-rellax-speed="4" src="@asset('img/presentation-page/pricing5.jpg')" alt="">
        -->
    </div>
@endsection

@section('custom-foot')
    <script type="text/javascript">
        $('#carouselContainer').children(':first').addClass("active");
    </script>
@endsection
