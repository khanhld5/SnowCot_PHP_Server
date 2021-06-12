<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

//db connect
include_once 'productDAO.php';

//set ID need to read
$product->id = isset($_GET['id']) ? $_GET['id'] : die();

//read details of product
$product->readOne();

if ($product->title != null) {
  $product_arr = array(
    "id" => $product->id,
    "title" => $product->title,
    "image" => $product->image,
    "price" => $product->price,
    "quantity" => $product->quantity,
    "productLeft" => $product->productLeft,
    "brand" => $product->brand,
    "origin" => $product->origin,
    "description" => $product->description
  );
  // return response - 200 OK
  http_response_code(200);
  echo json_encode($product_arr);
  return;
}
// return response - 404 Not found
http_response_code(404);
echo json_encode(array("message" => "Product does not exist"));
