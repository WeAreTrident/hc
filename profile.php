<?php 

    include("includes/header.php");
    include("includes/classes/Eprsections.php");    
    require_once 'includes/form_handlers/add_condition.php';
    require_once 'includes/form_handlers/add_prescription.php';    
    require_once 'includes/form_handlers/add_section17.php';

    $epr_obj = new EPRSections($con, $userLoggedIn);

    if (isset($_POST['submit_note'])) {
        $patient = $_POST['patient'];
        $posted_by = $_POST['posted_by'];
        $note = $_POST['notes'];
        $date_time = date("Y-m-d H:i:s");
        $note_category = $_POST['note_category'];

        mysqli_query($con, "INSERT INTO daily_record VALUES ('','$patient','$posted_by','$note_category','$date_time','$note')") or die(mysqli_error($con));
        header("Location: $patient");

    }

    if (isset($_POST['section17_note_submit'])) {
        $leave_id = $_POST['section17_leave_id'];
        $date_added = date("Y-m-d H:i:s");
        $added_by = $_POST['posted_by'];
        $note = $_POST['section17_note'];

        mysqli_query($con, "INSERT INTO section17_notes VALUES ('', '$leave_id', '$date_added', '$added_by', '$note', 'Section 17')");
        header("Location: $patient");
    }

    if (isset($_POST['submit_body_map_note'])) {
        $name = $_POST['name'];
        $injury = $_POST['injury'];
        $created_by = $_POST['created_by'];
        $description = $_POST['description'];
        $x = $_POST['x'];
        $y = $_POST['y'];
        $id = $_POST['id'];
        $frontBack = $_POST['frontBack'];
        $date_time_now = date("Y-m-d H:i:s");

        $query = "INSERT INTO body (name, injury, created_by, description, x, y, front_back, date_time) VALUES ('$name', '$injury', '$created_by', '$description', '$x', '$y', '$frontBack', '$date_time_now')";
            if (mysqli_query($con, $query)) {
            // echo "New record has been added successfully !";
            } else {
            // echo "Error: " . $query . ":-" . mysqli_error($conn);
            }
        
    }

    if (isset($_POST['post'])) {

        $uploadOk = 1;
        $imageName = $_FILES['fileToUpload']['name'];
        $errorMessage = "";
        
        if($imageName != "") {
          $targetDir = "assets/images/posts/";
          $imageName = $targetDir . uniqid() . basename($imageName);
          $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);
        
          if($_FILES['fileToUpload']['size'] > 10000000) {
            $errorMessage = "Sorry, your file is too large.";
            $uploadOk = 0;
          }
        
          if(strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg") {
            $errorMessage = "Sorry, only jpeg, jpg and png files are allowed.";
            $uploadOk = 0;
          }
        
          if($uploadOk) {
            if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)) {
              // image uploaded ok
            }
            else {
              // image did not upload
              $uploadOk = 0;
            }
          }
        }
        
        if($uploadOk) {
          $post = new Post($con, $userLoggedIn);

          $post->submitPost($_POST['post_text'], $_POST['user_to']);
        }
        else {
          echo "<div style='text-align:center;' class='alert alert-danger'>
          $errorMessage
          </div>";
        }
    }

    if (isset($_GET['profile_username'])) {
        $username = $_GET['profile_username'];
        $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
        $user_array = mysqli_fetch_array($user_details_query);

        $num_friends = substr_count($user_array['friend_array'], ",") - 1;
    }

    if (isset($_POST['remove_friend'])) {
        $user = new User($con, $userLoggedIn); 
        $user->removeFriend($username);
    }

    if (isset($_POST['add_friend'])) {
        $user = new User($con, $userLoggedIn);
        $user->sendRequest($username);
    }

    if (isset($_POST['respond_request'])) {
        header("Location: requests.php");
    }

    if (isset($_POST['post_message'])) {
        if (isset($_POST['message_body'])) {
            $body = mysqli_real_escape_string($con, $_POST['message_body']);
            $date = date("Y-m-d H:i:s");
            $message_obj = new Message($con, $userLoggedIn);
            $message_obj->sendMessage($username, $body, $date);
        }

        $link = 'profileTabs a[href="messages_div"]';
        echo "<script>
            $(function() {
                $('" . $link ."').tab('show');
            });
            </script>";
    }

    $joined_date = date("F Y", strtotime($user_array['signup_date']));

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="profile-page-banner" style="background-image: url('<?php echo $user_array['cover_pic']; ?>');"> </div>
<div class="banner-profile-blur">
    <div class="user_details_banner container">
        <div class="user_details_profile_img_position"> <img class="user_details_profile_img" src="<?php echo $user_array['profile_pic']; ?>">
            <br /> 
        </div>
        <div class="user_details_title">
            <h1><?php echo $user_array['first_name'] . " " . $user_array['last_name']; ?></h1>
            <!-- <p class="job-title-profile">< ?php echo $user_array['field_of_work']; ?></p> -->
            <p class="job-title-profile-banner">
                <?php echo $user_array['profession'] = $user_array['profession'] ? $user_array['profession'] : ''; ?>
            </p>
            <div class="icon-count">
                <p class="friends-count"><i class="fas fa-user-friends"></i> Connections: <strong><?php echo $num_friends; ?></strong></p>
                <?php 
                    $logged_in_user_obj = new User($con, $userLoggedIn);
                    if ($userLoggedIn != $username) {
                        echo "<p><i class='fas fa-user-plus'></i>Mutual Connections: " . $logged_in_user_obj->getMutualFriends($username) . " </p>";
                    }
                    $rating = $user_obj->getRating($username);
                ?>
                <p><i class='fas fa-calendar'></i> Joined <strong><?php echo $joined_date; ?></strong></p>
                <p><i class="fas fa-user"></i> @<strong><?php echo $username; ?></strong></p>
            </div>
        </div>
    </div>
</div>
    
