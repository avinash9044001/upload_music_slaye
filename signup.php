<?php

// If user is logged in, header them away
if(isset($_SESSION["username"])){
	header("location: message.php?msg=NO to that weenis");
    exit();
}
?><?php
// Ajax calls this NAME CHECK code to execute
if(isset($_POST["usernamecheck"])){
	include_once("php_includes/db_conx.php");
	$username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
	$sql = "SELECT id FROM users WHERE username='$username' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
    $uname_check = mysqli_num_rows($query);
    if (strlen($username) < 3 || strlen($username) > 16) {
//	    echo '<strong style="color:#F00;">3 - 16 characters please</strong>';
		echo '</br><div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Warning!</strong> 3-16 character please
</div>';
	    exit();
    }
	if (is_numeric($username[0])) {
//	    echo '<strong style="color:#F00;">Usernames must begin with a letter</strong>';
 		echo '</br><div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Warning!</strong> Usernames must begin with a letter!!
</div>';
	
    exit();
    }
    if ($uname_check < 1) {
	  //  echo '<strong style="color:#009900;">' . $username . ' Check!!</strong>';
	    echo '</br><div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Success!</strong>'.$username.' Checked!!</div>';
		exit();
    } else {
	  //  echo '<strong style="color:#F00;">' . $username . ' is taken please try another one!!</strong>';
	    echo '</br><div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Warning!</strong>'.$username.' is taken please try another one!!</div>';
		exit();
    }
}
?><?php
// Ajax calls this REGISTRATION code to execute
if(isset($_POST["u"])){
	// CONNECT TO THE DATABASE
	include_once("php_includes/db_conx.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = $_POST['p'];
	$pr= $_POST['g'];
	$g = preg_replace('#[^a-z]#', '', $_POST['g']);
	//$c = preg_replace('#[^a-z ]#i', '', $_POST['c']);
	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
	$sql = "SELECT id FROM users WHERE username='$u' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
	$u_check = mysqli_num_rows($query);
	// -------------------------------------------
	$sql = "SELECT id FROM users WHERE email='$e' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
	$e_check = mysqli_num_rows($query);
	// FORM DATA ERROR HANDLING
	if($u == "" || $e == "" || $p == "" || $g == "" || $pr == ""){
		echo "The form submission is missing values.";
        exit();
	} else if ($u_check > 0){ 
        echo "The username you entered is already taken";
        exit();
	} else if ($e_check > 0){ 
        echo "That email address is already in use in the system";
        exit();
	} else if (strlen($u) < 3 || strlen($u) > 16) {
        echo "Username must be between 3 and 16 characters";
        exit(); 
    } else if (is_numeric($u[0])) {
        echo 'Username cannot begin with a number';
        exit();
    } else {
	$p_hash=md5($p);
		// Add user info into the database table for the main site table
		$sql = "INSERT INTO users (priv_role,username, email, password, gender,ip, signup, lastlogin, notescheck)       
		        VALUES('$pr','$u','$e','$p_hash','$g','$ip',now(),now(),now())";
		$query = mysqli_query($db_conx, $sql); 
		$uid = mysqli_insert_id($db_conx);
		// Establish their row in the useroptions table
		$sql = "INSERT INTO useroptions (id, username, background) VALUES ('$uid','$u','original')";
		$query = mysqli_query($db_conx, $sql);
		// Create directory(folder) to hold each user's files(pics, MP3s, etc.)
		if (!file_exists("user/$u")) {
			mkdir("user/$u", 0755);
		}
		// Email the user their activation link
		$to = "$e";							 
		//$from = "auto_responder@yoursitename.com";
		$from = "avinash.srivastava.103@gmail.com";
		$subject = 'yoursitename Account Activation';
		$message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>yoursitename Message</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px; background:#333; font-size:24px; color:#CCC;"><a href="http://www.yoursitename.com"><img src="http://www.yoursitename.com/images/logo.png" width="36" height="30" alt="yoursitename" style="border:none; float:left;"></a>yoursitename Account Activation</div><div style="padding:24px; font-size:17px;">Hello '.$u.',<br /><br />Click the link below to activate your account when ready:<br /><br /><a href="http://www.yoursitename.com/activation.php?id='.$uid.'&u='.$u.'&e='.$e.'&p='.$p_hash.'">Click here to activate your account now</a><br /><br />Login after successful activation using your:<br />* E-mail Address: <b>'.$e.'</b></div></body></html>';
		$headers = "From: $from\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
		mail($to, $subject, $message, $headers);
		echo "signup_success";
		exit();
	}
	exit();
}
?>
<!-- LOGIN LOGIC -->
<?php
include_once("php_includes/check_login_status.php");
// If user is already logged in, header that weenis away
if($user_ok == true){
	header("location: user.php?username=".$_SESSION["username"]);
    exit();
}
?><?php
// AJAX CALLS THIS LOGIN CODE TO EXECUTE
if(isset($_POST["e"])){
	// CONNECT TO THE DATABASE
	include_once("php_includes/db_conx.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = md5($_POST['p']);
	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// FORM DATA ERROR HANDLING
	if($e == "" || $p == ""){
		echo "login_failed";
        exit();
	} else {
	// END FORM DATA ERROR HANDLING
		$sql = "SELECT id, username, password FROM users WHERE email='$e' AND activated='1' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
		$db_id = $row[0];
		$db_username = $row[1];
        $db_pass_str = $row[2];
		if($p != $db_pass_str){
			echo "login_failed";
            exit();
		} else {
			// CREATE THEIR SESSIONS AND COOKIES
			$_SESSION['userid'] = $db_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_pass_str;
			setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
			setcookie("user", $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
    		setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE); 
			// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
			$sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE username='$db_username' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
			echo $db_username;
		    exit();
		}
	}
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Welcome To MuSlaTe</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="avinash">

	<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
	<!--script src="js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="mystyles.css" rel="stylesheet" media="screen">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->
 
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
	<script type="text/javascript" src="js/shortcut_.js"></script>
	<script type="text/javascript">
/*	function on_load() {
	alert("as");
	
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("bo").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","listing.php",true);
  xmlhttp.send();

}	
//rest script
*/
function restrict(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "email"){
		rx = /[' "]/gi;
	} else if(elem == "username"){
		rx = /[^a-z0-9]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}
function emptyElement(x){
	_(x).innerHTML = "";
}
function checkusername(){
	var u = _("username").value;
	if(u != ""){
		_("unamestatus").innerHTML = 'checking ...';
		var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            _("unamestatus").innerHTML = ajax.responseText;
	        }
        }
        ajax.send("usernamecheck="+u);
	}
}
function signup(){
   
	var u = _("username").value;
	var e = _("email").value;
	var p1 = _("pass1").value;
	var p2 = _("pass2").value;
	//var c = _("country").value;
	var g = _("gender").value;
	var pr = _("priority").value;
	//var status = _("status");  
	if(u == "" || e == "" || p1 == "" || p2 == "" || g == ""){
		status.innerHTML = "Fill out all of the form data";
	} else if(p1 != p2){
		status.innerHTML = "Your password fields do not match";
	} /* else if( _("terms").style.display == "none"){
		status.innerHTML = "Please view the terms of use";
	} */ else {
		_("signupbtn").style.display = "none";
		status.innerHTML = 'please wait ...';
		var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText != "signup_success"){
					status.innerHTML = ajax.responseText;
					_("signupbtn").style.display = "block";
				} else {
					window.scrollTo(0,0);
					_("signupform").innerHTML = "<b>OK "+u+", <i>check your email inbox and junk mail box at </i><u></b>"+e+"</u> in a moment to complete the sign up process by activating your account.</br><b>You will not be able to do anything on the site until you successfully activate your account.<b> <i>You are now being redirected in 5 seconds into another form to completed the Sign Up Process!!</i> ";
					if(pr==1){
					var myVar = setTimeout(function(){window.location = 'user.php?username='+u},7000);}
					else if(pr==2){
					var myVar = setTimeout(function(){window.location = 'user.php?username='+u},7000);
					}
				}
	        }
        }
        ajax.send("u="+u+"&e="+e+"&p="+p1+"&g="+g+"&pr"+pr);
	}
}
function openTerms(){
	_("terms").style.display = "block";
	emptyElement("status");
}
// LOGIN LOGIC
function emptyElement(x){
	_(x).innerHTML = "";
}

