<?php
session_start();
include("../config/db.php");

// Restrict access to patients only
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'patient') {
    header("Location: ../auth/login.php");
    exit;
}

// Fetch patient info
$user_id = $_SESSION['user_id'];
$patient_info_query = mysqli_query($conn, "SELECT * FROM patients WHERE user_id='$user_id'");
$patient_info = mysqli_fetch_assoc($patient_info_query);
if (!$patient_info) die("Patient record not found. Please contact administration.");

// Handle form submissions for appointments and lab requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['new_appointment'])) {
        $doctor_id = intval($_POST['doctor_id']);
        $appointment_date = $_POST['appointment_date'];
        mysqli_query($conn, "INSERT INTO appointments (patient_id, doctor_id, appointment_date, status) VALUES ('{$patient_info['patient_id']}', '$doctor_id', '$appointment_date', 'Scheduled')");
        $success_msg = "Appointment booked successfully!";
    }

    if (isset($_POST['new_lab'])) {
        $test_name = mysqli_real_escape_string($conn, $_POST['test_name']);
        $request_date = $_POST['request_date'];
        mysqli_query($conn, "INSERT INTO lab_requests (patient_id, test_name, request_date, status) VALUES ('{$patient_info['patient_id']}', '$test_name', '$request_date', 'Pending')");
        $success_msg = "Lab test requested successfully!";
    }
}

