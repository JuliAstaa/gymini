<?php

    // create transaction
    function createTransaction($data, $conn) {
        $members_id = $data['members_id'] ?? null;
        $plan_id = $data['plan_id'] ?? null;
        $amount = $data['amount'] ?? null;
        $payment_method	 = $data['payment_method'] ?? null;
        $description = $data['description'] ?? null;

        $query = "INSERT INTO payments(members_id, plan_id, amount, payment_method, description) VALUES(?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "iiiss", $members_id, $plan_id, $amount, $payment_method, $description);
        $isExecuted = mysqli_stmt_execute($stmt);

        if($isExecuted) {
            return true;
        }

        return false;
        
    }

    //get all data transaction 
    function getAllTransaction($conn) {
        $query = "SELECT * FROM payments ORDER BY id_transaction DESC";
        $result = mysqli_query($conn, $query);
        $transactionData = [];

        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $transactionData[] = $row;
            }
        }

        return $transactionData;
    }

    function getTransactionById($id, $conn) {
        $query = "SELECT * FROM payments WHERE id_transaction = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $transanctionById = null;
        if($result && mysqli_num_rows($result) > 0) {
            $transanctionById = mysqli_fetch_assoc($result);
        }

        return $transanctionById;
    }

?>