function login(){
	var e = _("email_1").value;
	var p = _("password_1").value;
	if(e == "" || p == ""){
		_("status").innerHTML = "Fill out all of the form data";
	} else {
		_("loginbtn").style.display = "none";
		_("status").innerHTML = 'please wait ...';
		var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "login_failed"){
					_("status").innerHTML = "Login unsuccessful, please try again.";
					_("loginbtn").style.display = "block";
				} else {
					window.location = "user.php?username="+ajax.responseText;
				}
	        }
        }
        ajax.send("e="+e+"&p="+p);
	}
}




</script>
<style> 
#all_the_way {
    background-image: url(images/6.jpg), url(images/2.jpg), url(images/3.jpg), url(images/4.jpg), url(images/5.jpg), url(images/6.jpg), url(images/5.jpg), url(images/3.jpg), url(images/9.jpg), url(images/10.jpg), url(images/11.jpg), url(images/12.jpg), url(images/13.jpg), url(images/14.jpg), url(images/15.jpg);
    
	background-position:0px 100px, 300px 100px, 600px 100px, 900px 100px, 1200px 100px, 1500px 100px, 0px 400px, 300px 400px, 600px 400px, 900px 400px, 1200px 400px, 1500px 400px, 0px 700px, 300px 700px;
	
	background-size:299px 299px, 299px 299px, 299px 299px, 299px 299px, 299px 299px, 299px 299px, 299px 299px, 299px 299px;
  
	background-repeat: no-repeat, no-repeat, no-repeat, no-repeat, no-repeat, no-repeat, no-repeat,no-repeat,no-repeat,no-repeat;

}
</style>
</head>
<body id="all_the_way"  style="background-color:#E9EAED" >
<div >
<section>
<div class="container" >
	<div class="row clearfix">
		<div class="box_top feedy">
		
		<div class="col-xs-12 col-md-12 column">
		
			<div class="row clearfix">
				<div class="col-xs-4 col-md-3 column"></br>
				<img src="http://www.muslate.com/_i/logo/MuslateLogoTransparentHover.png" alt="our_logo"></img>
				</div>
				<div class="col-xs-0 col-md-3 column">
				</div>
				<form class="form-inline">
				<div class="col-xs-0 col-md-1 column">
			
				</div>
				<div class="col-xs-4 col-md-2 column">
				<label  for="exampleInputEmail3" style="color: #A7A7Af;">Email address</label>
    <input class="form-control" type="text" id="email_1" onFocus="emptyElement('status')" maxlength="88" placeholder="Enter email">
  	<label style="color:#A7A7Af;">
      <input type="checkbox"> Remember me
    </label>
				</div>
				
				<div class="col-xs-4 col-md-2 column">
				<label for="exampleInputPassword3" style="color: #A7A7Af;">Password</label>
    <input  class="form-control"  type="password" id="password_1" onFocus="emptyElement('status')" maxlength="100" placeholder="Password">
