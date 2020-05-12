<div class="section related-items" data-background-color="black">
    <div class="container">
        <h3 class="title text-center">Les vins les plus appréciés</h3>
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