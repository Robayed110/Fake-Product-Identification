<?php
$page_title="registration form";
include('includes/header.php');
include('includes/navbar.php');
include('db.php');
include('smtp/PHPMailerAutoload.php');
$msg="";
if(isset($_POST['submit'])){
	$name=$_POST['name'];
	$email=$_POST['email'];
	$password=$_POST['password'];
	$user_type=$_POST['user_type'];
	
	$check=mysqli_num_rows(mysqli_query($con,"select * from user where email='$email' AND user_type='$user_type'"));
	
	if($check>0){
		$msg="User already present";
	}else{
		$verification_id=rand(111111111,999999999);
		
		mysqli_query($con,"insert into user(name,email,password,verification_status,verification_id,user_type) values('$name','$email','$password',0,'$verification_id','$user_type')");
		
		$msg="We've just sent a verification link to <strong>$email</strong>. Please check your inbox and click on the link to get started. If you can't find this email (which could be due to spam filters), just request a new one here.";
		
		$mailHtml="Please confirm your account registration by clicking the button or link below: <a href='http://localhost/emailAuth/Fake-Product-IdentificationProject/check.php?id=$verification_id'>http://localhost/emailAuth/Fake-Product-IdentificationProject/check.php?id=$verification_id</a>";
		
		smtp_mailer($email,'Account Verification',$mailHtml);
		
	}
}

function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	//$mail->SMTPDebug = 2; 
	$mail->Username = "robayed765@gmail.com";
	$mail->Password =  "dgrl sknb cfpn jcls";
	$mail->SetFrom("robayed765@gmail.com");
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo $mail->ErrorInfo;
	}else{
		return 'Sent';
	}
}
?>

<div class="signup-form">
    <form method="post">
		<h2>Register</h2>
		<p class="hint-text">Create your account. It's free and only takes a minute.</p>
         <div class="form-group">
        	<input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
        </div>
        <div class="form-group">
        	<input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
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
            <button type="submit"  name="submit" class="btn btn-success btn-lg btn-block">Register Now</button>
        </div>
		<div class="message">
		<?php
		echo $msg;
		?>
		</div>
    </form>
	<div class="text-center">Already have an account? <a href="login.php">Sign in</a></div>
</div>
                          
<?php include('includes/footer.php')?>