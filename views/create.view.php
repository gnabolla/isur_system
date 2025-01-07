<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Create Schedule</title>
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    />
    <link 
        href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" 
        rel="stylesheet"
    />
    <style>
        /* Make the table more "square-like" but with reduced cell height */
        .time-table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed; /* Forces columns to share the available width */
        }

        /* Custom class for the time column to make it wider */
        .time-column {
            width: 120px; /* Increase as needed */
        }

        .time-table th,
        .time-table td {
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            user-select: none;
            border: 1px solid #dee2e6;
            white-space: nowrap; /* Prevents time from breaking into multiple lines */
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 0.85rem;
            height: 30px;        /* Reduced row height */
            padding: 0.3rem;     /* Adjust for spacing */
        }

        .time-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .time-table td:hover {
            background-color: #f1f3f5;
        }

        .time-table td.selected {
            background-color: #ffd966;
            font-weight: 600;
        }

        .time-table td.disabled {
            background-color: #e9ecef;
            color: #6c757d;
            cursor: not-allowed;
        }

        .disabled-table {
            pointer-events: none;
            opacity: 0.6;
        }

        /* Make sure it looks okay on small screens */
        @media (max-width: 576px) {
            .time-table th,
            .time-table td {
                font-size: 0.7rem;
                padding: 0.3rem;
            }
        }
    </style>
