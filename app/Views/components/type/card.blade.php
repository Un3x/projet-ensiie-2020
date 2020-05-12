<div class="card card-item">
    <div class="card-image text-center">
        <a target="_blank" href="{{ \App\Core\Route::getUrl('typePage', ['id' => $type->getId()]) }}">
            <img class="img card-img-top rounded" style="width: 20em; height: auto;" src="@asset($type->getImagePath())">
        </a>
    </div>
    <div class="card-body">
        <h6 class="category text-muted"></h6>
        <h4 class="card-title">
            <a target="_blank" href="{{ \App\Core\Route::getUrl('typePage', ['id' => $type->getId()]) }}" class="card-link">{{ $type->getName() }}</a>
        </h4>
        <div class="card-description">
            <input disabled id="tags" type="text" value="{{ $type->getTags(false) }}" class="tagsinput" data-role="tagsinput" data-color="primary" />
        </div>
        <div class="card-footer">
            <div class="likes-container">
                <span class="likes">@isset($type->{'comments'}){{ $type->{'comments'} }} <i class="fal fa-comments"></i>@endisset</span>
            </div>
        </div>
    </div>
</div>