// Fetch updated data
$appointments = mysqli_query($conn, "
    SELECT a.appointment_id, a.appointment_date, a.status, d.full_name AS doctor
    FROM appointments a
    JOIN doctors d ON a.doctor_id = d.doctor_id
    WHERE a.patient_id='{$patient_info['patient_id']}'
    ORDER BY a.appointment_date DESC
");

$lab_requests = mysqli_query($conn, "
    SELECT lab_id, test_name, request_date, status
    FROM lab_requests
    WHERE patient_id='{$patient_info['patient_id']}'
    ORDER BY request_date DESC
");

$billing = mysqli_query($conn, "
    SELECT bill_id, amount, description, bill_date
    FROM billing
    WHERE patient_id='{$patient_info['patient_id']}'
    ORDER BY bill_date DESC
");

$discharge_query = mysqli_query($conn, "
    SELECT discharge_date, remarks
    FROM discharge
    WHERE patient_id='{$patient_info['patient_id']}'
");
$discharge = mysqli_fetch_assoc($discharge_query);

$offers = mysqli_query($conn, "
    SELECT * FROM offers
    WHERE valid_until >= CURDATE()
    ORDER BY valid_until ASC
");

// Fetch doctors for dropdown
$doctors = mysqli_query($conn, "SELECT doctor_id, full_name FROM doctors");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Patient Dashboard | MediTrack HMS</title>
<style>
/* Body and background image */
body {
    margin: 0;
    font-family: "Segoe UI", Arial, sans-serif;
    background: url("../assets/img/22.jpg") no-repeat center center fixed;
    background-size: cover;
}

/* Overlay to make content readable */
.overlay {
    min-height: 100vh;
    background: rgba(255,255,255,0.92);
    padding-bottom: 40px;
}

/* Container */
.container { width:95%; max-width:1200px; margin:auto; padding-top:30px; }
h1 { color:#0056b3; margin-bottom:5px; }
.subtitle { color:#555; margin-bottom:30px; font-size:16px; }

/* Cards */
.cards { display:grid; grid-template-columns: repeat(auto-fit, minmax(220px,1fr)); gap:20px; margin-bottom:30px; }
.card { background:#007bff; color:#fff; padding:25px; border-radius:15px; box-shadow:0 15px 35px rgba(0,0,0,0.15); text-align:center; }
.card h2 { margin:0; font-size:32px; }
.card p { margin-top:10px; font-size:16px; }

/* Actions */
.actions { background:#ffffff; padding:20px 25px; border-radius:15px; box-shadow:0 20px 40px rgba(0,0,0,0.12); margin-bottom:30px; }
.actions h3 { color:#0056b3; margin-bottom:15px; }
.actions a { display:inline-block; margin:10px 15px 10px 0; padding:10px 15px; background:#007bff; color:#fff; border-radius:8px; text-decoration:none; font-weight:600; cursor:pointer; }
.actions a:hover { background:#0056b3; }

/* Sections */
.section { background:#ffffff; padding:25px; border-radius:15px; box-shadow:0 20px 40px rgba(0,0,0,0.12); margin-bottom:30px; }
.section h3 { margin-bottom:20px; color:#0056b3; }
table { width:100%; border-collapse:collapse; }
th { background:#007bff; color:#fff; padding:12px; text-align:left; }
td { padding:12px; border-bottom:1px solid #ddd; }
.status-pending { color:#e67e22; font-weight:bold; }
.status-completed { color:#27ae60; font-weight:bold; }

/* Modal */
.modal { display:none; position:fixed; z-index:999; padding-top:60px; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.5); }
.modal-content { background:#fff; margin:auto; padding:25px; border-radius:15px; width:90%; max-width:800px; box-shadow:0 20px 40px rgba(0,0,0,0.2); }
.close { color:#007bff; float:right; font-size:28px; font-weight:bold; cursor:pointer; }
.close:hover { color:#0056b3; }

/* Forms inside modal */
.modal form { display:flex; flex-direction:column; gap:15px; margin-top:15px; }
.modal input, .modal select { padding:10px; border-radius:8px; border:1px solid #ccc; font-size:16px; }
.modal button { padding:10px 15px; background:#007bff; color:#fff; border:none; border-radius:8px; cursor:pointer; font-weight:600; }
.modal button:hover { background:#0056b3; }

.back-link { display:inline-block; margin-top:20px; text-decoration:none; color:#007bff; font-weight:600; }
.back-link:hover { color:#0056b3; }
.success-msg { color: green; font-weight:bold; margin-bottom:15px; }
</style>
</head>
<body>
<div class="overlay">

<?php include("topbar.php"); ?>

<div class="container">
    <h1>Patient Dashboard</h1>
    <p class="subtitle">Welcome, <?php echo htmlspecialchars($patient_info['full_name']); ?> | Your hospital stats and actions.</p>

    <!-- Cards -->
    <div class="cards">
        <div class="card"><h2><?php echo mysqli_num_rows($appointments); ?></h2><p>Appointments</p></div>
        <div class="card"><h2><?php echo mysqli_num_rows($lab_requests); ?></h2><p>Lab Tests Requested</p></div>
        <div class="card">
            <h2><?php $total_bill=0; mysqli_data_seek($billing,0); while($b=mysqli_fetch_assoc($billing)) $total_bill+=$b['amount']; echo number_format($total_bill,2); ?></h2>
            <p>Total Bills</p>
        </div>
        <div class="card"><h2><?php echo $discharge ? "Yes" : "No"; ?></h2><p>Discharged</p></div>
    </div>

    <!-- Actions -->
    <div class="actions">
        <h3>What would you like to do?</h3>
        <a onclick="openModal('appointmentModal')">Book New Appointment</a>
        <a onclick="openModal('labModal')">Request Lab Test</a>
        <a onclick="openModal('billingModal')">View Billing Details</a>
    </div>

    <?php if(isset($success_msg)) echo "<div class='success-msg'>$success_msg</div>"; ?>

    <!-- Modals -->
    <div id="appointmentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('appointmentModal')">&times;</span>
            <h3>Book New Appointment</h3>
            <form method="POST">
                <label>Choose Doctor:</label>
                <select name="doctor_id" required>
                    <?php while($d=mysqli_fetch_assoc($doctors)) {
                        echo "<option value='{$d['doctor_id']}'>{$d['full_name']}</option>";
                    } ?>
                </select>
                <label>Appointment Date:</label>
                <input type="date" name="appointment_date" required>
                <button type="submit" name="new_appointment">Book Appointment</button>
            </form>
        </div>
    </div>

    <div id="labModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('labModal')">&times;</span>
            <h3>Request Lab Test</h3>
            <form method="POST">
                <label>Test Name:</label>
                <input type="text" name="test_name" required>
                <label>Request Date:</label>
                <input type="date" name="request_date" required>
                <button type="submit" name="new_lab">Request Lab Test</button>
            </form>
        </div>
    </div>

    <div id="billingModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('billingModal')">&times;</span>
            <h3>Your Bills</h3>
            <table>
                <tr><th>Description</th><th>Amount</th><th>Date</th></tr>
                <?php mysqli_data_seek($billing,0); while($b=mysqli_fetch_assoc($billing)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($b['description']); ?></td>
                        <td><?php echo number_format($b['amount'],2); ?></td>
                        <td><?php echo $b['bill_date']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <!-- Existing Sections -->
    <div class="section">
        <h3>Your Appointments</h3>
        <table>
            <tr><th>Doctor</th><th>Date</th><th>Status</th></tr>
            <?php mysqli_data_seek($appointments,0); while($a=mysqli_fetch_assoc($appointments)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($a['doctor']); ?></td>
                    <td><?php echo $a['appointment_date']; ?></td>
                    <td class="<?php echo strtolower($a['status']); ?>"><?php echo $a['status']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="section">
        <h3>Your Lab Requests</h3>
        <table>
            <tr><th>Test Name</th><th>Request Date</th><th>Status</th></tr>
            <?php mysqli_data_seek($lab_requests,0); while($l=mysqli_fetch_assoc($lab_requests)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($l['test_name']); ?></td>
                    <td><?php echo $l['request_date']; ?></td>
                    <td class="<?php echo strtolower($l['status']); ?>"><?php echo $l['status']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="section">
        <h3>Hospital Offers & Services</h3>
        <table>
            <tr><th>Title</th><th>Description</th><th>Valid Until</th></tr>
            <?php while($o=mysqli_fetch_assoc($offers)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($o['title']); ?></td>
                    <td><?php echo htmlspecialchars($o['description']); ?></td>
                    <td><?php echo $o['valid_until']; ?></td>
                </tr>
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
