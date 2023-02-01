<?php 

include("includes/header.php");

$message_obj = new Message($con, $userLoggedIn);

if (isset($_GET['u'])) {
	$user_to = $_GET['u'];
	if ($_GET['a'] == "del") {
		$message_obj->archiveConvo($userLoggedIn, $_GET['u']);
	}
	if ($_GET['a'] == "restore") {
		$message_obj->restoreConvo($userLoggedIn, $_GET['u']);
	}
}
else {
	$user_to = $message_obj->getMostRecentUser();

	if($user_to == false)
		$user_to = 'new';
}

if ($user_to != "new")
	$user_to_obj = new User($con, $user_to);

if (isset($_POST['post_message'])) {

	if(isset($_POST['message_body'])) {
		$body = mysqli_real_escape_string($con, $_POST['message_body']);
		$body = nl2br($body);

		$date = date("Y-m-d H:i:s");
		$message_obj->sendMessage($user_to, $body, $date);
	}
}
if (isset($_POST['save_draft'])) {

	if(isset($_POST['message_body'])) {
		$body = mysqli_real_escape_string($con, $_POST['message_body']);
		$body = nl2br($body);

		$date = date("Y-m-d H:i:s");
		$message_obj->saveDraft($user_to, $body, $date);
	}
}
?>
<br>
<div class="message-wrapper container">
	<div class="row">
		<div class="col-12" style="margin-left: 15px;">
			<div class="my-news-feed-title">
				<h1>Messages</h1>
                <a href="messages.php">Inbox</a> | <a href="messages.php?v=archived">Archived</a> | <a href="messages.php?v=draft">Draft</a>
			</div>

			<?php  
				if ($user_to != "new") {
					echo "<div class='top-convo-names-title'>";
                    echo "<br>";
					echo "</div>";
				}
			?>
		</div>
	</div>
	<div class="row message-page-message-box">
		<div class="col-lg-5 message-borders">
		<script>
			//var div = document.getElementById("scroll_messages");
			$("#scroll_messages").scrollTop($("#scroll_messages")[0].scrollHeight);

		</script>
			<div class="user_details message-section-left" id="conversations">
				<!-- <h4>Conversations</h4>  -->
				<div class="message-search">
					<div class="search-bar-message">
						<input type="text" class="searchTerm"  id="docSearchFour"onkeyup="myFunctionThree()" placeholder="What are you looking for?">
						<i class="fa fa-search"></i>
					</div>
				</div>
				<div class="loaded_conversations message-page-other-messages" id="messageFilter">

					<?php
					if ($_GET['v'] == "archived")
						echo $message_obj->getConvos("999999999999","deleted"); 	
					else
						echo $message_obj->getConvos("999999999999","inbox");
					?>
				</div>
				<br />	
			</div>
		</div>
		<div class="col-lg-7 message-borders-2">
			<div class="main_column" id="main_column">
				<?php  

				if ($user_to != "new") {
					echo "<div class='top-convo-names'>";
					echo "<a class='new-message-message-page' href='messages.php?u=new'><i class='fa fa-edit'></i></a>";
					echo "</div>";
					echo "<div class='loaded_messages' id='scroll_messages'>";
					echo "<br>";
					echo "<div class='chat-overflow'>";
					echo "<p style='text-align: center; color: lightgrey;'>----- Start of Conversation -----</p>";
					echo "<div class='group-messages-chat'>";
					echo $message_obj->getMessages($user_to);
					echo "</div>";
					echo "<p style='text-align: center; color: lightgrey;'>----- End of Conversation -----</p>";
					echo "</div>";
					echo "</div>";
				}
				// else {
				// 	echo "<h4>New Message</h4>";
				// }
				?>
	
    				<script src="https://unpkg.com/vue-emoji-picker/dist/vue-emoji-picker.js"></script>
    				<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.js"></script>
						<?php  

						if ($user_to == "new") {
							echo "<div class='message_post_new'>";
							echo "<form action='' method='POST' class='form-messages-page-new'>";
							echo "<p style='color: grey;'>Select the friend you would like to message</p>";
			
							?>
							 <input type='text' onkeyup='javascript:getUsers(this.value, "<?php echo $userLoggedIn; ?>")' name='q' placeholder='Name' autocomplete='off' id='search_text_input' class='settings-input-account'>
							<?php
							echo "<div class='results_main_top'><div class='results_main'><div class='results'></div></div></div>";
							echo "</form>";
							echo "</div>";
						}
						else {
							echo "<div class='message_post' id='app'><div class='wrapper_one'><form action='' method='POST' class='form-messages-page'>
							<textarea v-model='input' class='text-area-messages'  name='message_body' id='message_textarea-message-page' placeholder='Write your message...'></textarea>";
							echo "<button type='submit' name='save_draft' class='info' id='save_draft' /><i class='fa-solid fa-floppy-disk'></i></button>
                            <button type='submit' name='post_message' class='info' id='message_submit' value='Send' /><i class='far fa-paper-plane'></i></button><br>"; ?>

							 <emoji-picker @emoji="append" :search="search">
							      <div
							        class="emoji-invoker"
							        slot="emoji-invoker"
							        slot-scope="{ events: { click: clickEvent } }"
							        @click.stop="clickEvent"
							      >
							        <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
							          <path d="M0 0h24v24H0z" fill="none"/>
							          <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
							        </svg>
							      </div>
							      <div slot="emoji-picker" slot-scope="{ emojis, insert, display }">
							        <div class="emoji-picker" :style="{ top: display.y + 'px', left: display.x + 'px' }">
							          <div class="emoji-picker__search">
							            <input type="text" v-model="search" v-focus>
							          </div>
							          <div>
							            <div v-for="(emojiGroup, category) in emojis" :key="category">
							              <h5>{{ category }}</h5>
							              <div class="emojis">
							                <span
							                  v-for="(emoji, emojiName) in emojiGroup"
							                  :key="emojiName"
							                  @click="insert(emoji)"
							                  :title="emojiName"
							                >{{ emoji }}</span>
							              </div>
							            </div>
							          </div>
							        </div>
							      </div>
							    </emoji-picker>

								    <?php 
								 echo "</form></div></div>";
							
						}

						?>
				<script>
					Vue.use(EmojiPicker)

						new Vue({
						  el: '#app',
						  data() {
						    return {
						      input: '',
						      search: '',
						    }
						  },
						  methods: {
						    append(emoji) {
						      this.input += emoji
						    },
						  },
						  directives: {
						    focus: {
						      inserted(el) {
						        el.focus()
						      },
						    },
						  },
						})
				</script>			
			</div>
		</div>
	</div>
</div>