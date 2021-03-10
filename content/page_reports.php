<?php session_start(); ?>

<div class="container mt-4">
    <h4>Rapporter</h4>

    <br><br>

    <div class="row ml-2">
        <div class="col-sm-6 col-lg-4 mt-2">
            <h5>Personal</h5>

            <ul>
                <li><a href="#" data-target="page_reports_time">Arbetade timmar</a></li>  
                <li>Frånvaro</li>
                <li><a href="#" data-target="page_reports_registerextract">Registerutdrag (GDPR)</a></li>
            </ul>
        </div>
        
        

        <div class="col-sm-6 col-lg-4 mt-2">
            <h5>Projekt</h5>

            <ul>                
                <li>Timmar per projekt</li>
            </ul>
        </div>

        

        <div class="col-sm-6 col-lg-4 mt-2">
            <h5>Tankning</h5>

            <ul>
                <li><a href="#" data-target="page_reports_fuel">Visa senaste tankningar</a></li>
            </ul>
        </div>

    </div>

</div>
<script>
    // click listener
    // will open the .PHP file matching the data-target name
    // under content folder
    $("ul>li>a").click(function (e) {            
        e.preventDefault();   
        e.stopPropagation();     
        var $target = $(this).data('target');           
        var $file = $target + '.php';
        var $path = 'content/';    
                
        $("#page-content").load($path + $file);                 
    }); 
</script>