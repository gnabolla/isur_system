<?php
require 'Database.php';
$config = require 'config.php';
$db = new Database($config['database'], 'root', '');

// Exclude the schedule being edited from the conflict check
$excludeScheduleId = $_GET['exclude_schedule_id'] ?? null;

$schoolYearId = $_GET['school_year_id'] ?? null;
$semesterId = $_GET['semester_id'] ?? null;
$departmentId = $_GET['department_id'] ?? null;
$programId = $_GET['program_id'] ?? null;
$facultyId = $_GET['faculty_id'] ?? null;
$sectionId = $_GET['section_id'] ?? null;
$roomId = $_GET['room_id'] ?? null;
// $subjectId = $_GET['subject_id'] ?? null; // Removed usage

$sql = "
SELECT
    s.id,
    s.day,
    s.start_time,
    s.end_time,
    f.firstname AS faculty_fname,
    f.lastname AS faculty_lname,
    r.name AS room_name,
    sec.section AS section_name,
    sub.code AS subject_code,
    sub.description AS subject_desc
FROM schedules s
JOIN faculties f ON s.faculty_id = f.id
JOIN rooms r ON s.room_id = r.id
LEFT JOIN sections sec ON s.section_id = sec.id
LEFT JOIN subjects sub ON s.subject_id = sub.id
WHERE 1=1
";

$params = [];

if ($schoolYearId) {
    $sql .= " AND s.school_year_id = ?";
    $params[] = $schoolYearId;
}
if ($semesterId) {
    $sql .= " AND s.semester_id = ?";
    $params[] = $semesterId;
}
if ($departmentId) {
    $sql .= " AND s.department_id = ?";
    $params[] = $departmentId;
}
if ($programId) {
    $sql .= " AND s.program_id = ?";
    $params[] = $programId;
}

// Only faculty, section, or room cause conflict check:
$orClauses = [];
$orParams = [];

if ($facultyId) {
    $orClauses[] = "s.faculty_id = ?";
    $orParams[] = $facultyId;
}
if ($sectionId) {
    $orClauses[] = "s.section_id = ?";
    $orParams[] = $sectionId;
}
if ($roomId) {
    $orClauses[] = "s.room_id = ?";
    $orParams[] = $roomId;
}

// Removed subject-based OR check:
// if ($subjectId) {
//     $orClauses[] = "s.subject_id = ?";
//     $orParams[] = $subjectId;
// }

if (!empty($orClauses)) {
    $sql .= " AND (" . implode(" OR ", $orClauses) . ")";
    $params = array_merge($params, $orParams);
}

if ($excludeScheduleId) {
    $sql .= " AND s.id <> ?";
    $params[] = $excludeScheduleId;
}

$sql .= " ORDER BY FIELD(s.day,'Mon','Tue','Wed','Thu','Fri'), s.start_time";

$schedules = $db->query($sql, $params)->fetchAll();

header('Content-Type: application/json');
echo json_encode($schedules);