<div class="container">
    <div class="call_to_action_profile_button">
        <form action="<?php echo $username; ?>" method="POST">
            <?php
                    $profile_user_obj = new User($con, $username);
                    if ($profile_user_obj->isClosed()) {
                        header("Location: user_closed.php");
                    }

                    if ($userLoggedIn != $username) {

                        if ($logged_in_user_obj->isFriend($username)) {
                            echo '<button type="submit" name="remove_friend" class="cta main-button">Remove Connection</button><br />';
                        }
                        elseif ($logged_in_user_obj->didReceiveRequest($username)) {
                            echo '<button type="submit" name="respond_request" class="cta main-button">Respond to Request</button><br />';
                        }
                        elseif ($logged_in_user_obj->didSendRequest($username)) {
                            echo '<button type="submit" name="" class="cta main-button">Request Sent</button><br />';
                        }
                        else {
                            echo '<button type="submit" name="add_friend" class="cta main-button">Make Connection</button><br />';                 
                        }
                    }

                ?>
        </form> 
        <a class="cta main-button" href="messages.php?u=<?php echo $username; ?>">Message</a>
        <?php

        if ($user_array['user_role'] == "Service User")  {

        ?>
        <a class="cta main-button" href="refer.php?u=<?php echo $username; ?>" data-bs-toggle="modal" data-bs-target="#referPatientModal">Refer Patient</a>
        <a class="cta main-button" href="share-epr.php?u=<?php echo $username; ?>" data-bs-toggle="modal" data-bs-target="#shareEPRModal">Share EPR</a>


        <!-- Modal -->
        <div class="modal fade" id="referPatientModal" tabindex="-1" aria-labelledby="referPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="referPatientModalLabel">Refer Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                 <form method="POST" action="" class="refer-form">
                    <input type="text" name="refer_with_username" placeholder="Who would you like to refer to?" class="refer-form">
                    <textarea name="post_text" placeholder="Please enter notes:" class="input textarea-field-profile"></textarea>
                    <input type="hidden" name="referred_by" value="<?php echo $userLoggedIn; ?>">
            </div>
            <div class="modal-footer">
                    <button type="submit" name="submit_patient_referral" type="submit" class="main-button">Refer Patient</button>
                    </form>
                <button type="button" class="main-button" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="shareEPRModal" tabindex="-1" aria-labelledby="shareEPRModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareEPRModalLabel">Share EPR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                 <form method="POST" action="" class="share-form">
                    <input type="text" name="refer_with_username" placeholder="Who would you like to share with?" >
                    <textarea name="post_text" class="input textarea-field-profile" placeholder="Please enter notes:"></textarea>
                    <input type="hidden" name="shared_by" value="<?php echo $userLoggedIn; ?>" class="share-form">
            </div>
            <div class="modal-footer">
                    <button type="submit" name="submit_patient_referral" type="submit" class="main-button">Share EPR</button>
                    </form>
                <button type="button" class="main-button" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>        


        <?php

        }

        ?>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="news-feed-about-feed">
                <ul class="nav tab-menu-profile" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="button-4 active" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="false">About</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="button-4" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab" aria-controls="notes" aria-selected="false">EPR</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="button-4 " id="news-tab" data-bs-toggle="tab" data-bs-target="#news" type="button" role="tab" aria-controls="news" aria-selected="true">
                            <?php echo $user_array['first_name'] . " " . $user_array['last_name'];  ?>'s Posts</button>
                    </li>
                    <!--<li class="nav-item" role="presentation">
                            <button class="button-4 " id="articles-tab" data-bs-toggle="tab" data-bs-target="#articles" type="button" role="tab" aria-controls="articles" aria-selected="true">Articles</button>
                            </li>
                            <li class="nav-item" role="presentation">
                            <button class="button-4 " id="marketplaces-tab" data-bs-toggle="tab" data-bs-target="#marketplaces" type="button" role="tab" aria-controls="marketplaces" aria-selected="true">Marketplace</button>
                            </li>-->
                </ul>
                <div class="profile_responses">
                    <div class="main_column column">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade" id="news" role="tabpanel" aria-labelledby="news-tab">
                                <div class="profile-post">
                                    <form class="post_form" action="" method="POST" enctype="multipart/form-data">
                                        <div class="textarea-wrapper">
                                            <textarea name="post_text" id="input22" class="input textarea-field-profile" rows="5" placeholder="Use @mentions to get someone's attention"></textarea>
                                            <input type="hidden" name="user_to" value="<?php echo $username; ?>">
                                        </div>
                                        <div id="users22" class="users">
                                            <ul class="list22"></ul>
                                        </div>
                                        <div class="align-input-field-profile">
                                            <div class='file-input'>
                                                <input type="file" name="fileToUpload" id="fileToUpload" /> <span class='button'>Choose</span> <span class='label' data-js-label>No file selected</label>
                                                </div>
                                                <script>
                                                    // Also see: https://www.quirksmode.org/dom/inputfile.html

                                                    var inputs = document.querySelectorAll('.file-input')

                                                    for (var i = 0, len = inputs.length; i < len; i++) {
                                                        customInput(inputs[i])
                                                    }

                                                    function customInput (el) {
                                                        const fileInput = el.querySelector('[type="file"]')
                                                        const label = el.querySelector('[data-js-label]')
                                                        
                                                        fileInput.onchange =
                                                        fileInput.onmouseout = function () {
                                                        if (!fileInput.value) return
                                                        
                                                        var value = fileInput.value.replace(/^.*[\\\/]/, '')
                                                        el.className += ' -chosen'
                                                        label.innerText = value
                                                        }
                                                    }
                                                </script>
                                                <button class="main-button" type="submit" name="post">Post</button>
                                            </div>
                                    </form>
                                </div>
                                <div class="posts_area"></div>
                                <div style="text-align: center;"><img src="assets/images/icons/loading.gif" id="loading" /></div>
                            </div>

                            <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="note-box">
                                            <div class="top-note">
                                                <h3 class="text-center">Add a note</h3>
                                            </div>
                                            <div class="body-note">
                                                <!--<img src="https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" style="width: 50px; height: 50px; border-radius: 100%;">
                                                <strong><a href="#" class="note-name">Name</a></strong>-->
                                                <form action="" method="POST" class="gen-form">
                                                <select name="note_category">
                                                    <option value="Daily Record" selected>Daily Record</option>
                                                    <option value="AHP">AHP</option>
                                                    <option value="Fitness Instructors">Fitness Instructors</option>
                                                    <option value="HCA">HCA</option>
                                                    <option value="Incidents">Incidents</option>
                                                    <option value="Medical">Medical</option>
                                                    <option value="Medication">Medication</option>
                                                    <option value="MHA">MHA</option>
                                                    <option value="Not for disclosure">Not for disclosure</option>
                                                    <option value="Nursing">Nursing</option>
                                                    <option value="Nutrition">Nutrition</option>
                                                    <option value="Observations">Observations</option>
                                                    <option value="Oral Health">Oral Health</option>
                                                    <option value="Physical Health">Physical Health</option>
                                                    <option value="Psychology">Psychology</option>
                                                    <option value="Risk">Risk</option>
                                                    <option value="Social Work">Social Work</option>
                                                    <option value="Substance Misuse">Substance Misuse</option>
                                                </select>
                                                
                                                <input type="textarea" id="note" name="notes" value="" placeholder="Write your note here...">
                                                <input type="hidden" name="posted_by" value="<?php echo $userLoggedIn; ?>">
                                                <input type="hidden" name="patient" value="<?php echo $username; ?>">
                                            </div>
                                            <div class="foot-note">
                                                <div class="row">
                                                    <div class="ft-point first"><i class="fa fa-plus" aria-hidden="true"></i> <a href="#">Document</a></div>
                                                    <div class="ft-point"><i class="fa fa-plus" aria-hidden="true"></i> <a href="#">Video</a></div>
                                                    <div class="ft-point"><i class="fa fa-plus" aria-hidden="true"></i> <a href="#">Image</a></div>
                                                    <div class="ft-point last"> <button type="submit" name="submit_note">Submit</button></div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <ul class="nav nav-pills flex-column" id="myTab2" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" role="tab" aria-controls="general" aria-selected="true">General Notes</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="careplans-tab" data-bs-toggle="tab" data-bs-target="#careplans" role="tab" aria-controls="careplans" aria-selected="true">Care Plans</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="initialassessment-tab" data-bs-toggle="tab" data-bs-target="#initialassessment" role="tab" aria-controls="initialassessment" aria-selected="true">Initial Assessment</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="mentalhealth-tab" data-bs-toggle="tab" data-bs-target="#mentalhealth" role="tab" aria-controls="mentalhealth" aria-selected="true">Mental Health Act</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="riskassessments-tab" data-bs-toggle="tab" data-bs-target="#riskassessments" role="tab" aria-controls="riskassessments" aria-selected="true">Risk Assessments</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="seclusion-tab" data-bs-toggle="tab" data-bs-target="#seclusion" role="tab" aria-controls="seclusion" aria-selected="true">Seclusion</a>
                                            </li>                                            
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="section17-tab" data-bs-toggle="tab" data-bs-target="#section17" role="tab" aria-controls="section17" aria-selected="true">Section 17</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="incidentrecords-tab" data-bs-toggle="tab" data-bs-target="#incidentrecords" role="tab" aria-controls="incidentrecords" aria-selected="true">Incident Records</a>
                                            </li>                                        
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="labtests-tab" data-bs-toggle="tab" data-bs-target="#labtests" role="tab" aria-controls="labtests" aria-selected="true">Lab Tests</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="imaging-tab" data-bs-toggle="tab" data-bs-target="#imaging" role="tab" aria-controls="imaging" aria-selected="true">Imaging</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="bodymap-tab" data-bs-toggle="tab" data-bs-target="#bodymap" role="tab" aria-controls="bodymap" aria-selected="true">Body Map</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="bodymap-tab" data-bs-toggle="tab" data-bs-target="#toothmap" role="tab" aria-controls="toothmap" aria-selected="true">Dental</a>
                                            </li>                                                                            
                                        </ul>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                                <div class="note-top">
                                                    <div class="row note-search-fields">
                                                        <div class="col-md-4">
                                                            <input type="text" id="search-general-notes" name="search-general-notes" placeholder="Search general notes...">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="note-filter">
                                                                <select name="note_category_filter">
                                                                    <option value="Daily Record" selected>Daily Record</option>
                                                                    <option value="AHP">AHP</option>
                                                                    <option value="Fitness Instructors">Fitness Instructors</option>
                                                                    <option value="HCA">HCA</option>
                                                                    <option value="Incidents">Incidents</option>
                                                                    <option value="Medical">Medical</option>
                                                                    <option value="Medication">Medication</option>
                                                                    <option value="MHA">MHA</option>
                                                                    <option value="Not for disclosure">Not for disclosure</option>
                                                                    <option value="Nursing">Nursing</option>
                                                                    <option value="Nutrition">Nutrition</option>
                                                                    <option value="Observations">Observations</option>
                                                                    <option value="Oral Health">Oral Health</option>
                                                                    <option value="Physical Health">Physical Health</option>
                                                                    <option value="Psychology">Psychology</option>
                                                                    <option value="Risk">Risk</option>
                                                                    <option value="Section 17">Section 17</option>
                                                                    <option value="Social Work">Social Work</option>
                                                                    <option value="Substance Misuse">Substance Misuse</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" id="sort-general-notes-date" name="sprt-general-notes-date" placeholder="Sort by date...">
                                                        </div>  
                                                    </div>
                                                </div>
                                                    <?php
