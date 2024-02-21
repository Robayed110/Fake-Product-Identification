<?php

$page_title="registration form";
include('includes/header.php');
include('includes/navbar.php');
include('db.php');
session_start();
unset($_SESSION['IS_LOGIN']);
?>
<div class="signup-form">
    <form method="post">
		<h2>Login</h2>
		<p class="hint-text">Enter your email id and password.</p>
         
        <div class="form-group">
        	<input type="email" class="form-control" name="email" id="email" placeholder="Email">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
		<div class="form-group">
        <label for="user_type">User Type:</label>
        <select class="form-control" name="user_type" id="user_type" required>
            <option value="consumer">Consumer</option>
            <option value="seller">Seller</option>
            <option value="manufacturer">Manufacturer</option>
        </select>
        </div>
		
		<div class="form-group">
            <button type="button" class="btn btn-success btn-lg btn-block" onclick="login_now()">Login Now</button>
        </div>
		<div class="message"></div>
    </form>
	<div class="text-center">Create a account? <a href="registration.php">Sign up</a></div>
</div>
<script>
function login_now(){
	
	var email=jQuery('#email').val();
	var password=jQuery('#password').val();
	var user_type=jQuery('#user_type').val();
	
	jQuery.ajax({
		url:'login_check.php',
		type:'post',
		data:'email='+email+'&password='+password+'&user_type='+user_type,
		success:function(result){
			
			if(result=='done'){
				if(user_type=="manufacturer"){
					
					window.location.href="http://localhost:3000/manufacturer.html";
				    die();
				}
				else if(user_type=="consumer"){
					
					window.location.href="http://localhost:3000/consumer.html";
				    die();
				}else if(user_type=="seller"){
					
					window.location.href="http://localhost:3000/seller.html";
				    die();
				}
				
				
				
			}
			jQuery('.message').html(result);
		}
	});
}
</script>
<?php include('includes/footer.php')?>            