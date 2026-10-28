<?php
session_start();
include("../config/db.php");

// Only receptionist
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'receptionist') {
    header("Location: ../auth/login.php");
    exit;
}

// Fetch patients
$patients = mysqli_query($conn, "SELECT * FROM patients ORDER BY date_registered DESC");

// Fetch appointments
$appointments = mysqli_query($conn, "
    SELECT a.appointment_id, p.full_name AS patient, d.full_name AS doctor, a.appointment_date, a.status
    FROM appointments a
    JOIN patients p ON a.patient_id=p.patient_id
    JOIN doctors d ON a.doctor_id=d.doctor_id
    ORDER BY a.appointment_date DESC
");

// Fetch lab requests
$lab_requests = mysqli_query($conn, "
    SELECT l.lab_id, p.full_name AS patient, l.test_name, l.request_date, l.status
    FROM lab_requests l
    JOIN patients p ON l.patient_id=p.patient_id
    ORDER BY l.request_date DESC
");

// Fetch billing
$billing = mysqli_query($conn, "
    SELECT b.bill_id, p.full_name AS patient, b.amount, b.description, b.bill_date
    FROM billing b
    JOIN patients p ON b.patient_id=p.patient_id
    ORDER BY b.bill_date DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Receptionist Reports | MediTrack HMS</title>
<style>
body {
    font-family:"Segoe UI", Arial, sans-serif;
    background: url("../assets/img/111.jpg") no-repeat center center fixed;
    background-size: cover;
    margin:0;
}
.overlay {
    min-height:100vh;
    background: rgba(255,255,255,0.85);
    padding:20px 0;
}
.container {
    max-width:1000px;
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
.status-pending { color:#e67e22; font-weight:bold; }
.status-completed { color:#27ae60; font-weight:bold; }
</style>
</head>
<body>
<div class="overlay">
<?php include("../receptionist/topbar.php"); ?>

<div class="container">
<h1>Receptionist Reports</h1>

<h2>Patients</h2>
<table>
<tr><th>Name</th><th>Gender</th><th>Age</th><th>Phone</th><th>Address</th><th>Date Registered</th></tr>
<?php while($p=mysqli_fetch_assoc($patients)) { ?>
<tr>
<td><?php echo htmlspecialchars($p['full_name']); ?></td>
<td><?php echo htmlspecialchars($p['gender']); ?></td>
<td><?php echo $p['age']; ?></td>
<td><?php echo htmlspecialchars($p['phone']); ?></td>
<td><?php echo htmlspecialchars($p['address']); ?></td>
<td><?php echo $p['date_registered']; ?></td>
</tr>
<?php } ?>
</table>

<h2>Appointments</h2>
<table>
<tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Status</th></tr>
<?php while($a=mysqli_fetch_assoc($appointments)) { ?>
<tr>
<td><?php echo htmlspecialchars($a['patient']); ?></td>
<td><?php echo htmlspecialchars($a['doctor']); ?></td>
<td><?php echo $a['appointment_date']; ?></td>
<td class="status-<?php echo strtolower($a['status']); ?>"><?php echo $a['status']; ?></td>
</tr>
<?php } ?>
</table>

<h2>Lab Requests</h2>
<table>
<tr><th>Patient</th><th>Test</th><th>Request Date</th><th>Status</th></tr>
<?php while($l=mysqli_fetch_assoc($lab_requests)) { ?>
<tr>
<td><?php echo htmlspecialchars($l['patient']); ?></td>
<td><?php echo htmlspecialchars($l['test_name']); ?></td>
<td><?php echo $l['request_date']; ?></td>
<td class="status-<?php echo strtolower($l['status']); ?>"><?php echo $l['status']; ?></td>
</tr>
<?php } ?>
</table>

<h2>Billing</h2>
<table>
<tr><th>Patient</th><th>Amount</th><th>Description</th><th>Date</th></tr>
<?php while($b=mysqli_fetch_assoc($billing)) { ?>
<tr>
<td><?php echo htmlspecialchars($b['patient']); ?></td>
<td><?php echo number_format($b['amount'],2); ?></td>
<td><?php echo htmlspecialchars($b['description']); ?></td>
<td><?php echo $b['bill_date']; ?></td>
</tr>
<?php } ?>
</table>

<button onclick="window.print()">Print / Save as PDF</button>
<a href="../receptionist/dashboard.php" class="back-link">← Back to Dashboard</a>
</div>
</div>
</body>
</html>
