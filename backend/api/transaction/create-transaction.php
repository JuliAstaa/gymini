<?php

    require_once __DIR__ . './../../includes/connection.php';
    require_once __DIR__ . './../../models/transaction.model.php';
    require_once __DIR__ . './../../models/membership-plan.model.php';
    require_once __DIR__ . './../../includes/validator.php';

    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers");

    $response = [
        'status' => null,
        'message' => '',
        'data' => null,
        'errors' => null
    ];

    
    if($_SERVER['REQUEST_METHOD'] === "POST") {

        // ambil data json dari body
        $jsonInputRaw = file_get_contents('php://input');
        $transactionData = json_decode($jsonInputRaw, true);

        //cek json 
        if(json_last_error() !== JSON_ERROR_NONE && $transactionData !== null) {
            http_response_code(400);
            $response['status'] = 400;
            $response['message'] = "invalid JSON format!";
            $response['errors'] = "invalid JSON format!";
        } else {
            //validasi
            $validationError = createTransactionValidation($transactionData);

            $price = getMembershipPlanPrice($transactionData['plan_id'], $conn);

            if(!empty($validationError)){
                http_response_code(400);
                $response['status'] = 400;
                $response['message'] = "Bad request!";
                $response['errors'] = $validationError;
            } else {
                //sanitasi
                $sanitizedData = [];
                $sanitizedData['members_id'] = sanitizeString($transactionData['members_id']);
                $sanitizedData['plan_id'] = sanitizeString($transactionData['plan_id']);
                $sanitizedData['amount'] = sanitizeString($price['harga_paket']);
                $sanitizedData['payment_method'] = sanitizeString($transactionData['payment_method']);
                $sanitizedData['description'] = sanitizeString($transactionData['description']);

                // insert to database
                $result = createTransaction($sanitizedData, $conn);
                if($result){
                    $response['status'] = 201;
                    $response['message'] = 'Created!';
                    $response['data'] = $sanitizedData;
                }

            }

        }
        
        
    } else { //method selain post
        http_response_code(405);
        $response['status'] = 405;
        $response['message'] = "Method not allowed!";
    }

    echo json_encode($response);

?>