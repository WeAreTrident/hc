<?php  

include("includes/header.php");
require 'includes/form_handlers/add_project_docs.php';

$project = new Project($con, $userLoggedIn);

if(isset($_POST['post'])) {

    $project_id = $_GET['id'];

    $uploadOk = 1;
    $imageName = $_FILES['fileToUpload']['name'];
    $errorMessage = "";

    if($imageName != "") {
        $targetDir = "assets/images/projects/";
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
        $poject = new Post($con, $userLoggedIn);
        $project->submitPost($_POST['post_text'], $project_id);
    }
    else {
        echo "<div style='text-align:center;' class='alert alert-danger'>
                $errorMessage
            </div>";
    }
}

if(isset($_GET['id'])) {

    if (isset($_GET['del'])) {
        $doc_id = $_GET['del'];
        $project_id = $_GET['id'];
        $query = mysqli_query($con, "DELETE FROM project_docs WHERE id='$doc_id'");
        header("Location:projects.php?id=$project_id&d=1");		
    }

    $project_id = $_GET['id'];

    $project_name = $project->getProjectName($project_id);
    $date_created = $project->getProjectCreatedDate($project_id);
    $date_created = date("d/m/Y", strtotime($date_created));
    $created_by = $project->createdBy($project_id);

?>
        <div class="container">
            <div class="row project-header">
                <div class="col-12">
                    <div class="my-news-feed-title">
                        <h1><?php echo $project_name; ?></h1>
                    </div>
                    <div class="projects-sub-title">
                        <p>Project created by: <?php echo $created_by; ?> on <?php echo $date_created; ?></p>
                    </div>
                    <a href="new_project.php" class="main-button">Create New Project</a>
                    <ul class="nav nav-tabs tab-menu-profile" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="button-4 active" id="feed-tab" data-bs-toggle="tab" data-bs-target="#feed" role="tab" aria-controls="feed" aria-selected="true">Feed</button>
                          </li>
                          <li class="nav-item" role="presentation">
                              <button href="#documents" class="button-4" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" role="tab" aria-controls="documents" aria-selected="false">Documents</button>

                               <?php 
                              if (isset($_GET['d'])) { 

                                  $js = "<script>
                                         $(document).ready(function() {
                                            $('.nav-tabs a[href=\"#documents\"]').tab('show')
                                        });
                                        </script>";
                            }

                              ?> 

                         </li>
                          <li class="nav-item" role="presentation">
                              <button class="button-4" id="members-tab" data-bs-toggle="tab" data-bs-target="#members" role="tab" aria-controls="members" aria-selected="false">Members</button>
                          </li>
                          <li class="nav-item" role="presentation">
                              <button class="button-4" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</button>
                          </li>		  			  	
                    </ul>
                    <div class="wrapper-projects">
                    

                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="feed" role="tabpanel" aria-labelledby="feed-tab">
                            <form class="post_form" action="projects.php?id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data">
                                <div class="textarea-wrapper">
                                    <textarea class="input textarea-field-profile" name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
                                </div>
                                <div class="align-input-field-profile">
                                <div class='file-input'>
                                    <input type="file" name="fileToUpload" id="fileToUpload" />
                                      <span class='button'>Choose</span>
                                            <span class='label' data-js-label>No file selected</label>
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
                            <div class="posts_area"></div>
                            <div style="text-align: center;"><img src="assets/images/icons/loading.gif" id="loading" /></div>	
                          </div>

                          <div class="tab-pane fade" id="members" role="tabpanel" aria-labelledby="members-tab">
                              <h3>Invite</h3>
                            <div class="invite_invite_search">
                                <form class="invite-members" action="search.php" method="GET" name="invite_search_form">
                                    <input class="input-field-projects-members" type="text" onkeyup="getLiveSearchUsersProjects(this.value, '<?php echo $userLoggedIn; ?>')" name="q" placeholder="Search..." autocomplete="off" id="invite_search_text_input" />
                                    <button class="main-button">Send Invite</button>
                                </form>
                                <div class="invite_search_results"></div>
                                <div class="invite_search_results_footer_empty"></div>
                            </div>
                            <br>
                              <h3>Members</h3>
                              <br>
                              <?php

                                $member_list = $project->memberList($_GET['id']);
                                echo $member_list;

                              ?> 
                              <br>
                        </div>

                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">Settings
                        </div>



                        <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                              <form id="form-projects" action="projects.php?id=<?php echo $_GET['id']; ?>" method="POST">
                                  <div class="row">
                                      <div class="col-lg-9">
                                        <fieldset  class="xm-fieldset" id="prefix-0">
                                          <input class="input-field-projects" type="text" name="doc_link[]" placeholder="URL" />
                                          <input class="input-field-projects" type="text" name="doc_name[]" placeholder="Folder/Document Name" />
                                          <select class="input-field-projects" name="doc_type[]">
                                              <option value="" selected>Type</option>
                                              <option value="Folder">Folder</option>
                                              <option value="Document">Document</option>
                                              <option value="Spreadsheet">Spreadsheet</option>
                                              <option value="Presentation">Presentation</option>
                                              <option value="Video">Video</option>
                                              <option value="Other">Other</option> 				      	
                                          </select>				      
                                          <a class="decommission" href="#"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
                                          <a id="factory" href="#"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                        </fieldset>
                                      </div>
                                      <div class="col-lg-3">
                                        <input class="main-button" type="submit" name="submitDocForm" style="float: right;" />
                                      </div>
                                  </div>
                            </form>
                            

                            <?php echo $js; ?>

                            <script>
                            (function (jQuery) {
                                  jQuery.mark = {
                                    dupeIt: function (options) {
                                      var defaults = {
                                        selector: '#factory'
                                      };
                                      if (typeof options == 'string') defaults.selector = options;
                                      var options = jQuery.extend(defaults, options);
                                      return jQuery(options.selector).each(function () {
                                        var obj = jQuery(this);
                                        var geddit = $('.xm-fieldset:first');
                                        var gedditUp = geddit.parent();
                                        obj.click(function(e){
                                          var initialid = jQuery('.xm-fieldset:last').attr('id').split('-');
                                          var domaths = parseInt(initialid[1]) + 1;
                                          var newid = initialid[0] + '-' + domaths;
                                          jQuery('.xm-fieldset:first').clone(true,true).attr('id',newid).attr('title',newid).appendTo('#form-projects');
                                          e.preventDefault();
                                        });
                                      })
                                    },
                                    killIt: function (options) {
                                      var defaults = {
                                        selector: '.decommission'
                                      };
                                      if (typeof options == 'string') defaults.selector = options;
                                      var options = jQuery.extend(defaults, options);
                                      return jQuery(options.selector).each(function () {
                                        var obj = jQuery(this);
                                        obj.on("click", function(e){
                                          jQuery(this).parent().remove();
                                          e.preventDefault();
                                        });
                                      })
                                    }
                                  }
                                    })(jQuery);

                                    jQuery(function(){	
                                          jQuery.mark.dupeIt();
                                          jQuery.mark.killIt();
                                    });

                                    function doClone(){
                                          var initialid = jQuery('.xm-fieldset:last').attr('id').split('-');
                                          var domaths = parseInt(initialid[1]) + 1;
                                          var newid = initialid[0] + '-' + domaths;
                                          jQuery('.xm-fieldset:first').clone(true,true).attr('id',newid).attr('title',newid).appendTo('#form-projects');
                                    }

                            </script>

                             <?php  
                                // Check for no documents
                                $query = mysqli_query($con, "SELECT * FROM project_docs WHERE project_id='$project_id'");
                                if (mysqli_num_rows($query) == 0) {
                                    echo "<p>No documents have been added to this project yet.</p>";
                                }
                                else {
                                    // Get all documents
                                    echo "<br />";
                                    $docs_obj = new Document($con, $userLoggedIn);
                                    $docs = $docs_obj->getDocuments($project_id, "project");
                                    echo $docs;
                                }
                            ?> 
                        </div>

                        
                    </div>
                </div>
            
            
                </div>
            
        <br style="clear: both;" />
                </div>
        </div> 
     </div> 

        <?php 
        }
        else {

            if(isset($_POST['join_project'])) {

                $project_id = $_POST['id'];
                $add_member_query = mysqli_query($con, "UPDATE projects SET member_array=CONCAT(member_array, '$userLoggedIn,') WHERE id='$project_id'");
                header("Location: projects.php?id=$project_id");
            }

            $project_list = $project->mainProjectList();

            ?>

            

    

            <div class="container">
                <div class="my-news-feed-title">
                    <h1>Projects</h1>
                </div>
                <br>
                <div id="tabs" class="project-tabs-list">
                      <div><a class="button-4 active" id="tab12">All</a></div>
                      <div><a class="button-4" id="tab22">Joined Projects</a></div>
                      <div><a class="button-4" id="tab32">Not Joined</a></div>
                      <div><a class="button-4" id="tab42">Request Access</a></div>
                </div>

                <div class="projects-group">
                
                    <br>
                    <div class='container '>
                        <div class="row">
                            
                            
                            <div class="tab-container" id="tab12C">
                                <div class="top-bar-projects">
                                    <div class=" wrapper-search-project">
                                        <input type="text" id="myFilterTwo" class="search-service" onkeyup="myFunctionTwo()" placeholder="Search for card name...">
                                    </div>
                                    <div>
                                        <a href="new_project.php" class="main-button">Create New Project</a>
                                    </div>
                                
                                </div>
                                <div id="filterRowProjects">
                                    <div class="project-list-one col-12" >
                                        <div class="row">
                                            <div class="my-news-feed-title">
                                                <h3>Projects Joined</h3>
                                            </div>
                                            <?php 	echo $project_list; ?>	

                                        </div>
                                    </div>

                                    <div class="project-list-two col-12" >
                                        <div class="row">
                                            <div class="my-news-feed-title">
                                                <h3>Projects Not Joined</h3>
                                            </div>
                                            <?php 	echo $project_list; ?>	
                                        </div>
                                    </div>

                                    <div class="project-list-three col-12" >
                                        <div class="row">
                                            <div class="my-news-feed-title">
                                                <h3>Request Access</h3>
                                            </div>
                                            <?php 	echo $project_list; ?>	
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="tab-container" id="tab22C">
                                <div class="top-bar-projects">
                                    <div class=" wrapper-search-project">
                                        <input type="text" id="myFilterTabTwo" class="search-service" onkeyup="myFunctionTabTwo()" placeholder="Search for card name...">
                                    </div>
                                    <div>
                                        <a href="new_project.php" class="main-button">Create New Project</a>
                                    </div>
                                
                                </div>
                                <div id="filterRowProjectsTabTwo">
                                    <div class="project-list-one col-12" >
                                        <div class="row">
                                            <div class="my-news-feed-title">
                                            <h3>Projects Joined</h3>
                                        </div>
                                            <?php 	echo $project_list; ?>	
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="tab-container" id="tab32C">
                                <div class="top-bar-projects">
                                    <div class=" wrapper-search-project">
                                        <input type="text" id="myFilterTabThree" class="search-service" onkeyup="myFunctionTabThree()" placeholder="Search for card name...">
                                    </div>
                                    <div>
                                        <a href="new_project.php" class="main-button">Create New Project</a>
                                    </div>
                                
                                </div>
                                <div id="filterRowProjectsTabThree">
                                    <div class="project-list-two col-12" >
                                        <div class="row">
                                            <div class="my-news-feed-title">
                                            <h3>Projects Not Joined</h3>
                                        </div>
                                            <?php 	echo $project_list; ?>	
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-container" id="tab42C">
                                <div class="top-bar-projects">
                                    <div class=" wrapper-search-project">
                                        <input type="text" id="myFilterTabFour" class="search-service" onkeyup="myFunctionTabFour()" placeholder="Search for card name...">
                                    </div>
                                    <div>
                                        <a href="new_project.php" class="main-button">Create New Project</a>
                                    </div>
                                
                                </div>
                                <div id="filterRowProjectsTabFour">
                                    <div class="project-list-three col-12" >
                                        <div class="row">
                                            <div class="my-news-feed-title">
                                            <h3>Request Access</h3>
                                        </div>
                                            <?php 	echo $project_list; ?>	
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            
                        </div>
                        
                    </div>
                </div>
                        
            </div>
            <br /><br />
    <?php 

}

?>
        </div> 
        </div>

    
<script>
$(function(){
 
    var userLoggedIn = '<?php echo $userLoggedIn; ?>';
    var projectId = '<?php echo $_GET['id']; ?>';
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
            url: "includes/handlers/ajax_load_project_posts.php",
            type: "POST",
            data: "page=" + page + "&userLoggedIn=" + userLoggedIn + "&projectId=" + projectId,
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



<?php 

include("includes/footer.php");

?>