<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Faculty Schedule Print</title>
  <style>
    @page {
      size: A4 portrait;
      margin: 1in;
    }
    body {
      font-family: Arial, sans-serif;
      font-size: 14px;
      margin: 0;
      padding: 0;
    }
    .header {
      text-align: center;
      margin-bottom: 1em;
    }
    .faculty-info {
      margin-bottom: 1em;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1em;
    }
    th, td {
      border: 1px solid #333;
      padding: 6px;
      text-align: center;
    }
    .time-column {
      width: 100px;
    }
    .merged-cell {
      font-weight: bold;
      vertical-align: middle;
    }
  </style>
</head>
<body>
  <div class="header">
    <h2>Faculty Schedule</h2>
  </div>
  <div class="faculty-info">
    <?php if ($facultyInfo): ?>
      <p><strong>Faculty Name:</strong>
        <?= htmlspecialchars($facultyInfo['lastname'] . ', ' . $facultyInfo['firstname']) ?>
      </p>
    <?php endif; ?>
    <?php if ($schoolYearId): ?>
      <p><strong>School Year:</strong>
        <?php
          $foundSy = array_filter($schoolYears, function($sy) use($schoolYearId) {
            return $sy['id'] == $schoolYearId;
          });
          $foundSy = current($foundSy);
          echo htmlspecialchars($foundSy['name'] ?? '');
        ?>
      </p>
    <?php endif; ?>
    <?php if ($semesterId): ?>
      <p><strong>Semester:</strong>
        <?php
          $foundSem = array_filter($semesters, function($sem) use($semesterId) {
            return $sem['id'] == $semesterId;
          });
          $foundSem = current($foundSem);
          echo htmlspecialchars($foundSem['label'] ?? '');
        ?>
      </p>
    <?php endif; ?>
  </div>
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
    $allTimeSlots = generateTimeSlots("07:30", "17:00", 30);
    $daysOfWeek = ["Mon","Tue","Wed","Thu","Fri"];
  ?>
  <table>
    <thead>
      <tr>
        <th class="time-column">Time</th>
        <?php foreach ($daysOfWeek as $day): ?>
          <th><?= $day ?></th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($allTimeSlots as $slot): ?>
        <tr>
          <td><?= htmlspecialchars($slot) ?></td>
          <?php foreach ($daysOfWeek as $day): ?>
            <td data-day="<?= $day ?>" data-slot="<?= $slot ?>"></td>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <script>
    (function() {
      const scheduleData = <?= json_encode($scheduleData) ?>;
      const slots = document.querySelectorAll('td[data-day]');
      
      function parseTime(t) {
        return new Date("2020-01-01 " + t);
      }

      function generateBlocks(startTimeStr, endTimeStr) {
        let blocks = [];
        let cur   = parseTime(startTimeStr);
        let end   = parseTime(endTimeStr);
        while (cur < end) {
          let slotStart = formatAMPM(cur);
          cur.setMinutes(cur.getMinutes() + 30);
          let slotEnd = formatAMPM(cur);
          blocks.push(`${slotStart}-${slotEnd}`);
        }
        return blocks;
      }

      function formatAMPM(date) {
        let hours   = date.getHours();
        let minutes = date.getMinutes();
        let ampm    = (hours >= 12) ? 'pm' : 'am';
        hours       = hours % 12;
        hours       = hours ? hours : 12;
        minutes     = (minutes < 10) ? '0'+minutes : minutes;
        return hours + ':' + minutes + ampm;
      }

      scheduleData.forEach(sched => {
        const day    = sched.day;
        const stime  = sched.start_time;
        const etime  = sched.end_time;
        const code   = sched.subject_code || '';
        const desc   = sched.subject_desc || '';
        const room   = sched.room_name    || '';
        const sec    = sched.section_name || '';
        let blocks = generateBlocks(stime, etime);

        if (blocks.length === 0) return;
        let firstBlock = blocks[0];
        let firstTd    = document.querySelector(`td[data-day='${day}'][data-slot='${firstBlock}']`);
        if (!firstTd) return;
        firstTd.classList.add('merged-cell');
        firstTd.rowSpan = blocks.length;
        firstTd.innerHTML = `
          <div><strong>${code}</strong> - ${desc}</div>
          <div>Sec: ${sec}</div>
          <div>Room: ${room}</div>
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
