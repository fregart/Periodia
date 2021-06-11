<?php session_start(); ?>
<?php require_once("../functions.php")?>

<div class="container mt-4">
    <h4>Galleri</h4>

    <br>
    
    <div class="alert alert-secondary">Bilder inlagda från tidrappporter. Senaste bilderna visas först.</div>
    
    <br>

    <?php getAllImages(); ?>
    
</div>
<script>
  // Modal function
  $(document).ready(function () {

    $('#myModal').on('show.bs.modal', function (e) {
      var image = $(e.relatedTarget).attr('src').replace('thumbnail_', '');              
      $(".img-responsive").attr("src", image);                            
    });
    
  });
</script>