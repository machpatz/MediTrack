<?php
session_start();
include("../config/db.php");

// Restrict access to admin only
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Fetch admin info
$admin_id = $_SESSION['user_id'];
$admin_query = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$admin_id'");
$admin = mysqli_fetch_assoc($admin_query);

// =======================
// Handle POST actions
// =======================
$success_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Appointments
    if (isset($_POST['edit_appointment'])) {
        $id = intval($_POST['appointment_id']);
        $patient_id = intval($_POST['patient_id']);
        $doctor_id = intval($_POST['doctor_id']);
        $date = $_POST['appointment_date'];
        $status = $_POST['status'];
        mysqli_query($conn, "UPDATE appointments SET patient_id=$patient_id, doctor_id=$doctor_id, appointment_date='$date', status='$status' WHERE appointment_id=$id");
        $success_msg = "Appointment updated!";
    }
    if (isset($_POST['delete_appointment'])) {
        $id = intval($_POST['appointment_id']);
        mysqli_query($conn, "DELETE FROM appointments WHERE appointment_id=$id");
        $success_msg = "Appointment deleted!";
    }

    // Lab Requests
    if (isset($_POST['edit_lab'])) {
        $id = intval($_POST['lab_id']);
        $patient_id = intval($_POST['patient_id']);
        $test_name = $_POST['test_name'];
        $status = $_POST['status'];
        mysqli_query($conn, "UPDATE lab_requests SET patient_id=$patient_id, test_name='$test_name', status='$status' WHERE lab_id=$id");
        $success_msg = "Lab request updated!";
    }
    if (isset($_POST['delete_lab'])) {
        $id = intval($_POST['lab_id']);
        mysqli_query($conn, "DELETE FROM lab_requests WHERE lab_id=$id");
        $success_msg = "Lab request deleted!";
    }

    // Billing
    if (isset($_POST['edit_bill'])) {
        $id = intval($_POST['bill_id']);
        $patient_id = intval($_POST['patient_id']);
        $amount = floatval($_POST['amount']);
        $desc = $_POST['description'];
        mysqli_query($conn, "UPDATE billing SET patient_id=$patient_id, amount=$amount, description='$desc' WHERE bill_id=$id");
        $success_msg = "Billing updated!";
    }
    if (isset($_POST['delete_bill'])) {
        $id = intval($_POST['bill_id']);
        mysqli_query($conn, "DELETE FROM billing WHERE bill_id=$id");
        $success_msg = "Billing deleted!";
    }

    // Discharges
    if (isset($_POST['edit_discharge'])) {
        $id = intval($_POST['discharge_id']);
        $patient_id = intval($_POST['patient_id']);
        $remarks = $_POST['remarks'];
        mysqli_query($conn, "UPDATE discharge SET patient_id=$patient_id, remarks='$remarks' WHERE discharge_id=$id");
        $success_msg = "Discharge updated!";
    }
    if (isset($_POST['delete_discharge'])) {
        $id = intval($_POST['discharge_id']);
        mysqli_query($conn, "DELETE FROM discharge WHERE discharge_id=$id");
        $success_msg = "Discharge deleted!";
    }

    // Contact Messages
    if (isset($_POST['delete_message'])) {
        $id = intval($_POST['message_id']);
        mysqli_query($conn, "DELETE FROM contact_messages WHERE id=$id");
        $success_msg = "Message deleted!";
    }
}