<p></p><button type="submit" id="loginbtn" onClick="login()" class="btn btn-sm btn-primary">Sign in</button>
<a id="status"></a>
<a href="forgot_pass.php" style="color: rgb(167, 167, 175);cursor: pointer;"><b>Forgot Password</b></a>
</form>
				</div>
				<div class="col-xs-0 col-md-1 column">
				 				</div>
				
		</div>	</div>
		</div>
	</div>
</div>
</section>
<svg id="clouds" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none" style="margin: -11% 0% 0% 0%;">
				<path d="M-5 100 Q 0 20 5 100 Z
						 M0 100 Q 5 0 10 100
						 M5 100 Q 10 30 15 100
						 M10 100 Q 15 10 20 100
						 M15 100 Q 20 30 25 100
						 M20 100 Q 25 -10 30 100
						 M25 100 Q 30 10 35 100
						 M30 100 Q 35 30 40 100
						 M35 100 Q 40 10 45 100
						 M40 100 Q 45 50 50 100
						 M45 100 Q 50 20 55 100
						 M50 100 Q 55 40 60 100
						 M55 100 Q 60 60 65 100
						 M60 100 Q 65 50 70 100
						 M65 100 Q 70 20 75 100
						 M70 100 Q 75 45 80 100
						 M75 100 Q 80 30 85 100
						 M80 100 Q 85 20 90 100
						 M85 100 Q 90 50 95 100
						 M90 100 Q 95 25 100 100
						 M95 100 Q 100 15 105 100 Z">
				</path>
			</svg>
