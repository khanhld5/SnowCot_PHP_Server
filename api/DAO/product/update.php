<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//dbConnect
include_once 'productDAO.php';

// get id of product
$data = json_decode(file_get_contents("php://input"));

echo var_dump($data);

// set id for product
$product->id = $data->product->id;

// set orther property of product
$product->title = $data->product->title;
$product->image = $data->product->image;
$product->price = $data->product->price;
$product->quantity = $data->product->quantity;
$product->productLeft = $data->product->left;
$product->brand = $data->product->brand;
$product->origin = $data->product->origin;
$product->description = $data->product->description;

// update product

if ($product->update()) {
  // set response success - 200 OK
  http_response_code(200);
  echo json_encode(array("message" => "Product update successfully"));
  return;
}
// set response fail - 503 service unavailable
http_response_code(503);
echo json_encode(array("message" => "Unable to update product"));
return;
