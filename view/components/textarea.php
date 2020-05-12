<?php function textarea($call)
{ ?>
<div class="card text-white bg-dark mb-3">
    <form action="send-message?page=<?php echo $call ?>" method="post">
        <div class="card-body" style="padding:0">
            <textarea placeholder="Write something..." class="form-control" oninput="lengthUpdate(this.value)" name="content"></textarea>
            <button class="btn btn-outline-light btn-emoji-input" type="button"><i class="far fa-laugh-wink"></i></button>
        </div>
        <div class="card-footer d-flex" style="align-items: center; padding: 0 0 0 1.25rem">
            <div class="small mr-auto text-monospace" id="counter">0/255</div>
            <input type="radio" id="public" name="visibility" value="public" checked>
            <label class="px-2" for="public" data-toggle="tooltip" data-placement="bottom" title="Public"><i class="fas fa-globe"></i></label>
            <input type="radio" id="unlisted" name="visibility" value="unlisted">
            <label class="px-2" for="unlisted" data-toggle="tooltip" data-placement="bottom" title="Unlisted"><i class="fas fa-unlock"></i></label>
            <input type="radio" id="private" name="visibility" value="private">
            <label class="px-2" for="private" data-toggle="tooltip" data-placement="bottom" title="Private"><i class="fas fa-lock"></i></label>
            <button class="btn btn-outline-light" type="submit"><i class="fas fa-share"></i></button>
        </div>
    </form>
</div>

<script>
    function lengthUpdate(value) {
        if (value.length > 255) {
            document.querySelector("#counter").innerHTML = '<i class="fas fa-exclamation-triangle"></i> ' + value.length + "/255";
            document.querySelector("#counter").style.color = "red";
        } else {
            document.querySelector("#counter").innerHTML = value.length + "/255";
            document.querySelector("#counter").style.color = "#fff";
        }
    }

    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<style>
    input[type="radio"] {
        display: none;
    }

    textarea {
        background: #343a40 !important;
        border-color: #2a2c2e !important;
        color: #fff !important;
        border-top-left-radius: 20px !important;
    }

    label {
        color: #fff2;
        margin-bottom: 0;
        cursor: pointer;
    }

    input:checked+label {
        color: #fff;
    }

    .btn-emoji-input {
        position: absolute;
        top: 0;
        right: 0;
        border-bottom-left-radius: 20px;
    }
</style>
<?php }