
    <?php  

include("includes/header.php");

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

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- ********************************************** -->
    <!-- Two tabs for both front and back of the svg   -->
    <!-- ********************************************* -->

<div class="container my-news-feed-title">
    <!-- <h1>Medical Notes</h1>
</div>
<br>
<br> -->

<div class="container">
    <div class="tabs-two">
    <div id="tabs-nav-two" class="project-tabs-list">
        <div><a class="button-4" href="#tab1">Front</a></div>
        <div><a class="button-4" href="#tab2">Back</a></div>
    </div> <!-- END tabs-nav -->
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
                            <input type="text" id="myFilterBody" class="search-service" onkeyup="myFunctionBody()" placeholder="Search...">
                            <i class="fa fa-search fa-lg" aria-hidden="true"></i>
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

                            <!--     <a href='?delete=true&id=". $re['id'] ."'><i class='fas fa-trash-alt'></i></a> -->
                
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
                            <input type="text" id="myFilterBodyBack" class="search-service" onkeyup="myFunctionBodyBack()" placeholder="Search for card name...">
                            <i class="fa fa-search fa-lg" aria-hidden="true"></i>
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
        <!--<div class="form-group">
            <label for="textinput">Name</label>
            <div>-->
                <input class="settings-input-account" id="textinput" name="name" type="hidden" value="Laura Dugdale" placeholder="Name...">
            <!--</div>
        </div>
        <div class="form-group">
            <label for="textinput">Created By</label>
            <div>-->
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
<br>
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
        "top": (y) + 'px'
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



<?php  

include("includes/footer.php");

?> 
