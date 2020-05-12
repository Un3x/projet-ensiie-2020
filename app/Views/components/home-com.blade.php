<div class="col-md-3 col-sm-6">
    <div class="card">
        <div class="card-body text-center">
            <a class="text-primary" href="{{ \App\Core\Route::getUrl('winePage', ['id' => $com->getWine()]) }}#comment-{{$com->getId()}}">
                {{\App\Utils::limit($com->getMsg(), 250)}}
            </a>
        </div>
    </div>
</div>