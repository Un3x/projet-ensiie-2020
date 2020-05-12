<div class="card card-item">
    <div class="card-image text-center">
        <a target="_blank" href="{{ \App\Core\Route::getUrl('domainPage', ['id' => $domain->getId()]) }}">
            <img class="img card-img-top rounded" style="width: 20em; height: auto;" src="@asset($domain->getImagePath())">
        </a>
    </div>
    <div class="card-body">
        <h6 class="category text-muted"></h6>
        <h4 class="card-title">
            <a target="_blank" href="{{ \App\Core\Route::getUrl('domainPage', ['id' => $domain->getId()]) }}" class="card-link">{{ $domain->getName() }}</a>
        </h4>
        <div class="card-description">
            <input disabled id="tags" type="text" value="{{ $domain->getTags(false) }}" class="tagsinput" data-role="tagsinput" data-color="primary" />
        </div>
        <div class="card-footer">
            <div class="likes-container">
                <span class="likes">@isset($domain->{'comments'}){{ $domain->{'comments'} }} <i class="fal fa-comments"></i>@endisset</span>
            </div>
        </div>
    </div>
</div>