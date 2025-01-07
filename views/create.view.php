<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Create Schedule</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link
        href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
        rel="stylesheet"
    />
    <style>
        .time-table td {
            width: 175px;
            height: 35px;
            text-align: center;
            border: 1px solid #ccc;
            cursor: pointer;
            user-select: none;
        }
        .time-table td:hover {
            background: #f2f2f2;
        }
        .time-table td.selected {
            background: #a3c4f3 !important;
        }
        .time-table td.disabled {
            background: #eee !important;
            color: #999;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <h1>Create a New Schedule</h1>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['schedule_created'])): ?>
        <div class="alert alert-success">
            Schedule created successfully!
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-4">
            <form method="POST" action="">
                <div class="mb-3">
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
                <div class="mb-3">
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
                <div class="mb-3">
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
                <div class="mb-3">
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
                <div class="mb-3">
                    <label for="faculty_id" class="form-label">Faculty</label>
                    <select class="form-select select2" name="faculty_id" id="faculty_id" required>
                        <option value="">--Select Faculty--</option>
                        <?php foreach ($faculties as $faculty): ?>
                            <option value="<?= htmlspecialchars($faculty['id']) ?>">
                                <?= htmlspecialchars($faculty['lastname'] . ', ' . $faculty['firstname']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="section_id" class="form-label">Section</label>
                    <select class="form-select select2" name="section_id" id="section_id">
                        <option value="">--Select Section--</option>
                        <?php foreach ($sections as $section): ?>
                            <option value="<?= htmlspecialchars($section['id']) ?>">
                                <?= htmlspecialchars($section['section']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="room_id" class="form-label">Room</label>
                    <select class="form-select select2" name="room_id" id="room_id">
                        <option value="">--Select Room--</option>
                        <?php foreach ($rooms as $room): ?>
                            <option value="<?= htmlspecialchars($room['id']) ?>">
                                <?= htmlspecialchars($room['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="subject_id" class="form-label">Subject</label>
                    <select class="form-select select2" name="subject_id" id="subject_id" required>
                        <option value="">--Select Subject--</option>
                        <?php foreach ($subjects as $subject): ?>
                            <option value="<?= htmlspecialchars($subject['id']) ?>">
                                <?= htmlspecialchars($subject['code'] . ' - ' . $subject['description']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="day" class="form-label">Day</label>
                    <input
                        type="text"
                        class="form-control"
                        name="day"
                        id="day"
                        placeholder="Mon"
                        readonly
                        required
                    >
                </div>
                <div class="mb-3">
                    <label for="start_time" class="form-label">Start Time</label>
                    <input
                        type="text"
                        class="form-control"
                        name="start_time"
                        id="start_time"
                        placeholder="7:30am"
                        readonly
                        required
                    >
                </div>
                <div class="mb-3">
                    <label for="end_time" class="form-label">End Time</label>
                    <input
                        type="text"
                        class="form-control"
                        name="end_time"
                        id="end_time"
                        placeholder="8:00am"
                        readonly
                        required
                    >
                </div>
                <button type="submit" class="btn btn-primary">Create Schedule</button>
            </form>

            <button type="button" class="btn btn-secondary mt-3" id="checkAvailability">
                Check Availability
            </button>
        </div>

        <div class="col-md-8 mt-4 mt-md-0">
            <div class="table-responsive">
                <table class="table time-table" id="timetable">
                    <thead>
                        <tr>
                            <th>Time</th>
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
                            $slots   = [];
                            $current = strtotime($start);
                            $endTime = strtotime($end);

                            while ($current < $endTime) {
                                $slotStart = date("g:ia", $current);
                                $current  += $interval * 60;
                                $slotEnd   = date("g:ia", $current);
                                $slots[]   = "$slotStart-$slotEnd";
                            }
                            return $slots;
                        }

                        $timeSlots = generateTimeSlots("07:30", "17:00", 30);
                        foreach ($timeSlots as $slot):
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($slot) ?></td>
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
    });

    let isMouseDown   = false;
    let selectedDay   = null;
    let selectedCells = [];

    function parseTimeStrToDate(timeStr) {
        return new Date("01/01/2020 " + timeStr);
    }

    function clearSelection() {
        selectedCells.forEach(cell => cell.classList.remove('selected'));
        selectedCells = [];
    }

    const timetable = document.getElementById('timetable');
    timetable.addEventListener('mousedown', (e) => {
        if (e.target.tagName === 'TD' && e.target.dataset.day && !e.target.classList.contains('disabled')) {
            e.preventDefault();
            isMouseDown = true;
            selectedDay = e.target.dataset.day;
            clearSelection();
            e.target.classList.add('selected');
            selectedCells.push(e.target);
        }
    });

    timetable.addEventListener('mouseenter', (e) => {
        if (isMouseDown && e.target.tagName === 'TD') {
            if (e.target.dataset.day === selectedDay && !e.target.classList.contains('disabled')) {
                e.target.classList.add('selected');
                selectedCells.push(e.target);
            }
        }
    }, true);

    timetable.addEventListener('mouseup', () => {
        isMouseDown = false;
        if (selectedCells.length > 0) {
            const day         = selectedCells[0].dataset.day;
            const slotStrings = selectedCells.map(c => c.dataset.slot);

            slotStrings.sort((a, b) => {
                const [startA] = a.split('-');
                const [startB] = b.split('-');
                return parseTimeStrToDate(startA) - parseTimeStrToDate(startB);
            });

            const earliestSlot    = slotStrings[0];
            const latestSlot      = slotStrings[slotStrings.length - 1];
            const [earliestStart] = earliestSlot.split('-');
            const [, latestEnd]   = latestSlot.split('-');

            document.getElementById('day').value        = day;
            document.getElementById('start_time').value = earliestStart;
            document.getElementById('end_time').value   = latestEnd;
        }
    });

    function fetchAndDisableOccupied() {
        // Always clear old states
        document.querySelectorAll('#timetable td[data-day]').forEach(td => {
            td.classList.remove('disabled', 'selected');
        });

        const faculty_id     = document.getElementById('faculty_id').value;
        const section_id     = document.getElementById('section_id').value;
        const room_id        = document.getElementById('room_id').value;
        const school_year_id = document.getElementById('school_year_id').value;
        const semester_id    = document.getElementById('semester_id').value;

        // We STILL require these two as per your requirement
        if (!school_year_id || !semester_id) {
            return;
        }

        // We do NOT skip the fetch if faculty, section, or room is empty:
        // (Removed the old "if (!faculty_id && !section_id && !room_id) return;")

        const queryParams = new URLSearchParams({
            faculty_id,
            section_id,
            room_id,
            school_year_id,
            semester_id
        });

        fetch(`/schedule/availability?${queryParams}`)
            .then(resp => resp.json())
            .then(data => {
                data.forEach(block => {
                    const selector = `#timetable td[data-day='${block.day}'][data-slot='${block.slot}']`;
                    const cell     = document.querySelector(selector);
                    if (cell) {
                        cell.classList.add('disabled');
                    }
                });
            })
            .catch(err => console.error(err));
    }

    // "Check Availability" button
    document.getElementById('checkAvailability').addEventListener('click', () => {
        fetchAndDisableOccupied();
    });

    // Whenever user changes faculty, section, room, etc. we re-check
    $('#faculty_id, #section_id, #room_id, #school_year_id, #semester_id').on('change', function() {
        fetchAndDisableOccupied();
    });
</script>
</body>
</html>
