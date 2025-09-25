<!DOCTYPE html>

<html lang="hu">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>PHP Teszt</title>
  </head>
  
  <body>


    <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
      <label for="name">Name</label>
      <input type="text" name="name">
      <label for="stock">Stock</label>
      <input type="text" name="stock">
      <label for="sold">Sold</label>
      <input type="sold" name="sold">
      <input type="submit" value="Add">
    </form>

    <table>
      <tr>
        <th>Name</th>
        <th>Stock</th>
        <th>Sold</th>
      </tr>
      <?php
        $cars = [["alms", 2, 4], ["dwalms", 2, 4]];
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $name = htmlspecialchars($_REQUEST["name"]);
          $stock = htmlspecialchars($_REQUEST["stock"]);
          $sold = htmlspecialchars($_REQUEST["sold"]);
          array_push($cars,[$name, $stock, $sold]);
        }

        for ($i=0; $i < count($cars); $i++) {
          echo "<tr>";
          for ($j=0; $j < 3; $j++) { 
            echo "<td>" . $cars[$i][$j] . "</td>";
          }
          echo "</tr>";
        }
      ?>
    </table>

  </body>

</html>