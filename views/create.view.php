<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Schedule (Merged Display)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
  <style>
    .time-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
    .time-table th, .time-table td { border: 1px solid #ccc; text-align: center; padding: 0.3rem; font-size: 0.85rem; }
    .time-column { width: 100px; }
    .disabled { background-color: #f5c6cb !important; }
    .merged-cell {
      background-color: #f5c6cb !important;
      vertical-align: middle;
      font-weight: bold;
    }
    .selected { background-color: #c3e6cb !important; }
    .disabled-table { pointer-events: none; opacity: 0.5; }
  </style>
</head>
<body>
<div class="container my-5">
  <h1>Create a New Schedule (Merged Display)</h1>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="row g-3">
      <div class="col-md-6">
        <label for="school_year_id" class="form-label">School Year</label>
        <select class="form-select select2" name="school_year_id" id="school_year_id" required>
          <option value="">--Select--</option>
          <?php foreach ($schoolYears as $sy): ?>
            <option value="<?= $sy['id'] ?>" <?= (isset($_POST['school_year_id']) && $_POST['school_year_id'] == $sy['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($sy['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <label for="semester_id" class="form-label">Semester</label>
        <select class="form-select select2" name="semester_id" id="semester_id" required>
          <option value="">--Select--</option>
          <?php foreach ($semesters as $sem): ?>
            <option value="<?= $sem['id'] ?>" <?= (isset($_POST['semester_id']) && $_POST['semester_id'] == $sem['id']) ? 'selected' : '' ?>>
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
          <option value="">--Select--</option>
          <?php foreach ($departments as $dept): ?>
            <option value="<?= $dept['id'] ?>" <?= (isset($_POST['department_id']) && $_POST['department_id'] == $dept['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($dept['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <label for="program_id" class="form-label">Program</label>
        <select class="form-select select2" name="program_id" id="program_id" required>
          <option value="">--Select--</option>
          <?php foreach ($programs as $prog): ?>
            <option value="<?= $prog['id'] ?>" <?= (isset($_POST['program_id']) && $_POST['program_id'] == $prog['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($prog['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="row g-3 mt-1">
      <div class="col-md-6">
        <label for="faculty_id" class="form-label">Faculty</label>
        <select class="form-select select2" name="faculty_id" id="faculty_id" required>
          <option value="">--Select--</option>
          <?php foreach ($faculties as $faculty): ?>
            <option value="<?= $faculty['id'] ?>" <?= (isset($_POST['faculty_id']) && $_POST['faculty_id'] == $faculty['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($faculty['lastname'] . ', ' . $faculty['firstname']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <label for="section_id" class="form-label">Section</label>
        <select class="form-select select2" name="section_id" id="section_id">
          <option value="">--Select--</option>
          <?php foreach ($sections as $section): ?>
            <option value="<?= $section['id'] ?>" <?= (isset($_POST['section_id']) && $_POST['section_id'] == $section['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($section['section']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="row g-3 mt-1">
      <div class="col-md-6">
        <label for="room_id" class="form-label">Room</label>
        <select class="form-select select2" name="room_id" id="room_id">
          <option value="">--Select--</option>
          <?php foreach ($rooms as $room): ?>
            <option value="<?= $room['id'] ?>" <?= (isset($_POST['room_id']) && $_POST['room_id'] == $room['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($room['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <label for="subject_id" class="form-label">Subject</label>
        <select class="form-select select2" name="subject_id" id="subject_id" required>
          <option value="">--Select--</option>
          <?php foreach ($subjects as $subject): ?>
            <option value="<?= $subject['id'] ?>" <?= (isset($_POST['subject_id']) && $_POST['subject_id'] == $subject['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($subject['code'] . ' - ' . $subject['description']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="mt-3">
      <button type="button" class="btn btn-info" id="fetchAvailability">Check Availability</button>
    </div>

    <hr class="my-4">

    <div class="row g-3">
      <div class="col-md-4">
        <label for="day" class="form-label">Day</label>
        <input type="text" class="form-control" name="day" id="day"
               value="<?= isset($_POST['day']) ? htmlspecialchars($_POST['day']) : '' ?>" readonly required>
      </div>
      <div class="col-md-4">
        <label for="start_time" class="form-label">Start Time</label>
        <input type="text" class="form-control" name="start_time" id="start_time"
               value="<?= isset($_POST['start_time']) ? htmlspecialchars($_POST['start_time']) : '' ?>" readonly required>
      </div>
      <div class="col-md-4">
        <label for="end_time" class="form-label">End Time</label>
        <input type="text" class="form-control" name="end_time" id="end_time"
               value="<?= isset($_POST['end_time']) ? htmlspecialchars($_POST['end_time']) : '' ?>" readonly required>
      </div>
    </div>

    <div class="mt-3">
      <button type="submit" class="btn btn-primary">Create Schedule</button>
    </div>
  </form>

  <div class="mt-5">
    <div class="table-responsive">
      <table class="table table-striped table-hover time-table disabled-table" id="timetable">
        <thead>
        <tr>
          <th class="time-column">Time</th>
          <th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th>
        </tr>
        </thead>
        <tbody>
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
        foreach (generateTimeSlots("07:30", "17:00", 30) as $slot):
        ?>
          <tr>
            <td class="time-column"><?= htmlspecialchars($slot) ?></td>
            <td data-day="Mon" data-slot="<?= $slot ?>"></td>
            <td data-day="Tue" data-slot="<?= $slot ?>"></td>
            <td data-day="Wed" data-slot="<?= $slot ?>"></td>
            <td data-day="Thu" data-slot="<?= $slot ?>"></td>
            <td data-day="Fri" data-slot="<?= $slot ?>"></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
  $('.select2').select2();
});

let isMouseDown = false;
let selectedDay = null;
let selectedCells = [];

function parseTimeStr(t) { return new Date("01/01/2020 " + t); }
function clearSelection() {
  selectedCells.forEach(c => c.classList.remove('selected'));
  selectedCells = [];
}
function enableTimetable(enable=true) {
  if (enable) $('#timetable').removeClass('disabled-table');
  else $('#timetable').addClass('disabled-table');
}

document.getElementById('timetable').addEventListener('mousedown', e => {
  if (e.target.tagName === 'TD' && e.target.dataset.day && !e.target.classList.contains('disabled')) {
    e.preventDefault();
    isMouseDown = true;
    selectedDay = e.target.dataset.day;
    clearSelection();
    e.target.classList.add('selected');
    selectedCells.push(e.target);
  }
});

document.getElementById('timetable').addEventListener('mouseenter', e => {
  if (isMouseDown && e.target.tagName === 'TD' && !e.target.classList.contains('disabled')) {
    if (e.target.dataset.day === selectedDay) {
      e.target.classList.add('selected');
      selectedCells.push(e.target);
    }
  }
}, true);

document.addEventListener('mouseup', () => {
  isMouseDown = false;
  if (selectedCells.length > 0) {
    let day = selectedCells[0].dataset.day;
    let slotStrs = selectedCells.map(c => c.dataset.slot);
    slotStrs.sort((a,b) => {
      let aStart = a.split('-')[0];
      let bStart = b.split('-')[0];
      return parseTimeStr(aStart) - parseTimeStr(bStart);
    });
    let earliest = slotStrs[0].split('-');
    let latest   = slotStrs[slotStrs.length - 1].split('-');
    $('#day').val(day);
    $('#start_time').val(earliest[0]);
    $('#end_time').val(latest[1]);
  }
});

document.getElementById('fetchAvailability').addEventListener('click', () => {
  let sy   = $('#school_year_id').val();
  let sem  = $('#semester_id').val();
  let dep  = $('#department_id').val();
  let prog = $('#program_id').val();
  let fac  = $('#faculty_id').val();
  let sec  = $('#section_id').val();
  let rm   = $('#room_id').val();
  let sub  = $('#subject_id').val();
  if (!sy || !sem || !dep || !prog || !fac || !sub) {
    alert('Please fill all required fields first.');
    return;
  }

  $('#timetable td[data-day]')
    .removeClass('disabled selected merged-cell')
    .removeAttr('rowspan')
    .html('');
  clearSelection();
  enableTimetable(false);

  let q = new URLSearchParams({
    school_year_id: sy,
    semester_id: sem,
    department_id: dep,
    program_id: prog,
    faculty_id: fac
  });
  if (sec) q.set('section_id', sec);
  if (rm)  q.set('room_id', rm);
  if (sub) q.set('subject_id', sub);

  fetch('/schedule/availability?' + q)
    .then(r => r.json())
    .then(data => {
      data.forEach(sched => {
        let day         = sched.day;
        let stime       = sched.start_time;
        let etime       = sched.end_time;
        let facultyName = sched.faculty_lname + ', ' + sched.faculty_fname;
        let subj        = sched.subject_code || '';
        let room        = sched.room_name    || '';
        let sectionName = sched.section_name || '';

        let blocks = generateBlocks(stime, etime);
        if (blocks.length === 0) return;

        let firstBlock = blocks[0];
        let firstTdSel = `#timetable td[data-day='${day}'][data-slot='${firstBlock}']`;
        let firstTd    = document.querySelector(firstTdSel);
        if (!firstTd) return;

        let rowSpanCount = blocks.length;
        firstTd.classList.add('merged-cell');
        firstTd.rowSpan = rowSpanCount;
        firstTd.innerHTML = `
          <div><strong>Subject:</strong> ${subj}</div>
          <div><strong>Faculty:</strong> ${facultyName}</div>
          <div><strong>Section:</strong> ${sectionName}</div>
          <div><strong>Room:</strong> ${room}</div>
        `;

        for (let i = 1; i < blocks.length; i++) {
          let nextTd = document.querySelector(`#timetable td[data-day='${day}'][data-slot='${blocks[i]}']`);
          if (nextTd) nextTd.remove();
        }
      });
      enableTimetable(true);
    })
    .catch(err => console.error(err));
});

function generateBlocks(startTimeStr, endTimeStr) {
  let slots = [];
  let cur   = new Date("01/01/2020 " + startTimeStr);
  let end   = new Date("01/01/2020 " + endTimeStr);
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
  let ampm    = hours >= 12 ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12;
  minutes = minutes < 10 ? '0'+minutes : minutes;
  return hours + ':' + minutes + ampm;
}
</script>
</body>
</html>
