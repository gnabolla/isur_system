<?php
require 'Database.php';
$config = require 'config.php';
$db = new Database($config['database'], 'root', '');

// Fixed School Year (2024-2025) and Semester (2nd Semester)
$schoolYearId = 1;
$semesterId   = 2;

$viewType  = $_GET['view_type']  ?? null;
$facultyId = $_GET['faculty_id'] ?? null;
$sectionId = $_GET['section_id'] ?? null;
$roomId    = $_GET['room_id']    ?? null;

$scheduleData = [];

if ($viewType) {
    $sql = "
    SELECT
        s.id,
        s.day,
        s.start_time,
        s.end_time,
        sub.code AS subject_code,
        sub.description AS subject_desc,
        r.name AS room_name,
        sec.section AS section_name,
        f.lastname AS faculty_lname,
        f.firstname AS faculty_fname
    FROM schedules s
    LEFT JOIN subjects sub ON s.subject_id = sub.id
    LEFT JOIN rooms r ON s.room_id = r.id
    LEFT JOIN sections sec ON s.section_id = sec.id
    LEFT JOIN faculties f ON s.faculty_id = f.id
    WHERE s.school_year_id = ?
      AND s.semester_id    = ?
    ";

    $params = [$schoolYearId, $semesterId];

    if ($viewType === 'faculty' && $facultyId) {
        $sql .= " AND s.faculty_id = ? ";
        $params[] = $facultyId;
    } elseif ($viewType === 'section' && $sectionId) {
        $sql .= " AND s.section_id = ? ";
        $params[] = $sectionId;
    } elseif ($viewType === 'room' && $roomId) {
        $sql .= " AND s.room_id = ? ";
        $params[] = $roomId;
    }

    $sql .= " ORDER BY FIELD(s.day,'Mon','Tue','Wed','Thu','Fri'), s.start_time ";
    $scheduleData = $db->query($sql, $params)->fetchAll();
}

require 'views/general_schedule_print.view.php';
