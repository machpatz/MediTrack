<?php
include("config/db.php");

// Live stats
$total_patients = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as total FROM patients"))['total'];
$total_doctors = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as total FROM doctors"))['total'];
$total_appointments = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as total FROM appointments"))['total'];
$total_lab_requests = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as total FROM lab_requests"))['total'];
?>

<?php include("includes/header.php"); ?>

<!-- Hero Section -->
<div class="hero" style="
    width:100%;
    min-height:700px;
    display:flex;
    align-items:center;
    justify-content:center;
    background: url('assets/img/2.jpg') no-repeat center center/cover;
    position:relative;
">
    <div style="
        position:absolute;
        top:0; left:0; width:100%; height:100%;
        background: rgba(0,0,0,0.65);
    "></div>
    <div style="position:relative; color:#fff; text-align:center; max-width:1000px; padding:0 30px;">
        <h1 style="font-size:60px; font-weight:700; margin-bottom:20px;">About MediTrack Hospital</h1>
        <p style="font-size:22px; line-height:1.8; margin-bottom:30px;">
            MediTrack Hospital has been a beacon of medical excellence, community service, and innovation in healthcare 
            for over a decade. From its inception, our hospital has aimed to transform the healthcare experience 
            through technology, compassion, and dedication to patient well-being.
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
</div>

<!-- Our Story & History -->
<section style="max-width:1200px; margin:80px auto; padding:0 20px; text-align:justify;">
    <h2 style="color:#007bff; font-size:42px; text-align:center; margin-bottom:40px;">Our Story & History</h2>

    <p style="font-size:18px; color:#555; line-height:1.8;">
        MediTrack Hospital was founded in 2012 by a team of visionary healthcare professionals committed to 
        bridging the gap between quality medical care and technology-driven management. Initially starting 
        as a small 20-bed clinic in central Nairobi, we recognized the need for a structured, patient-centered 
        system that would reduce administrative burdens while enhancing medical outcomes. Over the years, 
        MediTrack evolved into a modern hospital with multiple specialized departments, state-of-the-art labs, 
        surgical theaters, and advanced outpatient facilities.
    </p>

    <p style="font-size:18px; color:#555; line-height:1.8;">
        Throughout our journey, we have continually drawn inspiration from globally acclaimed hospitals such as 
        <a href="https://www.mayoclinic.org/" target="_blank" style="color:#007bff;">Mayo Clinic</a>, 
        <a href="https://www.hopkinsmedicine.org/" target="_blank" style="color:#007bff;">Johns Hopkins Medicine</a>, 
        and <a href="https://www.clevelandclinic.org/" target="_blank" style="color:#007bff;">Cleveland Clinic</a>. 
        Adapting their best practices to our local context, MediTrack implemented modern clinical workflows, 
        integrated patient information systems, and a holistic approach to healthcare.
    </p>

    <p style="font-size:18px; color:#555; line-height:1.8;">
        From 2012 to 2015, the hospital expanded its facilities to include an advanced diagnostic center, 
        outpatient clinics, and a dedicated emergency wing. By 2016, we had introduced our proprietary 
        MediTrack Hospital Information System, streamlining appointments, patient records, lab results, 
        billing, and discharge management. This innovation allowed our medical staff to devote more time 
        to patient care rather than administrative duties, greatly improving efficiency and satisfaction.
    </p>

    <p style="font-size:18px; color:#555; line-height:1.8;">
        Between 2017 and 2020, MediTrack broadened its reach by opening community health initiatives, 
        preventive care programs, and mobile clinics that serviced underserved regions of Nairobi and surrounding counties. 
        Our focus on holistic healthcare and patient education has allowed thousands of individuals to make 
        informed health decisions, reduce chronic disease risks, and improve overall community wellness.
    </p>

    <p style="font-size:18px; color:#555; line-height:1.8;">
        During the COVID-19 pandemic, MediTrack played a pivotal role in patient management and public health education. 
        Our hospital conducted over 50,000 consultations, implemented strict infection control protocols, 
        and supported government-led vaccination campaigns. These efforts highlighted our dedication to 
        patient safety, operational excellence, and community responsibility.
    </p>