//(SELECT posted_by, category, date_time, note_body FROM daily_record WHERE patient='ben_holmes' ORDER BY date_time DESC) UNION (SELECT id, patient_username, staff_username, date FROM section17 WHERE patient_username='ben_holmes' ORDER BY date DESC)
                                                    $query = mysqli_query($con, "(SELECT posted_by, category, date_time, note_body FROM daily_record WHERE patient='$username') UNION (SELECT section17_notes.added_by, section17_notes.category, section17_notes.date_time, section17_notes.note FROM section17, section17_notes WHERE section17.patient_username='$username' AND section17.id=section17_notes.leave_id) ORDER BY date_time DESC") or die(mysqli_error($con));

                                                    while ($row = mysqli_fetch_array($query)) {
                                                        $dr_obj = new User($con, $row['posted_by']);
                                                        $dr_name = $dr_obj->getFirstAndLastName();
                                                        $dr_pic = $dr_obj->getProfilePic();
                                                        $note_date = date("d/m/Y H:i", strtotime($row['date_time']));

                                                        ?>
                                                    <div class="row patient-note">
                                                        <div class="col-md-3">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <img src="<?php echo $dr_pic; ?>" style="width: 50px; height: 50px; border-radius: 100%;">
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <span><?php echo $note_date; ?></span><br />
                                                                    <strong><a href="<?php echo $row['posted_by']; ?>" class="dr-patient-note"><?php echo $dr_name; ?></a></strong>
                                                                    
                                                                    
                                                                    <div class="note-category">
                                                                        <?php 

                                                                        switch ($row['category']) {
                                                                            case "Daily Record":
                                                                                $note_icon = '<i class="fa-solid fa-calendar"></i>';
                                                                                break;
                                                                            case "Incidents":
                                                                                $note_icon = '<i class="fa-solid fa-brake-warning"></i>';
                                                                                break;
                                                                            case "Medication":
                                                                                $note_icon = '<i class="fa-solid fa-tablets"></i>';
                                                                                break;
                                                                            case "Physical Health":
                                                                                $note_icon = '<i class="fa-solid fa-weight-scale"></i>';
                                                                                break;
                                                                            case "Oral Health":
                                                                                $note_icon = '<i class="fa-solid fa-tooth"></i>';
                                                                                break;
                                                                            case "Nutrition":
                                                                                $note_icon = '<i class="fa-solid fa-apple-whole"></i>';
                                                                                break;
                                                                            case "Not for Disclosure":
                                                                                $note_icon = '';
                                                                                break;
                                                                            case "Nursing":
                                                                                $note_icon = '<i class="fa-solid fa-comment-medical"></i>';
                                                                                break;
                                                                            case "HCA":
                                                                                $note_icon = '<i class="fa-solid fa-user-nurse"></i>';
                                                                                break;
                                                                            case "Medical":
                                                                                $note_icon = '<i class="fa-solid fa-stethoscope"></i>';
                                                                                break;
                                                                            case "Psychology":
                                                                                $note_icon = '<i class="fa-solid fa-head-side-brain"></i>';
                                                                                break;
                                                                            case "AHP":
                                                                                $note_icon = '<i class="fa-solid fa-hand-heart"></i>';
                                                                                break;
                                                                            case "Social Work":
                                                                                $note_icon = '<i class="fa-solid fa-family"></i>';
                                                                                break;
                                                                            case "Substance Misuse":
                                                                                $note_icon = '<i class="fa-solid fa-skull-crossbones"></i>';
                                                                                break;
                                                                            case "Fitness Instructors":
                                                                                $note_icon = '<i class="fa-solid fa-dumbbell"></i>';
                                                                                break;
                                                                            case "MHA":
                                                                                $note_icon = '<i class="fa-solid fa-person-cane"></i>';
                                                                                break;
                                                                        }
                                                                        echo $note_icon . " " . $row['category']; 

                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        <div class="col-md-9">
                                                            <p>
                                                                <?php echo $row['note_body']; ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <?php } ?>

                                            </div>
                                            <div class="tab-pane fade" id="careplans" role="tabpanel" aria-labelledby="careplans-tab">
                                                <form id="formCare" action="" method="POST" enctype="multipart/form-data">
                                                    <h4>My care and support plan - at a glance</h4>
                                                    <div class="section-btn">
                                                        <a class="cta main-button" href="#">Add New</a>
                                                        <a class="cta main-button" href="#">View History</a>
                                                        <a class="main-button" href="form.php?type=Risk%20Assessment">Use Form Builder</a>
                                                    </div>
                                                    <hr>
                                                <?php

                                                $care_plans_section = $epr_obj->showSectionCategoriesList("Care Plans");
                                                echo $care_plans_section;

                                                ?>                                                    
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label for="">My name</label>
                                                            <input type="text" class="form-control" id="name"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">I like to be known as</label>
                                                            <input type="text" class="form-control" id="like"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">My birthday</label>
                                                            <input type="text" class="form-control" id="name"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">Important people to me</label>
                                                            <input type="text" class="form-control" id="name"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label for="" class="col-md-4">My background, skills and interests</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="" class="col-md-4">I like</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="" class="col-md-4">I dislike</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="" class="col-md-4">Tips for talking to me</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <!-- <h4>My care & support plan – in detail</h4>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label for="">My name</label>
                                                            <input type="text" class="form-control" id="name"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">I like to be known as</label>
                                                            <input type="text" class="form-control" id="like">
                                                        </div> 
                                                    </div>
                                                    <hr> -->
                                                    <h4>What you need to know – Safety</h4>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label for="">Areas of high risk for me</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">What you must do to keep me safe</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h4>What you need to know – Cognitive ability</h4>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label for="">How illness has affected my thinking and doing</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">What I can still do</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for=""> What I find difficult</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">How you can help me to do the things I can still do and support me with the things I find difficult</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h4>What you need to know – Biography</h4>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label for="">What is important for you to know about my past</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">How my past affects the way I am today</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for=""> How can you support me to make the best use of my past and overcome any difficulties it causes me</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">What is important for you to know about my cultural background</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">How you can support me to maintain my cultural identity</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">What you need to know about my use of language</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h4>What you need to know – Personality</h4>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label for="">How I am generally as a person, my disposition</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">How I respond to new situations and difficulties</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for=""> What upsets me</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">How you can support me to be positive and help me when I am distressed or withdrawn</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h4>What you need to know – Physical health</h4>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label for="">What I can still do for myself</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">What I find difficult</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">How you can help me with my physical health</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">How you can support me to be positive and help me when I am distressed or withdrawn</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h4>What you need to know – Physical health: eating and drinking</h4>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label for="">Things I enjoy</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">Things I do not like</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">This is how and where I prefer to eat</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">These are things I must have</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">How you can help me with eating and drinking</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h4>What you need to know – Sensory Impairment</h4>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label for="">My good senses are </label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">What I find difficult</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">How you can help me to make best use of my senses</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">How you can help me to sustain them</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h4>What you need to know – Environment</h4>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label for="">The environment which best suits me is one where</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">These are the challenges I have</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">This is how you can support me to make the best of the world around me</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h4>What you need to know – Family, friends and community</h4>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label for="">People and organisations which are important to me</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">How you can support me with maintaining these relationships</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">How you can support them to maintain a relationship with me</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h4>What you need to know – Occupation and social activities</h4>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label for="">In my past I have enjoyed</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">These are the challenges I have</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">This is how you can support me to make the best of the world around me</label>
                                                            <textarea name="description" class="input textarea-field-profile"></textarea> 
                                                        </div>
                                                    </div>
                                                    <div class="text-center">
                                                        <input type="submit" name="SUBMIT" id="submit" class="risk-submit">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="initialassessment" role="tabpanel" aria-labelledby="initialassessment-tab">
                                                <h2>Initial Assessment</h2><br>
                                                <div class="section-btn">
                                                    <a class="cta main-button" href="#">Add New</a>
                                                    <a class="cta main-button" href="#">View History</a>
                                                    <a class="main-button" href="form.php?type=Risk%20Assessment">Use Form Builder</a>
                                                </div>
                                                <hr>
                                                <?php require_once 'includes/forms/referral-assessment.php'; ?>
                                            </div>
                                            <div class="tab-pane fade" id="mentalhealth" role="tabpanel" aria-labelledby="mentalhealth-tab">
                                                <h2>Mental Health</h2><br>
                                                <div class="section-btn">
                                                    <a class="cta main-button" href="#">Add New</a>
                                                    <a class="cta main-button" href="#">View History</a>
                                                    <a class="main-button" href="form.php?type=Risk%20Assessment">Use Form Builder</a>
                                                </div>
                                                <hr>
                                                <div class="mental-sec">
                                                <?php

                                                $mental_health_section = $epr_obj->showSectionCategoriesList("Mental Health Act");
                                                echo $mental_health_section;

                                                ?>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="riskassessments" role="tabpanel" aria-labelledby="riskassessments-tab">
                                                <h2>Risk Assessments</h2>
                                                <select id="selectRiskAssessment">
                                                    <option selected="selected">Select a Risk Assessment...</option>
                                                    <option value="activity-risk-assessmet">Activity Risk Assessment</option>
                                                    <option value="assessment-of-needs-new-document-in-place">Assessment of needs new document in place</option>
                                                    <option value="assessment-of-falls">Assessment of falls</option>
                                                    <option value="bedside-rails-risk-assessment-tool">Bedside Rails Risk Assessment Tool</option>
                                                    <option value="behavioural-chart">Behavioural Chart</option>
                                                    <option value="care-plan-blank">Care Plan Blank</option>
                                                    <option value="care-plan-evaluation">Care Plan Evaluation</option>
                                                    <option value="care-plan-blank">Care Plan Blank</option>
                                                    <option value="clinical-risk-assessment-hoist">Clinical Risk Assessment Hoist</option>
                                                    <option value="daily-inspection-of-profiling-bed-and-mattress">Daily Inspection of profiling bed and mattress</option>
                                                    <option value="dementia-risk-assessment">Dementia Risk Assessment</option>
                                                    <option value="diabetes-passport">Diabetes Passport</option>
                                                    <option value="environmental-risk-assessment-form">Environmental Risk Assessment Form</option>
                                                    <option value="epilepsy-passport">Epilepsy Passport</option>
                                                    <option value="falls-risk-assessment">Falls Risk Assessment</option>
                                                    <option value="falls-risk-formulation">Falls Risk Formulation</option>
                                                    <option value="financial-risk-assessment">Financial Risk Assessment</option>
                                                    <option value="general-non-clinical-assessment-form">General non-Clinical Assessment Form</option>
                                                    <option value="handling">Handling</option>
                                                    <option value="hospital-transfer-tool-care-home-june-2016">Hospital Transfer Tool Care Home June 2016</option>
                                                    <option value="identification-sheet-alerts-july-16">Identification Sheet Alerts July 16</option>
                                                    <option value="individual-falls-risk-assessment-blank">Individual Falls Risk Assessment - Blank</option>
                                                    <option value="medication-identification-form">Medication Identification Form*</option>
                                                    <option value="mh-assessment-and-care-proposal">MH assessment and Care Proposal</option>
                                                    <option value="mind-the-gap">Mind The Gap</option>
                                                    <option value="moston-grange-nursing-home-pre-admission-assessment">Moston Grange Nursing Home Pre-Admission Assessment*</option>
                                                    <option value="moston-grange-nursing-home-medication">Moston Grange Nursing Home Medication</option>
                                                    <option value="moving-and-handling-risk-assessment">Moving and Handling Risk Assessment</option>
                                                    <option value="my-end-of-life-plan">My End of Life Plan</option>
                                                    <option value="oakland-pre-admission-assessment-report-2015">Oakland Pre-Admission Assessment Report 2015*</option>
                                                    <option value="peep">Personal Emergency Evacuation Plan (PEEP)*</option>
                                                    <option value="record-of-reviews">Record of Reviews</option>
                                                    <option value="road-safety-risk-assessment">Road Safety Risk Assessment</option>
                                                    <option value="the-fallowfield-supported-living-service-pre-admission-assessment">The Fallowfield Supported Living Service - Pre-admission Assessment (template)*</option>
                                                    <option>--------- CUSTOM FORMS ---------</option>
                                                    <?php

                                                    $query = mysqli_query($con, "SELECT * FROM forms WHERE category='Risk Assessment'");
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        echo "<option value='" . $row['category'] ."'>" . $row['category'] ."</option>\n";
                                                    }

                                                    ?>
                                                </select>
                                                <div class="section-btn">
                                                    <a class="cta main-button" href="#">Add New</a>
                                                    <a class="cta main-button" href="#">View History</a>
                                                    <a class="main-button" href="form.php?type=Risk%20Assessment">Use Form Builder</a>
                                                </div>
                                                

                                                    <div id="moston-grange-nursing-home-pre-admission-assessment" class="riskAssessmentContentArea">                                                        <br>
                                                    <?php require_once 'includes/forms/risk-form1.php'; ?>
                                                    </div>
                                                    <div id="oakland-pre-admission-assessment-report-2015" class="riskAssessmentContentArea">
                                                    <br>
                                                    <?php require_once 'includes/forms/risk-form1.php'; ?>
                                                    </div>
                                                    <div id="the-fallowfield-supported-living-service-pre-admission-assessment" class="riskAssessmentContentArea">
                                                    <br>
                                                    <?php require_once 'includes/forms/risk-form1.php'; ?>
                                                    </div>
                                                    <div id="peep">
                                                    <br>
                                                    <?php require_once 'includes/forms/risk-form2.php'; ?>
                                                    </div>
                                                    <div id="medication-identification-form">
                                                    <br>
                                                    <?php 'includes/forms/risk-form3.php'; ?>
                                                    </div>
                                                    <script>
                                                        $(function() {
                                                            $('.riskAssessmentContentArea').hide();
                                                            $('#selectRiskAssessment').change(function() {
                                                                $('.riskAssessmentContentArea').hide();
                                                                $('#' + $(this).val()).show();
                                                            });
                                                        });
                                                    </script>
                                            </div>
                                            <div class="tab-pane fade" id="seclusion" role="tabpanel" aria-labelledby="seclusion-tab">
                                                <h2>Seclusion</h2><br>
                                                <div class="section-btn">
                                                    <a class="cta main-button" href="#">Add New</a>
                                                    <a class="cta main-button" href="#">View History</a>
                                                    <a class="main-button" href="form.php?type=Risk%20Assessment">Use Form Builder</a>
                                                </div>
                                                <hr>
                                                
                                            </div>                                            
                                            <div class="tab-pane fade" id="section17" role="tabpanel" aria-labelledby="section17-tab">
                                            <h2>Section 17 - Leave of Absence Record<br></h2>
                                            <div class="section-btn">
                                                    <a class="cta main-button" href="#"  data-bs-toggle="modal" data-bs-target="#section17HistoryModal">View History</a>
                                                    <a class="main-button" href="form.php?type=Risk%20Assessment">Use Form Builder</a>
                                                </div>
                                                <hr>                                            
                                            <?php 

                                              // DISPLAY ALL IN A TABLE

                                                ?>

                                                <div class="modal fade" id="section17HistoryModal" tabindex="-1" role="dialog" aria-labelledby="section17HistoryModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="section17HistoryModal">Modal title</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body">


                                                <div class="section17-tb">
                                                <table class="section-box">
                                                    <thead>
                                                        <tr>
                                                            <td>Date</td>
                                                            <td>Leave Type</td>
                                                        </tr>
                                                    </thead>
                                                <?php

                                                $query = mysqli_query($con, "SELECT * FROM section17 WHERE patient_username='$username'");
                                                while ($row = mysqli_fetch_array($query)) {

                                                    $staff_username = $row['staff_username'];
                                                    $section17_leave_id = $row['id'];

                                                    $section17_staff_obj = new User($con, $staff_username);
                                                    $staff_name = $section17_staff_obj->getFirstAndLastName();

                                                    $date_added = $row['date_time'];
                                                    $date_added = date("jS M y h:i A", strtotime($date_added));

                                                    // FOR ALL TYPES OF LEAVE
                                                    $section_absence = $row['section_absence'];
                                                    $date_of_section = $row['date_section_absence'];
                                                    if (isset($row['moj1_absence']))
                                                        $moj = $row['moj1_absence'];
                                                    if (isset($row['moj2_absence']))
                                                        $moj = $row['moj2_absence'];
                                                    if (isset($row['moj3_absence']))
                                                        $moj = $row['moj3_absence'];

                                                    $moj_conditions = $row['moj_conditions_absence'];

                                                    if ($row['date_emergency_valid'] != NULL) {

                                                        $leave_type = "Emergency";
                                                        $dates_valid = $row['date_emergency_valid'];
                                                        $destination_of_leave = $row['destination_emergency_leave'];
                                                        $purpose_of_leave = $row['purpose_emergency_leave'];
                                                        $duration_of_leave = $row['duration_emergency_leave'];
                                                        $type_of_leave = $row['type_emergency_leave'];
                                                        $number_of_escorts = $row['number_emergency_escorts'];
                                                        $gen1 = $row['gen1_emergency'];
                                                        $gen2 = $row['gen2_emergency'];
                                                        $gen3 = $row['gen3_emergency'];
                                                        $details_of_conditions = $row['detail_emergency_condition'];
                                                    }

                                                    elseif ($row['dates_valid_medical'] != NULL) {

                                                        $leave_type = "Medical";
                                                        $dates_valid = $row['dates_valid_medical'];
                                                        $destination_of_leave = $row['destination_medical_leaves'];
                                                        $purpose_of_leave = $row['purpose_medical_leave'];
                                                        $duration_of_leave = $row['duration_medical_leave'];
                                                        $type_of_leave = $row['type_medical_leave'];
                                                        $number_of_escorts = $row['number_medical_escorts'];
                                                        $gen1 = $row['gen1_escorts_medical'];
                                                        $gen2 = $row['gen2_escorts_medical'];
                                                        $gen3 = $row['gen3_escorts_medical'];
                                                        $details_of_conditions = $row['detail_medical_condition'];    
                                                    }

                                                    elseif ($row['dates_valid_escorted'] != NULL) {

                                                        $leave_type = "Escorted";
                                                        $dates_valid = $row['dates_valid_escorted'];
                                                        $destination_of_leave = $row['destination_escorted_leaves'];
                                                        $purpose_of_leave = $row['purpose_escorted_leave'];
                                                        $duration_of_leave = $row['duration_escorted_leave'];
                                                        $type_of_leave = $row['dur_escorted_leave'];
                                                        $number_of_escorts = $row['number_of_escorted_level'];
                                                        if (isset($row['gen1_escorts_condition']))
                                                            $gender = $row['gen1_escorts_condition'];
                                                        if (isset($row['gen2_escorts_condition']))
                                                            $gender = $row['gen2_escorts_condition'];
                                                        if (isset($row['gen3_escorts_condition']))
                                                            $gender = $row['gen3_escorts_condition'];
                                                        $details_of_conditions =  $row['details_escorted_condition'];
                                                    }

                                                    elseif ($row['date_unescorted_valid'] != NULL) {

                                                        $leave_type = "Unescorted";
                                                        $dates_valid = $row['date_unescorted_valid'];
                                                        $destination_of_leave = $row['destination_unescorted_leaves'];
                                                        $purpose_of_leave = $row['purpose_unescorted_leaves'];
                                                        $duration_of_leave = $row['duration_unescorted_leaves'];
                                                        $type_of_leave = $row['dur_unescorted'];
                                                        $number_of_escorts = $row['number_unescorted_level'];
                                                        if (isset($row['gen1_unescorted']))
                                                            $gender = $row['gen1_unescorted'];
                                                        if (isset($row['gen2_unescorted']))
                                                            $gender = $row['gen2_unescorted'];
                                                        if (isset($row['gen3_unescorted']))
                                                            $gender = $row['gen3_unescorted'];
                                                        $details_of_conditions = $row['details_unescorted_condition'];
                                                    }

                                                    elseif ($row['date_group_valid'] != NULL) {

                                                        $leave_type = "Group";
                                                        $dates_valid = $row['date_group_valid'];
                                                        $destination_of_leave = $row['destination_group_leave'];
                                                        $purpose_of_leave = $row['purpose_group_leave'];
                                                        $duration_of_leave = $row['duration_group_leave'];
                                                        if (isset($row['dur_group']))
                                                            $type_of_leave = $row['dur_group'];
                                                        if (isset($row['dur2_group']))
                                                            $type_of_leave = $row['dur2_group'];
                                                        if (isset($row['dur3_group']))
                                                            $type_of_leave = $row['dur3_group'];
                                                        $number_of_escorts = $row['number_group_level'];
                                                        if (isset($row['gen1_group']))
                                                            $gender = $row['gen1_group'];
                                                        if (isset($row['gen2_group']))
                                                            $gender = $row['gen2_group'];
                                                        if (isset($row['gen3_group']))
                                                            $gender = $row['gen3_group'];
                                                        $details_of_conditions = $row['details_group_condition'];
                                                    }
                                                

                                                    ?>

                                                        <tr>
                                                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#section17Modal<?php echo $row['id']; ?>"><?php echo $date_added; ?></a></td>
                                                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#section17Modal<?php echo $row['id']; ?>"><?php echo $leave_type; ?></a>

        <!-- Modal -->
        <div class="modal fade" id="section17Modal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="section17Modal<?php echo $row['id']; ?>ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?php echo $row['id']; ?>Label">Section 17 - Leave of Absence Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <?php if (!empty($staff_username) || $staff_username == NULL) { ?>
                        Added by: <br><a href="<?php echo $staff_username; ?>"><?php echo $staff_name; ?></a>
                        <hr>
                        <?php } if (!empty($section_absence) || $section_absence == NULL) { ?>
                        Section: <br><?php echo $section_absence; ?>
                        <hr>
                        <?php } if (!empty($moj) || $moj == NULL) {?>
                        MOJ Restrictions: <br><?php echo $moj; ?>
                        <hr>
                        <?php } if (!empty($leave_type) || $leave_type == NULL) { ?>
                        Type of Leave: <br><?php echo $leave_type; ?>
                        <hr>
                        <?php } if (!empty($destination_of_leave) || $destination_of_leave == NULL) { ?>
                        Destination of Leave: <br><?php echo $destination_of_leave; ?>
                        <hr>
                        <?php } if (!empty($duration_of_leave) || $duration_of_leave == NULL) { ?>
                        Duration of Leave: <br><?php echo $duration_of_leave; ?>
                        <hr>
                        <?php } if (!empty($number_of_escorts) || $number_of_escorts == NULL) { ?>
                        Number of Escorts: <br><?php echo $number_of_escorts; ?>

                    </div>
                    <div class="col-6">
                        <?php } if (!empty($date_added) || $date_added == NULL ) { ?>
                        Date Added: <br><?php echo $date_added; ?>
                        <hr>
                        <?php } if (!empty($date_of_section) || $date_of_section == NULL) { ?>
                        Date of Section: <br><?php echo $date_of_section; ?>
                        <hr>
                        <?php } if (!empty($moj_conditions) || $moj_conditions == NULL) { ?>
                        MOJ Conditions: <br><?php echo $moj_conditions; ?>
                        <hr>
                        <?php } if (!empty($dates_valid) || $dates_valid == NULL) { ?>
                        Dates Valid: <br><?php echo $dates_valid; ?>
                        <hr>
                        <?php } if (!empty($purpose_of_leave) || $purpose_of_leave == NULL) { ?>
                        Purpose of Leave: <br><?php echo $purpose_of_leave; ?>
                        <hr>
                        <?php } if (!empty($type_of_leave) || $type_of_leave == NULL) { ?>
                        Type of Leave: <br><?php echo $type_of_leave; ?>
                        <hr>
                        <?php } if (!empty($gender) || $gender == NULL) { ?>
                        Conditions attached to escorts: <?php echo $gender; ?>
                        <?php } ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                    <?php

                        $query = mysqli_query($con, "SELECT * FROM section17_notes WHERE leave_id='$section17_leave_id'");
                        while ($row = mysqli_fetch_array($query)) {
                            $dr_obj = new User($con, $row['added_by']);
                            $dr_name = $dr_obj->getFirstAndLastName();
                            $note_date = date("d/m/Y H:i", strtotime($row['date_added']));
                            echo $row['note'] . "<br>Added by <a href='" . $row['added_by'] ."'>" . $dr_name . "</a> - " . $note_date;
                        }

                    ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <form method="POST" action="">
                        <textarea name="section17_note" class="form-control"></textarea>
                        <input type="hidden" name="posted_by" value="<?php echo $userLoggedIn; ?>">
                        <input type="hidden" name="section17_leave_id" value="<?php echo $section17_leave_id; ?>">
                        <br>
                        <button type="submit" class="main-button" name="section17_note_submit">Add Note</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="submit" name="submit_patient_referral" type="submit" class="main-button">Refer Patient</button> -->
                <button type="button" class="main-button" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>

                                                            </td>
                                                        </tr>
                                                    <?php
                                                }

                                                echo "        </table></div>";
                                                ?>




                                                        
                                                      </div>
                                                      <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close</button>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>

                                             <p>Select a type of leave:</p>
                                            <select name="section17_category" id="section17_category">
                                                <option value="">- SELECT LEAVE TYPE -</option>
                                                <option value="emergency_leave">Emergency Leave</option>
                                                <option value="medical_appointments">Medical Appointments</option>
                                                <option value="escorted">Escorted</option>
                                                <option value="unescorted">Unescorted</option>
                                                <option value="group">Group</option>
                                            </select>
                                            <script>
                                                $(function() {
                                                    $('.section17ContentArea').hide();
                                                    $('#section17_category').change(function() {
                                                        $('.section17ContentArea').hide();
                                                        $('#' + $(this).val()).show();
                                                    });
                                                });
                                            </script>
                                                <form action="" method="POST" class="sec-17">
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                    <label for="section">Section</label>
                                                    <input type="text" class="form-control" name="section_absence" id="section">
                                                    </div>
                                                    <div class="col-md-6">
                                                    <label for="dsection">Date of Section</label>
                                                    <input type="date" class="form-control" name="date_section_absence" id="dsection">
                                                    </div>
                                                    <div class="col-md-6">
                                                    <label for="moj-res">MOJ Restrictions</label><br>
                                                    <label class="placement" for="moj1">Yes
                                                        <input type="checkbox" id="moj1" name="moj1_absence">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="placement" for="moj2">Section 47/49
                                                        <input type="checkbox" id="moj2" name="moj2_absence">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="placement" for="moj2">N/A
                                                        <input type="checkbox" id="moj2" name="moj3_absence">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="moj-condition">MOJ Conditions</label>
                                                        <input type="text" class="form-control" name="moj_conditions_absence" id="moj-condition"> 
                                                    </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div id="emergency_leave" class="section17ContentArea">
                                                    <h5>1. Emergency Leave</h5>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                        <label for="date">Dates Valid</label>
                                                        <input type="text" class="form-control" name="date_emergency_valid" id="date1">
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="destination1">Destination for leaves</label>
                                                        <input type="text" class="form-control" name="destination_emergency_leave" id="destination1"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="leave1">Purpose of Leave</label>
                                                        <input type="text" class="form-control" name="purpose_emergency_leave" id="leave1"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="leave2">Duration of leave</label>
                                                        <input type="text" class="form-control" name="duration_emergency_leave" id="leave2"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="">Type of leave</label><br>
                                                        <label class="placement" for="leave3">Escorted
                                                            <input type="checkbox" id="leave3" name="type_emergency_leave">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="escorts">Number of Escorts & Level of Observations</label>
                                                        <input type="text" class="form-control" name="number_emergency_escorts" id="escorts">
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="">Conditions attached to escorts</label><br>
                                                        <label class="placement" for="gen7">Male
                                                            <input type="checkbox" id="gen7" name="gen1_emergency">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <label class="placement" for="gen8">Female
                                                            <input type="checkbox" id="gen8" name="gen2_emergency">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <label class="placement" for="gen9">Other
                                                            <input type="checkbox" id="gen9" name="gen3_emergency">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="conditions">Details of conditions</label>
                                                        <input type="text" class="form-control" id="condition1" name="detail_emergency_condition">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div id="medical_appointments" class="section17ContentArea">
                                                    <h5>Section 17 Leave: Medical Appointments.</h5>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                        <label for="date2">Dates Valid</label>
                                                        <input type="text" class="form-control" id="date2" name="dates_valid_medical">
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="leave4">Destination for leaves</label>
                                                        <input type="text" class="form-control" id="leave4" name="destination_medical_leaves">
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="leave5">Purpose of Leave</label>
                                                        <input type="text" class="form-control" id="leave5" name="purpose_medical_leave"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="leave6">Duration of leave</label>
                                                        <input type="text" class="form-control" id="leave6" name="duration_medical_leave"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="">Type of leave</label><br>
                                                        <label class="placement" for="leave6">Escorted
                                                            <input type="checkbox" id="leave6" name="type_medical_leave">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="level">Number of Escorts & Level of Observations</label>
                                                        <input type="text " class="form-control " id="level" name="number_medical_escorts "> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for=" ">Conditions attached to escorts</label><br>
                                                            <label class="placement" for="gen10">Male
                                                            <input type="checkbox" id="gen10" value="gen10" name="gen1_escorts_medical">
                                                            <span class="checkmark"></span>
                                                            </label>
                                                            <label class="placement" for="gen11">Female
                                                            <input type="checkbox" id="gen11" value="gen11" name="gen2_escorts_medical">
                                                            <span class="checkmark"></span>
                                                            </label>
                                                            <label class="placement" for="gen12">Other
                                                            <input type="checkbox" id="gen12" value="gen12" name="gen3_escorts_medical">
                                                            <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="detail">Details of conditions</label>
                                                        <input type="text" class="form-control" name="detail_medical_condition" id="condition2"> 
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div id="escorted" class="section17ContentArea">
                                                    <h5>Section 17 Leave: Escorted</h5>
                                                    <div class="form-group row ">
                                                        <div class="col-md-6">
                                                        <label for="date3">Dates Valid</label>
                                                        <input type="text" class="form-control" id="date3" name="dates_valid_escorted"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="leave7">Destination for leaves</label>
                                                        <input type="text" class="form-control" id="leave7" name="destination_escorted_leaves"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="leave8">Purpose of Leave</label>
                                                        <input type="text" class="form-control" id="leave8" name="purpose_escorted_leave"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="leave9">Duration of leave</label>
                                                        <input type="text" class="form-control" id="leave9" name="duration_escorted_leave"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for=" ">Type of leave</label><br>
                                                        <label class="placement" for="leave10">Escorted
                                                            <input type="checkbox" id="leave10" name="dur_escorted_leave">
                                                            <span class="checkmark"></span>
                                                        </label> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="observ">Number of Escorts & Level of Observations</label>
                                                        <input type="text" class="form-control" name="number_of_escorted_level" id="observ"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for=" ">Conditions attached to escorts</label><br>
                                                        <label class="placement" for="gen13">Male
                                                            <input type="checkbox" id="gen13" value="gen13" name="gen1_escorts_condition">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <label class="placement" for="gen14">Female
                                                            <input type="checkbox" id="gen14" value="gen14" name="gen2_escorts_condition">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <label class="placement" for="gen15">Other
                                                            <input type="checkbox" id="gen15" value="gen15" name="gen3_escorts_condition">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="condition3">Details of conditions</label>
                                                        <input type="text" class="form-control" name="details_escorted_condition" id="condition3">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div id="unescorted" class="section17ContentArea">
                                                    <h5>2. Section 17 Leave: Unescorted</h5>
                                                    <div class="form-group row ">
                                                        <div class="col-md-6">
                                                        <label for="date4">Dates Valid</label>
                                                        <input type="date" class="form-control" name="date_unescorted_valid" id="date4"> 
                                                        </div> 
                                                        <div class="col-md-6">
                                                        <label for="leave11">Destination for leaves</label>
                                                        <input type="text" class="form-control" name="destination_unescorted_leaves" id="leave11"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="leave12">Purpose of Leave</label>
                                                        <input type="text" class="form-control" name="purpose_unescorted_leaves" id="leave12"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="leave13">Duration of leave</label>
                                                        <input type="text" class="form-control" name="duration_unescorted_leaves" id="leave13"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for=" ">Type of leave</label><br>
                                                        <label class="placement" for="leave14">Escorted
                                                            <input type="checkbox" id="leave14" name="dur_unescorted">
                                                            <span class="checkmark"></span>
                                                        </label> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="leave15">Number of Escorts & Level of Observations</label>
                                                        <input type="text" class="form-control" id="leave15" name="number_unescorted_level"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for=" ">Conditions attached to escorts</label><br>
                                                            <label class="placement" for="gen1">Male
                                                            <input type="checkbox" id="gen1" value="gen1" name="gen1_unescorted">
                                                            <span class="checkmark"></span>
                                                            </label>
                                                            <label class="placement" for="gen2">Female
                                                            <input type="checkbox" id="gen2" value="gen2" name="gen2_unescorted">
                                                            <span class="checkmark"></span>
                                                            </label>
                                                            <label class="placement" for="gen3">Other
                                                            <input type="checkbox" id="gen3" value="gen3" name="gen3_unescorted">
                                                            <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for=" ">Details of conditions</label>
                                                        <input type="text" class="form-control" name="details_unescorted_condition" id="condition4"> 
                                                        </div> 
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div id="group" class="section17ContentArea">
                                                    <h5> 3. Section 17 Leave: Group Leaves</h5>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                        <label for="date5">Dates Valid</label>
                                                        <input type="date" class="form-control" name="date_group_valid" id="date5"> 
                                                        </div> 
                                                        <div class="col-md-6">
                                                        <label for="leave16">Destination for leaves</label>
                                                        <input type="text" class="form-control" name="destination_group_leave" id="leave16"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="leave17">Purpose of Leave</label>
                                                        <input type="text" class="form-control" name="purpose_group_leave" id="leave17"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for="leave18">Duration of leave</label>
                                                        <input type="text" class="form-control" name="duration_group_leave" id="leave18"> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for=" ">Type of leave</label><br>
                                                        <label class="placement" for="leave19">Escorted
                                                            <input type="checkbox" id="leave19" value="dur" name="dur_group">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <label class="placement" for="leave20">Unescorted
                                                            <input type="checkbox" id="leave20" value="dur2" name="dur2_group">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <label class="placement" for="leave21">Group leave - 2 staff with 3 patients
                                                            <input type="checkbox" id="leave21" value="dur3" name="dur3_group">
                                                            <span class="checkmark"></span>
                                                        </label> 
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for=" ">Number of Escorts & Level of Observations</label>
                                                        <input type="text" class="form-control" name="number_group_level" id="pre">  
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for=" ">Conditions attached to escorts</label><br>
                                                            <label class="placement" for="gen4">Male
                                                            <input type="checkbox" id="gen4" value="gen4" name="gen1_group">
                                                            <span class="checkmark"></span>
                                                            </label>
                                                            <label class="placement" for="gen5">Female
                                                            <input type="checkbox" id="gen5" value="gen5" name="gen2_group">
                                                            <span class="checkmark"></span>
                                                            </label>
                                                            <label class="placement" for="gen6">Other
                                                            <input type="checkbox" id="gen6" value="gen6" name="gen3_group">
                                                            <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label for=" ">Details of conditions</label>
                                                        <input type="text" class="form-control" name="details_group_condition" id="condition5"> 
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <input type="hidden" name="patient_username" value="<?php echo $username; ?>">
                                                    <input type="submit" id="submit" name="submit_section_17" class="risk-submit"> 
                                                </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="incidentrecords" role="tabpanel" aria-labelledby="incidentrecords-tab">
                                                <h2>Incident Records</h2><br>
                                                <div class="section-btn">
                                                    <a class="cta main-button" href="#">Add New</a>
                                                    <a class="cta main-button" href="#">View History</a>
                                                    <a class="main-button" href="form.php?type=Risk%20Assessment">Use Form Builder</a>
                                                </div>
                                                <hr>

                                            </div>
                                            <div class="tab-pane fade" id="labtests" role="tabpanel" aria-labelledby="labtests-tab">
                                                <h2>Lab Tests</h2><br>
                                                <div class="section-btn">
                                                    <a class="cta main-button" href="#">Add New</a>
                                                    <a class="cta main-button" href="#">View History</a>
                                                    <a class="main-button" href="form.php?type=Risk%20Assessment">Use Form Builder</a>
                                                </div>
                                                <hr>
                                                <div class="lab-sec">
                                                    <div class="row">
                                                    <?php

                                                    if (isset($_GET['section_category'])) {


                                                    }
                                                    else {

                                                        $lab_tests = $epr_obj->showSectionCategories("Lab Tests");
                                                        echo $lab_tests;

                                                    }

                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="imaging" role="tabpanel" aria-labelledby="imaging-tab">
                                                <h2>Imaging</h2><br>
                                                <div class="section-btn">
                                                    <a class="cta main-button" href="#">Add New</a>
                                                    <a class="cta main-button" href="#">View History</a>
                                                    <a class="main-button" href="form.php?type=Risk%20Assessment">Use Form Builder</a>
                                                </div>
                                                <hr>
                                                <form class="search-form" action="#">
                                                    <input type="text" placeholder="Search Imaging" name="search">
                                                    <button type="submit"><i class="fa fa-search"></i></button>
                                                </form>
                                                <div class="imaging-sec">
                                                    <div class="row">
                                                    <?php

                                                    if (isset($_GET['section_category'])) {


                                                    }
                                                    else {

                                                        $lab_tests = $epr_obj->showSectionCategories("Imaging");
                                                        echo $lab_tests;

                                                    }

                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="bodymap" role="tabpanel" aria-labelledby="bodymap-tab">
                                                <h2>Body Map</h2>
                                                <!-- START BODY MAP CODE -->
                                                <!-- ********************************************** -->
                                                <!-- Two tabs for both front and back of the svg   -->
                                                <!-- ********************************************* -->
                                                <div class="container my-news-feed-title">
                                                    <div class="container">
                                                        <div class="tabs-two">
                                                            <div id="tabs-nav-two" class="project-tabs-list">
                                                                <div><a class="button-4" href="#tab1">Front</a></div>
                                                                <div><a class="button-4" href="#tab2">Back</a></div>
                                                            </div>
                                                            <!-- END tabs-nav -->
                                                            <div id="tabs-content-two">
                                                                <div id="tab1" class="tab-content-two">
                                                                    <div class="container">
                                                                        <div class="row">
                                                                            <div class="col-lg-6 human-position">
                                                                                <?php
                                                                                    $query = mysqli_query($con, "SELECT * FROM body WHERE front_back = 'Front' ORDER BY date_time DESC");
                                                                                    include("assets/images/svgs/male-human-body.php");
                                                                                ?>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class=" wrapper-search-project">
                                                                                    <input type="text" id="myFilterBody" class="search-service" onkeyup="myFunctionBody()" placeholder="Search..."> <i class="fa fa-search fa-lg" aria-hidden="true"></i>
                                                                                </div>
                                                                                <br>
                                                                                <div id="bodySearchInjury">
                                                                                    <?php 
                                                                                        $query = "SELECT * FROM body WHERE front_back = 'Front' ORDER BY date_time DESC"; 
                                                                                        $result = mysqli_query($con, $query);
                                                                                        while ($re = mysqli_fetch_array($result)) {
                                                                                                $nice_date = date("d/m/Y H:i", strtotime($re['date_time']));
                                                                                                echo "<div class='injury-wrapper'><div id='bodyConnect". $re['id'] ."'><h2>" . $re['name'] ."</h2><p class='injury-card'>" . $re['injury'] ."</p><p>" . $re['description'] ."<br /><br />".$nice_date."</p></div></div>";
                                                                                            }
                                                                                            
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="tab2" class="tab-content-two">
                                                                    <div class="container">
                                                                        <div class="row">
                                                                            <div class="col-lg-6 human-position">
                                                                                <?php 
                                                                                    $query = mysqli_query($con, "SELECT * FROM body WHERE front_back = 'Back'");
                                                                                    include("assets/images/svgs/male-human-body-back.php")
                                                                                ?>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class=" wrapper-search-project">
                                                                                    <input type="text" id="myFilterBodyBack" class="search-service" onkeyup="myFunctionBodyBack()" placeholder="Search for card name..."> <i class="fa fa-search fa-lg" aria-hidden="true"></i> 
                                                                                </div>
                                                                                <br>
                                                                                <div id="bodySearchInjuryBack">
                                                                                    <?php 
                                                                                        $query = "SELECT * FROM body WHERE front_back = 'Back'"; 
                                                                                        $result = mysqli_query($con, $query);

                                                                                        while ($re = mysqli_fetch_array($result)) {
                                                                                                echo "<div class='injury-wrapper'><div id='bodyConnect". $re['id'] ."'><h2>" . $re['name'] ."</h2><p class='injury-card'>" . $re['injury'] ."</p><p>" . $re['description'] ."</p></div></div>";
                                                                                            }
                                                                                        ?> 
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="toothmap" role="tabpanel" aria-labelledby="toothmap-tab">
                                                <h2>Tooth Map</h2>
                                                <style>
                                                .tooth {
                                                    cursor: pointer;
                                                }
                                                .tooth-wrapper {
                                                    position: relative;
                                                    display: inline-block;
                                                }
                                                .tooth-number {
                                                    position: absolute;
                                                    top: 50%;
                                                    left: 50%;
                                                    width: 110px;
                                                    height: 40px;
                                                    margin: -20px 0 0 -55px;
                                                    padding: 0 20px;
                                                    text-align: center;
                                                    font: normal 14px/40px Arial;
                                                    color: #fff;
                                                    border-radius: 20px;
                                                    background: #ca70cd;
                                                    cursor: pointer;
                                                    -webkit-transition: all ease-out .3s;
                                                    -o-transition: all ease-out .3s;
                                                    transition: all ease-out .3s;
                                                    -webkit-box-sizing: border-box;
                                                    -moz-box-sizing: border-box;
                                                    box-sizing: border-box;
                                                    -webkit-transform: rotate(0deg);
                                                    -moz-transform: rotate(0deg);
                                                    transform: rotate(0deg);
                                                }
                                                .tooth-number.disabled {
                                                    width: 40px;
                                                    font-size: 30px;
                                                    padding: 0 12px;
                                                    margin-left: -20px;
                                                    -webkit-transform: rotate(-270deg);
                                                    -moz-transform: rotate(-270deg);
                                                    transform: rotate(-270deg);
                                                }    
                                        </style>

                                        <div class="tooth-wrapper">
                                            <?php

                                                require_once("assets/images/svgs/toothmap.php");

                                            ?>
                                            <div class="tooth-number disabled" data-next-step="2" data-title="Закрыть">&times;</div>
                                        </div>
                                        <form method="POST" action="" class="dental-form">
                                            <input type="hidden" name="selected_tooth" id="selected_tooth"><br>
                                            <input type="hidden" name="patient" id="patient_username" value="<?php echo $username; ?>"><br>
                                            <input type="hidden" name="dentist" id="dentist_username" value="<?php echo $userLoggedIn; ?>"><br>
                                            <label>Note</label> <textarea name="tooth_note" class="textarea-field-profile" id="tooth_note" cols="30" rows="10"></textarea>
                                            <button type="submit" name="submit_tooth_note" class="risk-submit">Submit</button>
                                        </form>
                                        <script>
                                        var doc = $(document);
                                                doc
                                                    .on('click touchstart', '.tooth', function(event) {
                                                        var $this = $(this),
                                                            toothText = $this.data('title'),
                                                            $numberText = $('.tooth-number'),
                                                            number;
                                                        if (/(^|\s)active(\s|$)/.test($this.attr("class"))) {
                                                            $this.attr('class','tooth');
                                                            $numberText.html('&times;').data('title', 'Закрыть');
                                                            number = false;
                                                            $('#selected_tooth').val("");
                                                        } else {
                                                            $this.attr('class','tooth active').siblings().attr('class','tooth');
                                                            $numberText.html('<b>' + toothText + '</b>').data('title', 'Следующий шаг');
                                                            number = toothText;
                                                            $('#selected_tooth').val(number);
                                                        }
                                                        $.event.trigger({
                                                            type: "change.tooth",
                                                            message: number,
                                                            time: new Date()
                                                        });
                                                    })
                                                    .on('change.tooth', function(e) {
                                                        var $nextStep = $('[data-next-step]');
                                                        if (e.message) {
                                                            $nextStep.removeClass('disabled').data('nextStep', e.message);
                                                        } else {
                                                            $nextStep.addClass('disabled').data('nextStep', '');
                                                        }
                                                        console.log($nextStep.data('nextStep'));
                                                    });
                                                jQuery(document).ready(function($) {
                                                    $('[data-title]').tooltip({
                                                        title: function () {
                                                            return $(this).data('title');
                                                        },
                                                        container: 'body'
                                                    });
                                                });    
                                        </script>

                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                                <!-- ************************************ -->
                                <!-- popup for markers on the svg images  -->
                                <!-- *********************************** -->
                                <?php 

                                    $query = "SELECT * FROM body"; 
                                    $result = mysqli_query($con, $query);
                                    while ($r = mysqli_fetch_array($result)) { 

                                    echo  "<div id='popup".  $r['id']. "' class='overlay-one'>
                                            <div class='popup-one'>
                                                <h2>".  $r['name']. "</h2>
                                                <h3>".  $r['injury']. "</h3>
                                                <a class='close-one' href='#'>&times;</a>
                                                    <div class='content-one'>
                                                        <p>".  $r['description']. "</p>
                                                    </div>
                                            </div>
                                        </div>";
                                } ?>

                                    <!-- ************************************************* -->
                                    <!-- Submit form for both front and back of svg -->
                                    <!-- ************************************************* -->

                                    <div id="pinConfirmSucces" class="pin-confirm-succes">
                                        <a href="#" id="btnpinConfirmSucces" class="btn btn-success">&#10004; Registration Successful</a>
                                    </div>
                                    <div id="pinConfirm" class="pin-confirm">
                                        <div id="pinConfirmBtns">
                                            <a href="#" id="btnConfirmTrue" class="button-success"><i class="fas fa-check"></i></a>
                                            <a href="#" id="btnConfirmCancel" class="button-danger"><i class="fas fa-times"></i></a>
                                        </div>
                                    </div>
                                    <form id="pinForm" class="pin-form" method=POST action="test.php">
                                        <fieldset>
                                            <legend>Create Note</legend>
                                                    <input class="settings-input-account" id="textinput" name="name" type="hidden" value="Laura Dugdale" placeholder="Name...">
                                                    <input class="settings-input-account" id="textinput" name="created_by" value="Devan Moodley" type="hidden" placeholder="Created By...">

                                                <!--</div>
                                            </div>-->
                                            <div class="form-group">
                                                <label for="textinput">Location</label>
                                                <div>
                                                    <input class="settings-input-account" id="textinput" name="injury" type="text" placeholder="Location...">

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="textarea">Description</label>
                                                <div>
                                                    <textarea id="textarea" name="description"></textarea>
                                                </div>
                                            </div>
                                            <input type="hidden" id="x-axis" name="x" value="">
                                            <input type="hidden" id="y-axis" name="y" value="">
                                            <input id="frontBackInput" type="hidden" name="frontBack" value="Front">
                                            
                                            <div class="form-group">
                                        
                                                <div>
                                                    <input type="submit" href="#" id="btnSuccess" name="submit_body_map_note" class="body-form-submit" value="Submit">
                                                    <input href="#" id="btnDanger" class="body-form-cancel" value="X">
                                                </div>
                                            </div>

                                        </fieldset>
                                    </form>
                                    <script>
                                        // Show the first tab and hide the rest
                                        $('#tabs-nav-two div:first-child').addClass('active');
                                        $('.tab-content-two').hide();
                                        $('.tab-content-two:first').show();

                                        // Click function
                                        $('#tabs-nav-two div').click(function(){
                                            $('#tabs-nav-two div').removeClass('active');
                                            $(this).addClass('active');
                                            $('.tab-content-two').hide();
                                            
                                            var activeTab = $(this).find('.button-4').attr('href');
                                            $(activeTab).fadeIn();
                                            return false;
                                        });
                                    </script>

                                    <script>
                                        var
                                        svg = document.getElementById('humanAnatomy'),
                                        //NS = svg.getAttribute('xmlns'),
                                        NS = $('.human-body-front').attr('xmlns'),
                                        pinForm = $('#pinForm'),
                                        btnOK = $('#btnSuccess'),
                                        btnCancel = $('#btnDanger'),
                                        pinConfirm = $('#pinConfirm'),
                                        btnConfirmTrue = $('#btnConfirmTrue'),
                                        btnConfirmCancel = $('#btnConfirmCancel'),
                                        pinConfirmSucces = $('#pinConfirmSucces'),
                                        pinConfirmBtns = $('#pinConfirmBtns');

                                        $(document).on('click', '#humanInner', function(e) {
                                        var
                                        t = e.target,
                                        x = e.clientX,
                                        y = e.clientY,
                                        target = (t == svg ? svg : t.parentNode),
                                        pin = pinCenter(target, x, y),
                                        newCircIdParam = "newcircle" + Math.round(pin.x) + '-' + Math.round(pin.y),
                                        circle = document.createElementNS(NS, 'circle');
                                        circle.setAttributeNS(null, 'cx', Math.round(pin.x));

                                        $('#x-axis').val(pin.x);
                                        $('#y-axis').val(pin.y);

                                        circle.setAttributeNS(null, 'cy', Math.round(pin.y));
                                        circle.setAttributeNS(null, 'r', 10);
                                        circle.setAttributeNS(null, 'class', "newcircle");
                                        // circle.setAttributeNS(null, 'name', "name");
                                        circle.setAttributeNS(null, 'id', newCircIdParam);
                                        circle.setAttributeNS(null, 'data-x', Math.round(pin.x));
                                        circle.setAttributeNS(null, 'data-y', Math.round(pin.y));
                                        target.after(circle);

                                        pinConfirm.show();
                                        pinConfirmBtns.css({
                                            "left": (x + 20) + 'px',
                                            "top": '1350px'
                                        });

                                        /* Confirm the position of the added Circle*/
                                        btnConfirmTrue.click(function() {
                                            pinConfirm.hide();
                                            pinForm.show();
                                        });

                                        /* Fill the form, send it or give it up */
                                        btnOK.click(function() {
                                            pinForm.hide();
                                            pinConfirmSucces.show();
                                        });

                                        btnCancel.click(function() {
                                            pinForm.hide();
                                            pinConfirm.show();
                                        });

                                        /* After confirmation completion*/
                                        pinConfirmSucces.click(function() {
                                            pinConfirmSucces.hide();
                                        });
                                        });

                                        function pinCenter(element, x, y) {
                                            var pt = svg.createSVGPoint();
                                            pt.x = x;
                                            pt.y = y;
                                            return pt.matrixTransform(element.getScreenCTM().inverse());
                                        }

                                        btnConfirmCancel.click(function() {
                                            $("#humanInner + .newcircle").remove();
                                            pinConfirm.hide();
                                        });         
                                    </script>

                            <div class="tab-pane fade active show" id="about" role="tabpanel" aria-labelledby="about-tab">
                                <!-- ************** -->
                                    <!-- start -->
                                <!-- ************** -->
                                <div class="row">
                                    <div class="col-lg-7 about-info-profile">
                                    <?php
                                        if ($user_array['user_role'] == "Service User")  
                                        {
                                    ?>
                                        <h3>Ward</h3>
                                        <p>Ward 1</p>
 
                                        <?php  
                                        }
                                        ?>

                                        <h3>Summary</h3>
                                        <p><?php echo $user_array['summary']; ?></p>

                                        <?php
                                        if ($user_array['user_role'] != "Service User") {

                                        ?>
                                        <h3>Profession</h3>
                                        <p><?php echo $user_array['field_of_work'] = $user_array['field_of_work'] ? $user_array['field_of_work'] : 'Field Name Missing'; ?></p>
                                        <?php
                                        }
                                        if ($user_array['user_role'] == "Service User")  
                                        {         
                                            echo "<h3>Conditions</h3><ul>";
                                            // GET PATIENT'S CONDITIONS
                                            $query = mysqli_query($con, "SELECT condition_name FROM conditions, patient_conditions WHERE patient_conditions.patient_username='$username' AND patient_conditions.condition_id = conditions.id");
                                            while ($row = mysqli_fetch_array($query)) {
                                                echo "<li>" . $row['condition_name'] . "</li>";
                                            }
                                            echo "</ul>";
                                            
                                            ?>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="main-button" data-bs-toggle="modal" data-bs-target="#newConditionModal">
                                            Add New Condition
                                            </button>



                                            <!-- Modal -->
                                            <div class="modal fade" id="newConditionModal" tabindex="-1" aria-labelledby="newConditionModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="newConditionModalLabel">Add New Condition</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="profile.php" method="POST">
                                                        <select name="medical_conditions" id="conditions" class="form-control">
                                                            <option value="">- PLEASE SELECT A CONDITION -</option>
                                                            <?php

                                                            $query = mysqli_query($con, "SELECT * FROM conditions");
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                echo "<option value='" . $row['id'] . "'>" . $row['condition_name'] . "</option>";
                                                            }
                                                            
                                                            ?>
                                                        </select>
                                                        <input type="hidden" name="user" value="<?php echo $username; ?>">
                                                </div>
                                                <div class="modal-footer">
                                                        <button type="submit" name="submit_condition" type="submit" class="main-button">Add Condition</button>
                                                        </form>
                                                    <button type="button" class="main-button" data-bs-dismiss="modal">Close</button>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                            <?php
                                            
                                            echo "<h3>Medication</h3><ul>";

                                            $query = mysqli_query($con, "SELECT medication.id, medication_name, side_effects, dosage, frequency FROM medication, prescriptions WHERE prescriptions.patient='$username' AND  prescriptions.drug = medication.id");
                                            while ($row = mysqli_fetch_array($query)) {

                                                ?>
                                                <li><?php echo $row['medication_name']; ?> - <?php echo $row['dosage']; ?> - <?php echo $row['frequency']; ?> <a href="#" data-bs-toggle="modal" data-bs-target="#sideEffect<?php echo $row['id']; ?>Modal">Side Effects</a></li>


                                           <!-- Modal -->
                                            <div class="modal fade" id="sideEffect<?php echo $row['id']; ?>Modal" tabindex="-1" aria-labelledby="sideEffect<?php echo $row['id']; ?>ModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="sideEffect<?php echo $row['id']; ?>ModalLabel"><?php echo $row['medication_name']; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><?php echo nl2br($row['side_effects']); ?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="main-button" data-bs-dismiss="modal">Close</button>
                                                </div>
                                                </div>
                                            </div>
                                            </div>

                                                <?php
                                            }
                                            echo "</ul>";

                                            ?>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="main-button" data-bs-toggle="modal" data-bs-target="#newMedicationModal">
                                            Add New Medication
                                            </button>



                                            <!-- Modal -->
                                            <div class="modal fade" id="newMedicationModal" tabindex="-1" aria-labelledby="newMedicationModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="newMedicationModalLabel">Add New Medication</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="profile.php" method="POST">
                                                        <select name="medication" id="medication" class="form-control">
                                                            <option value="">- PLEASE SELECT A MEDICATION -</option>
                                                            <?php

                                                            $query = mysqli_query($con, "SELECT * FROM medication");
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                echo "<option value='" . $row['id'] . "'>" . $row['medication_name'] . "</option>";
                                                            }
                                                            
                                                            ?>
                                                        </select>
                                                        Dosage: <input type="text" name="dosage" class="form-control"><br>
                                                        Frequency: <input type="text" name="frequency" class="form-control"><br>
                                                        Notes: <textarea name="notes" class="form-control"></textarea>
                                                        Review Date: <input type="date" name="review_date" class="form-control">
                                                        <input type="hidden" name="user" value="<?php echo $username; ?>">
                                                </div>
                                                <div class="modal-footer">
                                                        <button type="submit" name="submit_medication" type="submit" class="main-button">Add Medication</button>
                                                        </form>
                                                    <button type="button" class="main-button" data-bs-dismiss="modal">Close</button>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                            <?php


                                        }
                                        if (!$user['user_role'] == "Provider")  
                                        {

                                        ?>

                                        <h3>Main Specialty</h3>
                                        <p><?php echo $user_array['specialty'] = $user_array['specialty'] ? $user_array['specialty'] : 'Field Name Missing'; ?></p>
                                        <h3>Other Specialties</h3>
                                        <p><?php echo $user_array['sub_specialty'] = $user_array['sub_specialty'] ? $user_array['sub_specialty'] : 'Field Name Missing'; ?></p>
                                        <h3>Preferred Specialism</h3>
                                        <p><?php echo $user_array['preferred_specialism'] = $user_array['preferred_specialism'] ? $user_array['preferred_specialism'] : 'Field Name Missing'; ?></p>

                                        <?php
                                        }

                                        ?>

                                        <!-- <h3>Bio</h3> -->
                                        <p><?php //echo $result = substr("Devan has extensive experience in both the NHS and private healthcare sectors, working as a doctor and now to his current role as Registered Site Manager whom will be implementing technology and improving healthcare facilities for Equilibrium Healthcare.", 0, 140);?><!--... <a class="toggle-popup popup-button" data-target="myPopup">Read More</a></p>-->

                                        <div id="myPopup" class="popup-main hide-popup">
                                        <div class="popup-header">
                                            Bio
                                            <span class="close-popup toggle-popup" data-target="myPopup">close</span>
                                        </div>
                                        <div class="popup-body">
                                            <p>Devan has extensive experience in both the NHS and private healthcare sectors, working as a doctor and now to his current role as Registered Site Manager whom will be implementing technology and improving healthcare facilities for Equilibrium Healthcare.</p>
                                        </div>
                                        <br>
                                        <div class="popup-footer">
                                            <button class="toggle-popup popup-button main-button" data-target="myPopup">Got it !</button>
                                        </div>
                                        </div>

                                        <script>
                                            $(document).on('click', '.toggle-popup', function(event) {
                                                event.preventDefault();
                                                
                                                var target = $(this).data('target');
                                                $('#' + target).toggleClass('hide-popup');
                                            });
                                        </script>
                                        <?php

                                        if (!$user['user_role'] == "Provider")  
                                        {

                                        ?>
                                        <h3>Languages</h3>
                                        <p style="margin-bottom: 0px !important;"><strong>Primary:</strong> <?php echo $user_array['primary_language'] = $user_array['primary_language'] ? $user_array['primary_language'] : 'Field Name Missing'; ?></p>
                                        <p><strong>Secondary: </strong> <?php echo $user_array['secondary_languages'] = $user_array['secondary_languages'] ? $user_array['secondary_languages'] : 'Field Name Missing'; ?></p>

                                        <!-- <h3>Company Name</h3>
                                        <p>< ?php echo $user_array['company_name'] = $user_array['company_name'] ? $user_array['company_name'] : 'Field Name Missing'; ?></p>
                                            <h3>Company Size</h3>
                                        <p><strong>< ?php echo $user_array['company_size'] = $user_array['company_size'] ? $user_array['company_size'] : 'Field Name Missing'; ?></strong> Employees</p> -->
                                        
                                        <a class="edit-profile-link" href="settings.php"><i class="fas fa-edit"></i></a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="col-lg-5">
                                        <?php

                                        if ($user_array['user_role'] != "Provider")  {

                                        ?>

                                        <!-- <div class="map-container">
                                            <div id='map' style='width: 100%; height: 500px;'></div>
                                            <br>
                                            <p class="icon-location"><i class="fas fa-map-marker-alt"></i>< ?php echo $user_array['location'] = $user_array['location'] ? $user_array['location'] : 'Atlantic Oceon';?></p>
                                        </div> -->
                                        <div class="card-cal">
                                            <div class="calendar-toolbar">
                                                <button class="prev month-btn"><i class="fas fa-chevron-left"></i></button>
                                                <div class="current-month"></div>
                                                <button class="next month-btn"><i class="fas fa-chevron-right"></i></button>
                                            </div>
                                            <div class="calendar">
                                                <div class="weekdays">
                                                <div class="weekday-name">Sa</div>
                                                <div class="weekday-name">Su</div>
                                                <div class="weekday-name">Mo</div>
                                                <div class="weekday-name">Tu</div>
                                                <div class="weekday-name">We</div>
                                                <div class="weekday-name">Th</div>
                                                <div class="weekday-name">Fr</div>
                                                </div>
                                                <div class="calendar-days"></div>
                                            </div>
                                            <div class="goto-buttons">
                                                <button type="button" class="btn-cal prev-year">Prev Year</button>
                                                <button type="button" class="btn-cal today">Today</button>
                                                <button type="button" class="btn-cal next-year">Next Year</button>
                                            </div>
                                            </div>
                                            <script>
                                            
                                            var currentMonth = document.querySelector(".current-month");
                                            var calendarDays = document.querySelector(".calendar-days");
                                            var today = new Date();
                                            var date = new Date();


                                            currentMonth.textContent = date.toLocaleDateString("en-US", {month:'long', year:'numeric'});
                                            today.setHours(0,0,0,0);
                                            renderCalendar();

                                            function renderCalendar(){
                                                const prevLastDay = new Date(date.getFullYear(),date.getMonth(),0).getDate();
                                                const totalMonthDay = new Date(date.getFullYear(),date.getMonth()+1,0).getDate();
                                                const startWeekDay = new Date(date.getFullYear(),date.getMonth(),1).getDay();
                                                
                                                calendarDays.innerHTML = "";

                                                let totalCalendarDay = 6 * 7;
                                                for (let i = 0; i < totalCalendarDay; i++) {
                                                    let day = i-startWeekDay;

                                                    if(i <= startWeekDay){
                                                        // adding previous month days
                                                        calendarDays.innerHTML += `<div class='padding-day'>${prevLastDay-i}</div>`;
                                                    }else if(i <= startWeekDay+totalMonthDay){
                                                        // adding this month days
                                                        date.setDate(day);
                                                        date.setHours(0,0,0,0);
                                                        
                                                        let dayClass = date.getTime()===today.getTime() ? 'current-day' : 'month-day';
                                                        calendarDays.innerHTML += `<div class='${dayClass}'>${day}</div>`;
                                                    }else{
                                                        // adding next month days
                                                        calendarDays.innerHTML += `<div class='padding-day'>${day-totalMonthDay}</div>`;
                                                    }
                                                }
                                            }

                                            document.querySelectorAll(".month-btn").forEach(function (element) {
                                                element.addEventListener("click", function () {
                                                date = new Date(currentMonth.textContent);
                                                    date.setMonth(date.getMonth() + (element.classList.contains("prev") ? -1 : 1));
                                                currentMonth.textContent = date.toLocaleDateString("en-US", {month:'long', year:'numeric'});
                                                renderCalendar();
                                                });
                                            });

                                            document.querySelectorAll(".btn-cal").forEach(function (element) {
                                                element.addEventListener("click", function () {
                                                    let btnClass = element.classList;
                                                    date = new Date(currentMonth.textContent);
                                                    if(btnClass.contains("today"))
                                                        date = new Date();
                                                    else if(btnClass.contains("prev-year"))
                                                        date = new Date(date.getFullYear()-1, 0, 1);
                                                    else
                                                        date = new Date(date.getFullYear()+1, 0, 1);
                                                    
                                                currentMonth.textContent = date.toLocaleDateString("en-US", {month:'long', year:'numeric'});
                                                renderCalendar();
                                                });
                                            });
                                        </script>
                                    <?php
                                     
                                     } 

                                     ?>
                                    </div>
                                </div>
                                
            
                                <!-- ************** -->
                                        <!-- end -->
                                <!-- ************** -->
                            </div>
                            <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                    
                                <?php  

                                $message_obj = new Message($con, $userLoggedIn);

                                echo "<h4>You and <a href='" . $username ."'>" . $profile_user_obj->getFirstAndLastName() . "</a></h4><hr /><br />";
                                echo "<div class='loaded_messages' id='scroll_messages'>";
                                echo $message_obj->getMessages($username);
                                echo "</div>";

                                ?>

                                <div class="message_post">
                                    <form action="" method="POST">
                                        <textarea name='message_body' id='message_textarea' placeholder='Write your message...'></textarea>
                                        <input type='submit' name='post_message' class='info' id='message_submit' value='Send' />
                                    </form>             
                                </div>
                            </div>  
                                <script>
                                    var div = document.getElementById("scroll_messages");
                                    if(div != null) {
                                        div.scrollTop = div.scrollHeight;
                                    }
                                </script> 

                            <div class="tab-pane fade" id="articles" role="tabpanel" aria-labelledby="articles-tab">
                                <div class="container">
                                    <div class=" wrapper-search-project">
                                        <input type="text" id="myFilterArticle" class="search-service" onkeyup="myFunctionArticle()" placeholder="Search for article...">
                                    </div>
                                    <br>
                                    <div class="row" id="articleCardContainer">
                                        
                                            <?php  
                                            $article = new Article($con, $userLoggedIn); 
                                            $articles = $article->getUserArticlesProfile($userLoggedIn);
                                            echo $articles;
                                            ?>
                                            
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="marketplaces" role="tabpanel" aria-labelledby="marketplaces-tab">
                                <div class="container">
                                    <p>marketplace</p>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>  
    

<script>
$(function(){

    var userLoggedIn = '<?php echo $userLoggedIn; ?>';
    var username = '<?php echo $username; ?>';
    var inProgress = false;

    loadPosts(); //Load first posts

    $(window).scroll(function() {
        var bottomElement = $(".status_post").last();
        var noMorePosts = $('.posts_area').find('.noMorePosts').val();
        // isElementInViewport uses getBoundingClientRect(), which requires the HTML DOM object, not the jQuery object. The jQuery equivalent is using [0] as shown below.
        if (isElementInView(bottomElement[0]) && noMorePosts == 'false') {
            loadPosts();
        }
    });
    function loadPosts() {
        if(inProgress) { //If it is already in the process of loading some posts, just return
            return;
        }
        
        inProgress = true;
        $('#loading').show();
    
        var page = $('.posts_area').find('.nextPage').val() || 1; //If .nextPage couldn't be found, it must not be on the page yet (it must be the first time loading posts), so use the value '1'
    
        $.ajax({
            url: "includes/handlers/ajax_load_profile_posts.php",
            type: "POST",
            data: "page=" + page + "&userLoggedIn=" + userLoggedIn + "&profileUsername=" + username,
            cache:false,
    
            success: function(response) {
                $('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
                $('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage 
                $('.posts_area').find('.noMorePostsText').remove(); //Removes current .nextpage 
    
                $('#loading').hide();
                $(".posts_area").append(response);
    
                inProgress = false;
            }
        });
    }
    //Check if the element is in view
    function isElementInView (el) {
            if(el == null) {
            return;
        }
        var rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && //* or $(window).height()
            rect.right <= (window.innerWidth || document.documentElement.clientWidth) //* or $(window).width()
        );
    }
});
</script>

    <br>
<hr>
<br>

<?php  

include("includes/footer.php");

?>