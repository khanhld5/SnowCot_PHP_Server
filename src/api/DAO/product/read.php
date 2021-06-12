<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//dbconnect
include_once 'productDAO.php';

//action

$data = $product->read();
$_totalRow = $data->rowCount();

if ($_totalRow > 0) {
  $products_arr = array();
  $products_arr["list"] = array();

  while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $product_item = array(
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

  // return response - 200 OK
  http_response_code(200);
  echo json_encode($products_arr);
  return;
}

// return response - 404 Not found
http_response_code(404);
echo json_encode(
  array("message" => "No products found.")
);
