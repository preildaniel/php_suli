<?php

class Car
{

  private $id;
  private $brand;
  private $stock;
  private $sold;

  public function __construct($id, $conn)
  {
    $stmt = $conn->prepare("SELECT id, brand, stock, sold FROM cars WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $this->id = $id;
      $this->brand = $row["brand"];
      $this->stock = $row["stock"];
      $this->sold = $row["sold"];
    }
  }

  public function get_brand()
  {
    return $this->brand;
  }

  public function get_stock()
  {
    return $this->stock;
  }

  public function get_sold()
  {
    return $this->sold;
  }

  public static function logo_extensions()
  {
    return array('jpg', 'png', 'gif');
  }

  public static function get_all($conn)
  {
    $cars = array();
    $sql = "SELECT id, brand, stock, sold FROM cars";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $cars[] = $row;
      }
    }
    return json_encode($cars);
  }

  public static function add($brand, $stock, $sold, $conn)
  {
    $stmt = $conn->prepare("INSERT INTO cars (brand, stock, sold) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $brand, $stock, $sold);
    $stmt->execute();
    return $conn->insert_id;
  }

  public function update($brand, $stock, $sold, $conn)
  {
    $stmt = $conn->prepare("UPDATE cars SET brand = ?, stock = ?, sold = ? WHERE id = ?");
    $stmt->bind_param("siii", $brand, $stock, $sold, $this->id);
    $stmt->execute();
  }

  public function remove($conn)
  {
    $stmt = $conn->prepare("DELETE FROM cars WHERE id = ?");
    $stmt->bind_param("i", $this->id);
    $stmt->execute();
    foreach (self::logo_extensions() as $ext) {
      $file = $this->id . "." . $ext;
      if (file_exists("logos/" . $file))
        unlink("logos/" . $file);
    }
  }
}