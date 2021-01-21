<?php
include('session.php');
?>
<?php require_once "functions.php" ?>
<!DOCTYPE html>
<html lang="sv">

<head><meta charset="euc-kr">

<!-- Meta tags -->
  
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Projektplaneringsverktyg">
  <meta name="author" content="Fredrik Edman">
  <meta name="robots" content="nofollow">

  <title>Periodia</title>
  
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Fontawesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  
  <!-- Custom styles -->
  <link href="css/style.css" rel="stylesheet">

  <!-- Startup configuration -->
  <link rel="manifest" crossorigin="use-credentials" href="./manifest.webmanifest">

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="d-flex sidebar-heading justify-content-center">
        <!-- Company name -->        
        <div class="company-name">
          <?php                            
            if ($_SESSION['user_company']) {            
              echo $_SESSION['user_company'];            
            }else {            
              echo $_SESSION['login_user'];            
            }
          ?>
        </div>         

      </div>

      <!-- Sidebar menu-->
      <div class="list-group list-group-flush">      
        <a href="#" class="list-group-item list-group-item-action bg-light" data-target="page_schema"><div class="sidebar-icon"><i class="fas fa-business-time"></i></div> Startsida</a>  
        <a href="#" class="list-group-item list-group-item-action bg-light" data-target="page_projekt"><div class="sidebar-icon"><i class="fas fa-tasks"></i></div> Projekt</a>                     
        <a href="#" class="list-group-item list-group-item-action bg-light" data-target="page_myhours"><div class="sidebar-icon"><i class="fas fa-user-clock"></i></div> Mina timmar</a>
        <a href="#" class="list-group-item list-group-item-action bg-light" data-target="page_reporttime"><div class="sidebar-icon"><i class="far fa-clock"></i></div> Rapportera tid</a>
        <a href="#" class="list-group-item list-group-item-action bg-light" data-target="page_reportabsence"><div class="sidebar-icon"><i class="far fa-clock"></i></div> Rapportera frånvaro</a>
        <!-- Admin menu section-->  
        <?php
          if ($_SESSION['user_role'] == 2) {
            echo "
            <div class='dropdown-divider'></div>     
            <a href='#' class='list-group-item list-group-item-action bg-light' data-target='page_reports'><div class='sidebar-icon'><i class='far fa-file-alt'></i></div> Rapporter</a>
            <a href='#' class='list-group-item list-group-item-action bg-light' data-target='page_inställningar'><div class='sidebar-icon'><i class='fas fa-cog'></i></div> Inställningar</a>
            <div class='dropdown-divider'></div>";
          }
        ?>

        <!-- Periodia information -->
        <div class="alert alert-secondary small" role="alert">
          <h6>Information</h6>
          <p>Denna app är under utveckling. Buggar och designfel kan uppstå.</p>
          <p>Vid frågor mejla <a href="mailto:support@periodia.se">support@periodia.se</a></p>
          
        </div>

        <div class="alert alert-secondary small" role="alert">
          <h6>Uppdateringar</h6>
          <p>2021-01. Omdesign av projektsidorna. Lägga in bilder, noteringar. Översikt över arbetstimmar mm.</p>          
          <p>2021-01-21. Fältet Eget-ID har lagts till under redigering av projekt. Eget-ID visas med projektnamn.</p>          
          
        </div>
        
      </div>
    </div>
    <!-- /#sidebar-wrapper -->    
    
    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-dark border-bottom">
        <button class="btn btn-primary btn-custom-collapse" title="Växla meny" id="menu-toggle"><i class="fas fa-bars"></i></span></button>

        <div class="d-flex justify-content-center ml-2">
          <!-- Logo Image -->
          <div class="row">
            <div class="ml-2" id="periodia-logo"><img src="img/periodia-logo-gul.png" width="130" alt="periodia logotype" class="d-inline-block align-middle"></a></div>
            <div><?php 
              
              if ($_SESSION['user_role'] == 2) {
                echo '<div class="badge badge-pill badge-info">ADMIN</div>';
              }
            
            ?></div>
          </div>
          
          
        </div>

        
    
        <button class="navbar-toggler justify-content-center" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <?php         
        if(isset($_SESSION['login_user'])){ 
            echo "<i class='fas fa-user mr-2'></i>";
        } else{ 
          header("location:login.php");
        }         
          ?>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            
            <li class="nav-item dropdown active">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php                 

        if(isset($_SESSION['login_user'])){ 
            echo "<i class='fas fa-user mr-2'></i>";
            echo $_SESSION['login_user'];             
        } else{ 
          header("location:login.php");
        }         
          ?>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <!--<a class="dropdown-item" href="#">Profil</a>                
                <div class="dropdown-divider"></div>-->
                <a class="dropdown-item" href="logout.php">Logga ut</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
      
      
      <!-- Section for page content -->
      <div id="page-content">      
      </div>
      

     


          

      <!-- Timbank 
      <section class="page-timbank">
        <div class="container-fluid">
          <h1 class="mt-4">Timbank</h1>
          <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p>
          <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>. The top navbar is optional, and just for demonstration. Just create an element with the <code>#menu-toggle</code> ID which will toggle the menu when clicked.</p>
        </div>
      </section> -->

    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Ajax -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>  

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  <!-- Custom JavaScript -->
  <script src="js/main.js"></script>

<script>
  
  // show schema at start
  $('#page-content').load('content/page_schema.php');
             
  // sidebar toggler
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });

  // logo click listener
  $("#periodia-logo").click(function(){                  
    window.open('index.php', "_self");
  });
</script>
<script>
  // service worker manifest script
  if ('serviceWorker' in navigator) {
    console.log("Will the service worker register?");
    navigator.serviceWorker.register('service-worker.js')
      .then(function(reg){
        console.log("Yes, it did.");
      }).catch(function(err) {
        console.log("No it didn't. This happened: ", err)
      });
  }

  
</script>


</body>

</html>