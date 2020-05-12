<div class="carousel-item justify-content-center">
    <div class="card card-testimonial card-plain">
        <div class="row">
            <div class="col-4">
                <a href="{{ \App\Core\Route::getUrl('winePage', ['id' => $com->getWine()->getId()]) }}">
                    <img class="card-img img-fluid" src="@asset($com->getWine()->getImagePath())" style="max-height: 26em; width: auto;"/>
                </a>
            </div>
            <div class="col-8">
                <div class="card-avatar">
                    <a href="{{ \App\Core\Route::getUrl('profile', ['id' => $com->getUser()->getId()]) }}">
                        <img class="img img-raised rounded" src="@asset($com->getUser()->getPPPath())" />
                    </a>
                </div>
                <div class="card-body">
                    <h5 class="card-description">
                        <a href="{{ \App\Core\Route::getUrl('winePage', ['id' => $com->getWine()->getId()]) }}#comment-{{$com->getId()}}">
                            {{\App\Utils::limit($com->getMsg())}}
                        </a>
                    </h5>
                    <h4 class="card-title">{{$com->getUser()->getUsername()}}</h4>
                    <h6 class="category text-muted">{{$com->getUser()->getRoleName()}}</h6>
                    <div class="card-footer">
                        <div class="likes-container">
                            <span class="likes">
                                @isset($com->{'likes'}){{ $com->{'likes'} }}
                                <i class="now-ui-icons ui-2_like"></i>
                                @endisset
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
