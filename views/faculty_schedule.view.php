<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Faculty Schedule</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
  <style>
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
      width: 130px;        /* Increased width */
      white-space: nowrap; /* Prevent text wrapping */
    }
    .merged-cell {
      background-color: #f5c6cb;
      vertical-align: middle;
      font-weight: bold;
    }
  </style>
</head>
<body>
<div class="container mt-4">
  <h1>Faculty Schedule</h1>

  <!-- NEW LINK TO VIEW SCHEDULE LIST -->
  <div class="mb-3">
    <a href="/" class="btn btn-secondary">Back to Schedule List</a>
  </div>
  <!-- END NEW LINK -->

  <form method="GET" action="/faculty/schedule" class="row row-cols-lg-auto g-3 align-items-end mb-4">
    <div class="col-12">
      <label class="form-label">Faculty</label>
      <select name="faculty_id" class="form-select select2" required>
        <option value="">--Select--</option>
        <?php foreach ($faculties as $f): ?>
          <option value="<?= $f['id'] ?>" 
            <?= ($facultyId == $f['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($f['lastname'] . ', ' . $f['firstname']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-12">
      <label class="form-label">School Year</label>
      <select name="school_year_id" class="form-select select2" required>
        <option value="">--Select--</option>
        <?php foreach ($schoolYears as $sy): ?>
          <option value="<?= $sy['id'] ?>"
            <?= ($schoolYearId == $sy['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($sy['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-12">
      <label class="form-label">Semester</label>
      <select name="semester_id" class="form-select select2" required>
        <option value="">--Select--</option>
        <?php foreach ($semesters as $s): ?>
          <option value="<?= $s['id'] ?>"
            <?= ($semesterId == $s['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($s['label']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-12">
      <button type="submit" class="btn btn-primary">View Schedule</button>
    </div>
  </form>

  <!-- Show "Print Schedule" only if user has selected the faculty, school year, and semester -->
  <?php if ($facultyId && $schoolYearId && $semesterId): ?>
    <a 
      href="/faculty/schedule/print?faculty_id=<?= urlencode($facultyId) ?>&school_year_id=<?= urlencode($schoolYearId) ?>&semester_id=<?= urlencode($semesterId) ?>"
      class="btn btn-secondary mb-3"
      target="_blank"
    >
      Print Schedule
    </a>
  <?php endif; ?>

  <?php
  function generateTimeSlots($start, $end, $interval=30) {
    $slots = [];
    $cur   = strtotime($start);
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
  $daysOfWeek   = ["Mon","Tue","Wed","Thu","Fri"];
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
  $('.select2').select2();
  plotSchedule();
});

function parseTime(t) {
  return new Date("2020-01-01 " + t);
}

function generateBlocks(startTimeStr, endTimeStr) {
  let slots = [];
  let cur   = parseTime(startTimeStr);
  let end   = parseTime(endTimeStr);
  while (cur < end) {
    let slotStart = formatAMPM(cur);
    cur.setMinutes(cur.getMinutes() + 30);
    let slotEnd = formatAMPM(cur);
    slots.push(`${slotStart}-${slotEnd}`);
  }
  return slots;
}

function formatAMPM(date) {
  let hours   = date.getHours();
  let minutes = date.getMinutes();
  let ampm    = (hours >= 12) ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12;
  minutes = (minutes < 10) ? '0'+minutes : minutes;
  return hours + ':' + minutes + ampm;
}

function plotSchedule() {
  const data = <?= json_encode($scheduleData) ?>;

  data.forEach(sched => {
    let day    = sched.day;
    let stime  = sched.start_time;
    let etime  = sched.end_time;
    let code   = sched.subject_code || '';
    let desc   = sched.subject_desc || '';
    let room   = sched.room_name    || '';
    let sec    = sched.section_name || '';

    let blocks = generateBlocks(stime, etime);
    if (!blocks.length) return;

    let firstBlock = blocks[0];
    let firstTdSel = `td[data-day='${day}'][data-slot='${firstBlock}']`;
    let firstTd    = document.querySelector(firstTdSel);
    if (!firstTd) return;

    let rowSpanCount = blocks.length;
    firstTd.classList.add('merged-cell');
    firstTd.rowSpan = rowSpanCount;
    firstTd.innerHTML = `
      <div><strong>${code}</strong> - ${desc}</div>
      <div>Section: ${sec}</div>
      <div>Room: ${room}</div>
    `;

    for (let i = 1; i < blocks.length; i++) {
      const nextSel = `td[data-day='${day}'][data-slot='${blocks[i]}']`;
      const nextTd  = document.querySelector(nextSel);
      if (nextTd) nextTd.remove();
    }
  });
}
</script>
</body>
</html>