</head>
<body>
<div class="container my-5">

    <h1 class="mb-4">Create a New Schedule</h1>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- Side-by-side layout -->
    <div class="row">
        <!-- Left Column (Form) -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="school_year_id" class="form-label">School Year</label>
                                <select class="form-select select2" name="school_year_id" id="school_year_id" required>
                                    <option value="">--Select School Year--</option>
                                    <?php foreach ($schoolYears as $sy): ?>
                                        <option value="<?= htmlspecialchars($sy['id']) ?>">
                                            <?= htmlspecialchars($sy['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="semester_id" class="form-label">Semester</label>
                                <select class="form-select select2" name="semester_id" id="semester_id" required>
                                    <option value="">--Select Semester--</option>
                                    <?php foreach ($semesters as $sem): ?>
                                        <option value="<?= htmlspecialchars($sem['id']) ?>">
                                            <?= htmlspecialchars($sem['label']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label for="department_id" class="form-label">Department</label>
                                <select class="form-select select2" name="department_id" id="department_id" required>
                                    <option value="">--Select Department--</option>
                                    <?php foreach ($departments as $dept): ?>
                                        <option value="<?= htmlspecialchars($dept['id']) ?>">
                                            <?= htmlspecialchars($dept['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="program_id" class="form-label">Program</label>
                                <select class="form-select select2" name="program_id" id="program_id" required>
                                    <option value="">--Select Program--</option>
                                    <?php foreach ($programs as $prog): ?>
                                        <option value="<?= htmlspecialchars($prog['id']) ?>">
                                            <?= htmlspecialchars($prog['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label for="faculty_id" class="form-label">Faculty</label>
                                <select class="form-select select2" name="faculty_id" id="faculty_id" required disabled>
                                    <option value="">--Select Faculty--</option>
                                    <?php foreach ($faculties as $faculty): ?>
                                        <option value="<?= htmlspecialchars($faculty['id']) ?>">
                                            <?= htmlspecialchars($faculty['lastname'] . ', ' . $faculty['firstname']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="section_id" class="form-label">Section</label>
                                <select class="form-select select2" name="section_id" id="section_id" disabled>
                                    <option value="">--Select Section--</option>
                                    <?php foreach ($sections as $section): ?>
                                        <option value="<?= htmlspecialchars($section['id']) ?>">
                                            <?= htmlspecialchars($section['section']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label for="room_id" class="form-label">Room</label>
                                <select class="form-select select2" name="room_id" id="room_id" disabled>
                                    <option value="">--Select Room--</option>
                                    <?php foreach ($rooms as $room): ?>
                                        <option value="<?= htmlspecialchars($room['id']) ?>">
                                            <?= htmlspecialchars($room['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="subject_id" class="form-label">Subject</label>
                                <select class="form-select select2" name="subject_id" id="subject_id" required disabled>
                                    <option value="">--Select Subject--</option>
                                    <?php foreach ($subjects as $subject): ?>
                                        <option value="<?= htmlspecialchars($subject['id']) ?>">
                                            <?= htmlspecialchars($subject['code'] . ' - ' . $subject['description']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-4">
                                <label for="day" class="form-label">Day</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="day" 
                                    id="day" 
                                    readonly 
                                    required
                                >
                            </div>
                            <div class="col-md-4">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="start_time" 
                                    id="start_time" 
                                    readonly 
                                    required
                                >
                            </div>
                            <div class="col-md-4">
                                <label for="end_time" class="form-label">End Time</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="end_time" 
                                    id="end_time" 
                                    readonly 
                                    required
                                >
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary me-2">
                                Create Schedule
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column (Timetable) -->
        <div class="col-md-6">
            <div class="table-responsive">
                <table class="table table-striped table-hover time-table disabled-table" id="timetable">
                    <thead>
                        <tr>
                            <!-- Add time-column class to the first TH -->
                            <th class="time-column">Time</th>
                            <!-- Shortened day headers -->
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        function generateTimeSlots($start, $end, $interval = 30) {
                            $slots = [];
                            $current = strtotime($start);
                            $endTime = strtotime($end);
                            while ($current < $endTime) {
                                $slotStart = date("g:ia", $current);
                                $current += $interval * 60;
                                $slotEnd = date("g:ia", $current);
                                // Single-line format: e.g. "7:30am-8:00am"
                                $slots[] = "$slotStart-$slotEnd";
                            }
                            return $slots;
                        }
                        $timeSlots = generateTimeSlots("07:30", "17:00", 30);
                        foreach ($timeSlots as $slot):
                        ?>
                        <tr>
                            <!-- Add time-column class to the first TD as well -->
                            <td class="time-column"><?= htmlspecialchars($slot) ?></td>
                            <td data-day="Mon" data-slot="<?= htmlspecialchars($slot) ?>"></td>
                            <td data-day="Tue" data-slot="<?= htmlspecialchars($slot) ?>"></td>
                            <td data-day="Wed" data-slot="<?= htmlspecialchars($slot) ?>"></td>
                            <td data-day="Thu" data-slot="<?= htmlspecialchars($slot) ?>"></td>
                            <td data-day="Fri" data-slot="<?= htmlspecialchars($slot) ?>"></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
</script>
<script 
    src="https://code.jquery.com/jquery-3.6.0.min.js">
</script>
<script 
    src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js">
</script>
<script>
$(document).ready(function() {
    $('.select2').select2();
    updateFormState();
});

// Variables for selecting timeslots
let isMouseDown = false;
let selectedDay = null;
let selectedCells = [];

function parseTimeStrToDate(timeStr) {
    return new Date("01/01/2020 " + timeStr);
}

function clearSelection() {
    selectedCells.forEach(cell => cell.classList.remove('selected'));
    selectedCells = [];
}

function updateFormState() {
    const sy  = $('#school_year_id').val();
    const sem = $('#semester_id').val();
    const dep = $('#department_id').val();
    const pro = $('#program_id').val();
    const fac = $('#faculty_id').val();
    const sec = $('#section_id').val();
    const rom = $('#room_id').val();
    const sub = $('#subject_id').val();

    const canEnableFaculty = sy && sem && dep && pro;
    $('#faculty_id').prop('disabled', !canEnableFaculty);

    const canEnableSection = canEnableFaculty && fac;
    $('#section_id').prop('disabled', !canEnableSection);

    const canEnableRoom = canEnableSection && sec;
    $('#room_id').prop('disabled', !canEnableRoom);

    const canEnableSubject = canEnableRoom && rom;
    $('#subject_id').prop('disabled', !canEnableSubject);

    const canEnableTable = canEnableSubject && sub;
    if (canEnableTable) {
        $('#timetable').removeClass('disabled-table');
    } else {
        $('#timetable').addClass('disabled-table');
        clearSelection();
    }
}

$('#school_year_id, #semester_id, #department_id, #program_id, #faculty_id, #section_id, #room_id, #subject_id')
    .on('change', function() {
        updateFormState();
        fetchAndDisableOccupied();
    });

const timetable = document.getElementById('timetable');

timetable.addEventListener('mousedown', (e) => {
    if (e.target.tagName === 'TD' && e.target.dataset.day && 
        !e.target.classList.contains('disabled')) {
        e.preventDefault();
        isMouseDown = true;
        selectedDay = e.target.dataset.day;
        clearSelection();
        e.target.classList.add('selected');
        selectedCells.push(e.target);
    }
});

timetable.addEventListener('mouseenter', (e) => {
    if (isMouseDown && e.target.tagName === 'TD' && 
        !e.target.classList.contains('disabled') && 
        e.target.dataset.day === selectedDay) {
        e.target.classList.add('selected');
        selectedCells.push(e.target);
    }
}, true);

timetable.addEventListener('mouseup', () => {
    isMouseDown = false;
    if (selectedCells.length > 0) {
        const day = selectedCells[0].dataset.day;
        const slotStrings = selectedCells.map(c => c.dataset.slot);
        slotStrings.sort((a, b) => {
            const [startA] = a.split('-');
            const [startB] = b.split('-');
            return parseTimeStrToDate(startA) - parseTimeStrToDate(startB);
        });
        const earliestSlot = slotStrings[0];
        const latestSlot = slotStrings[slotStrings.length - 1];
        const [earliestStart] = earliestSlot.split('-');
        const [, latestEnd]   = latestSlot.split('-');
        $('#day').val(day);
        $('#start_time').val(earliestStart);
        $('#end_time').val(latestEnd);
    }
});

function fetchAndDisableOccupied() {
    const sy  = $('#school_year_id').val();
    const sem = $('#semester_id').val();
    const dep = $('#department_id').val();
    const pro = $('#program_id').val();
    const fac = $('#faculty_id').val();
    const sec = $('#section_id').val();
    const rom = $('#room_id').val();
    const sub = $('#subject_id').val();

    // Clear all disabled or selected classes first
    document.querySelectorAll('#timetable td[data-day]').forEach(td => {
        td.classList.remove('disabled', 'selected');
    });

    // Not enough info to query
    if (!(sy && sem && dep && pro && fac)) return;

    const queryParams = new URLSearchParams({
        school_year_id: sy,
        semester_id: sem,
        department_id: dep,
        program_id: pro,
        faculty_id: fac
    });
    if (sec) queryParams.set('section_id', sec);
    if (rom) queryParams.set('room_id', rom);
    if (sub) queryParams.set('subject_id', sub);

    fetch('/schedule/availability?' + queryParams.toString())
        .then(resp => resp.json())
        .then(data => {
            data.forEach(block => {
                const selector = `#timetable td[data-day='${block.day}'][data-slot='${block.slot}']`;
                const cell = document.querySelector(selector);
                if (cell) {
                    cell.classList.add('disabled');
                }
            });
        })
        .catch(err => console.error(err));
}
</script>
</body>
</html>
