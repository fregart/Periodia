<?php session_start(); ?>

<div class="container mt-4">
    <h4>Mina timmar</h4>

    <br><br>

    <div class="row ml-2">
        <div class="col-sm-6 col-lg-4 mt-2">
            <h5>Mina timmar</h5>

            <ul>
                <li><a href="#" data-target="page_myhours_hours">Arbetade timmar</a></li>
                <li><a href="#" data-target="page_myhours_absence">Frånvaro</a></li>
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