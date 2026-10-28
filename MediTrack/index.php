<?php
include("config/db.php");

// Live stats
$total_patients = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as total FROM patients"))['total'];
$total_doctors = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as total FROM doctors"))['total'];
$total_appointments = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as total FROM appointments"))['total'];
$total_lab_requests = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as total FROM lab_requests"))['total'];
?>

<?php include("includes/header.php"); ?>

<!-- Hero Section (Image Only) -->
<div class="hero" style="
    width:100%;
    min-height:600px;
    background: url('assets/img/101.jpg') no-repeat center center/cover;
    margin-top:20px;
">
</div>

<!-- Welcome Text Section (Centered, below hero) -->
<div style="
    max-width:1000px;
    margin:40px auto;
    text-align:center;
    padding:20px;
    color:#007bff; /* blue text */
">
    <h1 style="font-size:50px; font-weight:700; margin-bottom:20px;">Welcome to MediTrack Hospital</h1>
    <p style="font-size:22px; line-height:1.8; margin-bottom:30px;">
        Improving Access to Quality Healthcare for Over a Decade. At MediTrack Hospital, we are committed to delivering integrated healthcare with modern technology, compassionate care, and a holistic approach to wellness.
    </p>
    <a href="auth/login.php" style="
        display:inline-block;
        padding:15px 35px;
        background:#007bff;
        color:#fff;
        text-decoration:none;
        font-weight:700;
        border-radius:8px;
        transition:0.3s;
    " onmouseover="this.style.background='#0056b3'" onmouseout="this.style.background='#007bff'">Login to Explore</a>
</div>

<!-- Live Stats Section -->
<div class="stats" style="display:flex; justify-content:space-around; max-width:1200px; margin:60px auto; flex-wrap:wrap; gap:20px;">
    <div class="card" style="flex:1 1 200px; background:#fff; padding:25px; border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.1); text-align:center;">
        <h3 style="font-size:36px; color:#007bff; margin-bottom:10px;"><?php echo $total_patients; ?></h3>
        <p>Total Patients</p>
    </div>
    <div class="card" style="flex:1 1 200px; background:#fff; padding:25px; border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.1); text-align:center;">
        <h3 style="font-size:36px; color:#007bff; margin-bottom:10px;"><?php echo $total_doctors; ?></h3>
        <p>Total Doctors</p>
    </div>
    <div class="card" style="flex:1 1 200px; background:#fff; padding:25px; border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.1); text-align:center;">
        <h3 style="font-size:36px; color:#007bff; margin-bottom:10px;"><?php echo $total_appointments; ?></h3>
        <p>Appointments</p>
    </div>
    <div class="card" style="flex:1 1 200px; background:#fff; padding:25px; border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.1); text-align:center;">
        <h3 style="font-size:36px; color:#007bff; margin-bottom:10px;"><?php echo $total_lab_requests; ?></h3>
        <p>Lab Requests</p>
    </div>
</div>

<!-- Example Hospitals Section -->
<section style="max-width:1200px; margin:60px auto; padding:0 20px; text-align:center;">
    <h2 style="color:#007bff; font-size:36px; margin-bottom:40px;">Our Partner Hospitals</h2>
    <div style="display:flex; flex-wrap:wrap; gap:20px; justify-content:center;">

        <?php
        $hospitals = [
            ['name'=>'MediTrack Nairobi', 'desc'=>'Comprehensive care and emergency services.', 'img'=>'assets/img/10.jpg'],
            ['name'=>'MediTrack Mombasa', 'desc'=>'Specialized in cardiology and surgery.', 'img'=>'assets/img/11.jpg'],
            ['name'=>'MediTrack Kisumu', 'desc'=>'Advanced maternal and child health services.', 'img'=>'assets/img/12.jpg'],
            ['name'=>'MediTrack Eldoret', 'desc'=>'State-of-the-art diagnostic and lab facilities.', 'img'=>'assets/img/13.jpg'],
            ['name'=>'MediTrack Nakuru', 'desc'=>'Focus on outpatient and preventive care.', 'img'=>'assets/img/14.jpg'],
            ['name'=>'MediTrack Thika', 'desc'=>'Modern surgical and specialty clinics.', 'img'=>'assets/img/15.jpg'],
            ['name'=>'MediTrack Kitale', 'desc'=>'Holistic family medicine and pediatrics.', 'img'=>'assets/img/16.jpg'],
            ['name'=>'MediTrack Machakos', 'desc'=>'Integrated laboratory and imaging services.', 'img'=>'assets/img/17.jpg'],
        ];

        foreach($hospitals as $hospital){
            echo '<div style="
                flex:1 1 250px; 
                background:#fff; 
                border-radius:15px; 
                overflow:hidden; 
                box-shadow:0 10px 25px rgba(0,0,0,0.1); 
                transition:0.3s;
                cursor:pointer;
            " onmouseover="this.style.transform=\'translateY(-8px) scale(1.03)\'; this.style.boxShadow=\'0 15px 35px rgba(0,0,0,0.2)\';" onmouseout="this.style.transform=\'translateY(0) scale(1)\'; this.style.boxShadow=\'0 10px 25px rgba(0,0,0,0.1)\';">
                <img src="'.$hospital['img'].'" alt="'.$hospital['name'].'" style="width:100%; height:180px; object-fit:cover;">
                <div style="padding:15px;">
                    <h3 style="color:#007bff; font-size:22px; margin-bottom:10px;">'.$hospital['name'].'</h3>
                    <p style="font-size:16px; color:#555;">'.$hospital['desc'].'</p>
                </div>
            </div>';
        }
        ?>

    </div>
</section>

<!-- Contact Section -->
<section id="contact" style="max-width:1000px; margin:60px auto; padding:0 20px; text-align:center;">
    <h2 style="color:#007bff; font-size:36px; margin-bottom:20px;">Contact Us</h2>
    <p style="font-size:18px; color:#555; line-height:1.8;">
        Phone: <a href="auth/login.php" style="color:#007bff;">079-483-9492</a> | 
        Email: <a href="auth/login.php" style="color:#007bff;">info@meditrack.com</a> | 
        Address: <a href="auth/login.php" style="color:#007bff;">123 Health Avenue, Nairobi, Kenya</a>
    </p>
    <a href="auth/login.php" style="
        display:inline-block;
        margin-top:20px;
        padding:12px 25px;
        background:#007bff;
        color:#fff;
        text-decoration:none;
        border-radius:5px;
        font-weight:bold;
        transition:0.3s;
    " onmouseover="this.style.background='#0056b3'" onmouseout="this.style.background='#007bff'">Login to Contact Us</a>
</section>

<?php include("includes/footer.php"); ?>
