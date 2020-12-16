<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>

<!-- Inställningar -->
<section class="page-inställningar">
   <div class="container-fluid">
      <h4 class="mt-4">Inställningar</h4>
      <br>
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" id="inställningar-Tab" role="tablist">
         <li class="nav-item">
            <a class="nav-link active" id="företag-tab" data-toggle="tab" href="#företag" role="tab" aria-controls="företag" aria-selected="true">Företag</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" id="användare-tab" data-toggle="tab" href="#användare" role="tab" aria-controls="användare" aria-selected="false">Användare</a>
         </li>
         <!--
         <li class="nav-item">
            <a class="nav-link" id="maskiner-tab" data-toggle="tab" href="#maskiner" role="tab" aria-controls="maskiner" aria-selected="false">Maskiner</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" id="schema-tab" data-toggle="tab" href="#schema" role="tab" aria-controls="schema" aria-selected="false">Schema</a>
         </li>
         -->
      </ul>
      <!-- Tab panes -->
      <div class="card" id="card-inställningar">
         <div class="card-body">
            <div class="tab-content">

               <div class="tab-pane active" id="företag" role="tabpanel" aria-labelledby="företag-tab">
               <form class="small" method="post" id="updateCompanyInfoForm" action="">
                     <input type="hidden" name="action" value='updateCompanyInfo'>
                     <div class="form-group">
                        <label for="företagsnamnInput">Företagsnamn</label>
                        <input type="text" class="form-control" name="företagsnamnInput" id="företagsnamnInput" value="<?php echo $_SESSION['user_company'];?>">
                     </div>
                     <div class="form-group">
                        <label for="organisationsnummerInput">Organisationsnummer</label>
                        <input type="text" class="form-control" name="organisationsnummerInput" id="organisationsnummerInput" value="<?php echo $_SESSION['user_company_nr'];?>">
                     </div>
                     <div class="form-group">
                        <label for="beskrivningTextarea">Beskrivning</label>
                        <textarea class="form-control"  name="beskrivningTextarea" id="beskrivningTextarea" rows="5"><?php echo $_SESSION['user_company_desc'];?></textarea>
                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-success">Spara</button>
                     </div>
                  </form>
               </div>

               <div class="tab-pane" id="användare" role="tabpanel" aria-labelledby="användare-tab">
                  
                  <div class="card-body text-middle">Lägg till och ta bort användare eller blockera de från systemet.</div>
                  
                  <div class="col-12 col-sm-12 col-lg-12">
                  <div class="table-responsive">
                  <table class="table table-striped table-hover table-m">
                     <thead>
                        <tr class="table-active">
                           <th class="align-middle">Användarhantering</th>                           
                           <th scope="col" class="d-none d-lg-table-cell"></th>
                           <th scope="col" class="d-none d-lg-table-cell"></th>
                           <th scope="col" class="d-none d-lg-table-cell"></th>
                           <th scope="col">
                              
                              <a href="#" data-toggle='modal' data-target='#addUserModal' aria-hidden="true"><button class="btn btn-primary float-right" title="Lägg till ny användare"><i class="fa fa-plus-circle"></i><span> Lägg till</span></button></a>
                        </tr>
                        <tr>                           
                           <th scope="col">Användare</th>
                           <th scope="col" class="d-none d-lg-table-cell">Skapad</th>
                           <th scope="col" class="d-none d-lg-table-cell">Roll</th>
                           <th scope="col" class="d-none d-lg-table-cell">Status</th>
                           <th scope="col">Hantera</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                           getAllUsers();
                           ?>
                     </tbody>
                  </table>
                  </div>
                  </div>
                  
               </div>

               <div class="tab-pane" id="maskiner" role="tabpanel" aria-labelledby="maskiner-tab">
               
               
               <div class="card-body text-middle">Lägg till maskiner till företaget här.</div>
                  
                  <div class="col-12 col-sm-12 col-lg-12">
                  <div class="table-responsive">
                  <table class="table table-striped table-hover table-m">
                     <thead>
                        <tr class="table-active">
                           <th class="align-middle">Maskiner</th>                           
                           <th scope="col"></th>
                           <th scope="col" class="d-none d-lg-table-cell"></th>
                           <th scope="col" class="d-none d-lg-table-cell"></th>
                           <th scope="col"></th>
                           <th scope="col">                              
                              <a href="#" data-toggle='modal' data-target='#addMachineModal' aria-hidden="true"><button class="btn btn-primary" title="Lägg till ny maskin"><i class="fa fa-plus-circle"></i><span> Lägg till</span></button></a>
                        </tr>
                        <tr>                           
                           <th scope="col">Namn</th>
                           <th scope="col">Reg.nummer</th>
                           <th scope="col" class="d-none d-lg-table-cell">Arbetstimmar</th>
                           <th scope="col" class="d-none d-lg-table-cell">Mätarställning</th>                           
                           <th scope="col">Status</th>
                           <th scope="col">Hantera</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                           getAllMachines();
                           ?>
                     </tbody>
                  </table>
                  </div>
                  </div>
               
               
               
               </div>






               
               <div class="tab-pane" id="schema" role="tabpanel" aria-labelledby="schema-tab">.schema..</div>
            </div>
         </div>
      </div>
   </div>
   <!-- Modals -->
   <!-- Add user -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Lägg till ny användare</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form class="small" method="post" id="addUserForm" action="">
                    <input type="hidden" name="action" value="addUser" />
                    

                    <div class="bg-warning p-2">
    <fieldset class="border p-2">
        <legend class="w-auto">Inloggning</legend>
        <div class="form-group">            
            <label for="usernameInput">Användarnamn</label>
            <div class="badge badge-pill badge-info" id="usernameInput-error"></div>
            <input type="text" class="form-control" name="usernameInput" id="usernameInput" value="" onkeyup="validate(this)" />
        </div>
        <div class="form-group">
            <label for="pass1Input">Lösenord</label>
            <div class="badge badge-pill badge-info" id="pass1Input-error"></div>
            <input type="password" class="form-control" name="pass1Input" id="pass1Input" value="" onkeyup="validatePassword(this)" />
            <br />
            <label for="pass2Input">Skriv lösenord igen</label>
            <input type="password" class="form-control" name="pass2Input" id="pass2Input" value="" onkeyup="validatePassword(this)" />
        </div>
    </fieldset>
