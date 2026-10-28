<?php
session_start();
include("../config/db.php");

// Restrict access to receptionist only
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'receptionist') {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receptionist Dashboard | MediTrack HMS</title>

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: url("../assets/img/111.jpg") no-repeat center center fixed;
            background-size: cover;
        }

        /* Soft hospital overlay */
        .overlay {
            min-height: 100vh;
            background: rgba(255,255,255,0.92);
        }

        .container {
            width: 95%;
            max-width: 1300px;
            margin: auto;
            padding: 30px 0 40px;
        }

        h1 {
            color: #0056b3;
            margin-bottom: 5px;
        }

        .subtitle {
            color: #555;
            margin-bottom: 30px;
            font-size: 16px;
        }

        /* Summary cards */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .card {
            background: #007bff;
            color: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .card h2 {
            margin: 0;
            font-size: 36px;
        }

        .card p {
            margin-top: 10px;
            font-size: 16px;
            opacity: 0.9;
        }

        /* Action buttons */
        .actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .action-btn {
            background: #ffffff;
            border: 2px solid #007bff;
            color: #007bff;
            padding: 20px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.3s;
            text-align: center;
            text-decoration: none;
        }

        .action-btn:hover {
            background: #007bff;
            color: #ffffff;
            transform: translateY(-3px);
        }

        /* Sections */
        .section {
            background: #ffffff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
            margin-bottom: 30px;
        }

        .section h3 {
            margin-bottom: 20px;
            color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #007bff;
            color: #fff;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .status-pending {
            color: #e67e22;
            font-weight: bold;
        }

        .status-completed {
            color: #27ae60;
            font-weight: bold;
        }
    </style>
</head>

<body>
<div class="overlay">

    <!-- TOPBAR -->
    <?php include("topbar.php"); ?>

    <div class="container">

        <h1>Receptionist Dashboard</h1>
        <p class="subtitle">
            Welcome, <?php echo $_SESSION['full_name']; ?> | Hospital Front Desk Control Panel
        </p>

        <!-- SUMMARY CARDS -->
        <div class="cards">
            <div class="card">
                <h2>2</h2>
                <p>Patients Registered Today</p>
            </div>
            <div class="card">
                <h2>2</h2>
                <p>Appointments Today</p>
            </div>
            <div class="card">
                <h2>1</h2>
                <p>Pending Lab Requests</p>
            </div>
            <div class="card">
                <h2>1</h2>
                <p>Pending Bills</p>
            </div>
        </div>

<!-- REAL WORKING ACTION LINKS -->
<div class="actions">
    <a href="register_patient.php" class="action-btn">➕ Register New Patient</a>
    <a href="schedule_appointment.php" class="action-btn">📅 Schedule Appointment</a>
    <a href="lab_request.php" class="action-btn">🔬 Request Lab Test</a>
    <a href="billing.php" class="action-btn">💳 Create Billing</a>
    <a href="discharge.php" class="action-btn">📤 Discharge Patient</a>
    <a href="../reports/generate_receptionist.php" class="action-btn">📄 Generate Reports</a>
</div>


        <!-- TODAY'S APPOINTMENTS -->
        <div class="section">
            <h3>Today's Appointments</h3>
            <table>
                <tr>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td>Peter Kamau</td>
                    <td>Dr. John Mwangi</td>
                    <td><?php echo date("Y-m-d"); ?></td>
                    <td class="status-pending">Scheduled</td>
                </tr>
                <tr>
                    <td>Jane Wanjiku</td>
                    <td>Dr. Alice Njeri</td>
                    <td><?php echo date("Y-m-d"); ?></td>
                    <td class="status-completed">Completed</td>
                </tr>
            </table>
        </div>

        <!-- LAB REQUESTS -->
        <div class="section">
            <h3>Pending Lab Requests</h3>
            <table>
                <tr>
                    <th>Patient</th>
                    <th>Test</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td>Peter Kamau</td>
                    <td>Blood Test</td>
                    <td class="status-pending">Pending</td>
                </tr>
            </table>
        </div>

    </div>
</div>
</body>
</html>
