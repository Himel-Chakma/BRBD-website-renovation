<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="vendor/jquery/jquery-ui.css">
  <title>Document</title>
  <script src="vendor/jquery/jquery-ui.js"></script>
      
      <script>
        $(document).ready(function() {
          $("#draggable-list").sortable({
          update: function(event, ui) {

            var sortedIDs = [];
            $("#draggable-list li.list_items").each(function() {
              sortedIDs.push($(this).data("id"));
            });
          
            $.ajax({
              url: "courses_action.php",
              method: "POST",
              data: { sortedIDs: sortedIDs, action: 'update_topic_serial' },
              success: function(data) {

              }
            });
          }
          });
          
        });
      </script>
</head>
<body>
<?php
include('main.php');
$object = new brbd();
?>
<div class="card">
  <div class="card-header">Course Builder</div>
  <div class="card-body">
    <div class="form-group">
      <div id="topic_container">
        <ul id="draggable-list">
        <?php echo $object->material_fetch(1); ?>
      </ul>
      </div>
    </div>
  </div>
</div>
</body>
</html>
