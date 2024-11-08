<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create New SCP Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="container">
      <?php
          include "connection.php"; // Include the database connection file

          // Check if the form has been submitted
          if (isset($_POST['submit'])) {
              // Prepare the SQL statement with placeholders
              $stmt = $connection->prepare("INSERT INTO SCP (item, class, description, containment, image) VALUES (?, ?, ?, ?, ?)");
              
              if ($stmt) {
                  // Bind the parameters to the placeholders
                  $stmt->bind_param("sssss", $_POST['item'], $_POST['class'], $_POST['description'], $_POST['containment'], $_POST['image']);
                  
                  // Execute the statement and check if successful
                  if ($stmt->execute()) {
                      echo "<div class='alert alert-success p-3'>Record successfully created</div>";
                  } else {
                      echo "<div class='alert alert-danger p-3'>Error: " . $stmt->error . "</div>";
                  }
                  
                  // Close the statement
                  $stmt->close();
              } else {
                  echo "<div class='alert alert-danger p-3'>Error in preparing SQL statement</div>";
              }
          }
      ?>
      
      <h1>Create a New SCP Record</h1>
      <p><a href="index.php" class="btn btn-dark">Back to index page</a></p>
      
      <!-- Form for creating a new SCP record -->
      <div class="p-3 bg-light border shadow">
          <form method="post" action="create.php" class="form-group">
             <div>
               <label for="item">Enter SCP Item:</label>
               <input type="text" id="item" name="item" placeholder="Item..." class="form-control" required>
               <br>
             </div>

             <div>
               <label for="class">Enter Class:</label>
               <input type="text" id="class" name="class" placeholder="Class..." class="form-control" required>
               <br>
             </div>

             <div>
               <label for="description">Enter Description:</label>
               <textarea id="description" name="description" placeholder="Enter description..." class="form-control" required></textarea>
               <br>
             </div>

             <div>
               <label for="containment">Enter Containment:</label>
               <textarea id="containment" name="containment" placeholder="Enter containment..." class="form-control" required></textarea>
               <br>
             </div>

             <div>
               <label for="image">Enter Image Path:</label>
               <input type="text" id="image" name="image" placeholder="images/nameofimage.png" class="form-control" required>
               <br>
             </div>

             <button type="submit" name="submit" class="btn btn-primary">Submit</button>
          </form>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
