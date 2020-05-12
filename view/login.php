  <div class="modal" role="dialog" style="display: block">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content bg-dark">
        <div class="modal-header">
          <h5 class="modal-title"><b class="logo"><img src="/img/logo.png" height="30" class="d-inline-block align-top" alt="Logo"> <b class="letter">ST</b>II<b class="letter">M</b>E</b> <em class="small">Login</em></h5>
        </div>
        <form action="log" method="post">
          <div class="modal-body" id="form">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
              </div>
              <input type="text" name="username" class="form-control" placeholder="Username" aria-label="Username" required>
            </div>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
              </div>
              <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" required>
            </div>
          </div>
          <div class="modal-footer">
            <a href="register" class="btn btn-outline-success" role="button">Register</a>
            <input type="submit" class="btn btn-outline-primary" value="Login" />
          </div>
        </form>
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
      height: 0;
      padding: 0 16px;
      overflow: hidden;
      transition: 1s;
    }
  </style>
  <script>
    window.onload = function() {
      document.querySelector("#form").style.height = "124px";
      document.querySelector("#form").style.padding = "16px";
    }
  </script>