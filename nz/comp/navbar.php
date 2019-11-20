<?php 
  $req = $_SERVER["SCRIPT_NAME"];
  $title = "";
  $brdcum = "";
  $mn=$hm=$ab=$sr=$blg=$cnt="";
  switch ($req) {
    case '/menu.php':
      $mn = "active";
      break;
    
    case '/about.php':
      $ab = "active";
      break;
    case '/services.php':
      $sr = "active";
      break;
    case '/contact.php':
      $cnt = "active";
      break;
      case '/storelist.php':
      $str = "active";
      break;
    default:
      $hm = "active";
  }

?>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="index.php"><img src="images/logo.png" alt="logo Image" width="12%"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?=$hm?>"><a href="index.php" class="nav-link ">Home</a></li>
                <!--  <li class="nav-item <?=$mn?>"><a href="menu.php" class="nav-link">Menu</a></li> -->
                <!--  <li class="nav-item <?=$blg?>"><a href="blog.php" class="nav-link">Blog</a></li> -->
                <li class="nav-item <?=$ab?>"><a href="http://us.new-yorkpizza.com/index.php?path=/home/about" class="nav-link">About Us</a></li>
                <li class="nav-item <?=$sr?>"><a href="http://us.new-yorkpizza.com/index.php?path=/home/employee_registration" class="nav-link ">Career</a></li>
                <li class="nav-item <?=$cnt?>"><a href="http://us.new-yorkpizza.com/index.php?path=/home/contact" class="nav-link ">Contact</a></li>
                <li class="nav-item <?=$str?>"><a href="http://us.new-yorkpizza.com/index.php?path=/home/storelist" class="nav-link ">Store list</a></li>
            </ul>
        </div>
    </div>
</nav>