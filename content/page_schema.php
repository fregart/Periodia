<?php session_start(); ?>
<?php require_once("../dbconnect.php")?>
<?php require_once("../functions.php")?>

<!-- Schema -->
<section class="page-schema">
   <div class="container">
      <div class="row d-flex justify-content-center">
         <div class="col-xs-12 full-width bg-info">
            <div class="container text-light">
               <div class="row text-center justify-content-center">

               <?php getWorkWeek();?>                                 
               
               </div>
               <div class="row" id="time-panel-summary">                  
                  <div class="col">
                     <div class="container">
                        <div class="col d-flex justify-content-center align-items-center mt-4">
                           <!-- Company name -->        
                           <div class="h6 text-white">
                              <?php                            
                                 if ($_SESSION['user_company']) {            
                                 echo $_SESSION['user_company'];            
                                 }else {            
                                 echo $_SESSION['login_user'];            
                                 }
                              ?>
                           </div>
                        </div>                 
                        <div class="row" style="height: 150px">
                        
                           <div class="col d-flex justify-content-center align-items-center">
                              <div class="row justify-content-center align-items-center text-center bg-dark rounded">
                                 <div class="col p-4 border-right text-nowrap">                                 
                                    Vecka <?php echo getCurrentWeek()?>
                                    <div class="text-info font-weight-bold text-nowrap"><?php echo getWeekTotalHours();?> timmar</div>
                                 </div>
                                 <div class="col d-flex justify-content-center">
                                    <table>
                                       <tr>                                          
                                          <td class="text-info font-weight-bold h5"><?php echo getCurrentMonthFullName(); ?></td>
                                       </tr>                                       
                                       
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>


               <div class="row">
                  <div class="col">
                     
                        <div class="row border-bottom time-panel-buttons" id="page_reporttime" style="height: 100px;">
                           <div class="col d-flex justify-content-left align-items-center">
                              <div class="row justify-content-center align-items-center text-center" style="margin-left: 3%;">

                              <table class="text-light">
                                 <tr>
                                    <td><i class="far fa-clock fa-2x"></i></td>
                                    <td class="pl-2 h4">Rapportera tid</td>
                                    
                                    
                                 </tr>
                              </table>

                              
                              </div>
                           </div>
                        </div>


                        <div class="row border-bottom time-panel-buttons" id="page_reportabsence" style="height: 100px;">
                           <div class="col d-flex justify-content-left align-items-center">
                              <div class="row justify-content-center align-items-center text-center" style="margin-left: 3%;">

                              <table class="text-light">
                                 <tr>
                                    <td><i class="far fa-clock fa-2x"></i></td>
                                    <td class="pl-2 h4">Rapportera frånvaro</td>
                                 </tr>
                              </table>
                              
                              </div>
                           </div>
                        </div>


                        <div class="row border-bottom time-panel-buttons" id="page_reportfuel" style="height: 100px;">
                           <div class="col d-flex justify-content-left align-items-center">
                              <div class="row justify-content-center align-items-center text-center" style="margin-left: 3%;">

                              <table class="text-light">
                                 <tr>
                                    <td><i class="fas fa-gas-pump fa-2x"></i></td>                                    
                                    <td class="pl-2 h4">Rapportera tankning</td>
                                 </tr>
                              </table>
                              
                              </div>
                           </div>
                        </div>


                     </div>                  
                  </div>                
               </div>
         </div>
         <button class="add-button btn btn-success d-md-none d-lg-none d-xl-none">Lägg till på hemskärmen</button>
      </div>
   </div>
</section>
<script>

   

   // time panel day button click listener
   // will open the .PHP file matching the data-target name
   // under content folder and send over the clicked date
   $('.time-panel-day-buttons').click(function (e) {
      e.preventDefault();   
      e.stopPropagation();              
      var $target = this.id;
      var $file = 'page_reporttime' + '.php?setDate=' + $target;
      var $path = 'content/';                  
                     
      $('#page-content').load($path + $file);                
   });

   // time panel button click listener
   // will open the .PHP file matching the data-target name
   // under content folder
   $('.time-panel-buttons').click(function (e) {
      e.preventDefault();   
      e.stopPropagation();     
      var $target = this.id;
      var $file = $target + '.php';
      var $path = 'content/';         
                     
      $('#page-content').load($path + $file);                
   });

   let deferredPrompt;
   const addBtn = document.querySelector('.add-button');
   addBtn.style.display = 'block';

   window.addEventListener('beforeinstallprompt', (e) => {
      // Prevent Chrome 67 and earlier from automatically showing the prompt
      e.preventDefault();
      // Stash the event so it can be triggered later.
      deferredPrompt = e;
      // Update UI to notify the user they can add to home screen
      addBtn.style.display = 'block';

      addBtn.addEventListener('click', (e) => {
         // hide our user interface that shows our A2HS button
         addBtn.style.display = 'none';
         // Show the prompt
         deferredPrompt.prompt();
         // Wait for the user to respond to the prompt
         deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
               console.log('User accepted the A2HS prompt');
            } else {
               console.log('User dismissed the A2HS prompt');
            }
            deferredPrompt = null;
            });
      });
   });

</script>