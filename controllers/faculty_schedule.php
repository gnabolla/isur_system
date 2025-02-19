<?php
require 'Database.php';
$config = require 'config.php';
$db = new Database($config['database'], 'root', '');

// Get parameters
$facultyId    = $_GET['faculty_id']     ?? null;
$schoolYearId = $_GET['school_year_id'] ?? null;
$semesterId   = $_GET['semester_id']    ?? null;

// Fetch all faculties for dropdown
$faculties = $db->query("
    SELECT id, firstname, middlename, lastname 
    FROM faculties 
    ORDER BY lastname, firstname
")->fetchAll();

// Fetch all school years for dropdown
$schoolYears = $db->query("
    SELECT id, name 
    FROM school_years 
    ORDER BY name
")->fetchAll();

// Fetch all semesters for dropdown
$semesters = $db->query("
    SELECT id, label, sy_id 
    FROM semesters 
    ORDER BY label
")->fetchAll();

// If user selected faculty, sy, sem, fetch the schedule
$scheduleData = [];
if ($facultyId && $schoolYearId && $semesterId) {
    $sql = "
        SELECT 
          s.id,
          s.day,
          s.start_time,
          s.end_time,
          sub.code AS subject_code,
          sub.description AS subject_desc,
          r.name       AS room_name,
          sec.section  AS section_name
        FROM schedules s
        LEFT JOIN subjects sub ON s.subject_id = sub.id
        LEFT JOIN rooms r     ON s.room_id    = r.id
        LEFT JOIN sections sec ON s.section_id = sec.id
        WHERE s.faculty_id     = ?
          AND s.school_year_id = ?
          AND s.semester_id    = ?
        ORDER BY FIELD(s.day,'Mon','Tue','Wed','Thu','Fri'), s.start_time
    ";
    $scheduleData = $db->query($sql, [$facultyId, $schoolYearId, $semesterId])->fetchAll();
}

require 'views/faculty_schedule.view.php';