</section>

<!-- Mission & Vision -->
<section style="max-width:1200px; margin:80px auto; padding:0 20px; text-align:justify;">
    <h2 style="color:#007bff; font-size:42px; text-align:center; margin-bottom:40px;">Mission, Vision & Values</h2>

    <p style="font-size:18px; color:#555; line-height:1.8;">
        <strong>Mission:</strong> Our mission is to deliver high-quality, patient-centered healthcare by integrating 
        modern technology with compassionate care. We aim to streamline hospital operations, enhance patient experience, 
        and ensure efficient service delivery through our comprehensive hospital information system.
    </p>

    <p style="font-size:18px; color:#555; line-height:1.8;">
        <strong>Vision:</strong> MediTrack aspires to be a leading healthcare institution recognized for excellence, 
        innovation, ethical standards, and community engagement. We envision a healthcare ecosystem where patient outcomes 
        are maximized, preventive care is emphasized, and technology enables seamless medical services.
    </p>

    <p style="font-size:18px; color:#555; line-height:1.8;">
        <strong>Core Values:</strong> Compassion, Integrity, Innovation, Excellence, and Accountability guide every aspect 
        of our hospital operations. From patient interactions to administrative decisions, these principles shape our culture 
        and service delivery.
    </p>
</section>

<!-- Departments & Specialties -->
<section style="max-width:1200px; margin:80px auto; padding:0 20px; text-align:justify;">
    <h2 style="color:#007bff; font-size:42px; text-align:center; margin-bottom:40px;">Departments & Specialties</h2>

    <p style="font-size:18px; color:#555; line-height:1.8;">
        MediTrack Hospital offers comprehensive care through multiple specialized departments, each staffed with 
        experienced professionals and equipped with cutting-edge technology. These include:
    </p>

    <ul style="font-size:18px; color:#555; line-height:1.8; margin-left:20px;">
        <li><strong>Cardiology:</strong> Advanced cardiac care including diagnostics, catheterization, and rehabilitation.</li>
        <li><strong>Neurology:</strong> Comprehensive neurological assessments, stroke care, and epilepsy management.</li>
        <li><strong>Pediatrics:</strong> Preventive and curative care for children, vaccination programs, and growth monitoring.</li>
        <li><strong>Obstetrics & Gynecology:</strong> Maternal care, safe deliveries, fertility support, and women’s health programs.</li>
        <li><strong>Orthopedics:</strong> Fracture management, joint replacement, and physiotherapy services.</li>
        <li><strong>Oncology:</strong> Cancer diagnostics, chemotherapy, radiotherapy, and palliative care.</li>
        <li><strong>ENT & Ophthalmology:</strong> Hearing and vision care, minor surgeries, and specialized treatments.</li>
        <li><strong>Radiology & Imaging:</strong> MRI, CT scans, X-rays, and ultrasound services with rapid reporting.</li>
        <li><strong>Laboratory Services:</strong> Full-service diagnostic labs offering blood tests, microbiology, and pathology.</li>
        <li><strong>Emergency & Trauma:</strong> 24/7 emergency care with trained trauma specialists and intensive care units.</li>
    </ul>
</section>

<!-- Patient-Centered Care -->
<section style="max-width:1200px; margin:80px auto; padding:0 20px; text-align:justify;">
    <h2 style="color:#007bff; font-size:42px; text-align:center; margin-bottom:40px;">Patient-Centered Care</h2>

    <p style="font-size:18px; color:#555; line-height:1.8;">
        MediTrack Hospital places patients at the center of all decision-making. Our healthcare approach focuses not only 
        on treating illness but also on prevention, education, and long-term wellness. Every patient receives an 
        individualized care plan that considers medical history, lifestyle, and personal preferences.  
    </p>

    <p style="font-size:18px; color:#555; line-height:1.8;">
        The hospital also emphasizes emotional support for patients and their families. Our social workers, counselors, 
        and patient advocates ensure that families are informed, comfortable, and engaged in the care process.  
    </p>

    <p style="font-size:18px; color:#555; line-height:1.8;">
        MediTrack integrates innovative technology, including electronic medical records, telemedicine, and automated 
        lab reporting, to provide accurate and timely information for both medical staff and patients. This reduces 
        errors, improves efficiency, and enhances trust in our services.
    </p>
