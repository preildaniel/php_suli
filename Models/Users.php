<?php

class User
{

  private $id;
  private $username;
  private $password;

  public function login($username, $password, $conn)
  {
    $login = 0;
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      if ($row['password'] == md5($password)) {
        $_SESSION["user_id"] = $row['id'];
        $_SESSION["username"] = $row['username'];
        $login = 1;
      } else {
        $error_msg = "Hibás jelszó";
      }
    } else {
      $error_msg = "Hibás felhasználónév";
    }
    $answer = array("login" => $login, "message" => $error_msg ?? '');
    return json_encode($answer);
  }

  public function logout()
  {
    session_destroy();
    header('Location: index.php');
  }
}

?>