// =======================
// Fetch all data
// =======================
$appointments = mysqli_query($conn,"SELECT a.appointment_id, p.full_name AS patient, d.full_name AS doctor, a.appointment_date, a.status FROM appointments a JOIN patients p ON a.patient_id=p.patient_id JOIN doctors d ON a.doctor_id=d.doctor_id ORDER BY a.appointment_date DESC");
$lab_requests = mysqli_query($conn,"SELECT l.lab_id, p.full_name AS patient, l.test_name, l.request_date, l.status FROM lab_requests l JOIN patients p ON l.patient_id=p.patient_id ORDER BY l.request_date DESC");
$billing = mysqli_query($conn,"SELECT b.bill_id, p.full_name AS patient, b.amount, b.description, b.bill_date FROM billing b JOIN patients p ON b.patient_id=p.patient_id ORDER BY b.bill_date DESC");
$discharges = mysqli_query($conn,"SELECT d.discharge_id, p.full_name AS patient, d.discharge_date, d.remarks FROM discharge d JOIN patients p ON d.patient_id=p.patient_id ORDER BY d.discharge_date DESC");
$messages = mysqli_query($conn,"SELECT * FROM contact_messages ORDER BY date_sent DESC");
$patients = mysqli_query($conn,"SELECT * FROM patients");
$doctors = mysqli_query($conn,"SELECT * FROM doctors");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard | MediTrack HMS</title>
<style>
body { margin:0; font-family:"Segoe UI",Arial,sans-serif; background:url('../assets/img/2222.jpg') no-repeat center center fixed; background-size:cover; }
.overlay { min-height:100vh; background:rgba(255,255,255,0.05); padding-bottom:40px; }
.container { width:95%; max-width:1400px; margin:auto; padding-top:30px; }
h1 { color:#0056b3; margin-bottom:10px; }
.subtitle { color:#555; margin-bottom:30px; font-size:16px; }
.section { background:#fff; padding:25px; border-radius:15px; box-shadow:0 20px 40px rgba(0,0,0,0.12); margin-bottom:30px; }
.section h3 { margin-bottom:20px; color:#0056b3; }
table { width:100%; border-collapse:collapse; }
th { background:#007bff; color:#fff; padding:12px; text-align:left; }
td { padding:10px; border-bottom:1px solid #ddd; }
.action-btn, .update-btn { background:#007bff; color:#fff; border:none; padding:6px 12px; border-radius:8px; cursor:pointer; font-weight:600; text-decoration:none; }
.action-btn:hover, .update-btn:hover { background:#0056b3; }
.modal { display:none; position:fixed; z-index:999; padding-top:60px; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.5); }
.modal-content { background:#fff; margin:auto; padding:25px; border-radius:15px; width:90%; max-width:600px; box-shadow:0 20px 40px rgba(0,0,0,0.2); }
.close { color:#007bff; float:right; font-size:28px; font-weight:bold; cursor:pointer; }
.close:hover { color:#0056b3; }
.modal form { display:flex; flex-direction:column; gap:12px; margin-top:12px; }
.modal input, .modal select, .modal textarea { padding:10px; border-radius:8px; border:1px solid #ccc; font-size:16px; width:100%; }
.modal button { padding:10px 15px; background:#007bff; color:#fff; border:none; border-radius:8px; cursor:pointer; font-weight:600; }
.modal button:hover { background:#0056b3; }
.success-msg { color:green; font-weight:bold; margin-bottom:15px; }
@media print {
    body { background:#fff !important; }
    .action-btn, .update-btn, .modal, .back-link, button { display:none !important; }
}
</style>
</head>
<body>
<div class="overlay">
<?php include("../admin/topbar.php"); ?>
<div class="container">
<h1>Admin Dashboard</h1>
<p class="subtitle">Welcome, <?php echo htmlspecialchars($admin['full_name']); ?> | Manage Appointments, Lab Requests, Billing, Discharges, and Messages</p>

<!-- PRINT BUTTON -->
<button onclick="printReport()" style="background:#28a745;color:#fff;border:none;padding:10px 20px;border-radius:8px;cursor:pointer;font-weight:bold;margin-bottom:20px;">
Print Report
</button>

<?php if($success_msg) echo "<div class='success-msg'>$success_msg</div>"; ?>

<!-- ================== APPOINTMENTS ================== -->
<div class="section">
<h3>Appointments</h3>
<table>
<tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Status</th><th>Action</th></tr>
<?php while($a=mysqli_fetch_assoc($appointments)){ ?>
<tr>
<td><?php echo htmlspecialchars($a['patient']); ?></td>
<td><?php echo htmlspecialchars($a['doctor']); ?></td>
<td><?php echo $a['appointment_date']; ?></td>
<td><?php echo $a['status']; ?></td>
<td>
<button class="update-btn" onclick="openModal('editAppointment<?php echo $a['appointment_id']; ?>')">Edit</button>
<form method="POST" style="display:inline;">
<input type="hidden" name="appointment_id" value="<?php echo $a['appointment_id']; ?>">
<button class="update-btn" name="delete_appointment" type="submit">Delete</button>
</form>
</td>
</tr>
<div id="editAppointment<?php echo $a['appointment_id']; ?>" class="modal">
<div class="modal-content">
<span class="close" onclick="closeModal('editAppointment<?php echo $a['appointment_id']; ?>')">&times;</span>
<h3>Edit Appointment</h3>
<form method="POST">
<input type="hidden" name="appointment_id" value="<?php echo $a['appointment_id']; ?>">
<select name="patient_id" required>
<?php mysqli_data_seek($patients,0); while($p=mysqli_fetch_assoc($patients)){ $sel=$p['full_name']==$a['patient']?'selected':''; echo "<option value='{$p['patient_id']}' $sel>{$p['full_name']}</option>"; } ?>
</select>
<select name="doctor_id" required>
<?php mysqli_data_seek($doctors,0); while($d=mysqli_fetch_assoc($doctors)){ $sel=$d['full_name']==$a['doctor']?'selected':''; echo "<option value='{$d['doctor_id']}' $sel>{$d['full_name']}</option>"; } ?>
</select>
<input type="date" name="appointment_date" value="<?php echo $a['appointment_date']; ?>" required>
<select name="status">
<option value="Scheduled" <?php if($a['status']=='Scheduled') echo 'selected'; ?>>Scheduled</option>
<option value="Completed" <?php if($a['status']=='Completed') echo 'selected'; ?>>Completed</option>
<option value="Cancelled" <?php if($a['status']=='Cancelled') echo 'selected'; ?>>Cancelled</option>
</select>
<button type="submit" name="edit_appointment">Update</button>
</form>
</div>
</div>
<?php } ?>
</table>
</div>

<!-- ================== LAB REQUESTS ================== -->
<div class="section">
<h3>Lab Requests</h3>
<table>
<tr><th>Patient</th><th>Test</th><th>Date</th><th>Status</th><th>Action</th></tr>
<?php while($l=mysqli_fetch_assoc($lab_requests)){ ?>
<tr>
<td><?php echo htmlspecialchars($l['patient']); ?></td>
<td><?php echo htmlspecialchars($l['test_name']); ?></td>
<td><?php echo $l['request_date']; ?></td>
<td><?php echo $l['status']; ?></td>
<td>
<button class="update-btn" onclick="openModal('editLab<?php echo $l['lab_id']; ?>')">Edit</button>
<form method="POST" style="display:inline;">
<input type="hidden" name="lab_id" value="<?php echo $l['lab_id']; ?>">
<button class="update-btn" name="delete_lab" type="submit">Delete</button>
</form>
</td>
</tr>
<div id="editLab<?php echo $l['lab_id']; ?>" class="modal">
<div class="modal-content">
<span class="close" onclick="closeModal('editLab<?php echo $l['lab_id']; ?>')">&times;</span>
<h3>Edit Lab Request</h3>
<form method="POST">
<input type="hidden" name="lab_id" value="<?php echo $l['lab_id']; ?>">
<select name="patient_id" required>
<?php mysqli_data_seek($patients,0); while($p=mysqli_fetch_assoc($patients)){ $sel=$p['full_name']==$l['patient']?'selected':''; echo "<option value='{$p['patient_id']}' $sel>{$p['full_name']}</option>"; } ?>
</select>
<input type="text" name="test_name" value="<?php echo $l['test_name']; ?>" required>
<select name="status">
<option value="Pending" <?php if($l['status']=='Pending') echo 'selected'; ?>>Pending</option>
<option value="Completed" <?php if($l['status']=='Completed') echo 'selected'; ?>>Completed</option>
<option value="Cancelled" <?php if($l['status']=='Cancelled') echo 'selected'; ?>>Cancelled</option>
</select>
<button type="submit" name="edit_lab">Update</button>
</form>
</div>
</div>
<?php } ?>
</table>
</div>

<!-- ================== BILLING ================== -->
<div class="section">
<h3>Billing</h3>
<table>
<tr><th>Patient</th><th>Amount</th><th>Description</th><th>Date</th><th>Action</th></tr>
<?php while($b=mysqli_fetch_assoc($billing)){ ?>
<tr>
<td><?php echo htmlspecialchars($b['patient']); ?></td>
<td><?php echo $b['amount']; ?></td>
<td><?php echo htmlspecialchars($b['description']); ?></td>
<td><?php echo $b['bill_date']; ?></td>
<td>
<button class="update-btn" onclick="openModal('editBill<?php echo $b['bill_id']; ?>')">Edit</button>
<form method="POST" style="display:inline;">
<input type="hidden" name="bill_id" value="<?php echo $b['bill_id']; ?>">
<button class="update-btn" name="delete_bill" type="submit">Delete</button>
</form>
</td>
</tr>
<div id="editBill<?php echo $b['bill_id']; ?>" class="modal">
<div class="modal-content">
<span class="close" onclick="closeModal('editBill<?php echo $b['bill_id']; ?>')">&times;</span>
<h3>Edit Billing</h3>
<form method="POST">
<input type="hidden" name="bill_id" value="<?php echo $b['bill_id']; ?>">
<select name="patient_id" required>
<?php mysqli_data_seek($patients,0); while($p=mysqli_fetch_assoc($patients)){ $sel=$p['full_name']==$b['patient']?'selected':''; echo "<option value='{$p['patient_id']}' $sel>{$p['full_name']}</option>"; } ?>
</select>
<input type="number" name="amount" step="0.01" value="<?php echo $b['amount']; ?>" required>
<textarea name="description" required><?php echo $b['description']; ?></textarea>
<button type="submit" name="edit_bill">Update</button>
</form>
</div>
</div>
<?php } ?>
</table>
</div>

<!-- ================== DISCHARGES ================== -->
<div class="section">
<h3>Discharges</h3>
<table>
<tr><th>Patient</th><th>Date</th><th>Remarks</th><th>Action</th></tr>
<?php while($d=mysqli_fetch_assoc($discharges)){ ?>
<tr>
<td><?php echo htmlspecialchars($d['patient']); ?></td>
<td><?php echo $d['discharge_date']; ?></td>
<td><?php echo htmlspecialchars($d['remarks']); ?></td>
<td>
<button class="update-btn" onclick="openModal('editDischarge<?php echo $d['discharge_id']; ?>')">Edit</button>
<form method="POST" style="display:inline;">
<input type="hidden" name="discharge_id" value="<?php echo $d['discharge_id']; ?>">
<button class="update-btn" name="delete_discharge" type="submit">Delete</button>
</form>
</td>
</tr>
<div id="editDischarge<?php echo $d['discharge_id']; ?>" class="modal">
<div class="modal-content">
<span class="close" onclick="closeModal('editDischarge<?php echo $d['discharge_id']; ?>')">&times;</span>
<h3>Edit Discharge</h3>
<form method="POST">
<input type="hidden" name="discharge_id" value="<?php echo $d['discharge_id']; ?>">
<select name="patient_id" required>
<?php mysqli_data_seek($patients,0); while($p=mysqli_fetch_assoc($patients)){ $sel=$p['full_name']==$d['patient']?'selected':''; echo "<option value='{$p['patient_id']}' $sel>{$p['full_name']}</option>"; } ?>
</select>
<textarea name="remarks" required><?php echo $d['remarks']; ?></textarea>
<button type="submit" name="edit_discharge">Update</button>
</form>
</div>
</div>
<?php } ?>
</table>
</div>

<!-- ================== CONTACT MESSAGES ================== -->
<div class="section">
<h3>Contact Messages</h3>
<table>
<tr><th>Name</th><th>Email</th><th>Message</th><th>Date</th><th>Action</th></tr>
<?php while($m=mysqli_fetch_assoc($messages)){ ?>
<tr>
<td><?php echo htmlspecialchars($m['name']); ?></td>
<td><?php echo htmlspecialchars($m['email']); ?></td>
<td><?php echo htmlspecialchars($m['message']); ?></td>
<td><?php echo $m['date_sent']; ?></td>
<td>
<form method="POST" style="display:inline;">
<input type="hidden" name="message_id" value="<?php echo $m['id']; ?>">
<button class="update-btn" name="delete_message" type="submit">Delete</button>
</form>
</td>
</tr>
<?php } ?>
</table>
</div>

<a href="../admin/dashboard.php" class="back-link">← Refresh / Back to Dashboard</a>
</div>
</div>

<script>
function openModal(id){ document.getElementById(id).style.display='block'; }
function closeModal(id){ document.getElementById(id).style.display='none'; }
window.onclick=function(event){
    document.querySelectorAll('.modal').forEach(modal=>{
        if(event.target==modal) modal.style.display='none';
    })
}

// PRINT REPORT FUNCTION
function printReport() {
    window.print();
}
</script>
</body>
</html>