</section>

<!-- Community Outreach & Research -->
<section style="max-width:1200px; margin:80px auto; padding:0 20px; text-align:justify;">
    <h2 style="color:#007bff; font-size:42px; text-align:center; margin-bottom:40px;">Community Outreach & Research</h2>

    <p style="font-size:18px; color:#555; line-height:1.8;">
        MediTrack Hospital actively engages in community wellness programs. We conduct regular health camps, vaccination drives, 
        and public education campaigns in collaboration with the <a href="https://www.who.int/" target="_blank" style="color:#007bff;">World Health Organization</a> 
        and local NGOs. Over 100,000 community members have benefited from our outreach programs in the last five years.
    </p>

    <p style="font-size:18px; color:#555; line-height:1.8;">
        Our research initiatives focus on improving healthcare outcomes, integrating technology, and promoting preventive care. 
        Doctors and specialists at MediTrack contribute to national health policies, medical journals, and international conferences, 
        ensuring that our practices align with global standards.
    </p>
</section>

<!-- Achievements & Milestones -->
<section style="max-width:1200px; margin:80px auto; padding:0 20px; text-align:justify;">
    <h2 style="color:#007bff; font-size:42px; text-align:center; margin-bottom:40px;">Achievements & Milestones</h2>

    <ul style="font-size:18px; color:#555; line-height:1.8; margin-left:20px;">
        <li>2015 – Recognized as one of the top five hospitals in Nairobi for outpatient services.</li>
        <li>2016 – Implemented Kenya’s first fully integrated Hospital Information System.</li>
        <li>2017 – Expanded pediatric and maternity wards, increasing capacity by 40%.</li>
        <li>2018 – Accredited by the Kenyan Medical Practitioners Board for patient safety excellence.</li>
        <li>2019 – Achieved zero safety incidents during the management of over 50,000 COVID-19 consultations.</li>
        <li>2020 – Partnered with WHO for regional health awareness campaigns.</li>
        <li>2021 – Won the Healthcare Innovation Award for technology integration in patient care.</li>
        <li>2022 – Expanded research collaborations with global institutions including Mayo Clinic, Johns Hopkins, and Cleveland Clinic.</li>
    </ul>

    <div style="text-align:center; margin-top:40px;">
        <a href="auth/login.php" style="
            display:inline-block;
            padding:15px 35px;
            background:#007bff;
            color:#fff;
            text-decoration:none;
            font-weight:bold;
            border-radius:8px;
            transition:0.3s;
        " onmouseover="this.style.background='#0056b3'" onmouseout="this.style.background='#007bff'">Login to Access Dashboard</a>
    </div>
</section>

<!-- Stats Section -->
<div class="stats" style="
    display:flex;
    justify-content:center;
    max-width:1200px;
    margin:60px auto;
    flex-wrap:wrap;
    gap:25px;
">
    <div class="card" style="flex:1 1 200px; background:#fff; padding:30px; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.1); text-align:center;">
        <h3 style="font-size:38px; color:#007bff; margin-bottom:12px;"><?php echo $total_patients; ?></h3>
        <p>Total Patients</p>
    </div>
    <div class="card" style="flex:1 1 200px; background:#fff; padding:30px; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.1); text-align:center;">
        <h3 style="font-size:38px; color:#007bff; margin-bottom:12px;"><?php echo $total_doctors; ?></h3>
        <p>Total Doctors</p>
    </div>
    <div class="card" style="flex:1 1 200px; background:#fff; padding:30px; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.1); text-align:center;">
        <h3 style="font-size:38px; color:#007bff; margin-bottom:12px;"><?php echo $total_appointments; ?></h3>
        <p>Appointments</p>
    </div>
    <div class="card" style="flex:1 1 200px; background:#fff; padding:30px; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.1); text-align:center;">
        <h3 style="font-size:38px; color:#007bff; margin-bottom:12px;"><?php echo $total_lab_requests; ?></h3>
        <p>Lab Requests</p>
    </div>
</div>

<?php include("includes/footer.php"); ?>
