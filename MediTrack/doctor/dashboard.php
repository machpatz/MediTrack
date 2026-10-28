<?php
session_start();
include("../config/db.php");

// Restrict access to doctors only
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
    header("Location: ../auth/login.php");
    exit;
}

// Fetch doctor info
$user_id = $_SESSION['user_id'];
$doctor_query = mysqli_query($conn, "SELECT * FROM doctors d JOIN users u ON u.full_name=d.full_name WHERE u.user_id='$user_id'");
$doctor = mysqli_fetch_assoc($doctor_query);
if (!$doctor) die("Doctor record not found.");

// Handle updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_appointment'])) {
        $appointment_id = intval($_POST['appointment_id']);
        $status = $_POST['status'];
        mysqli_query($conn, "UPDATE appointments SET status='$status' WHERE appointment_id='$appointment_id'");
        $success_msg = "Appointment status updated successfully!";
    }
    if (isset($_POST['update_lab'])) {
        $lab_id = intval($_POST['lab_id']);
        $status = $_POST['status'];
        mysqli_query($conn, "UPDATE lab_requests SET status='$status' WHERE lab_id='$lab_id'");
        $success_msg = "Lab request status updated successfully!";
    }
}

// Fetch appointments, lab requests, and patients
$appointments = mysqli_query($conn, "
    SELECT a.appointment_id, a.appointment_date, a.status, p.full_name AS patient
    FROM appointments a
    JOIN patients p ON a.patient_id=p.patient_id
    WHERE a.doctor_id='{$doctor['doctor_id']}'
    ORDER BY a.appointment_date DESC
");

$lab_requests = mysqli_query($conn, "
    SELECT l.lab_id, l.test_name, l.request_date, l.status, p.full_name AS patient
    FROM lab_requests l
    JOIN patients p ON l.patient_id=p.patient_id
    JOIN appointments a ON a.patient_id=p.patient_id
    WHERE a.doctor_id='{$doctor['doctor_id']}'
    ORDER BY l.request_date DESC
");

$patients = mysqli_query($conn, "
    SELECT p.*
    FROM patients p
    JOIN appointments a ON a.patient_id=p.patient_id
    WHERE a.doctor_id='{$doctor['doctor_id']}'
    GROUP BY p.patient_id
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Doctor Dashboard | MediTrack HMS</title>
<style>
body {
    margin:0;
    font-family:"Segoe UI", Arial, sans-serif;
    background: url("../assets/img/222.jpg") no-repeat center center fixed;
    background-size: cover;
}
.overlay {
    min-height:100vh;
    background: rgba(255,255,255,0.5); /* lighter overlay */
    padding-bottom:40px;
}
.container { width:95%; max-width:1200px; margin:auto; padding-top:30px; }
h1 { color:#0056b3; margin-bottom:5px; }
.subtitle { color:#555; margin-bottom:20px; font-size:16px; }

/* Cards */
.cards { display:grid; grid-template-columns: repeat(auto-fit, minmax(220px,1fr)); gap:20px; margin-bottom:20px; }
.card { background:#007bff; color:#fff; padding:25px; border-radius:15px; box-shadow:0 15px 35px rgba(0,0,0,0.15); text-align:center; }
.card h2 { margin:0; font-size:32px; }
.card p { margin-top:10px; font-size:16px; }

/* Sections */
.section { background:#ffffff; padding:25px; border-radius:15px; box-shadow:0 20px 40px rgba(0,0,0,0.12); margin-bottom:30px; }
.section h3 { margin-bottom:20px; color:#0056b3; }
table { width:100%; border-collapse:collapse; }
th { background:#007bff; color:#fff; padding:12px; text-align:left; }
td { padding:12px; border-bottom:1px solid #ddd; }
.status-scheduled { color:#e67e22; font-weight:bold; }
.status-completed { color:#27ae60; font-weight:bold; }
.status-cancelled { color:#c0392b; font-weight:bold; }

/* Buttons */
.update-btn {
    background: #007bff;
    color: #fff;
    border: none;
    padding: 8px 14px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
}
.update-btn:hover { background: #0056b3; }

/* Modal */
.modal { display:none; position:fixed; z-index:999; padding-top:60px; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.5); }
.modal-content { background:#fff; margin:auto; padding:25px; border-radius:15px; width:90%; max-width:600px; box-shadow:0 20px 40px rgba(0,0,0,0.2); }
.close { color:#007bff; float:right; font-size:28px; font-weight:bold; cursor:pointer; }
.close:hover { color:#0056b3; }
.modal form { display:flex; flex-direction:column; gap:15px; margin-top:15px; }
.modal select { padding:10px; border-radius:8px; border:1px solid #ccc; font-size:16px; }
.modal button { padding:10px 15px; background:#007bff; color:#fff; border:none; border-radius:8px; cursor:pointer; font-weight:600; }
.modal button:hover { background:#0056b3; }

.success-msg { color: green; font-weight:bold; margin-bottom:15px; }
.back-link { display:inline-block; margin-top:20px; text-decoration:none; color:#007bff; font-weight:600; }
.back-link:hover { color:#0056b3; }
</style>
</head>
<body>
<div class="overlay">
<?php include("topbar.php"); ?>

<div class="container">
    <h1>Doctor Dashboard</h1>
    <p class="subtitle">Welcome, Dr. <?php echo htmlspecialchars($doctor['full_name']); ?> | Manage your patients and appointments.</p>

    <!-- Cards -->
    <div class="cards">
        <div class="card"><h2><?php echo mysqli_num_rows($appointments); ?></h2><p>Appointments</p></div>
        <div class="card"><h2><?php echo mysqli_num_rows($lab_requests); ?></h2><p>Lab Requests</p></div>
        <div class="card"><h2><?php echo mysqli_num_rows($patients); ?></h2><p>Patients</p></div>
    </div>

    <!-- Inline Report Link -->
    <a href="../reports/generate.php" class="update-btn" style="margin-bottom:20px; display:inline-block;">
        Generate Report
    </a>

    <?php if(isset($success_msg)) echo "<div class='success-msg'>$success_msg</div>"; ?>

    <!-- Appointments Section -->
    <div class="section">
        <h3>Appointments</h3>
        <table>
            <tr><th>Patient</th><th>Date</th><th>Status</th><th>Action</th></tr>
            <?php mysqli_data_seek($appointments,0); while($a=mysqli_fetch_assoc($appointments)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($a['patient']); ?></td>
                    <td><?php echo $a['appointment_date']; ?></td>
                    <td class="status-<?php echo strtolower($a['status']); ?>"><?php echo $a['status']; ?></td>
                    <td><button class="update-btn" onclick="openModal('updateAppointment<?php echo $a['appointment_id']; ?>')">Update</button></td>
                </tr>

                <!-- Appointment Modal -->
                <div id="updateAppointment<?php echo $a['appointment_id']; ?>" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('updateAppointment<?php echo $a['appointment_id']; ?>')">&times;</span>
                        <h3>Update Appointment Status</h3>
                        <form method="POST">
                            <input type="hidden" name="appointment_id" value="<?php echo $a['appointment_id']; ?>">
                            <label>Status:</label>
                            <select name="status" required>
                                <option value="Scheduled" <?php if($a['status']=='Scheduled') echo 'selected'; ?>>Scheduled</option>
                                <option value="Completed" <?php if($a['status']=='Completed') echo 'selected'; ?>>Completed</option>
                                <option value="Cancelled" <?php if($a['status']=='Cancelled') echo 'selected'; ?>>Cancelled</option>
                            </select>
                            <button type="submit" name="update_appointment">Update</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </table>
    </div>

    <!-- Lab Requests Section -->
    <div class="section">
        <h3>Lab Requests</h3>
        <table>
            <tr><th>Patient</th><th>Test Name</th><th>Request Date</th><th>Status</th><th>Action</th></tr>
            <?php mysqli_data_seek($lab_requests,0); while($l=mysqli_fetch_assoc($lab_requests)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($l['patient']); ?></td>
                    <td><?php echo htmlspecialchars($l['test_name']); ?></td>
                    <td><?php echo $l['request_date']; ?></td>
                    <td class="status-<?php echo strtolower($l['status']); ?>"><?php echo $l['status']; ?></td>
                    <td><button class="update-btn" onclick="openModal('updateLab<?php echo $l['lab_id']; ?>')">Update</button></td>
                </tr>

                <!-- Lab Modal -->
                <div id="updateLab<?php echo $l['lab_id']; ?>" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('updateLab<?php echo $l['lab_id']; ?>')">&times;</span>
                        <h3>Update Lab Status</h3>
                        <form method="POST">
                            <input type="hidden" name="lab_id" value="<?php echo $l['lab_id']; ?>">
                            <label>Status:</label>
                            <select name="status" required>
                                <option value="Pending" <?php if($l['status']=='Pending') echo 'selected'; ?>>Pending</option>
                                <option value="Completed" <?php if($l['status']=='Completed') echo 'selected'; ?>>Completed</option>
                            </select>
                            <button type="submit" name="update_lab">Update</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </table>
    </div>

    <a href="dashboard.php" class="back-link">← Refresh / Back to Dashboard</a>
</div>
</div>

<script>
function openModal(id){ document.getElementById(id).style.display='block'; }
function closeModal(id){ document.getElementById(id).style.display='none'; }
window.onclick=function(event){
    let modals=document.querySelectorAll('.modal');
    modals.forEach(modal=>{ if(event.target==modal) modal.style.display='none'; });
}
</script>
</body>
</html>