<section >
<div class="container" >
	<div class="row clearfix">
		<div class="col-xs-12 col-md-12 column">
			<div class="row clearfix">
				<div class="col-xs-4 col-md-7 column">
				</div>
				<div class="col-xs-8 col-md-5 column">
					<div class="row clearfix">
						
						<div class="col-xs-10 col-md-10 column">
							<div class="page-header">
								<h1 style="color: #2F96B4;">
									Sign Up!! </br><small>To the awesomeness!!</small>
								</h1>
							</div> 
							<form name="signupform" id="signupform" onSubmit="return false;">
							<div class="row clearfix">
							<div class="col-xs-6 col-md-6 column">
							<input type="name" class="form-control" id="exampleInputEmail3" placeholder="First Name">
							</div>
							<div class="col-xs-6 col-md-6 column">
							<input type="name" class="form-control" id="exampleInputEmail3" placeholder="Last Name">
							</div>
							
							</div>
							</br>
							<input class="form-control" id="username" type="text" onBlur="checkusername()" placeholder="Enter Display Name" onKeyUp="restrict('username')" maxlength="16" placeholder="Username">
							 <span id="unamestatus"></span>
							</br>
							<input class="form-control" id="email" type="text" onFocus="emptyElement('status')" onKeyUp="restrict('email')" maxlength="88" placeholder="Email">
							</br>
							<input class="form-control" id="pass1" type="password" onFocus="emptyElement('status')" maxlength="16" placeholder="Password">
							</br>
							<input class="form-control" id="pass2" type="password" onFocus="emptyElement('status')" maxlength="16" placeholder="Confirm Password">
				<select id="gender" onFocus="emptyElement('status')">
      <option value=""></option>
      <option value="m">Male</option>
      <option value="f">Female</option>
    </select>
    <div>Sign Up As:</div>
    <select id="priority" onFocus="emptyElement('status')">
      <option value=""></option>
      <option value="1">Student</option>
      <option value="1">Professor</option>
    </select>
	<div id="terms" style="display:none;">
      <h3>Terms And Condtion</h3>
      <p>1). Website Uses Your Fb ID TO Import Stuff</p>
      <p>jkbhkj</p>
    </div>
						<!--	<div class="btn-group" id="gender" onFocus="emptyElement('status')">
				 <button class="btn btn-default">Sex</button> <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><span class="caret"></span></button>
				<ul class="dropdown-menu">
					<li>
						<a href="#" value="m">Male</a>
					</li>
					<li class="divider">
					</li>
					<li>
						<a href="#" value="f">Female</a>
					</li>
				</ul>
			</div>
			<div class="btn-group" id="priority" onFocus="emptyElement('status')">
				 <button class="btn btn-default">SELECT</button> <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><span class="caret"></span></button>
				<ul class="dropdown-menu">
					<li>
						<a href="#" value="1">Listener</a>
					</li>
					<li class="divider">
					</li>
					<li>
						<a href="#" value="2">Uploader</a>
					</li>
				</ul>
			</div> -->							</br>
							<button id="signupbtn" onClick="signup()" type="button" class="btn btn-default btn-success">Sign In!</button></br>
							<span id="status"></span>
							</form>
						</div>
						<div class="col-xs-2 col-md-2 column">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</section>
</div>
</body>
</html>