</div>
<br />

<div class="form-group">
    <div class="form-row">
        <div class="col">
            <label for="firstnameInput">Förnamn</label>
            <input type="text" class="form-control" name="firstnameInput" id="firstnameInput" value=""/>
        </div>
        <div class="col">
            <label for="lastnameInput">Efternamn</label>
            <input type="text" class="form-control" name="lastnameInput" id="lastnameInput" value="" />
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col">
            <label for="emailInput">E-post</label>
            <input type="text" class="form-control" name="emailInput" id="emailInput" placeholder="name@example.com" value="" />
        </div>
        <div class="col"></div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col">
            <label for="phone1Input">Telefon 1</label>
            <input type="text" class="form-control" name="phone1Input" id="phone1Input" value="" />
        </div>
        <div class="col">
            <label for="phone2Input">Telefon 2</label>
            <input type="text" class="form-control" name="phone2Input" id="phone2Input" value="" />
        </div>
    </div>
</div>

<div class="form-group">
    <div class="form-row">
        <div class="col">
            <legend class="col-form-label col-sm-2 pt-0">Behörighet</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="roleRadios" id="roleRadios-admin" value="2" />                    
                    <label class="form-check-label" for="roleRadios">
                        Admin
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="roleRadios" id="roleRadios-user" value="3" checked />                    
                    <label class="form-check-label" for="roleRadios">
                        User
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group"></div>
        <div class="col">
            <legend class="col-form-label col-sm-2 pt-0">Status</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="userStatusRadios" id="userStatusRadios-active" value="1" checked />                    
                    <label class="form-check-label" for="userStatusRadios">
                        Aktiv
                    </label>
                </div>
                <div class="form-check">                    
                    <input class="form-check-input" type="radio" name="userStatusRadios" id="userStatusRadios-passive" value="0" />
                    <label class="form-check-label" for="userStatusRadios">
                        Passiv
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>




                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Avbryt</button>
                        <button type="submit" class="btn btn-success">Spara</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

   <!-- Remove user -->
   <div class="modal fade" id="removeUserModal" tabindex="-1" role="dialog" aria-labelledby="removeUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="removeUserModalLabel">Ta bort användare</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">            
               <div class="alert alert-danger" role="alert">Är du säker på att du vill ta bort användaren <span id="userName-data" class="font-weight-bold"></span> ?</div>
               <p>All data kommer försvinna som är lagrad i databasen.</p>
               <p>Det vill säga den här användarens inloggning, meddelanden, arbetstider m.m kommer att försvinna och det går inte att återställa detta igen.</p>
            </div>
            <div class="modal-footer">
            <form class="small" method="post" id="deleteUserForm" action="">
               <input type="hidden" name="action" value="deleteUser">   
               <input type="hidden" name="userID-data" value="">                             
               <button type="button" class="btn btn-primary" data-dismiss="modal">Avbryt</button>
               <button type="submit" class="btn btn-danger">Ta bort</button>
            </form>
            </div>
            
         </div>
      </div>
   </div>


   <!-- Edit user -->
   <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="editUserModalLabel">Redigera användare</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
         
            <div class="modal-body">
               <form class="small" method="post" id="updateUserForm" action="">
               <input type="hidden" name="action" value="updateUser">              
                  <div id="txtShowUser"></div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-primary" data-dismiss="modal">Avbryt</button>
                     <button type="submit" class="btn btn-success">Uppdatera</button>
                  </div>
               </form>
            </div>
         </div>
   </div>


   <!-- Add machine -->   
<div class="modal fade" id="addMachineModal" tabindex="-1" role="dialog" aria-labelledby="addMachineModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addMachineModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>





</section>



<script>     

   $(document).ready(function(){
       
 
      // save active tab in localstorage
      $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
      localStorage.setItem('activeTab', $(e.target).attr('href'));
      });

      var activeTab = localStorage.getItem('activeTab');
      if(activeTab){
         $('.nav-tabs a[href="' + activeTab + '"]').tab('show');      
      }

      // to know the user that was clicked
      $('#removeUserModal').on('show.bs.modal', function(e) {

         //get data attribute of the clicked element
         var userId = $(e.relatedTarget).data('user-id');
         var userName = $(e.relatedTarget).data('user-name');

         //populate the textbox
         $(e.currentTarget).find('input[name="userID-data"]').val(userId);
         $(e.currentTarget).find($('#userName-data')).text(userName);
      });

   });
   
</script>