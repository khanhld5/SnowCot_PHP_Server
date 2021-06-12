<?php
class Product
{
  private $conn;
  private $table_name = "products";

  public $productIndex;
  public $id;
  public $title;
  public $image;
  public $price;
  public $quantity;
  public $productLeft;
  public $brand;
  public $origin;
  public $description;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  // read all records
  function read()
  {
    // query to select all
    $query = "SELECT 
                p.productIndex, 
                p.id, 
                p.title, 
                p.image, 
                p.price, 
                p.quantity, 
                p.productLeft, 
                p.brand, 
                p.origin, 
                p.description 
              FROM 
                  " . $this->table_name . " p 
              ORDER BY p.productIndex DESC ";

    // prepare query
    $statement = $this->conn->prepare($query);

    //exec
    $statement->execute();

    return $statement;
  }

  // create new record
  function create()
  {
    // query insert to record
    $query = "INSERT INTO "
      . $this->table_name .
      " SET id = :id, 
           title = :title, 
           image = :image, 
           price = :price, 
           quantity = :quantity, 
           productLeft = :productLeft, 
           brand = :brand, 
           origin = :origin, 
           description = :description";

    // prepare query
    $statement = $this->conn->prepare($query);

    // santize number
    $price = intval($this->price);
    $quantity = intval($this->quantity);
    $productLeft = intval($this->productLeft);

    //bind value
    $statement->bindParam(":id", $this->id);
    $statement->bindParam(":title", $this->title);
    $statement->bindParam(":image", $this->image);
    $statement->bindParam(":price", $price);
    $statement->bindParam(":quantity", $quantity);
    $statement->bindParam(":productLeft", $productLeft);
    $statement->bindParam(":brand", $this->brand);
    $statement->bindParam(":origin", $this->origin);
    $statement->bindParam(":description", $this->description);

    //exec
    if ($statement->execute()) {
      return true;
    }
    return false;
  }

  // get only one record
  function readOne()
  {
    // query to read single record
    $query = "SELECT 
                p.productIndex, p.id, p.title, p.image,p.price,p.quantity, 
                p.productLeft,p.brand,p.origin, p.description 
              FROM 
                  " . $this->table_name . " p 
              WHERE 
                  P.id = ? 
              LIMIT
                  0,1";
    //prepare query 
    $statement = $this->conn->prepare($query);

    //bind id of product 
    $statement->bindParam(1, $this->id);

    //exec
    $statement->execute();

    //get row
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    //set value for object
    $this->productIndex = $row['productIndex'];
    $this->id = $row['id'];
    $this->title = $row['title'];
    $this->image = $row['image'];
    $this->price = $row['price'];
    $this->quantity = $row['quantity'];
    $this->productLeft = $row['productLeft'];
    $this->brand = $row['brand'];
    $this->origin = $row['origin'];
    $this->description = $row['description'];
  }

  // update product
  function update()
  {

    // update query
    $query = "UPDATE " . $this->table_name . "
              SET 
                title=:title, 
                image=:image, 
                price=:price, 
                quantity=:quantity, 
                productLeft=:productLeft, 
                brand=:brand, 
                origin=:origin, 
                description=:description
              WHERE 
                id =:id";
    // prepare query
    $statement = $this->conn->prepare($query);

    // santize number
    $price = intval($this->price);
    $quantity = intval($this->quantity);
    $productLeft = intval($this->productLeft);

    //bind value
    $statement->bindParam(":id", $this->id);
    $statement->bindParam(":title", $this->title);
    $statement->bindParam(":image", $this->image);
    $statement->bindParam(":price", $price);
    $statement->bindParam(":quantity", $quantity);
    $statement->bindParam(":productLeft", $productLeft);
    $statement->bindParam(":brand", $this->brand);
    $statement->bindParam(":origin", $this->origin);
    $statement->bindParam(":description", $this->description);

    //exec
    if ($statement->execute()) {
      return true;
    }
    return false;
  }

  // delete product
  function delete()
  {
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

    // prepare query
    $statement = $this->conn->prepare($query);

    // bind id
    $statement->bindParam(1, $this->id);

    //exec
    if ($statement->execute()) {
      return true;
    }
    return false;
  }

  // search
  function search($keywords)
  {

    // search query
    $query = "SELECT 
                * 
              FROM 
                  " . $this->table_name . " p 
              WHERE 
                MATCH(title) against(?) 
              ORDER BY p.productIndex DESC ";

    // prepare query
    $statement = $this->conn->prepare($query);

    // bind values
    $statement->bindParam(1, $keywords);

    //exec
    $statement->execute();

    return $statement;
  }
}
