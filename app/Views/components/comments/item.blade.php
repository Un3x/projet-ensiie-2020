<div id="comment-{{ $com->getId() }}" class="media">
    <a class="pull-left" href="{{ \App\Core\Route::getUrl('profile', ['id' => $com->getUser()->getId()]) }}" target="_blank">
        <div class="avatar">
            <img class="media-object img-raised" alt="Photo de profil" src="@asset(\App\Models\User::getPPPathFromId($com->getUser()->getId()))">
        </div>
    </a>
    <div class="media-body">
        <h5 class="media-heading">
            <a href="{{ \App\Core\Route::getUrl('profile', ['id' => $com->getUser()->getId()]) }}" target="_blank">{{ $com->getUser()->getUsername() }}</a>
            <small class="text-muted">· {{ ucfirst(Carbon\Carbon::instance($com->getPostedAt())->diffForHumans()) }}</small>
            @if(isset($com->{'canEdit'}) && $com->{'canEdit'})<a onclick="deleteComment({{ $com->getId() }});" class="pull-right" style="cursor: pointer;"><i class="now-ui-icons ui-1_simple-remove align-middle text-primary"></i></a>@endif
        </h5>
        {!! nl2br($com->getMsg()) !!}
        <div class="media-footer">
            <a @if(isset($root)) href="#response-{{ $root->getId() }}" @else href="#response-{{ $com->getId() }}" @endif data-toggle="collapse" class="btn btn-primary btn-neutral pull-right" rel="tooltip" title="" data-original-title="Répondre au commentaire">
                <i class="now-ui-icons ui-1_send"></i> Répondre
            </a>
            <button data-likable="{{ $com->getId() }}" @if(isset($com->{'isLiked'}) && $com->{'isLiked'}) data-liked @endif class="btn btn-default btn-neutral pull-right" @can onclick="toggleLike('{{ $com->getId() }}')" @endcan>
                <i class="now-ui-icons ui-2_like"></i> <span data-like-num>{{ $com->{'likes'} }}</span>
            </button>
        </div>
        @isset($children[$com->getId()])
        @foreach($children[$com->getId()] as $child)
            @component('components.comments.item', ['com' => $child, 'children' => $children, 'root' => $com, 'respId' => $respId])
            @endcomponent
        @endforeach
        @endisset
        @if(!isset($root))
            @can
                <div class="collapse" id="response-{{ $com->getId() }}" data-scrollable>
                    <div class="media media-post">
                        <a class="pull-left author" href="{{ \App\Core\Route::getUrl('profile', ['id' => \App\Core\Auth::loggedUser()->getId()]) }}">
                            <div class="avatar">
                                <img class="media-object img-raised" alt="64x64" src="@asset(\App\Core\Auth::loggedUser()->getPPPath())" title="" style="">
                            </div>
                        </a>
                        <div class="media-body">
                            <textarea class="form-control" placeholder="Que pensez vous du commentaire ?" rows="4"></textarea>
                            <div class="media-footer">
                                <button class="btn btn-primary pull-right" onclick="postComment({{ $com->getId() }});">
                                    <i class="now-ui-icons ui-1_send"></i> Répondre
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        @endisset
    </div>
</div>