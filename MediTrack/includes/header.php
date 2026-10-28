<?php
// No direct DB queries needed here, just for navbar links redirecting to login
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MediTrack HMS</title>
    <link rel="stylesheet" href="/MediTrack/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Roboto', sans-serif; min-height:100vh; display:flex; flex-direction:column; background:#f4f9ff; }

        .navbar {
            background:#007bff;
            color:#fff;
            padding:15px 50px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            position:sticky;
            top:0;
            z-index:1000;
            box-shadow:0 3px 6px rgba(0,0,0,0.1);
        }
        .navbar h2{ font-size:28px; font-weight:700; }
        .navbar ul { list-style:none; display:flex; gap:20px; flex-wrap:wrap; }
        .navbar ul li a { color:#fff; text-decoration:none; padding:8px 15px; border-radius:5px; font-weight:500; transition:0.3s; }
        .navbar ul li a:hover { background:#fff; color:#007bff; }

        .footer {
            background:#007bff;
            color:#fff;
            text-align:center;
            padding:25px 15px;
            margin-top:auto;
            font-size:14px;
            box-shadow:0 -3px 6px rgba(0,0,0,0.1);
        }

        @media(max-width:768px){
            .navbar{ padding:15px 20px; }
            .navbar ul{ flex-direction: column; gap:10px; margin-top:10px; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>MediTrack HMS</h2>
        <ul>
            <li><a href="/MediTrack/index.php">Home</a></li>
            <li><a href="/MediTrack/about.php">About Us</a></li>
            <li><a href="/MediTrack/contact.php">Contact</a></li>
            <li><a href="/MediTrack/auth/login.php">Log in</a></li>
        </ul>
    </div>
