<div class="col">
    <div class="card-container" style="width: 6rem">
        <div class="card-component">
            <a href="{{ \App\Core\Route::getUrl('winePage', ['id' => $wine->getId()]) }}" target="_blank">
                <div class="front bg-transparent" style="width: 6rem">
                    <img class="img-fluid" src="@asset($wine->getImagePath())" style="max-height: 26em; width: auto;">
                </div>
            </a>
        </div>
    </div>
</div>