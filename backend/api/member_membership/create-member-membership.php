<?php

    require_once __DIR__ . './../../includes/connection.php';
    require_once __DIR__ . './../../models/member-membership.model.php';
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
        $memberMembershipData = json_decode($jsonInputRaw, true);

        //cek json 
        if(json_last_error() !== JSON_ERROR_NONE && $memberMembershipData !== null) {
            http_response_code(400);
            $response['status'] = 400;
            $response['message'] = "invalid JSON format!";
            $response['errors'] = "invalid JSON format!";
        } else {

            
            //validasi
            $validationError = createMemberMembershipValidation($memberMembershipData);
            
            if(!empty($validationError)){
                http_response_code(400);
                $response['status'] = 400;
                $response['message'] = "Bad request!";
                $response['errors'] = $validationError;
            } else {
                // fungsi buat kalkulasi tanggal mnulai dan tanggal berakhir secara otomatis
                $tanggal = calculateMembershipDates($memberMembershipData['members_id'], $memberMembershipData['plan_id'], $conn);


                //sanitasi
                $sanitizedData = [];
                $sanitizedData['plan_id'] = sanitizeString($memberMembershipData['plan_id']);
                $sanitizedData['members_id'] = sanitizeString($memberMembershipData['members_id']);
                $sanitizedData['tanggal_mulai'] = sanitizeString($tanggal['tanggal_mulai']);
                $sanitizedData['tanggal_berakhir'] = sanitizeString($tanggal['tanggal_berakhir']);
                $sanitizedData['status_pembayaran'] = sanitizeString($memberMembershipData['status_pembayaran']);
                

                // insert to database
                $result = createMemberMembership($sanitizedData, $conn);
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