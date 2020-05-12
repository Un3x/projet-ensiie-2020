<div class="show fade alert {{ $alertClass }}" role="alert">
    <div class="container">
        <div class="alert-icon">
            <i class="now-ui-icons {{ $icon }}"></i>
        </div>
        <strong>{{ $catchPhrase }}</strong> {{ $msg }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">
            <i class="now-ui-icons ui-1_simple-remove"></i>
          </span>
        </button>
    </div>
</div>