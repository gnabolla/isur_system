<?php
require 'Database.php';
$config = require 'config.php';

$db = new Database($config['database'], 'root', '');

// Get query parameters
$schoolYearId = $_GET['school_year_id'] ?? null;
$semesterId   = $_GET['semester_id']   ?? null;

// Prepare base SQL
$sql    = "SELECT day, start_time, end_time FROM schedules WHERE 1=1";
$params = [];

// If the user selected a School Year, filter by it
if ($schoolYearId) {
    $sql     .= " AND school_year_id = ?";
    $params[] = $schoolYearId;
}

// If you also want to filter by Semester (optional)
if ($semesterId) {
    $sql     .= " AND semester_id = ?";
    $params[] = $semesterId;
}

// Fetch
$schedules = $db->query($sql, $params)->fetchAll();

// Transform each schedule into multiple half-hour blocks
$occupiedSlots = [];

function generateTimeBlocks($startTimeStr, $endTimeStr, $intervalMinutes = 30)
{
    $blocks = [];
    $start  = new DateTime($startTimeStr);
    $end    = new DateTime($endTimeStr);

    while ($start < $end) {
        $slotStart = $start->format("g:ia"); // e.g. 7:30am
        $start->modify("+$intervalMinutes minutes");
        $slotEnd   = $start->format("g:ia"); // e.g. 8:00am
        $blocks[]  = "$slotStart-$slotEnd";
    }
    return $blocks;
}

foreach ($schedules as $sched) {
    $day       = $sched['day'];         // e.g. 'Mon'
    $startTime = $sched['start_time'];  // e.g. '7:30am'
    $endTime   = $sched['end_time'];    // e.g. '9:00am'

    // Generate half-hour increments
    $timeBlocks = generateTimeBlocks($startTime, $endTime);

    foreach ($timeBlocks as $block) {
        $occupiedSlots[] = [
            "day"  => $day,
            "slot" => $block
        ];
    }
}

// Return JSON
header('Content-Type: application/json');
echo json_encode($occupiedSlots);
