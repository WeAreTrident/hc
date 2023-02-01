<?php  

include("includes/header.php");

if ($user['user_role'] == "Professional")
    include("professional-dashboard.php");

elseif($user['user_role'] == "CQC")
    include("cqc-dashboard.php");

elseif ($user['user_role'] == "Provider")
    // Group A Management
    include("provider-dashboard.php");

elseif($user['user_role'] == "Management")
    include("group-b.php");

elseif($user['user_role'] == "Staff")
    include("care-staff-dashboard.php");

// elseif($user['user_role'] == "Corporation")
//     include("corporation-dashboard.php");

// elseif($user['user_role'] == "Service User")
//     include("service-user-dashboard.php");

else
    header("Location: includes/handlers/logout.php");

include("includes/footer.php");

?>