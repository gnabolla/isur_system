<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Schedules</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <!-- Select2 CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
    rel="stylesheet"
  />
</head>
<body class="bg-light">

<div class="container mt-4">
  <h1 class="mb-4">Schedules</h1>

  <?php if (isset($_GET['schedule_created'])): ?>
    <div class="alert alert-success">
      Schedule created successfully!
    </div>
  <?php endif; ?>

  <?php if (isset($_GET['schedule_updated'])): ?>
    <div class="alert alert-success">
      Schedule updated successfully!
    </div>
  <?php endif; ?>

  <?php if (isset($_GET['schedule_deleted'])): ?>
    <div class="alert alert-success">
      Schedule deleted successfully!
    </div>
  <?php endif; ?>

  <!-- (Optional) Filter form could go here -->
  <form method="GET" class="row gy-2 gx-3 align-items-end" action="/">
    <!-- Filter fields, if any -->
  </form>

  <div class="mt-4">
    <a href="/schedule/create" class="btn btn-sm btn-success">Create New Schedule</a>
    <!-- [NEW LINK] -->
    <a href="/faculty/schedule" class="btn btn-sm btn-info">View Faculty Schedule</a>
  </div>
  <hr>

  <div class="table-responsive">
    <table class="table table-striped" id="scheduleTable">
      <thead class="table-light">
        <tr>
          <th>Day</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Room</th>
          <th>Section</th>
          <th>Subject</th>
          <th>Faculty</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($schedules)): ?>
          <?php foreach ($schedules as $sched): ?>
            <tr>
              <td><?= htmlspecialchars($sched['day']) ?></td>
              <td><?= htmlspecialchars($sched['start_time']) ?></td>
              <td><?= htmlspecialchars($sched['end_time']) ?></td>
              <td><?= htmlspecialchars($sched['room_name']) ?></td>
              <td><?= htmlspecialchars($sched['section_name'] ?? '') ?></td>
              <td>
                <?php
                  if (!empty($sched['subject_code'])) {
                    echo htmlspecialchars($sched['subject_code']) . ' - ' . htmlspecialchars($sched['subject_desc']);
                  } else {
                    echo "-";
                  }
                ?>
              </td>
              <td>
                <?= htmlspecialchars($sched['faculty_lname'] . ', ' . $sched['faculty_fname']) ?>
              </td>
              <td>
                <a
                  href="/schedule/edit?id=<?= htmlspecialchars($sched['id']) ?>"
                  class="btn btn-sm btn-warning"
                >
                  Edit
                </a>
                <a
                  href="/schedule/delete?id=<?= htmlspecialchars($sched['id']) ?>"
                  class="btn btn-sm btn-danger"
                  onclick="return confirm('Are you sure you want to delete this schedule?');"
                >
                  Delete
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="8" class="text-center">No schedules found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>

<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
</script>
<!-- jQuery -->
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js">
</script>
<!-- Select2 JS -->
<script
  src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js">
</script>
<script>
$(document).ready(function() {
  $('.select2').select2({
    placeholder: 'Search or select'
  });
});
</script>
</body>
</html>
