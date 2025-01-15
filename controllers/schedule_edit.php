<?php
session_start();

require 'Database.php';
$config = require 'config.php';

$db = new Database($config['database'], 'root', '');

// 1. Get schedule ID
$scheduleId = $_GET['id'] ?? null;
if (!$scheduleId) {
    header('Location: /');
    exit;
}

// 2. Fetch dropdown data
$schoolYears = $db->query("SELECT id, name FROM school_years ORDER BY name")->fetchAll();
$semesters = $db->query("SELECT id, label, sy_id FROM semesters ORDER BY label")->fetchAll();
$departments = $db->query("SELECT id, name FROM departments ORDER BY name")->fetchAll();
$programs = $db->query("SELECT id, name FROM programs ORDER BY name")->fetchAll();
$faculties = $db->query("SELECT id, firstname, middlename, lastname FROM faculties ORDER BY lastname, firstname")->fetchAll();
$sections = $db->query("SELECT id, section FROM sections ORDER BY section")->fetchAll();
$rooms = $db->query("SELECT id, name FROM rooms ORDER BY name")->fetchAll();
$subjects = $db->query("SELECT id, code, description FROM subjects ORDER BY code")->fetchAll();

$error = '';

// 3. If POST request, handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $schoolYearId = $_POST['school_year_id'] ?? null;
    $semesterId = $_POST['semester_id'] ?? null;
    $departmentId = $_POST['department_id'] ?? null;
    $programId = $_POST['program_id'] ?? null;
    $facultyId = $_POST['faculty_id'] ?? null;
    $sectionId = $_POST['section_id'] ?? null;
    $roomId = $_POST['room_id'] ?? null;
    $subjectId = $_POST['subject_id'] ?? null;
    $day = $_POST['day'] ?? null;
    $startTime = $_POST['start_time'] ?? null;
    $endTime = $_POST['end_time'] ?? null;

    // Convert to 24-hour format
    $startTime24 = date("H:i:s", strtotime($startTime));
    $endTime24   = date("H:i:s", strtotime($endTime));

    // 3.a: Check for conflicts, excluding current schedule
    $conflictSql = "
        SELECT COUNT(*) as cnt
        FROM schedules
        WHERE
            id <> ?
            AND school_year_id = ?
            AND semester_id = ?
            AND day = ?
            AND (
                faculty_id = ?
                OR section_id = ?
                OR room_id = ?
            )
            AND NOT (end_time <= ? OR start_time >= ?)
    ";
    $conflictParams = [
        $scheduleId,
        $schoolYearId,
        $semesterId,
        $day,
        $facultyId,
        $sectionId,
        $roomId,
        $startTime24,
        $endTime24
    ];
    $conflictCount = $db->query($conflictSql, $conflictParams)->fetch()['cnt'] ?? 0;

    if ($conflictCount > 0) {
        $error = "Conflict detected. Please choose another schedule.";
    } else {
        // 3.b: Update if no conflict
        $updateSql = "
            UPDATE schedules
            SET
                school_year_id = ?,
                semester_id = ?,
                department_id = ?,
                program_id = ?,
                faculty_id = ?,
                section_id = ?,
                room_id = ?,
                subject_id = ?,
                day = ?,
                start_time = ?,
                end_time = ?
            WHERE id = ?
        ";

        $db->query($updateSql, [
            $schoolYearId,
            $semesterId,
            $departmentId,
            $programId,
            $facultyId,
            $sectionId,
            $roomId,
            $subjectId,
            $day,
            $startTime24,
            $endTime24,
            $scheduleId
        ]);

        header('Location: /?schedule_updated=1');
        exit;
    }
}

// 4. Fetch existing schedule data
$sql = "SELECT * FROM schedules WHERE id = ?";
$schedule = $db->query($sql, [$scheduleId])->fetch();

if (!$schedule) {
    header('Location: /');
    exit;
}

// 5. Load the edit view
require 'views/edit.view.php';
