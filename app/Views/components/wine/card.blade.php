<div class="card card-item">
    <div class="card-image text-center">
        <a target="_blank" href="{{ \App\Core\Route::getUrl('winePage', ['id' => $wine->getId()]) }}">
            <img class="img card-img-top rounded" style="height: 20em; width: auto;" src="@asset($wine->getImagePath())">
        </a>
    </div>
    <div class="card-body">
        <h6 class="category text-muted">{{ $wine->getYearId()->getYear() }}</h6>
        <h4 class="card-title">
            <a target="_blank" href="{{ \App\Core\Route::getUrl('winePage', ['id' => $wine->getId()]) }}" class="card-link">{{ $wine->getName() }}</a>
        </h4>
        <div class="card-description">
            {{ \App\Utils::limit($wine->getDescription()) }}
        </div>
        <div class="card-footer">
            <div class="likes-container">
                <span class="likes">@isset($wine->{'likes'}){{ $wine->{'likes'} }} <i class="fal fa-wine-glass"></i>@endisset</span>
            </div>
        </div>
    </div>
</div>