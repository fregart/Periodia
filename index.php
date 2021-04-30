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
  <link rel="manifest" crossorigin="use-credentials" href="./manifest.periodia-webmanifest">

  <!-- Icons -->
  <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
  <link rel="shortcut icon" type="image/x-icon" sizes="16x16" href="/img/favicon.ico">

</head>

<body>

<div class="d-flex" id="wrapper">  
    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="d-flex sidebar-heading justify-content-center text-center">
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
        <a href="#" class="list-group-item list-group-item-action bg-light" data-target="page_schema"><div class="sidebar-icon"><i class="fas fa-home"></i></div> Startsida</a>  
        <a href="#" class="list-group-item list-group-item-action bg-light" data-target="page_projekt"><div class="sidebar-icon"><i class="fas fa-tasks"></i></div> Projekt</a>       
        <a href="#" class="list-group-item list-group-item-action bg-light" data-target="page_equipment"><div class="sidebar-icon"><i class="fas fa-tools"></i></div> Inventarier</a>
        <a href="#" class="list-group-item list-group-item-action bg-light" data-target="page_myhours"><div class="sidebar-icon"><i class="fas fa-user-clock"></i></div> Mina timmar</a>
        <a href="#" class="list-group-item list-group-item-action bg-light" data-target="page_gallery"><div class="sidebar-icon"><i class="fas fa-images"></i></i></div> Galleri </a>
        <a href="#" class="list-group-item list-group-item-action bg-light" data-target="page_reporttime"><div class="sidebar-icon"><i class="far fa-clock"></i></div> Rapportera tid</a>
        <a href="#" class="list-group-item list-group-item-action bg-light" data-target="page_reportabsence"><div class="sidebar-icon"><i class="far fa-clock"></i></div> Rapportera frånvaro</a>
        <a href="#" class="list-group-item list-group-item-action bg-light" data-target="page_reportfuel"><div class="sidebar-icon"><i class="fas fa-gas-pump"></i></div> Rapportera tankning</a>

        <!-- Admin menu section-->  
        <?php
          if ($_SESSION['user_role'] == 2) {
            echo "
            <div class='dropdown-divider'></div>
            <a href='#' class='list-group-item list-group-item-action bg-dark disabled' data-target='page_planning'><div class='sidebar-icon'><i class='fas fa-pencil-ruler'></i></div> Planering</a>
            <a href='#' class='list-group-item list-group-item-action bg-light' data-target='page_employees'><div class='sidebar-icon'><i class='fas fa-users'></i></div> Personal</a>
            <a href='#' class='list-group-item list-group-item-action bg-light' data-target='page_reports'><div class='sidebar-icon'><i class='far fa-file-alt'></i></div> Rapporter</a>
            <a href='#' class='list-group-item list-group-item-action bg-light' data-target='page_inställningar'><div class='sidebar-icon'><i class='fas fa-cog'></i></div> Inställningar</a>
            <div class='dropdown-divider'></div>";
          }
        ?>

        <!-- Periodia information -->
        <div class="alert alert-secondary small" role="alert">
          <h6>Information</h6>
          <p>Denna app är under utveckling. Buggar och fel kan uppstå.</p>
          <p>Vid frågor mejla <a href="mailto:support@periodia.se">support@periodia.se</a></p>
          
        </div>

        <div class="alert alert-secondary small" role="alert">
        <h6>Kommande uppdateringar</h6>
          <p>2021-04. Omdesign av projektsidorna. Önskemål om semester(kalender). Planeringssida för projekt.
          När projekt är klara att fakturera, datum och status.</p>       
        <h6>Senaste uppdateringar</h6>
        <p>2021-04-30. Under rapporter för tankning går det nu se mätarställning på mobilen. Under fordon så syns reg nr bara om det finns i databasen</p>
        <p>2021-04-28. Spärr lagts till för att inte kunna dubbelrapportera på samma datum och tider.</p>
        <p>2021-04-20. Rullistor med användare visar hela namnet om det finns.</p>
                
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
                <a href="#" id="profile-link" class="dropdown-item" data-target="page_profile">Profil</a>          
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Logga ut</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
      
      
      <!-- Section for page content -->
      <div id="page-content">      
      </div>

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

  // dropdown-menu click listener
  // will open the .PHP file matching the data-target name
  // under content folder
  $(".dropdown-menu>a#profile-link").click(function (e) {            
      e.preventDefault();   
      e.stopPropagation();     
      var $target = $(this).data('target');           
      var $file = $target + '.php';
      var $path = 'content/';    
              
      $("#page-content").load($path + $file);                 
  }); 


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