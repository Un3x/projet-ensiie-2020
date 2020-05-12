<div class="card card-profile" style="margin-top: 50px;">
    <div class="card-avatar">
        <a target="_blank" href="{{ \App\Core\Route::getUrl('profile', ['id' => $user->getId()]) }}">
            <img class="img img-raised" src="@asset($user->getPPPath())">
        </a>
    </div>
    <div class="card-body">
        <a target="_blank" href="{{ \App\Core\Route::getUrl('profile', ['id' => $user->getId()]) }}"><h4 class="card-title">{{ $user->getUsername() }}</h4></a>
        <h6 class="category text-gray">
            {{ $user->getRoleName() }}
        </h6>
        <p class="card-description">
            {{ \App\Utils::limit($user->getDescription()) }}
        </p>
        <div class="card-footer">
            <div class="likes-container">
                <span class="likes">@isset($user->{'proposedWines'}){{ $user->{'proposedWines'} }} <i class="fal fa-wine-glass"></i>@endisset</span>
            </div>
        </div>
    </div>
</div>