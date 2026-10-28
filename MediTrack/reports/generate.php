<?php
session_start();
include("../config/db.php");

// Only doctors
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
    header("Location: ../auth/login.php");
    exit;
}

$doctor_id = $_SESSION['user_id'];
$doctor_query = mysqli_query($conn, "SELECT * FROM doctors d JOIN users u ON u.full_name=d.full_name WHERE u.user_id='$doctor_id'");
$doctor = mysqli_fetch_assoc($doctor_query);

// Fetch appointments
$appointments = mysqli_query($conn, "
    SELECT a.appointment_id, p.full_name AS patient, a.appointment_date, a.status
    FROM appointments a
    JOIN patients p ON a.patient_id=p.patient_id
    WHERE a.doctor_id='{$doctor['doctor_id']}'
    ORDER BY a.appointment_date DESC
");

// Fetch lab requests
$lab_requests = mysqli_query($conn, "
    SELECT l.lab_id, p.full_name AS patient, l.test_name, l.request_date, l.status
    FROM lab_requests l
    JOIN patients p ON l.patient_id=p.patient_id
    JOIN appointments a ON a.patient_id=p.patient_id
    WHERE a.doctor_id='{$doctor['doctor_id']}'
    ORDER BY l.request_date DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Doctor Report | MediTrack HMS</title>
<style>
body {
    font-family:"Segoe UI", Arial, sans-serif;
    background: url("../assets/img/222.jpg") no-repeat center center fixed;
    background-size: cover;
    margin:0;
}
.overlay {
    min-height:100vh;
    background: rgba(255,255,255,0.7);
    padding:20px 0;
}
.container {
    max-width:900px;
    margin:auto;
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}
h1, h2 { color:#0056b3; margin-bottom:10px; }
table { width:100%; border-collapse:collapse; margin-bottom:20px; }
th, td { border:1px solid #007bff; padding:10px; text-align:left; }
th { background:#007bff; color:#fff; }
button { padding:10px 15px; background:#007bff; color:#fff; border:none; border-radius:8px; cursor:pointer; font-weight:600; margin-right:10px; }
button:hover { background:#0056b3; }
.back-link { display:inline-block; margin-top:10px; text-decoration:none; color:#007bff; font-weight:600; }
.back-link:hover { color:#0056b3; }
</style>
</head>
<body>
<div class="overlay">

<div class="container">
<h1>Doctor Report: Dr. <?php echo htmlspecialchars($doctor['full_name']); ?></h1>

<h2>Appointments</h2>
<table>
<tr><th>Patient</th><th>Date</th><th>Status</th></tr>
<?php while($a=mysqli_fetch_assoc($appointments)) { ?>
<tr>
<td><?php echo htmlspecialchars($a['patient']); ?></td>
<td><?php echo $a['appointment_date']; ?></td>
<td><?php echo $a['status']; ?></td>
</tr>
<?php } ?>
</table>

<h2>Lab Requests</h2>
<table>
<tr><th>Patient</th><th>Test Name</th><th>Request Date</th><th>Status</th></tr>
<?php while($l=mysqli_fetch_assoc($lab_requests)) { ?>
<tr>
<td><?php echo htmlspecialchars($l['patient']); ?></td>
<td><?php echo htmlspecialchars($l['test_name']); ?></td>
<td><?php echo $l['request_date']; ?></td>
<td><?php echo $l['status']; ?></td>
</tr>
<?php } ?>
</table>

<button onclick="window.print()">Print / Save as PDF</button>
<a href="../doctor/dashboard.php" class="back-link">← Back to Dashboard</a>
</div>
</div>
</body>
</html>
