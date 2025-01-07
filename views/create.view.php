<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Schedule</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
  <style>
    .time-table {
      width: 100%; border-collapse: collapse; table-layout: fixed;
    }
    .time-table th, .time-table td {
      border: 1px solid #ccc; text-align: center; vertical-align: middle;
      cursor: pointer; user-select: none; font-size: 0.85rem; padding: 0.3rem;
    }
    .time-table .time-column { width: 120px; }
    .time-table td.disabled { background-color: #f8d7da; cursor: not-allowed; }
    .time-table td.selected { background-color: #cce5ff; font-weight: bold; }
    .disabled-table { pointer-events: none; opacity: 0.6; }
  </style>
</head>
<body>
<div class="container my-5">
  <h1>Create a New Schedule</h1>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <div class="row">
    <div class="col-md-6">
      <div class="card shadow-sm mb-4">
        <div class="card-body">
          <form method="POST" action="">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="school_year_id" class="form-label">School Year</label>
                <select class="form-select select2" name="school_year_id" id="school_year_id" required>
                  <option value="">--Select--</option>
                  <?php foreach ($schoolYears as $sy): ?>
                    <option value="<?= $sy['id'] ?>"><?= htmlspecialchars($sy['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="semester_id" class="form-label">Semester</label>
                <select class="form-select select2" name="semester_id" id="semester_id" required>
                  <option value="">--Select--</option>
                  <?php foreach ($semesters as $sem): ?>
                    <option value="<?= $sem['id'] ?>"><?= htmlspecialchars($sem['label']) ?></option>
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
                    <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="program_id" class="form-label">Program</label>
                <select class="form-select select2" name="program_id" id="program_id" required>
                  <option value="">--Select--</option>
                  <?php foreach ($programs as $prog): ?>
                    <option value="<?= $prog['id'] ?>"><?= htmlspecialchars($prog['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="row g-3 mt-1">
              <div class="col-md-6">
                <label for="faculty_id" class="form-label">Faculty</label>
                <select class="form-select select2" name="faculty_id" id="faculty_id" required disabled>
                  <option value="">--Select--</option>
                  <?php foreach ($faculties as $faculty): ?>
                    <option value="<?= $faculty['id'] ?>">
                      <?= htmlspecialchars($faculty['lastname'] . ', ' . $faculty['firstname']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="section_id" class="form-label">Section</label>
                <select class="form-select select2" name="section_id" id="section_id" disabled>
                  <option value="">--Select--</option>
                  <?php foreach ($sections as $section): ?>
                    <option value="<?= $section['id'] ?>"><?= htmlspecialchars($section['section']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="row g-3 mt-1">
              <div class="col-md-6">
                <label for="room_id" class="form-label">Room</label>
                <select class="form-select select2" name="room_id" id="room_id" disabled>
                  <option value="">--Select--</option>
                  <?php foreach ($rooms as $room): ?>
                    <option value="<?= $room['id'] ?>"><?= htmlspecialchars($room['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="subject_id" class="form-label">Subject</label>
                <select class="form-select select2" name="subject_id" id="subject_id" required disabled>
                  <option value="">--Select--</option>
                  <?php foreach ($subjects as $subject): ?>
                    <option value="<?= $subject['id'] ?>">
                      <?= htmlspecialchars($subject['code'] . ' - ' . $subject['description']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="row g-3 mt-1">
              <div class="col-md-4">
                <label for="day" class="form-label">Day</label>
                <input type="text" class="form-control" name="day" id="day" readonly required>
              </div>
              <div class="col-md-4">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="text" class="form-control" name="start_time" id="start_time" readonly required>
              </div>
              <div class="col-md-4">
                <label for="end_time" class="form-label">End Time</label>
                <input type="text" class="form-control" name="end_time" id="end_time" readonly required>
              </div>
            </div>
            <div class="mt-3">
              <button type="submit" class="btn btn-primary">Create Schedule</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6">
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
              $slots=[]; $cur=strtotime($start); $tEnd=strtotime($end);
              while ($cur<$tEnd) {
                $s=date("g:ia",$cur); $cur+=$interval*60; $e=date("g:ia",$cur);
                $slots[]="$s-$e";
              }
              return $slots;
            }
            foreach (generateTimeSlots("07:30","17:00",30) as $slot):
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
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() { $('.select2').select2(); updateFormState(); });
let isMouseDown=false, selectedDay=null, selectedCells=[];
function parseTimeStrToDate(t) { return new Date("01/01/2020 "+t); }
function clearSelection(){ selectedCells.forEach(c=>c.classList.remove('selected')); selectedCells=[]; }
function updateFormState() {
  let sy=$('#school_year_id').val(), sem=$('#semester_id').val();
  let dep=$('#department_id').val(), pro=$('#program_id').val();
  let fac=$('#faculty_id').val(), sec=$('#section_id').val();
  let rom=$('#room_id').val(), sub=$('#subject_id').val();
  let canFac=sy&&sem&&dep&&pro; $('#faculty_id').prop('disabled',!canFac);
  let canSec=canFac&&fac; $('#section_id').prop('disabled',!canSec);
  let canRom=canSec&&sec; $('#room_id').prop('disabled',!canRom);
  let canSub=canRom&&rom; $('#subject_id').prop('disabled',!canSub);
  let canTable=canSub&&sub;
  canTable?$('#timetable').removeClass('disabled-table'):$('#timetable').addClass('disabled-table');
  if(!canTable) clearSelection(); 
}
$('#school_year_id,#semester_id,#department_id,#program_id,#faculty_id,#section_id,#room_id,#subject_id').on('change',function(){
  updateFormState(); fetchAndDisableOccupied();
});
document.getElementById('timetable').addEventListener('mousedown', e=>{
  if(e.target.tagName==='TD'&&e.target.dataset.day&&!e.target.classList.contains('disabled')){
    e.preventDefault(); isMouseDown=true; selectedDay=e.target.dataset.day;
    clearSelection(); e.target.classList.add('selected'); selectedCells.push(e.target);
  }
});
document.getElementById('timetable').addEventListener('mouseenter', e=>{
  if(isMouseDown&&e.target.tagName==='TD'&&!e.target.classList.contains('disabled')
     &&e.target.dataset.day===selectedDay){
    e.target.classList.add('selected'); selectedCells.push(e.target);
  }
},true);
document.getElementById('timetable').addEventListener('mouseup', ()=>{
  isMouseDown=false;
  if(selectedCells.length){
    let day=selectedCells[0].dataset.day;
    let times=selectedCells.map(c=>c.dataset.slot).sort((a,b)=>{
      return parseTimeStrToDate(a.split('-')[0]) - parseTimeStrToDate(b.split('-')[0]);
    });
    let earliest=times[0].split('-'), latest=times[times.length-1].split('-');
    $('#day').val(day); $('#start_time').val(earliest[0]); $('#end_time').val(latest[1]);
  }
});
function fetchAndDisableOccupied() {
  let sy=$('#school_year_id').val(), sem=$('#semester_id').val(),
      dep=$('#department_id').val(), pro=$('#program_id').val(),
      fac=$('#faculty_id').val(), sec=$('#section_id').val(),
      rom=$('#room_id').val(), sub=$('#subject_id').val();
  $('#timetable td[data-day]').removeClass('disabled selected');
  if(!(sy&&sem&&dep&&pro&&fac)) return;
  let q=new URLSearchParams({school_year_id:sy,semester_id:sem,department_id:dep,program_id:pro,faculty_id:fac});
  if(sec) q.set('section_id',sec); if(rom) q.set('room_id',rom); if(sub) q.set('subject_id',sub);
  fetch('/schedule/availability?'+q).then(r=>r.json()).then(data=>{
    data.forEach(b=>{
      let c=document.querySelector(`#timetable td[data-day='${b.day}'][data-slot='${b.slot}']`);
      if(c) c.classList.add('disabled');
    });
  }).catch(err=>console.error(err));
}
</script>
</body>
</html>
