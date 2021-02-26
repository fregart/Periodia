<?php session_start(); ?>

<div class="container mt-4">
    <h4>Rapporter</h4>

    <br><br>

    <div class="row ml-2">
        <div class="col">
            <h5>Anställda</h5>

            <ul>
                <li><a href="#" data-target="page_reports_time">Arbetade timmar</a></li>  
                <li>Frånvaro</li>
            </ul>
        </div>

        <div class="col">
            <h5>Tankning</h5>

            <ul>
                <li>Maskiner</li>  
                <li>Fordon</li>
                <li>Verktyg</li>
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