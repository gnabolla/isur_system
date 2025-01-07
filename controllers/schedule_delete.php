<?php
session_start();

require 'Database.php';
$config = require 'config.php';

// Initialize Database
$db = new Database($config['database'], 'root', '');

// 1. Get schedule ID from the query string
$scheduleId = $_GET['id'] ?? null;

// If no ID is provided, redirect back or handle error
if (!$scheduleId) {
    header('Location: /?error_no_id=1');
    exit;
}

// 2. Delete the schedule
$sql = "DELETE FROM schedules WHERE id = ?";
$db->query($sql, [$scheduleId]);

// 3. Redirect back to the homepage (or anywhere you prefer) with a success flag
header('Location: /?schedule_deleted=1');
exit;
