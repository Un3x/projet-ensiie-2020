<div id="comments">
    <div class="title">
        <h4>
            Vos commentaires
        </h4>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
            <div id="posts" class="media-area">
                @foreach($roots as $com)
                    @component('components.comments.item', ['com' => $com, 'children' => $children, 'respId' => $respId])
                    @endcomponent
                @endforeach
            </div>

            @can
            <h4 class="text-center">Ajouter votre commentaire
                <br>
            </h4>
            <div class="media media-post" id="{{ $respId }}">
                <a class="pull-left author">
                    <div class="avatar">
                        <img class="media-object img-raised" alt="64x64" src="@asset(\App\Core\Auth::loggedUser()->getPPPath())">
                    </div>
                </a>
                <div class="media-body">
                    <textarea class="form-control" placeholder="Que pensez-vous de cet article ?" rows="6"></textarea>
                    <div class="media-footer">
                        <button class="btn btn-primary btn-wd pull-right" onclick="postComment();">Poster le commentaire</button>
                    </div>
                </div>
            </div>
            @endcan
        </div>
    </div>
</div>
<script type="text/javascript">
    function deleteComment(cid){
        $.ajax({
            method: "DELETE",
            url: "{{ \App\Core\Route::getUrl('deleteCommentAPI') }}".replace(/{id}/gm, cid)
        }).done(function(data){
            if(data.type === "ok"){
                let elem = $('#comment-' + cid);
                elem.slideUp('slow', function(){ elem.remove(); });
            }
        }).fail(function(xhr, status, error) {
            alert(JSON.stringify(xhr));
        });
    }

    function postComment(replyTo){
        var data = {};
        @if(isset($wid)) data['wid'] = {{ $wid }}; @endif
        @if(isset($tid)) data['tid'] = {{ $tid }}; @endif
        @if(isset($did)) data['did'] = {{ $did }}; @endif
        @if(isset($yid)) data['yid'] = {{ $yid }}; @endif

        if(replyTo === undefined){
            data['msg'] = $("#{{ $respId }}").find("textarea").val();
            $.post(
                '{{ \App\Core\Route::getUrl('commentsPost') }}',
                data,
            ).done(function(data){
                if(data.type === "ok"){
                    var elem = $(data.content.elem).prependTo("#posts");
                    $("#{{ $respId }}").find("textarea").val('');
                    scrollAndFocus(elem[0]);
                    reinitScrolls();
                }
            }).fail(function(xhr, status, error) {
                alert(JSON.stringify(xhr));
            });
        }else{
            data['msg'] = $("#response-" + replyTo).find("textarea").val();
            data['replyTo'] = replyTo;
            $.post(
                '{{ \App\Core\Route::getUrl('commentsPost') }}',
                data,
            ).done(function(data){
                if(data.type === "ok"){
                    var elem = $(data.content.elem).insertBefore("#response-" + replyTo);
                    $("#response-" + replyTo).find("textarea").val('');
                    scrollAndFocus(elem[0]);
                    reinitScrolls();
                }
            }).fail(function(xhr, status, error) {
                alert(JSON.stringify(xhr));
            });
        }
    }

    function toggleLike(id){
        var elem = $('[data-likable="' + id + '"]');
        var wantToLike = !elem[0].hasAttribute('data-liked');
        $.post(
            '{{ \App\Core\Route::getUrl('commentsLike') }}'.replace(/{id}/g, id),
            {
                liked : wantToLike ? 1 : 0,
                _token: '@csrfvalue'
            }
        ).done(function(data) {
            if(data.type === "ok"){
                toggleLikedDisplay(elem, wantToLike, data.content.count);
            }else{
                console.log(data);
                alert('Un problème est survenue pendant le like du commentaire : \n' + JSON.stringify(data));
            }
        }).fail(function(xhr, status, error) {
            alert(JSON.stringify(xhr));
        });
    }

    function scrollAndFocus(elem){
        window.scrollableDiv.animateScroll(elem);
    }

    function toggleLikedDisplay(elem, isLiked, newCount){
        if(isLiked){
            elem.removeClass('btn-default').removeClass('btn-neutral').addClass('btn-primary');
            elem.attr('data-liked', '');
        }else{
            elem.removeClass('btn-primary').addClass('btn-default').addClass('btn-neutral');
            elem.removeAttr('data-liked');
        }
        if(newCount !== undefined){
            elem.find('[data-like-num]').text(newCount);
        }
    }

    function reinitScrolls(){
        $('.collapse').each(function(i){
            $(this).off('shown.bs.collapse');

            $(this).on('shown.bs.collapse', function () {
                if($(this).attr('data-scrollable') !== undefined){
                    scrollAndFocus(this);
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', (event) => {
        window.scrollableDiv = new SmoothScroll('html, body', {
            header:'nav',
            offset: 50,
            updateURL: false,
            durationMin: 1,
        });

        $('[data-liked]').each(function(i){
            toggleLikedDisplay($(this), true);
        });

        reinitScrolls();

        document.addEventListener('scrollStop', function(event){
            var elems = $(event.detail.anchor).find('textarea');
            if(elems){
                elems.focus();
            }
        }, false);
    });
</script>