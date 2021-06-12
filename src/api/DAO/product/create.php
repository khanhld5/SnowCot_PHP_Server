<?php
//require header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//dbconnect
include_once 'productDAO.php';

//get post data
$data = json_decode(file_get_contents("php://input"));


// set data
$product->id = $data->product->id;
$product->title = $data->product->title;
$product->image = $data->product->image;
$product->price = $data->product->price;
$product->quantity = $data->product->quantity;
$product->productLeft = $data->product->left;
$product->brand = $data->product->brand;
$product->origin = $data->product->origin;
$product->description = $data->product->description;

if ($product->create()) {

  // return response - 200 OK
  http_response_code(200);
  echo json_encode(array("message" => "Product was created successfully"));
  return;
}
// return response - 503 Unable to create
http_response_code(503);
echo json_encode(array("message" => "Unable to create product"));
