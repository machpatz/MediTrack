<?php
session_start();
include("../config/db.php");

/* Restrict access to receptionist only */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'receptionist') {
    header("Location: ../auth/login.php");
    exit;
}

/* Fetch patients */
$patients = mysqli_query($conn, "SELECT patient_id, full_name FROM patients");

/* Fetch doctors */
$doctors = mysqli_query($conn, "SELECT doctor_id, full_name FROM doctors");

/* Handle appointment scheduling */
if (isset($_POST['schedule'])) {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $status = "Scheduled";

    $sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, status)
            VALUES ('$patient_id', '$doctor_id', '$appointment_date', '$status')";

    if (mysqli_query($conn, $sql)) {
        $success = "Appointment scheduled successfully.";
    } else {
        $error = "Failed to schedule appointment.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule Appointment | MediTrack HMS</title>

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: url("../assets/img/111.jpg") no-repeat center center fixed;
            background-size: cover;
        }

        .overlay {
            min-height: 100vh;
            background: rgba(255,255,255,0.92);
        }

        .container {
            width: 95%;
            max-width: 900px;
            margin: auto;
            padding: 40px 0;
        }

        h1 {
            color: #0056b3;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #555;
            margin-bottom: 25px;
        }

        .card {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }

        label {
            font-weight: 600;
            display: block;
            margin-top: 15px;
            color: #333;
        }

        select, input {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        .btn {
            margin-top: 25px;
            background: #007bff;
            color: #fff;
            border: none;
            padding: 14px;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
        }

        .btn:hover {
            background: #0056b3;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            font-weight: 600;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
<div class="overlay">

    <!-- TOP BAR -->
    <?php include("topbar.php"); ?>

    <div class="container">

        <h1>Schedule Appointment</h1>
        <p class="subtitle">Assign Patient to Doctor</p>

        <div class="card">

            <?php if (isset($success)) echo "<div class='success'>$success</div>"; ?>
            <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

            <form method="POST">

                <label>Select Patient</label>
                <select name="patient_id" required>
                    <option value="">-- Select Patient --</option>
                    <?php while ($p = mysqli_fetch_assoc($patients)) { ?>
                        <option value="<?php echo $p['patient_id']; ?>">
                            <?php echo $p['full_name']; ?>
                        </option>
                    <?php } ?>
                </select>

                <label>Select Doctor</label>
                <select name="doctor_id" required>
                    <option value="">-- Select Doctor --</option>
                    <?php while ($d = mysqli_fetch_assoc($doctors)) { ?>
                        <option value="<?php echo $d['doctor_id']; ?>">
                            <?php echo $d['full_name']; ?>
                        </option>
                    <?php } ?>
                </select>

                <label>Appointment Date</label>
                <input type="date" name="appointment_date" required>

                <button type="submit" name="schedule" class="btn">
                    Schedule Appointment
                </button>
            </form>

            <a href="dashboard.php" class="back-link">← Back to Receptionist Dashboard</a>
        </div>

    </div>
</div>
</body>
</html>
