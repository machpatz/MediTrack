<?php
// topbar.php
?>

<div style="
    width:100%;
    background:#0056b3;
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 5px 15px rgba(0,0,0,0.15);
">

    <!-- Left: System Name -->
    <div style="color:#fff; font-size:22px; font-weight:700;">
        MediTrack HMS
    </div>

    <!-- Right: Status + User -->
    <div style="display:flex; align-items:center; gap:20px;">

        <!-- ONLINE BUTTON -->
        <form method="POST" action="../auth/logout.php" style="margin:0;">
            <button type="submit" style="
                background:#28a745;
                color:#fff;
                border:none;
                padding:10px 18px;
                border-radius:25px;
                font-size:15px;
                font-weight:600;
                cursor:pointer;
                display:flex;
                align-items:center;
                gap:8px;
                transition:0.3s;
            "
            onmouseover="this.style.background='#218838';"
            onmouseout="this.style.background='#28a745';">
                🟢 Admin Online | Logout
            </button>
        </form>

        <!-- User Name -->
        <div style="color:#fff; font-size:15px;">
            <?php echo $_SESSION['full_name']; ?>
        </div>

    </div>
</div>
