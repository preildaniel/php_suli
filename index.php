<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();

require 'config.inc.php';
require 'db.inc.php';
require 'Models/Users.php';
require 'Models/Cars.php';
require 'Controllers/user.php';
require 'Controllers/index.php';

?>
<!DOCTYPE html>
<html>

<body>

  <h1>My first PHP page</h1>

  <?php

  if (isset($_SESSION["user_id"])) { //isset hogy létetik e || session az a munkamenet, 
    echo "Üdv " . $_SESSION["username"] . "! ";
    ?>
    <a href="index.php?action=logout">Kilépés</a><br>
    <hr>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
      <?php

      if (isset($updateform)) {
        echo $updateform;
      } else {
        ?>
        Brand: <input type="text" name="brand"><br>
        Stock: <input type="text" name="stock"><br>
        Sold: <input type="text" name="sold"><br>
        <?php
      }
      ?>
      <input type="file" name="brandLogo" id="fileToUpload"><br>
      <input type="submit">
    </form>
    <?php
  } else {
    if (isset($error_msg)) {
      echo $error_msg;
    }
    ?>
    <form method="post" action="index.php">
      Felhasználónév: <input type="text" name="username"><br>
      Jelszó: <input type="password" name="password"><br>
      <input type="submit" value="Elküld">
    </form>
    <?php
  }

  include "./Views/index.php";

  ?>



</body>

</html>