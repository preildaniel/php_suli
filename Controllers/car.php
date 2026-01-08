<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // ha login postot kaptunk
  if (!isset($_POST['username']) && !isset($_POST['password'])) {
    if (isset($_POST['id'])) {
      $car = new Car($_POST['id'], $conn);
      $car->update($_POST['brand'], $_POST['stock'], $_POST['sold'], $conn);
    } else {
      $response = Car::add($_POST['brand'], $_POST['stock'], $_POST['sold'], $conn);
    }

    if (!isset($_POST['id'])) {
      $_POST['id'] = $response;
    }

    if ($_FILES["brandLogo"]["tmp_name"]) {
      /* file upload */

      $target_file = $target_dir . $_POST['id'];
      $uploadOk = 1;

      // MAMP szerveren nem működik $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      $validTypes = Car::logo_extensions();

      $check = getimagesize($_FILES["brandLogo"]["tmp_name"]);
      if ($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $fileExt = preg_split("/\//", $check["mime"]);
        if (in_array($fileExt[1], $validTypes)) {
          $target_file = $target_file . "." . $fileExt[1];
          $uploadOk = 1;
        } else {
          echo "HIBA: Csak " . implode(",", $validTypes) . " fájlok tölthetők fel";
        }
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }

      if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["brandLogo"]["tmp_name"], $target_file)) {
          echo "The file " . htmlspecialchars(basename($_FILES["brandLogo"]["name"])) . " has been uploaded.";
        } else {
          echo "Sorry, there was an error uploading your file.";
        }
      }
    }
  }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET['action'])) {
    switch ($_GET['action']) {
      case "getcardata":
        $car = new Car($_GET['id'], $conn);
        $updateform = "  Brand: <input type=\"text\" name=\"brand\" value=\"" . $car->get_brand() . "\"><br>
            Stock: <input type=\"text\" name=\"stock\" value=\"" . $car->get_stock() . "\"><br>
            Sold: <input type=\"text\" name=\"sold\" value=\"" . $car->get_sold() . "\"><br>
            <input type=\"hidden\" name=\"id\" value=\"" . $_GET['id'] . "\">";
        break;

      case "delete":
        $car = new Car($_GET['id'], $conn);
        $car->remove($conn);
        break;

    }
  }
}

