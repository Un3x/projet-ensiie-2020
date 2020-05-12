@extends('templates.default')

@section('title', 'Recherche')

@section('content')
    <div class="page-header page-header-small" style="background-color: rgba(0, 0, 0, 0.3);">
        <div class="page-header-image" data-parallax="true" style="background-image: url('@asset('img/pages/search/header.jpg')'); transform: translate3d(0px, 0px, 0px);">
        </div>
        <div class="content-center">
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto">
                    <h1 class="title">{{ $actionDisplay['title'] }}</h1>
                    <div class="input-group">
                        <span class="input-group-addon" style="background-color: transparent; color: white;">
                            <i class="far fa-search"></i>
                        </span>
                        <input id="searchInput" type="text" class="form-control" placeholder="{{ $actionDisplay['placeholder'] }}" style="background-color: transparent; color: white;">
                    </div>
                    <button type="button" class="btn btn-success" onclick="getResults();"><i class="fal fa-file-search"></i> Rechercher</button>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="row">
                <h2>Résultats</h2>
            </div>
            <hr/>
            <div id="results">

            </div>
        </div>
    </div>
@endsection
@section('custom-foot')
    <script type="text/javascript">
        $('#searchInput').keydown(function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                getResults();
                return false;
            }
        });

        function getResults(){
            var search = $("#searchInput").val();
            $.post(
                '{{ \App\Core\Route::getUrl('searchAPI', ['action' => $action]) }}',
                {'str': search},
            ).done(function(data) {
                var elem = $('#results');
                elem.empty();
                elem.hide();
                elem.html(data.content.result ? data.content.result : "<h5>Aucun résultat</h5>");
                elem.fadeIn(600);
                $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
            }).fail(function (xhr) {
                alert(JSON.stringify(xhr));
            });
        }

        getResults();
    </script>
@endsection