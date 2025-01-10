<?php
// File: controllers/faculty_schedule_print.php

require 'Database.php';
$config = require 'config.php';
$db = new Database($config['database'], 'root', '');

// Grab GET params
$facultyId    = $_GET['faculty_id']     ?? null;
$schoolYearId = $_GET['school_year_id'] ?? null;
$semesterId   = $_GET['semester_id']    ?? null;

// Fetch references (school years, semesters) to display in the print view
$schoolYears = $db->query("SELECT id, name FROM school_years ORDER BY name")->fetchAll();
$semesters   = $db->query("SELECT id, label, sy_id FROM semesters ORDER BY label")->fetchAll();

$scheduleData = [];
$facultyInfo  = null;

if ($facultyId && $schoolYearId && $semesterId) {
    // (Optional) fetch the faculty's info
    $facultyInfo = $db->query("
        SELECT id, firstname, middlename, lastname
        FROM faculties
        WHERE id = ?
    ", [$facultyId])->fetch();

    // Fetch schedules for that faculty
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

require 'views/faculty_schedule_print.view.php';
