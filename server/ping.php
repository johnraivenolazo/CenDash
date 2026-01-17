<?php
/**
 * Supabase Keep-Alive Script
 * This script is intended to be called by a cron job (e.g., cron-job.org) 
 * to prevent the Supabase database from pausing due to inactivity.
 */

include("src/scripts/db/connect.php");

header('Content-Type: application/json');

try {
    // Perform a very simple query to trigger database activity
    $stmt = $db->query("SELECT 1");
    $result = $stmt->fetch();

    if ($result) {
        echo json_encode([
            "status" => "success",
            "message" => "CenDash Backend & Supabase are alive!",
            "timestamp" => date('Y-m-d H:i:s')
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "Database responded but returned no data."
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Connection failed: " . $e->getMessage()
    ]);
}
?>