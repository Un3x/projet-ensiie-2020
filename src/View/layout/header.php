<div class="header">
  <div id="logo-header" class="jumbotron jumbotron-fluid text-center" style="margin-bottom:0">
    <div class="container">
      <h1>Tales of Webseria</h1>
      <p>Les histoires dont vous êtes le hêros</p>
    </div>
  </div>
  <nav id="menu" class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#contact">Contact</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <?php if (is_null($_SESSION['username'])) { ?>
      <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="register.php">Register</a>
      </li>
      <?php } else { ?>
      <li class="nav-item">
        <?php if (is_null($_SESSION['admin'])){ ?>
        <a class="nav-link" href="user_page.php"><?php echo $_SESSION['username']; ?></a>
        <?php } else { ?>
          <a class="nav-link" href="admin_page.php"><?php echo $_SESSION['username']; ?></a>
        <?php } ?>
      </li>
      <li class="nav-item">
        <form name="disconnect" method="post" action="server.php">
          <button type="submit" class="btn btn-link nav-link" name="disconnect">Log out</button>
        </form>
      </li>
      <?php } ?>
    </ul>
  </nav>
</div>
