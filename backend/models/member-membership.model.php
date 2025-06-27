<?php

    function createMemberMembership($data, $conn) {
        $members_id = $data["members_id"] ?? null;
        $plan_id = $data["plan_id"] ?? null;
        $tanggal_mulai = $data["tanggal_mulai"] ?? null;
        $tanggal_berakhir = $data["tanggal_berakhir"] ?? null;
        $status_pembayaran = $data["status_pembayaran"] ?? null;

        $query = "INSERT INTO members_memberships(members_id, plan_id, tanggal_mulai, tanggal_berakhir, status_pembayaran) VALUES(?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "iisss", $members_id, $plan_id, $tanggal_mulai, $tanggal_berakhir, $status_pembayaran);
        $isExecuted = mysqli_stmt_execute($stmt);

        if($isExecuted) {
            return true;
        }

        return false;
    }

    // fungsi untuk kalkulasi tanggal berakhir
    function calculateMembershipDates($memberId, $planId, $conn) {
    // Ambil durasi dari plan
    $queryPlan = "SELECT durasi_hari FROM membership_plan WHERE plan_id = ?";
    $stmtPlan = mysqli_prepare($conn, $queryPlan);
    mysqli_stmt_bind_param($stmtPlan, "i", $planId);
    mysqli_stmt_execute($stmtPlan);
    $result = mysqli_stmt_get_result($stmtPlan);
    $durasi = null;

    if($result && mysqli_num_rows($result) > 0) {
        $durasi = mysqli_fetch_assoc($result);
    }
    $durasi = $durasi['durasi_hari'];


    // Cek apakah ada membership aktif
    $queryLast = "SELECT tanggal_berakhir FROM members_memberships 
                  WHERE members_id = ? AND tanggal_berakhir >= CURDATE() 
                  ORDER BY tanggal_berakhir DESC LIMIT 1";
    
    $stmtLast = mysqli_prepare($conn, $queryLast);
    mysqli_stmt_bind_param($stmtLast, "i", $memberId);
    mysqli_stmt_execute($stmtLast);
    $result = mysqli_stmt_get_result($stmtLast);


    if ($result->num_rows > 0) {
        $lastMembership = mysqli_fetch_assoc($result);
        $tanggalMulai = $lastMembership['tanggal_berakhir'];
    } else {
        $tanggalMulai = date('Y-m-d');
    }

    // Hitung tanggal berakhir
    $tanggalBerakhir = date('Y-m-d', strtotime($tanggalMulai . " +$durasi days"));


    return [
        'tanggal_mulai' => $tanggalMulai,
        'tanggal_berakhir' => $tanggalBerakhir
    ];

    }

    // fungsi untuk set pembayaran dari yang belum lunas menjadi lunas
    function setPembayaranToLunas($idMembership, $conn) {
        $query = "UPDATE members_memberships SET status_pembayaran = 'Lunas' WHERE id_membership = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $idMembership);
        $isExecuted = mysqli_stmt_execute($stmt);
        
        if($isExecuted) {
            return true;
        }
        
        return false;

    }

    // fungsi untuk mendapatkan semua data membership
    function getAllMembershipData($conn) {
        $query = "SELECT * FROM members_memberships ORDER BY id_membership DESC";

        $result = mysqli_query($conn, $query);

        $dataMembership = [];

        if($result && mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)) {
                $dataMembership[] = $row;
            }
        }

        return $dataMembership;
    }

    // fungsi untuk mendapatkan data membership berdasarkan id membership
    function getMembershipDataById($id, $conn) {
        $query = "SELECT * FROM members_memberships WHERE id_membership = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $membershipDataById = null;

        if($result && mysqli_num_rows($result) > 0) {
            $membershipDataById = mysqli_fetch_assoc($result);
        }

        return $membershipDataById;
    }

    //fungsi untuk mendapatkan semua data membership berdasarkan id member 
    function getMembershipDataByMemberId($memberId, $conn) {
        $query = "SELECT * FROM members_memberships WHERE members_id = ? ORDER BY id_membership DESC";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $memberId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $memberData = [];
        
        if($result && mysqli_num_rows($result)) {
            while($row = mysqli_fetch_assoc($result)) {
                $memberData[] = $row;
            }

        }

        return $memberData;
    }   

?>