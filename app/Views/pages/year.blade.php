@extends('templates.default')

@section('title', 'Année')

@section('body-class', 'class="item-page"')

@section('content')
    <div class="page-header page-header-small">
        <div class="page-header-image" data-parallax="true" style="background-image: url('@asset('img/pages/year/header.jpg')') ;">
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div id="image" class="text-center">
                        <img src="@asset($year->getImagePath())" style="max-height: 40em;">
                    </div>
                </div>
                <div class="col-md-6 ml-auto mr-auto">
                    <h2 class="title"> {{ $year->getYear() }} </h2>
                    <div><input disabled id="tags" type="text" value="{{ $year->getTags(false) }}" class="tagsinput" data-role="tagsinput" data-color="primary" /></div>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            @include('components.comments')
        </div>
    </div>
    @include('components.fav-wines-section')
@endsection