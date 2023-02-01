<?php  

include("includes/header.php");
require 'includes/form_handlers/add_docs.php';
require 'includes/form_handlers/add_shared_doc.php';

if (isset($_GET['del'])) {
	$doc_id = $_GET['del'];
	$project_id = $_GET['id'];
	$query = mysqli_query($con, "DELETE FROM profile_docs WHERE id='$doc_id'");
	header("Location:documents.php");		
}


?>
				
				<div class="container my-news-feed-title">
				    <h1><?php echo $user['first_name'] . " " . $user['last_name']; ?>'s Documents</h1>
				</div>
				<br />
				<div class="container">
						<ul class="nav nav-tabs" id="myTab" role="tablist" style="border-bottom: none;">
							<li class="nav-item" role="presentation">
						    	<a class=" active button-4" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab" aria-controls="documents" aria-selected="true">My Documents</a>
						  	</li>
						  	<li class="nav-item" role="presentation">
						  		<a href="#shared" class=" button-4" id="shared-tab" data-bs-toggle="tab" data-bs-target="#shared" type="button" role="tab" aria-controls="shared" aria-selected="false">Shared With Me</a>
						 	</li>
						</ul>
					<div class="my-docs-container">
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="documents" role="tabpanel" aria-labelledby="documents-tab">
								<form id="form-projects" action="documents.php?id=<?php echo $_GET['id']; ?>" method="POST">
									<div class="row">
										<div class="col-9">
										    <fieldset  class="xm-fieldset" id="prefix-0">
												<input class="input-field-projects" type="text" name="doc_name[]" placeholder="Folder/Document Name" />
												<input class="input-field-projects" type="text" name="doc_link[]" placeholder="URL" />
												<select class="input-field-projects" type="text" name="doc_type[]">
													<option value="" selected>Type</option>
													<option value="Folder">Folder</option>
													<option value="Document">Document</option>
													<option value="Spreadsheet">Spreadsheet</option>
													<option value="Presentation">Presentation</option>
													<option value="Video">Video</option>
													<option value="Other">Other</option> 				      	
												</select>				      
										    	<a class="decommission" href="#"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
										    	<a id="factory" ><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
										    </fieldset>
										</div>
										<div class="col-3">
									    	<input class="projects-submit-button" type="submit" name="submitDocForm" />
										</div>
									</div>
								</form>
								<br>
							  	
							  	
								<?php

								$docs_obj = new Document($con, $userLoggedIn);
								$docs = $docs_obj->getDocuments($userLoggedIn, "profile");
								echo $docs;

								?>
					 		</div></div>
							<div class="tab-pane fade" id="shared" role="tabpanel" aria-labelledby="shared-tab">
								<?php
									$shared_docs_obj = new Document($con, $userLoggedIn);
									$shared_docs = $shared_docs_obj->getSharedDocuments($userLoggedIn);
									echo $shared_docs;
								?>
							</div>
						</div>
					</div>

				</div>
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

include("includes/footer.php");

?>