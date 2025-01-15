<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>General Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        .side-explorer {
            max-width: 250px;
        }
        .time-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .time-table th, .time-table td {
            border: 1px solid #ccc;
            text-align: center;
            padding: 0.3rem;
            font-size: 0.85rem;
        }
        .time-column {
            width: 130px;
            white-space: nowrap;
        }
        .merged-cell {
            background-color: #f5c6cb;
            vertical-align: middle;
            font-weight: bold;
        }
        .accordion-button:focus {
            box-shadow: none !important;
        }
    </style>
</head>
<body>
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-12 col-md-3 col-lg-2 side-explorer">
            <h4>Explorer</h4>
            <hr>

            <!-- Fixed School Year and Semester -->
            <p><strong>SY 2024-2025</strong><br>2nd Semester</p>

            <div class="accordion" id="scheduleAccordion">

                <!-- Faculty -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFaculty">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaculty" aria-expanded="false" aria-controls="collapseFaculty">
                            Faculty
                        </button>
                    </h2>
                    <div id="collapseFaculty" class="accordion-collapse collapse" aria-labelledby="headingFaculty" data-bs-parent="#scheduleAccordion">
                        <div class="accordion-body p-0">
                            <ul class="list-group">
                                <?php foreach ($faculties as $f): ?>
                                    <li class="list-group-item">
                                        <a href="/schedule/general?view_type=faculty&faculty_id=<?= $f['id'] ?>">
                                            <?= htmlspecialchars($f['lastname'] . ', ' . $f['firstname']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Section -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSection">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSection" aria-expanded="false" aria-controls="collapseSection">
                            Section
                        </button>
                    </h2>
                    <div id="collapseSection" class="accordion-collapse collapse" aria-labelledby="headingSection" data-bs-parent="#scheduleAccordion">
                        <div class="accordion-body p-0">
                            <ul class="list-group">
                                <?php foreach ($sections as $sec): ?>
                                    <li class="list-group-item">
                                        <a href="/schedule/general?view_type=section&section_id=<?= $sec['id'] ?>">
                                            <?= htmlspecialchars($sec['section']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Room -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingRoom">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRoom" aria-expanded="false" aria-controls="collapseRoom">
                            Room
                        </button>
                    </h2>
                    <div id="collapseRoom" class="accordion-collapse collapse" aria-labelledby="headingRoom" data-bs-parent="#scheduleAccordion">
                        <div class="accordion-body p-0">
                            <ul class="list-group">
                                <?php foreach ($rooms as $r): ?>
                                    <li class="list-group-item">
                                        <a href="/schedule/general?view_type=room&room_id=<?= $r['id'] ?>">
                                            <?= htmlspecialchars($r['name']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Main Content -->
        <div class="col-12 col-md-9 col-lg-10">
                <!-- NEW LINK TO VIEW SCHEDULE LIST -->
    <div class="mb-3">
        <a href="/" class="btn btn-secondary">Back to Schedule List</a>
    </div>
    <!-- END NEW LINK -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h3">General Schedule</h1>
                
                <?php if (!empty($viewType)): ?>
                    
                    <!-- Updated: link to a separate print page -->
                    <a 
                        href="/schedule/general/print?view_type=<?= urlencode($viewType) ?>
                           <?php if($facultyId): ?>&faculty_id=<?= urlencode($facultyId) ?><?php endif; ?>
                           <?php if($sectionId): ?>&section_id=<?= urlencode($sectionId) ?><?php endif; ?>
                           <?php if($roomId): ?>&room_id=<?= urlencode($roomId) ?><?php endif; ?>"
                        class="btn btn-secondary"
                        >
                        Print Schedule
                    </a>
                <?php endif; ?>
            </div>

            <?php
            function generateTimeSlots($start, $end, $interval=30) {
                $slots = [];
                $cur = strtotime($start);
                $endTS = strtotime($end);
                while ($cur < $endTS) {
                    $s = date("g:ia", $cur);
                    $cur += $interval * 60;
                    $e = date("g:ia", $cur);
                    $slots[] = "$s-$e";
                }
                return $slots;
            }
            $allTimeSlots = generateTimeSlots("07:30", "17:00");
            $daysOfWeek = ["Mon","Tue","Wed","Thu","Fri"];
            ?>

            <div class="table-responsive">
                <table class="table table-striped time-table">
                    <thead>
                    <tr>
                        <th class="time-column">Time</th>
                        <?php foreach ($daysOfWeek as $d): ?>
                            <th><?= $d ?></th>
                        <?php endforeach; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($allTimeSlots as $slot): ?>
                        <tr>
                            <td class="time-column"><?= htmlspecialchars($slot) ?></td>
                            <?php foreach ($daysOfWeek as $day): ?>
                                <td data-day="<?= $day ?>" data-slot="<?= $slot ?>"></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function() {
    const scheduleData = <?= json_encode($scheduleData) ?>;

    function parseTime(t) {
        return new Date("2020-01-01 " + t);
    }

    function generateBlocks(startTimeStr, endTimeStr) {
        let slots = [];
        let cur = parseTime(startTimeStr);
        let end = parseTime(endTimeStr);
        while (cur < end) {
            let slotStart = formatAMPM(cur);
            cur.setMinutes(cur.getMinutes() + 30);
            let slotEnd = formatAMPM(cur);
            slots.push(`${slotStart}-${slotEnd}`);
        }
        return slots;
    }

    function formatAMPM(date) {
        let hours = date.getHours();
        let minutes = date.getMinutes();
        let ampm = (hours >= 12) ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12;
        minutes = (minutes < 10) ? '0' + minutes : minutes;
        return hours + ':' + minutes + ampm;
    }

    function plotSchedule() {
        scheduleData.forEach(sched => {
            let day = sched.day;
            let stime = sched.start_time;
            let etime = sched.end_time;
            let code = sched.subject_code || '';
            let desc = sched.subject_desc || '';
            let room = sched.room_name || '';
            let sec = sched.section_name || '';
            let fac = (sched.faculty_lname || '') + ', ' + (sched.faculty_fname || '');

            let blocks = generateBlocks(stime, etime);
            if (!blocks.length) return;

            let firstBlock = blocks[0];
            let firstTdSel = `td[data-day='${day}'][data-slot='${firstBlock}']`;
            let firstTd = document.querySelector(firstTdSel);
            if (!firstTd) return;

            let rowSpanCount = blocks.length;
            firstTd.classList.add('merged-cell');
            firstTd.rowSpan = rowSpanCount;
            firstTd.innerHTML = `
                <div><strong>${code}</strong> - ${desc}</div>
                <div>Section: ${sec}</div>
                <div>Room: ${room}</div>
                <div>Faculty: ${fac}</div>
            `;

            for (let i = 1; i < blocks.length; i++) {
                const nextSel = `td[data-day='${day}'][data-slot='${blocks[i]}']`;
                const nextTd = document.querySelector(nextSel);
                if (nextTd) nextTd.remove();
            }
        });
    }

    plotSchedule();
})();
</script>
</body>
</html>
