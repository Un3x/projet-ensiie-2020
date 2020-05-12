<div class="modal" role="dialog" style="display: block">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark">
            <div class="modal-body" id="form">
                <h1>404</h1>
                <p>This page does not exist</p>
                <a class="btn btn-outline-light" href="/" role="button">Go back</a>
            </div>
        </div>
    </div>
</div>
<style>
    .modal-title {
        font-family: 'Sen', sans-serif;
    }

    .modal-title img {
        margin-left: -15px;
    }

    .small {
        font-family: var(--font-family-sans-serif)
    }

    #form {
        text-align: center;
        height: 0;
        padding: 0 16px;
        overflow: hidden;
        transition: 1s;
    }
</style>
<script>
    window.onload = function() {
        document.querySelector("#form").style.height = "166px";
        document.querySelector("#form").style.padding = "16px";
    }
</script>