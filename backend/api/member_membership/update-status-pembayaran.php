<?php

    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-ALlow-Methods: PATCH");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers");

    //require
    require_once __DIR__ . './../../includes/connection.php';
    require_once __DIR__ . './../../models/member-membership.model.php';
    require_once __DIR__ . './../../includes/validator.php';

    // buat response
    $response = [
        'status' => null,
        'message' => '',
        'data' => null,
        'errors' => null
    ];


    if($_SERVER["REQUEST_METHOD"] == "PATCH"){

        $jsonInputRaw = file_get_contents('php://input');
        $idMembership = json_decode($jsonInputRaw, true);

        if(json_last_error() !== JSON_ERROR_NONE && $planDataToUpdate !== null) {
            http_response_code(400);
            $response['status'] = 400;
            $response['message'] = "invalid JSON format!";
            $response['errors'] = "invalid JSON format!";

        } else {
                // insert to database
                $result = setPembayaranToLunas($idMembership['id_memberships'], $conn);
                if($result){
                    $response['status'] = 200;
                    $response['message'] = 'OK!';
                }

        }

        

    } else { 
         // JIKA PAKAI METHOD SELAIN PATCH
        http_response_code(405);
        $response['status'] = 405;
        $response['message'] = "Method not";
    }


    echo json_encode($response);

?>
