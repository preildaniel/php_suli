<?php

$user = new User;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // ha login postot kaptunk
  if (isset($_POST['username']) && isset($_POST['password'])) {
    $user->login($_POST['username'], $_POST['password'], $conn);
  }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET['action'])) {
    if ($_GET['action'] == "logout") {
      $user->logout();
      exit;
    }
  }
}

?>