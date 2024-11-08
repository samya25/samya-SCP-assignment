<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="container">
      <?php include "connection.php"; ?>
      <div>
          <ul class="nav navbar-dark bg-dark">
              <?php foreach($result as $link): ?>
              <li class="nav-item active">
                  <a href="index.php?link=<?php echo htmlspecialchars($link['item']); ?>" class="nav-link text-light"><?php echo htmlspecialchars($link['item']); ?></a>
              </li>
              <?php endforeach; ?>
              
              <li class="nav-item active">
                  <a href="create.php" class="nav-link text-light">Create a new SCP record.</a>
              </li>
          </ul>
      </div>
    <h1>SCP CRUD Application</h1>
    <div>
        <?php
        
        if (isset($_GET['link']))
        {
            $item = $_GET['link'];
            
            // Prepared statement
            $stmt = $connection->prepare("SELECT * FROM SCP WHERE item = ?");
            if(!$stmt) {
                echo "<p>Error in preparing SQL statement</p>";
                exit;
            }
            $stmt->bind_param("s", $item);
            if($stmt->execute()) {
                $result = $stmt->get_result();
                
                // Check if record has been retrieved
                if($result->num_rows > 0)
                {
                    $array = $result->fetch_assoc();
                    $array = array_map('htmlspecialchars', $array);
                    $update = "update.php?update=" . $array['id'];
                    $delete = "index.php?delete=" . $array['id'];
                    
                    echo "
                    <div class='card card-body shadow mb-3'>
                        <h2 class='card-title'>{$array['item']}</h2>
                        <h4>{$array['class']}</h4>
                        <p>{$array['description']}</p>
                        <p><img src='{$array['image']}' alt='SCP' class='img-fluid'></p>
                        <p>{$array['containment']}</p>
                        <p>
                            <a href='{$update}' class='btn btn-info'>Update Record</a>
                            <a href='{$delete}' class='btn btn-warning'>Delete Record</a>
                        </p>
                    </div>
                    ";
                } else {
                    echo "<p>No record found for item: {$array['item']}</p>";
                }
            } else {
                echo "<p>Error executing the statement</p>";
            }
            
        } else {
            echo "
            <p>Welcome to this CRUD application.</p>
            <p><img src='images/logo.png' alt='SCP CRUD application' class='img-fluid'></p>
            ";
        }

        // Handle delete action
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $deleteStmt = $connection->prepare("DELETE FROM SCP WHERE id = ?");
            if (!$deleteStmt) {
                echo "<p>Error in preparing DELETE SQL statement</p>";
                exit;
            }
            $deleteStmt->bind_param("i", $id);
            if ($deleteStmt->execute()) {
                echo "<p>Record deleted successfully.</p>";
            } else {
                echo "<p>Error deleting record.</p>";
            }
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
