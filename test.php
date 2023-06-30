<?php
include 'connection.php';
// Get the start and end dates from the Flatpickr calendar

?>


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<link href=https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css rel="stylesheet">
    <title>Toggle Elements</title>
</head>
<body>
<a href="#" id="modal-link">Open Modal</a>



<input type="text" id="date-range-picker" placeholder="Select date range">
<p id="sql-query"></p>
<table id="result-table">
  <thead>
    <tr>
      <th>Year Level</th>
      <th>Count</th>
    </tr>
  </thead>
  <tbody id="result-body"></tbody>
</table>
<br>

<script>
  document.getElementById('modal-link').addEventListener('click', function(event) {
  event.preventDefault(); // Prevent the default link behavior
  var dateRangePicker = flatpickr("#date-range-picker", {
        mode: "range",
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "F j, Y",
        onChange: function(selectedDates, dateStr) {
    var startDate = selectedDates[0] ? selectedDates[0].toISOString().split('T')[0] : '';
    var endDate = selectedDates[1] ? selectedDates[1].toISOString().split('T')[0] : '';

    // Pass the selected date range to your SQL query
    var sqlQuery = "SELECT yearlevel, COUNT(*) AS count FROM student WHERE date_registered BETWEEN '" + startDate + "' AND '" + endDate + "' GROUP BY yearlevel;";


    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'execute_query.php?query=' + encodeURIComponent(sqlQuery), true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        displayResults(response);
      }
    };
    xhr.send();
  }
    });
    function displayResults(results) {
  var resultBody = document.getElementById('result-body');
  resultBody.innerHTML = '';

  results.forEach(function(result) {
    var row = document.createElement('tr');
    var yearLevelCell = document.createElement('td');
    var countCell = document.createElement('td');

    yearLevelCell.textContent = result.yearlevel;
    countCell.textContent = result.count;

    row.appendChild(yearLevelCell);
    row.appendChild(countCell);
    resultBody.appendChild(row);
  });
}
  // Create the modal HTML dynamically
  var modalHTML = `
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Select Date</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <input type="text" id="date-range-picker" placeholder="Select date range">
          <p id="sql-query"></p>
          <table id="result-table">
            <thead>
              <tr>
                <th>Year Level</th>
                <th>Count</th>
              </tr>
            </thead>
            <tbody id="result-body"></tbody>
          </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  `;

  // Add the modal HTML to the document body
  document.body.insertAdjacentHTML('beforeend', modalHTML);

  // Show the modal
  var modal = new bootstrap.Modal(document.getElementById('myModal'));
  modal.show();
});

</script>

  <!-- Include necessary JavaScript code -->
  <script>
    // Initialize the Flatpickr calendar
    var dateRangePicker = flatpickr("#date-range-picker", {
        mode: "range",
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "F j, Y",
        onChange: function(selectedDates, dateStr) {
    var startDate = selectedDates[0] ? selectedDates[0].toISOString().split('T')[0] : '';
    var endDate = selectedDates[1] ? selectedDates[1].toISOString().split('T')[0] : '';

    // Pass the selected date range to your SQL query
    var sqlQuery = "SELECT yearlevel, COUNT(*) AS count FROM student WHERE date_registered BETWEEN '" + startDate + "' AND '" + endDate + "' GROUP BY yearlevel;";


    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'execute_query.php?query=' + encodeURIComponent(sqlQuery), true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        displayResults(response);
      }
    };
    xhr.send();
  }
    });
    function displayResults(results) {
  var resultBody = document.getElementById('result-body');
  resultBody.innerHTML = '';

  results.forEach(function(result) {
    var row = document.createElement('tr');
    var yearLevelCell = document.createElement('td');
    var countCell = document.createElement('td');

    yearLevelCell.textContent = result.yearlevel;
    countCell.textContent = result.count;

    row.appendChild(yearLevelCell);
    row.appendChild(countCell);
    resultBody.appendChild(row);
  });
}
  </script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="js/script.js"></script>
</body>
</html>

<?php
// Close the database connection
$con->close();
?>
