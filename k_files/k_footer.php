<?php 
// if(is_resource($connect)) mysql_close($connect); 
?>
<!-- end: page -->
				</section>
			</div>

			<aside id="sidebar-right" class="sidebar-right">
				<div class="nano">
					<div class="nano-content" style="width: 100%; right: -17px;">
						<a href="#" class="mobile-close visible-xs">
							Collapse <i class="fa fa-chevron-right"></i>
						</a>
			
						<div class="sidebar-right-wrapper">
							
							<h2>Shortcuts</h2>
								
							<div class="sidebar-widget">
								<table class="table table-bordered" style="color: #C3C3C3">
									<thead>
										<tr>
											<td width1="45%"><b>Key</b></td>
											<td><b>Description</b></td>
											<td><b>Scope</b></td>
										</tr>
									</thead>
									<tbody>
										<!-- <tr><td><b>Alt + /</b></td><td>Open/Close Shortcuts</td><td>All Pages</td></tr> -->
										<tr><td><b>Alt + N</b></td><td>Add New Form</td><td>List View</td></tr>
										<tr><td><b>Ctrl + E</b></td><td>Preview edit form</td><td>Preview Page</td></tr>
										<tr><td><b>Ctrl + D</b></td><td>Preview Delete</td><td>Preview Page</td></tr>
										<tr><td><b>Ctrl + S</b></td><td>Save & Update</td><td>All Pages</td></tr>
										<tr><td><b>Alt + A</b></td><td>Save And Add More</td><td>Form</td></tr>
										<tr><td><b>Ctrl + P</b></td><td>Save And Preview</td><td>Form</td></tr>
										<tr><td><b>Alt + F</b></td><td>FIND in Menu</td><td>All Pages</td></tr>
										<tr><td><b>Alt + G</b></td><td>Add Grid Row</td><td>All Pages</td></tr>
										<tr><td><b>Alt + K</b></td><td>Auto Fill Amount In Adjustment</td><td>Form</td></tr>
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</aside>
		</section>


		<?php 
		//FOR SQL PROFILER FOR USERS
		$userCategory = isset ($_SESSION['Category']) ? $_SESSION['Category'] : 0;
		if($userCategory == 2){			
		?>
			<style>
				html .scroll-to-top{
					right: 230px !important;
				}
				#chat-popup {
					position: fixed;
					bottom: 0;
					right: 0;
					width: 300px;
					height: 400px;
					border: 1px solid #ccc;
					background: #fff;
					box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
					transition: all 0.3s ease;
					display: none;
					flex-direction: column;
					z-index: 1000;
				}
		
				#chat-popup.minimized {
					display: flex;
					width: 230px;
					height: 40px;
					bottom: 0;
					right: 0;
				}
		
				#chat-popup.maximized {
					display: flex;
					width: 80%;
					height: 80%;
					bottom: 10%;
					right: 10%;
				}
		
				#chat-header {
					background: #b80dba;
					color: #fff;
					padding: 10px;
					display: flex;
					border-radius: 10px 10px 0 0;
					justify-content: space-between;
					align-items: center;
				}
		
				#chat-body {
					flex: 1;
					padding: 10px;
					overflow-y: auto;
				}

				#chat-btns button{
					width: 50px;
					height: 50px;
					right: 14px;
					color: white;
					font-size: 25px;
					position: absolute;
					top: 45px;
					border: 0;
				}
				
			</style>
			<!--script src="https://code.jquery.com/jquery-3.6.0.min.js"></script-->
			<script>
				var scrollHt = 0;
				$(document).ready(function() {
					$('#chat-popup').addClass('minimized');		// Initially show the minimized chat popup
		
					$('#chat-header').click(function() {
						toggleChat();		// Click event to toggle the chat popup
					});
		
					function toggleChat() {			// Function to toggle chat between minimized and open
						console.log('calling toggleChat');
						if ($('#chat-popup').hasClass('minimized')) {
							$('#chat-popup').removeClass('minimized');
							$('#chat-popup').css('display', 'flex');
							$('#chat-minimize').show();
							$('#chat-maximize').show();
							$('#chat-open').hide();
							// $("#showSQLDebugger").val(1);
						} else {
							$('#chat-popup').removeClass('maximized');
							$('#chat-popup').addClass('minimized');
							//$('#chat-popup').css('display', 'none');
							$('#chat-minimize').hide();
							$('#chat-maximize').show();
							$('#chat-open').show();
							// $("#showSQLDebugger").val(0);
						}
					}		
					window.maximizeChat = function() {			// Function to maximize the chat popup
						console.log('calling maximizeChat');
						$('#chat-popup').removeClass('minimized');
						$('#chat-popup').addClass('maximized');
						//$('#chat-popup').css('display', 'flex');
						$('#chat-minimize').show();
						$('#chat-maximize').hide();
						$('#chat-open').show();
						// $("#showSQLDebugger").val(1);
					}
					window.minimizeChat = function() {			// Function to minimize the chat popup
						console.log('calling minChat');
						$('#chat-popup').removeClass('maximized');
						$('#chat-popup').addClass('minimized');
						//$('#chat-popup').css('display', 'none');
						$('#chat-minimize').hide();
						$('#chat-maximize').show();
						$('#chat-open').show();
						// $("#showSQLDebugger").val(0);
					}
					$('#chat-open').click(function() {
						console.log('openMinimizedChat');
						$('#chat-popup').removeClass('maximized');
						$('#chat-popup').removeClass('minimized');
						$('#chat-popup').css('display', 'flex');
						$('#chat-minimize').show();
						$('#chat-maximize').show();
						$('#chat-open').hide();
						// $("#showSQLDebugger").val(1);
					});					
					$("#chat-btn-start").on("click", function() {
						$("#chat-btn-start").hide();
						$("#chat-btn-stop").show();
						$("#showSQLDebugger").val(1);
						StartStopProfiler(1);
					});
					$("#chat-btn-stop").on("click", function() {
						$("#chat-btn-start").show();
						$("#chat-btn-stop").hide();
						$("#showSQLDebugger").val(0);
						StartStopProfiler(0);
					});
				});
				function StartStopProfiler(action){
					$.ajax({
						type : 'POST',
						dataType: 'json',
						data : { action : action },
						url: "getStartStopProfiler.php",
						success : function(result){
							console.log(result)
						},
					});
				}

				function isScrolledToBottom(element) {
					var chk = (element.scrollHeight - element.scrollTop - 30 < element.clientHeight)
					// console.log("isScrolledToBottom","chk=" + chk,
					// 		 "LHS=" + Math.ceil(element.scrollHeight - element.scrollTop - 30), 
					// 		 "RHS=" + element.clientHeight, 
					// 		 element.scrollHeight, Math.ceil(element.scrollTop), scrollHt)
					return chk;
				}
				function scrollToBottom(element) {
					element.scrollTop = element.scrollHeight;
					scrollHt = element.scrollHeight;
				}


				// if(<?php echo $_SESSION['user_id']; ?> == 1025){
				// 	// const sessionTimeout = 1800; // 30 mins
				// 	// const warningTime = 300;     // 5 mins
				// 	const sessionTimeout = <?php echo $userSessionTimeout; ?> * 60; // For user 1 hour & for developer 2 hour
				// 	const warningTime = <?php echo $userWarningTime; ?> * 60;  
				// 	let warningShown = false;
				// 	let countdownInterval = null;

				// 	function updateLastActivity() {
				// 		const now = Date.now();
				// 		localStorage.setItem('lastActivity', now);
				// 	}

				// 	$(document).on('mousemove keydown click', updateLastActivity);

				// 	// Listen to storage event from other tabs
				// 	window.addEventListener('storage', function (event) {
				// 		if (event.key === 'lastActivity') {
				// 			// Reset own timer based on activity from another tab
				// 			lastActivity = parseInt(event.newValue);
				// 			if (warningShown) {
				// 				removeSessionWarning();
				// 			}
				// 		}
				// 	});

				// 	let lastActivity = parseInt(localStorage.getItem('lastActivity')) || Date.now();

				// 	setInterval(() => {
				// 		const now = Date.now();
				// 		lastActivity = parseInt(localStorage.getItem('lastActivity')) || now;
				// 		const elapsed = (now - lastActivity) / 1000;
				// 		console.log(lastActivity, elapsed);
				// 		if (elapsed >= (sessionTimeout - warningTime)) {
				// 			console.log("after",lastActivity, elapsed);
				// 			showSessionWarning(sessionTimeout - warningTime - 10);
				// 		}
				// 	}, 1000);

				// 	function showSessionWarning(remainingTime) {
				// 		// 
				// 		// if (warningShown) return;
				// 		warningShown = true;

				// 		let countdown = warningTime;
					

				// 		// $('body').append(`
				// 		// 	<div id="session-warning-modal" ...>
				// 		// 		<div>
				// 		// 			<p>Your session will expire in <span id="countdown-timer">05:00</span>.</p>
				// 		// 			<button id="extend-session">Extend Session</button>
				// 		// 			<button id="logout-now">Logout</button>
				// 		// 		</div>
				// 		// 	</div>
				// 		// // `);

				// 		const modalHtml = `
				// 		<div class="modal fade" id="session-warning-modal" tabindex="-1" role="dialog" aria-hidden="true">
				// 			<div class="modal-dialog modal-dialog-centered" role="document">
				// 				<div class="modal-content text-center">
				// 					<div class="modal-body" style="padding: 30px;">
				// 						<!-- Warning Icon -->
				// 						<div style="font-size: 60px; color: #ff9800; margin-bottom: 10px;">
				// 							<i class="fa fa-exclamation-circle"></i>
				// 						</div>

				// 						<!-- Warning Title -->
				// 						<h3 class="fw-bold mb-3" style="font-weight: 700;color: #000000ff;">Warning</h3>

				// 						<!-- Message -->
				// 						<p class="mb-2" style="font-size: 16px; color: #333;">
				// 							Your logged-in session will expire in next 
				// 							<b><span id="session-timer" style="color:#d9534f;">${formatTime(remainingTime)}</span></b> seconds.
				// 						</p>
				// 						<p style="font-size: 15px; color: #555;">
				// 							Click <b>Continue</b> to extend your session, or click <b>Logout</b> to log out of the application.
				// 						</p>

				// 						<!-- Buttons -->
				// 						<div class="mt-4 d-flex justify-content-center gap-3">
				// 							<button id="logout-now" class="btn btn-default px-4">Logout</button>
				// 							<button id="extend-session" class="btn btn-primary px-4">Continue</button>
				// 						</div>
				// 					</div>
				// 				</div>
				// 			</div>
				// 		</div>`;

				// 		$('body').append(modalHtml);

				// 			// Show the modal properly using Bootstrap
				// 			const modal = $('#session-warning-modal');
				// 			modal.modal({
				// 				backdrop: 'static',
				// 				keyboard: false
				// 			});
				// 			modal.modal('show');

				// 		countdownInterval = setInterval(() => {
				// 			countdown--;
				// 			$('#countdown-timer').text(formatTime(countdown));
				// 			if (countdown <= 0) {
				// 				clearInterval(countdownInterval);
				// 				window.location.href = '/logout.php';
				// 			}
				// 		}, 1000);

				// 		// $('#extend-session').on('click', function () {
				// 		// 	$.post('extend_session.php', { csrf_token: CSRF_TOKEN }, () => {
				// 		// 		updateLastActivity(); // Notify all tabs
				// 		// 		removeSessionWarning();
				// 		// 	});
				// 		// });

				// 		$('#extend-session').on('click', function () {
				// 			$.post('extend_session.php', () => {
				// 				modal.modal('hide');
				// 				$(".modal-backdrop").remove();
				// 				updateLastActivity(); // Notify all tabs
				// 				removeSessionWarning();
				// 				// lastActivity = Date.now();
				// 				warningShown = false;
				// 				// console.log('Session extended by user');
				// 			});
				// 		});

				// 		$('#logout-now').on('click', function () {
				// 			clearInterval(countdownInterval);
				// 			window.location.href = '/logout.php';
				// 		});
				// 	}

				// 	function removeSessionWarning() {
				// 		$('#session-warning-modal').remove();
				// 		$(".modal-backdrop").remove();
				// 		warningShown = false;
				// 		clearInterval(countdownInterval);
				// 	}

				// 	function formatTime(seconds) {
				// 		const m = Math.floor(seconds / 60).toString().padStart(2, '0');
				// 		const s = Math.floor(seconds % 60).toString().padStart(2, '0');
				// 		return `${m}:${s}`;
				// 	}

				// }

				// const sessionTimeout = <?php echo $userSessionTimeout; ?> * 60; // For user 1 hour & for developer 2 hour
				// const warningTime = <?php echo $userWarningTime; ?> * 60;     // show popup after for user 55 minute & for developer 115 minute of inactivity
				// let lastActivity = Date.now();
				// let warningShown = false;
				// let sessionTimer;
				// let logoutCountdown; // to store countdown interval

				// function showSessionWarning(remainingTime) {
				// 	if (warningShown) return;
				// 	warningShown = true;

				// 	// If modal already exists, remove it first
				// 	$('#session-warning-modal').remove();

				// 	// Create a proper Bootstrap modal structure
				// 	const modalHtml = `
				// 	<div class="modal fade" id="session-warning-modal" tabindex="-1" role="dialog" aria-hidden="true">
				// 		<div class="modal-dialog modal-dialog-centered" role="document">
				// 			<div class="modal-content text-center">
				// 				<div class="modal-body" style="padding: 30px;">
				// 					<!-- Warning Icon -->
				// 					<div style="font-size: 60px; color: #ff9800; margin-bottom: 10px;">
				// 						<i class="fa fa-exclamation-circle"></i>
				// 					</div>

				// 					<!-- Warning Title -->
				// 					<h3 class="fw-bold mb-3" style="font-weight: 700;color: #000000ff;">Warning</h3>

				// 					<!-- Message -->
				// 					<p class="mb-2" style="font-size: 16px; color: #333;">
				// 						Your logged-in session will expire in next 
				// 						<b><span id="session-timer" style="color:#d9534f;">${formatTime(remainingTime)}</span></b> seconds.
				// 					</p>
				// 					<p style="font-size: 15px; color: #555;">
				// 						Click <b>Continue</b> to extend your session, or click <b>Logout</b> to log out of the application.
				// 					</p>

				// 					<!-- Buttons -->
				// 					<div class="mt-4 d-flex justify-content-center gap-3">
				// 						<button id="logout-now" class="btn btn-default px-4">Logout</button>
				// 						<button id="extend-session" class="btn btn-primary px-4">Continue</button>
				// 					</div>
				// 				</div>
				// 			</div>
				// 		</div>
				// 	</div>`;


				// 	// Append modal to body
				// 	$('body').append(modalHtml);

				// 	// Show the modal properly using Bootstrap
				// 	const modal = $('#session-warning-modal');
				// 	modal.modal({
				// 		backdrop: 'static',
				// 		keyboard: false
				// 	});
				// 	modal.modal('show');

				// 	let timeLeft = Math.round(remainingTime);
				// 	const timerDisplay = $('#session-timer');

				// 	logoutCountdown = setInterval(() => {
				// 		timeLeft--;
				// 		timerDisplay.text(formatTime(timeLeft));

				// 		if (timeLeft <= 0) {
				// 			clearInterval(logoutCountdown);
				// 			modal.modal('hide');
				// 			window.location.href = '/logout.php';
				// 		}
				// 	}, 1000);

				// 	// When user clicks "Extend"
				// 	$('#extend-session').on('click', function () {
				// 		clearInterval(logoutCountdown);
				// 		$.post('extend_session.php', () => {
				// 			modal.modal('hide');
				// 			lastActivity = Date.now();
				// 			warningShown = false;
				// 			console.log('Session extended by user');
				// 		});
				// 	});

				// 	// When user clicks "Logout Now"
				// 	$('#logout-now').on('click', function () {
				// 		clearInterval(logoutCountdown);
				// 		modal.modal('hide');
				// 		window.location.href = '/logout.php';
				// 	});
				// }

				// ✅ Helper function to convert seconds → MM:SS
				// function formatTime(seconds) {
				// 	const m = Math.floor(seconds / 60).toString().padStart(2, '0');
				// 	const s = Math.floor(seconds % 60).toString().padStart(2, '0');
				// 	return `${m}:${s}`;
				// }

				function loadLog() {
					console.log($("#showSQLDebugger").val())
					if(+$("#showSQLDebugger").val() == 1){
						// var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request 
						$.ajax({
							url: "getSQLprofiler.php",
							cache: false,
							success: function (html) {
								//Auto-scroll 
								// var chatbox = document.getElementById('chatbox');
								// console.log("chatbox.scrollHeight",chatbox.scrollHeight)
    							// chatbox.scrollTop = chatbox.scrollHeight;
								var chatbox = document.getElementById('chat-body');
								// console.log("Ht = ",chatbox.scrollHeight);
								var wasScrolledToBottom = isScrolledToBottom(chatbox);
								$("#chat-body").html(html); //Insert chat log into the #chatbox div 

								if (wasScrolledToBottom || scrollHt == 0) {
									// console.log("scrolling to bottom")
									scrollToBottom(chatbox);
								}
							
								// var newScroll = document.getElementById('chatbox').scrollHeight;
								// console.log(newScroll, scrollHt)
								// if(newScroll > scrollHt + 50)	scrollHt = newScroll;
								// $('#chat-body').scrollTop(scrollHt);


								// var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request 
								// if(newscrollHeight > oldscrollHeight){
								// 	$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div 
								// }	
							}
						});
					}

					// var elapsed = (Date.now() - lastActivity) / 1000;
					// // elapsed = elapsed + 10;
					// //  console.log(Date.now(),lastActivity, 'Inactive for:', elapsed, sessionTimeout, 'seconds', "warningTime ",warningTime,warningShown);
					// if (elapsed >= warningTime && !warningShown) {
					// 	showSessionWarning(sessionTimeout - elapsed - 10); // user inactive for >30s and then acted
					// }

				}
				setInterval(loadLog, 2000);	
			</script>
			<?php
				$showStartbtn = 1;
				$Username = isset ($_SESSION['email']) ? $_SESSION['email'] : '';
				$Filename = './logs/dev_'.$Username . '.proflog' ;
				if(file_exists($Filename)){
					$showStartbtn = 0;
				}
			?>
			<input type="hidden" id="showSQLDebugger" value="<?php echo !$showStartbtn; ?>" />
			<div id="chat-popup" class="minimized" style="display: flex;z-index: 99999;border-radius: 10px;box-shadow: 2px 2px 6px grey;">
				<div id="chat-header1">
					<div id="chat-header">
						<span id="chat-title" style="width:130px">SQL PROFILER</span>
					</div>
					<div style="display:flex;position: absolute;right: 5px;top: 8px;">
						<button id="chat-open" style="width: 35px;"> 💬 </button>
						<button id="chat-minimize" onclick="minimizeChat()" style="width: 25px;display: none"> _ </button>
						<button id="chat-maximize" onclick="maximizeChat()" style="width: 25px;"> ⬜ </button>
					</div>
				</div>
				<div id="chat-btns">
					<button id="chat-btn-start" class="custom-chat-btn btn-7" style="background: green;<?php if(!$showStartbtn) echo 'display: none;' ?>"><span> ▷ </span></button>
					<button id="chat-btn-stop"  class="custom-chat-btn btn-7" style="background: red;  <?php if( $showStartbtn) echo 'display: none;' ?>"><span> || </span></button>
				</div>
				<div id="chat-body">
					<!-- <div id="chatbox">
						
					</div> -->
				</div>
			</div>
			<?php if(!$showStartbtn) echo '<script> $(document).ready(function() { $("#chat-open").click(); });</script>'; ?>
		<?php } ?>

		<!-- Vendor -->
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script-->
		<script src="assets/vendor/jquery-ui/jquery-ui.js"></script>
		<script src="assets/vendor/select2/js/select2.js"></script>
		<script src="assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
		<script src="assets/vendor/jqueryui-touch-punch/jqueryui-touch-punch.js"></script>
		<script src="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
		<?php 
			//Added due to conflict between datatables used on form for dropdownTable
			if(isset($_GET['view'])) if($_GET['view'] == 1) echo '<script src="assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>';  
		?>

		<script src="assets/vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
		<script src="assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
		<script src="assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
		<script src="assets/vendor/bootstrap-timepicker/bootstrap-timepicker.js"></script>
		<script src="assets/vendor/fuelux/js/spinner.js"></script>
		<script src="assets/vendor/dropzone/dropzone.js"></script>
		<script src="assets/vendor/bootstrap-markdown/js/markdown.js"></script>
		<script src="assets/vendor/bootstrap-markdown/js/to-markdown.js"></script>
		<script src="assets/vendor/bootstrap-markdown/js/bootstrap-markdown.js"></script>
		<script src="assets/vendor/codemirror/lib/codemirror.js"></script>
		<script src="assets/vendor/codemirror/addon/selection/active-line.js"></script>
		<script src="assets/vendor/codemirror/addon/edit/matchbrackets.js"></script>
		<script src="assets/vendor/codemirror/mode/javascript/javascript.js"></script>
		<script src="assets/vendor/codemirror/mode/xml/xml.js"></script>
		<script src="assets/vendor/codemirror/mode/htmlmixed/htmlmixed.js"></script>
		<script src="assets/vendor/codemirror/mode/css/css.js"></script>
		<script src="assets/vendor/summernote/summernote.js"></script>
		<script src="assets/vendor/bootstrap-maxlength/bootstrap-maxlength.js"></script>
		<script src="assets/vendor/ios7-switch/ios7-switch.js"></script>
		<script src="assets/vendor/bootstrap-confirmation/bootstrap-confirmation.js"></script>
		<!-- <script type='text/javascript' src="jspdf.debug.js"></script> -->
		
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<script src="assets/javascripts/ui-elements/examples.modals.js"></script>
		<script src="assets/javascripts/forms/examples.advanced.form.js"></script>
		<script src="assets/javascripts/tables/examples.datatables.default.js"></script>
		<script src="assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
		<script src="assets/javascripts/tables/examples.datatables.tabletools.js"></script>
		<script src="assets/javascripts/dashboard/examples.dashboard.js"></script>
	</body>
</html>