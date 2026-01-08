<table>
  <?php

  $car_list = json_decode($allcars, true);


  if (count($car_list) > 0) {
    // output data of each row
    foreach ($car_list as $row) {
      echo "  <tr>";
      foreach ($row as $key => $data) {
        echo "      <td>$data";
        if ($key == 'id') {
          $img_extensions = Car::logo_extensions();
          foreach ($img_extensions as $ext) {
            if (file_exists($target_dir . $data . "." . $ext)) {
              echo "<img src=\"" . $target_dir . $data . "." . $ext . "\" style=\"width: 50px;\">";
            }
          }
        }
        echo "</td>";
      }
      if (isset($_SESSION["user_id"])) {
        echo "      <td><a href=\"index.php?action=delete&id=" . $row['id'] . "\">Törlés</a></td>";
        echo "      <td><a href=\"index.php?action=getcardata&id=" . $row['id'] . "\">Módosítás</a></td>";
      }
      echo "  </tr>";
    }
  }

  ?>
</table>