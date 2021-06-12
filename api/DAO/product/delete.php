<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// dbConnect
include_once 'productDAO.php';

// get product id
$data = json_decode(file_get_contents("php://input"));

// set product id 
$product->id = $data->id;

// delete the product
if ($product->delete()) {
  // set response success - 200 OK
  http_response_code(200);
  echo json_encode(array("message" => "Product was deleted successfully"));
  return;
}

// set response fail - 503 service unavaiable
http_response_code(503);
echo json_encode(array("message" => "Unable to delete product"));
return;
