<?php include("includes/header.php"); ?>

<section class="lab-test-inner">
	<div class="container">
		<div class="row">
			<p class="breadcrumb"><i class="fa-solid fa-caret-left"></i> Lab Tests</p>
			<h2>Blood Analysis Forms</h2><br>
			<div class="mental-sec">
                <div class="mental-line">
                    <div class="row">
                        <div class="col-md-1">
                            <div class="mental-icon">
                                <a href="#"><i class="fa-solid fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="mental-title">
                                <p>Blood Typing</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mental-history">
                                <p>Form History <span><i class="fa-solid fa-clock-rotate-left"></i></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mental-line">
                    <div class="row">
                        <div class="col-md-1">
                            <div class="mental-icon">
                                <a href="#"><i class="fa-solid fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="mental-title">
                                <p>Full Blood Count</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mental-history">
                                <p>No results</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mental-line">
                    <div class="row">
                        <div class="col-md-1">
                            <div class="mental-icon">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#ureaModal"><i class="fa-solid fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="mental-title">
                                <p>Urea and Electrolytes</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mental-history">
                                <p>Form History <span><i class="fa-solid fa-clock-rotate-left"></i></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mental-line">
                    <div class="row">
                        <div class="col-md-1">
                            <div class="mental-icon">
                                <a href="#"><i class="fa-solid fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="mental-title">
                                <p>Liver Function Tests</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mental-history">
                                <p>No results</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mental-line">
                    <div class="row">
                        <div class="col-md-1">
                            <div class="mental-icon">
                                <a href="#"><i class="fa-solid fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="mental-title">
                                <p>Thyroid Function Tests</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mental-history">
                                <p>Form History <span><i class="fa-solid fa-clock-rotate-left"></i></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mental-line">
                    <div class="row">
                        <div class="col-md-1">
                            <div class="mental-icon">
                                <a href="#"><i class="fa-solid fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="mental-title">
                                <p>Blood Glucose</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mental-history">
                                <p>No results</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mental-line">
                    <div class="row">
                        <div class="col-md-1">
                            <div class="mental-icon">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#xrayModal"><i class="fa-solid fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="mental-title">
                                <p>Leg X-ray</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mental-history">
                                <p>No results</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</section>

<div class="modal fade" id="ureaModal" tabindex="-1" aria-labelledby="newureaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h5 class="modal-title" id="newnoteModalLabel">Add New Condition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> -->
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="note-box">
                        <div class="top-note">
                            <h3 class="text-center">Urea and Electrolytes</h3>
                            <div class="note-close">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </div>
                        <div class="body-note">
                            <form action="" method="POST" class="urea-form">
                            	<p><i class="fa-solid fa-circle-exclamation"></i>  ATTENTION! Ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut ero labore et dolore magna aliqua. Ut enim ad minim veni exercitation ullamco poriti laboris nisi ut aliquip ex ea Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut ero labore et dolore magna aliqua. Ut enim ad minim veni exercitation ullamco poriti laboris nisi ut aliquip ex ea Read more</p>
                            	<div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="">Question</label>
                                        <input type="text" class="form-control" id="name" placeholder="Answer text"> 
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Question</label>
                                        <input type="text" class="form-control" id="name" placeholder="Answer text"> 
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Question</label>
                                        <input type="text" class="form-control" id="name" placeholder="Answer text"> 
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Question</label>
                                        <input type="text" class="form-control" id="name" placeholder="Answer text"> 
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Question</label>
                                        <input type="text" class="form-control" id="name" placeholder="Answer text"> 
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Question</label>
                                        <input type="text" class="form-control" id="name" placeholder="Answer text"> 
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Question</label>
                                        <input type="text" class="form-control" id="name" placeholder="Answer text"> 
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Question</label>
                                        <input type="text" class="form-control" id="name" placeholder="Answer text"> 
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Question</label>
                                        <input type="text" class="form-control" id="name" placeholder="Answer text"> 
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Question</label>
                                        <input type="text" class="form-control" id="name" placeholder="Answer text"> 
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Question</label>
                                        <input type="text" class="form-control" id="name" placeholder="Answer text"> 
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Question</label>
                                        <input type="text" class="form-control" id="name" placeholder="Answer text"> 
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="xrayModal" tabindex="-1" aria-labelledby="xrayModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h5 class="modal-title" id="newnoteModalLabel">Add New Condition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> -->
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="note-box">
                        <div class="top-note">
                            <h3 class="text-center">Leg X-ray</h3>
                            <div class="note-close">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </div>
                        <div class="body-note">
                            <div class="xray-img">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div class="xray-top">
                                            <p>
                                                <a href="#">Older results</a>
                                                <i class="fa-solid fa-caret-left"></i>
                                                <span class="date">01/04/2022</span>
                                                <i class="fa-solid fa-caret-right"></i>
                                                <a href="#">Newer results</a>
                                            </p>
                                            <img src="/assets/images/xray/xray.png" class="img-fluid">
                                        </div>
                                        <div class="xray-content">
                                            <div class="row border-line">
                                                <div class="col-md-6 border-line-right">
                                                    <div class="left-side">
                                                        <h5>Body Part</h5>
                                                        <p>Leg</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="right-side">
                                                        <h5>Subtitle 2 - Question</h5>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor. - Answer</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row border-line">
                                                <div class="col-md-6 border-line-right">
                                                    <div class="left-side">
                                                        <h5>Subtitle 2 - Question</h5>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor. - Answer</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="right-side">
                                                        <h5>Subtitle 2 - Question</h5>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor. - Answer</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row border-line">
                                                <div class="col-md-6 border-line-right">
                                                    <div class="left-side">
                                                        <h5>Subtitle 2 - Question</h5>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor. - Answer</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="right-side">
                                                        <h5>Subtitle 2 - Question</h5>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor. - Answer</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row border-line">
                                                <div class="col-md-6 border-line-right">
                                                    <div class="left-side">
                                                        <h5>Subtitle 2 - Question</h5>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor. - Answer</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="right-side">
                                                        <h5>Subtitle 2 - Question</h5>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor. - Answer</p>
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
            </div>
        </div>
    </div>
</div>

<script>
	$('#ureaModal').on('show.bs.modal', function () {
	   $('.container').addClass('blur');
	})

	$('#ureaModal').on('hide.bs.modal', function () {
	   $('.container').removeClass('blur');
	})
    $('#xrayModal').on('show.bs.modal', function () {
       $('.container').addClass('blur');
    })

    $('#xrayModal').on('hide.bs.modal', function () {
       $('.container').removeClass('blur');
    })
</script>

<?php include("includes/footer.php"); ?>