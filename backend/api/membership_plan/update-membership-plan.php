<?php

    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-ALlow-Methods: PATCH");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers");

    //require
    require_once __DIR__ . './../../includes/connection.php';
    require_once __DIR__ . './../../models/membership-plan.model.php';
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
        $planDataToUpdate = json_decode($jsonInputRaw, true);

        if(json_last_error() !== JSON_ERROR_NONE && $planDataToUpdate !== null) {
            http_response_code(400);
            $response['status'] = 400;
            $response['message'] = "invalid JSON format!";
            $response['errors'] = "invalid JSON format!";

        } else {
            $validationError = createMembershipPlanValidation($planDataToUpdate);


            if(!empty($validationError)){
                http_response_code(400);
                $response['status'] = 400;
                $response['message'] = "Bad request!";
                $response['errors'] = $validationError;
            } else {
                //sanitasi
                $sanitizedData = [];
                $sanitizedData['nama_paket'] = sanitizeString($planDataToUpdate['nama_paket']);
                $sanitizedData['harga_paket'] = sanitizeString($planDataToUpdate['harga_paket']);
                $sanitizedData['durasi_hari'] = sanitizeString($planDataToUpdate['durasi_hari']);
                $sanitizedData['deskripsi'] = sanitizeString($planDataToUpdate['deskripsi']);
                $sanitizedData['plan_id'] = sanitizeNumber($planDataToUpdate['plan_id']);
                

                // insert to database
                $result = updateMembershipPlan($sanitizedData, $conn);
                if($result){
                    $response['status'] = 200;
                    $response['message'] = 'OK!';
                    $response['data'] = $sanitizedData;
                }

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
