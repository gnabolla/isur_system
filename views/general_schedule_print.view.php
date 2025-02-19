<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Print General Schedule</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1in;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }
        h2 {
            margin-top: 1em;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1em;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .time-column {
            width: 130px;
        }
        .day-column {
            width: calc((100% - 130px) / 5);
        }
        .merged-cell {
            font-weight: bold;
            vertical-align: middle;
            background-color: #f5c6cb;
        }
        .info-section {
            margin-left: 1in;
            margin-right: 1in;
        }
    </style>
</head>
<body>
<h2>General Schedule</h2>

<div class="info-section">
<p><strong>School Year:</strong> 2024-2025</p>
<p><strong>Semester:</strong> 2nd Semester</p>

<?php if (!empty($viewType)): ?>
<p><strong>View Type:</strong> <?= htmlspecialchars($viewType) ?></p>
<?php if ($facultyId): ?>
<p><strong>Faculty ID:</strong> <?= htmlspecialchars($facultyId) ?></p>
<?php endif; ?>
<?php if ($sectionId): ?>
<p><strong>Section ID:</strong> <?= htmlspecialchars($sectionId) ?></p>
<?php endif; ?>
<?php if ($roomId): ?>
<p><strong>Room ID:</strong> <?= htmlspecialchars($roomId) ?></p>
<?php endif; ?>
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

<table>
    <thead>
    <tr>
        <th class="time-column">Time</th>
        <?php foreach ($daysOfWeek as $day): ?>
            <th class="day-column"><?= $day ?></th>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($allTimeSlots as $slot): ?>
        <tr>
            <td><?= htmlspecialchars($slot) ?></td>
            <?php foreach ($daysOfWeek as $day): ?>
                <td class="day-column" data-day="<?= $day ?>" data-slot="<?= $slot ?>"></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<script>
(function() {
    const scheduleData = <?= json_encode($scheduleData) ?>;

    function parseTime(t) {
        return new Date("2020-01-01 " + t);
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

    scheduleData.forEach(sched => {
        const day = sched.day;
        const stime = sched.start_time;
        const etime = sched.end_time;
        const code = sched.subject_code || '';
        const desc = sched.subject_desc || '';
        const room = sched.room_name || '';
        const sec = sched.section_name || '';
        const facL = sched.faculty_lname || '';
        const facF = sched.faculty_fname || '';
        const faculty = facL && facF ? (facL + ', ' + facF) : '';

        let blocks = generateBlocks(stime, etime);
        if (!blocks.length) return;

        let firstBlock = blocks[0];
        let firstTd = document.querySelector(`td[data-day='${day}'][data-slot='${firstBlock}']`);
        if (!firstTd) return;

        firstTd.classList.add('merged-cell');
        firstTd.rowSpan = blocks.length;
        firstTd.innerHTML = `
            <div><strong>${code}</strong> - ${desc}</div>
            <div>Section: ${sec}</div>
            <div>Room: ${room}</div>
            ${faculty ? `<div>Faculty: ${faculty}</div>` : ''}
        `;

        for (let i = 1; i < blocks.length; i++) {
            let nextTd = document.querySelector(`td[data-day='${day}'][data-slot='${blocks[i]}']`);
            if (nextTd) nextTd.remove();
        }
    });

    window.print();
})();
</script>
</body>
</html>
