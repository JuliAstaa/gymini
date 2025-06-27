<?php

    function getAllMembershipPlan($conn) {
        $query = "SELECT * FROM membership_plan WHERE membership_plan.membership_status = 1";
        $result = mysqli_query($conn, $query);

        $membershipPlanData = [];
        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $membershipPlanData[] = $row;
            }
        }
        return $membershipPlanData;
    }

    function getMembershipPlanById($id, $conn) {
        $query = "SELECT * FROM membership_plan WHERE membership_plan.plan_id = ? AND membership_plan.membership_status";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt,"s", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $dataMembershipPlanById = null;
        if($result && mysqli_num_rows($result) > 0) {
            $dataMembershipPlanById = mysqli_fetch_assoc($result);
        }

        return $dataMembershipPlanById;
    }

    function createMembershipPlan($data, $conn) {
        $nama_paket = $data["nama_paket"];
        $harga_paket = $data["harga_paket"];
        $durasi_hari = $data["durasi_hari"];
        $deskripsi = $data["deskripsi"];

        $query = "INSERT INTO membership_plan(nama_paket, harga_paket, durasi_hari, deskripsi) VALUES (?,?,?,?)";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "siis", $nama_paket, $harga_paket, $durasi_hari, $deskripsi);
        $isExecuted = mysqli_stmt_execute($stmt);

        if($isExecuted) {
            return true;
        }
        
        return false;
    }

    function updateMembershipPlan($data, $conn) {
        $nama_paket = $data["nama_paket"];
        $harga_paket = $data["harga_paket"];
        $durasi_hari = $data["durasi_hari"];
        $deskripsi = $data["deskripsi"];
        $plan_id = $data["plan_id"];    

        $query = "UPDATE membership_plan SET membership_plan.nama_paket = ?,                    
        membership_plan.harga_paket = ?,
        membership_plan.durasi_hari = ?,
        membership_plan.deskripsi = ?  WHERE membership_plan.plan_id = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "siisi", $nama_paket, $harga_paket, $durasi_hari, $deskripsi, $plan_id);
        $isExecuted = mysqli_stmt_execute($stmt);

        if($isExecuted) {
            return true;
        }
        
        return false;
    }

    function deleteMembershipPlan($id, $conn) {
        $query = "UPDATE membership_plan SET membership_plan.membership_status = 0 WHERE membership_plan.plan_id = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        $isExecuted = mysqli_stmt_execute($stmt);

        if($isExecuted) {
            return true;
        }

        return false;
    }

    function getMembershipPlanPrice($id, $conn) {
        $query = "SELECT harga_paket FROM membership_plan WHERE plan_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $price = null;
        if($result && mysqli_num_rows($result) > 0) {
            $price = mysqli_fetch_assoc($result);
        }

        return $price;
    }

?>