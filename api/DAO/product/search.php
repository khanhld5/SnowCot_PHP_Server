<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// dbConnect
include_once 'productDAO.php';

// get key word
$keywords = isset($_GET["s"]) ? $_GET["s"] : "";

// search
$data = $product->search($keywords);
$_totalRow = $data->rowCount();

// check record found
if ($_totalRow > 0) {

  // products array
  $products_arr = array();
  $products_arr["list"] = array();

  // set list content
  while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $product_item = array(
      "productIndex" => $productIndex,
      "id" => $id,
      "title" => $title,
      "image" => $image,
      "price" => $price,
      "quantity" => $quantity,
      "productLeft" => $productLeft,
      "brand" => $brand,
      "origin" => $origin,
      "description" => $description
    );

    array_push($products_arr["list"], $product_item);
  }

  // set response success - 200 OK
  http_response_code(200);
  echo json_encode($products_arr);
  return;
}

// set response fail - 404 Not Found
http_response_code(404);
echo json_encode(array("message" => "No products found"));
return;
