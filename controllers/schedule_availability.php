<?php
require 'Database.php';
$config = require 'config.php';
$db = new Database($config['database'], 'root', '');

$schoolYearId = $_GET['school_year_id']     ?? null;
$semesterId   = $_GET['semester_id']        ?? null;
$departmentId = $_GET['department_id']      ?? null;
$programId    = $_GET['program_id']         ?? null;
$facultyId    = $_GET['faculty_id']         ?? null;
$sectionId    = $_GET['section_id']         ?? null;
$roomId       = $_GET['room_id']            ?? null;
$subjectId    = $_GET['subject_id']         ?? null;

// Exclude the schedule being edited from the conflict check
$excludeScheduleId = $_GET['exclude_schedule_id'] ?? null;

$sql    = "SELECT id, day, start_time, end_time FROM schedules WHERE 1=1";
$params = [];

if ($schoolYearId) {
    $sql     .= " AND school_year_id = ?";
    $params[] = $schoolYearId;
}
if ($semesterId) {
    $sql     .= " AND semester_id = ?";
    $params[] = $semesterId;
}
if ($departmentId) {
    $sql     .= " AND department_id = ?";
    $params[] = $departmentId;
}
if ($programId) {
    $sql     .= " AND program_id = ?";
    $params[] = $programId;
}

$orClauses = [];
$orParams  = [];

if ($facultyId) {
    $orClauses[] = "faculty_id = ?";
    $orParams[]  = $facultyId;
}
if ($sectionId) {
    $orClauses[] = "section_id = ?";
    $orParams[]  = $sectionId;
}
if ($roomId) {
    $orClauses[] = "room_id = ?";
    $orParams[]  = $roomId;
}
if ($subjectId) {
    $orClauses[] = "subject_id = ?";
    $orParams[]  = $subjectId;
}

if (!empty($orClauses)) {
    $sql    .= " AND (" . implode(" OR ", $orClauses) . ")";
    $params  = array_merge($params, $orParams);
}

if ($excludeScheduleId) {
    $sql     .= " AND id <> ?";
    $params[] = $excludeScheduleId;
}

$schedules = $db->query($sql, $params)->fetchAll();

$occupiedSlots = [];

function generateTimeBlocks($startTimeStr, $endTimeStr, $intervalMinutes = 30) {
    $blocks = [];
    $start  = new DateTime($startTimeStr);
    $end    = new DateTime($endTimeStr);
    while ($start < $end) {
        $slotStart = $start->format("g:ia");
        $start->modify("+$intervalMinutes minutes");
        $slotEnd   = $start->format("g:ia");
        $blocks[]  = "$slotStart-$slotEnd";
    }
    return $blocks;
}

foreach ($schedules as $sched) {
    $timeBlocks = generateTimeBlocks($sched['start_time'], $sched['end_time']);
    foreach ($timeBlocks as $block) {
        $occupiedSlots[] = [
            "day"  => $sched['day'],
            "slot" => $block
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($occupiedSlots);
