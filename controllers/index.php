<?php

require 'Database.php';
$config = require 'config.php';

// Initialize Database
$db = new Database($config['database'], 'root', '');

// Gather filters
$facultyId      = $_GET['faculty_id']     ?? '';
$roomId         = $_GET['room_id']        ?? '';
$sectionId      = $_GET['section_id']     ?? '';
$subjectId      = $_GET['subject_id']     ?? '';
$semesterId     = $_GET['semester_id']    ?? '';
$programId      = $_GET['program_id']     ?? '';
$departmentId   = $_GET['department_id']  ?? '';
$schoolYearId   = $_GET['school_year_id'] ?? '';

$whereClauses = [];
$params       = [];

// Build where clauses
if ($facultyId) {
    $whereClauses[] = 's.faculty_id = ?';
    $params[]       = $facultyId;
}
if ($roomId) {
    $whereClauses[] = 's.room_id = ?';
    $params[]       = $roomId;
}
if ($sectionId) {
    $whereClauses[] = 's.section_id = ?';
    $params[]       = $sectionId;
}
if ($subjectId) {
    $whereClauses[] = 's.subject_id = ?';
    $params[]       = $subjectId;
}
if ($semesterId) {
    $whereClauses[] = 's.semester_id = ?';
    $params[]       = $semesterId;
}

// NOTE: If you need to add program_id, department_id, school_year_id in filtering, do so similarly

$whereString = '';
if (!empty($whereClauses)) {
    $whereString = 'WHERE ' . implode(' AND ', $whereClauses);
}

$sql = "
    SELECT 
        s.*,
        f.firstname   AS faculty_fname, 
        f.lastname    AS faculty_lname,
        r.name        AS room_name,
        sub.code      AS subject_code, 
        sub.description AS subject_desc,
        sec.section   AS section_name
    FROM schedules s
    JOIN faculties f ON s.faculty_id = f.id
    JOIN rooms r ON s.room_id = r.id
    LEFT JOIN subjects sub ON s.subject_id = sub.id
    LEFT JOIN sections sec ON s.section_id = sec.id
    $whereString
    ORDER BY FIELD(s.day,'Mon','Tue','Wed','Thu','Fri'), s.start_time
";

$schedules   = $db->query($sql, $params)->fetchAll();

// Dropdown data
$faculties   = $db->query("SELECT id, firstname, middlename, lastname FROM faculties ORDER BY lastname, firstname")->fetchAll();
$sections    = $db->query("SELECT id, section FROM sections ORDER BY section")->fetchAll();
$rooms       = $db->query("SELECT id, name FROM rooms ORDER BY name")->fetchAll();
$programs    = $db->query("SELECT p.id, p.name, p.department_id FROM programs p ORDER BY p.name")->fetchAll();
$departments = $db->query("SELECT id, name FROM departments ORDER BY name")->fetchAll();
$schoolYears = $db->query("SELECT id, name FROM school_years ORDER BY name")->fetchAll();
$semesters   = $db->query("SELECT id, label, sy_id FROM semesters ORDER BY label")->fetchAll();
$subjects    = $db->query("SELECT id, code, description FROM subjects ORDER BY code")->fetchAll();

require 'views/index.view.php';
