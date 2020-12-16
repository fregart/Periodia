<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>

<!-- Project -->
<section class="page-projekt">
   <div class="container-fluid">
      <h4 class="mt-4">Projekt</h4>
      <br>
      <div class="row">
        <div class="col">
          
        

          <div class="col-12 col-sm-12 col-lg-12">
          <form>
              <div class="form-group w-50">                 
                <input type="search" placeholder="Projektnamn, ID, Tidsram, Status..." class="form-control" onkeyup="searchProjectForm(this.value);">                              
              </div>
          </form>          
         
          
          <br>
            <div class="table-responsive">
              <table class="table table-striped table-hover table-m table-bordered table-projectlist">
                  <thead>
                    <tr class="table-active">
                        <th scope="col" class="d-none d-lg-table-cell"></th>
                        <th scope="col"></th>
                        <th scope="col" class="d-none d-lg-table-cell"></th>                        
                        
                        <?php
                          if ($_SESSION['user_role'] == 2) {
                          echo "<th scope='col><a href='#'><button class='btn btn-primary float-right' id='btn-add-new' title='Lägg till nytt projekt'><i class='fa fa-plus-circle'></i><span> Lägg till</span></button></a></th>";
                        }else {
                          echo "<th scope='col><a href='#'><button class='btn btn-primary float-right d-none' id='btn-add-new' title='Lägg till nytt projekt'><i class='fa fa-plus-circle'></i><span> Lägg till</span></button></a></th>";
                        }
                        ?>
                          
                    </tr>
                    <tr>
                        <th scope="col">Namn</th>
                        <th scope="col" class="d-none d-lg-table-cell text-center">Eget-ID</th>
                        <th scope="col" class="text-center">Tidsram</th>                                                
                        <th scope="col" class="d-none d-lg-table-cell text-center">Status</th>                        
                    </tr>
                  </thead>
                  <tbody id="projectResultList">                  
                  
                </tbody>
              </table>
            </div>
        
      



          </div>
        </div>
      </div>


      
















      
   </div>
</section>
<script>
  $(document).ready(function(){    
    
    // get all projects at start    
    $("#projectResultList").load('content/searchprojects.php?q=getAll');             

    // project list click listener
    $(document).on("click",".list-project a", function(){
      var id = $(this).attr('myId');      
      $("#page-content").load('content/page_showproject.php?projectID='+id,true);
    });

    // add new project button listener
    $("#btn-add-new").click(function(){
        $('#page-content').load('content/page_newproject.php');
    });
   

    

  });

  


  
</script>