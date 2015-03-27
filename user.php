<?php
$username = $_GET["username"];
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>MuSlate|Sign Up!</title>
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
	<script src="js/search_script.js"></script>
	<!--CROP -->
	<script src="js/angular.js"></script>
   <script src="js/ng-img-crop.js"></script>
   <link rel="stylesheet" type="text/css" href="css/ng-img-crop.css">
   <script type="text/javascript "src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
  
	<script type="text/javascript">
	//search
	$(document).ready(function(){

$("#search_country").keyup(function(event){
event.preventDefault();
search_ajax_way_country();
});
});

function search_ajax_way_country(){
$("#search_results").show();
var search_this=$("#search_country").val();
$.post("search_country.php", {searchit : search_this}, function(data){
$("#_confirm_country").html(data);
})
}

function xyz(x){
//alert(s);
var xy='<div class="alert alert-info" role="alert">'+x+'</div>';
document.getElementById("_confirm_country").innerHTML = xy;
document.getElementById("search_country").value = x;
}
		
angular.module('app', ['ngImgCrop'])
      .controller('Ctrl', function($scope) {
        $scope.myImage='';
        $scope.myCroppedImage='';

        var handleFileSelect=function(evt) {
          var file=evt.currentTarget.files[0];
          var reader = new FileReader();
          reader.onload = function (evt) {
            $scope.$apply(function($scope){
              $scope.myImage=evt.target.result;
            });
          };
          reader.readAsDataURL(file);
        };
        angular.element(document.querySelector('#fileInput')).on('change',handleFileSelect);
      });
	  function xyz(x)
	  {
	  
	  }
  </script>
<style> 
#all_the_way {
    background-image: url(images/6.jpg), url(images/2.jpg), url(images/3.jpg), url(images/4.jpg), url(images/5.jpg), url(images/6.jpg), url(images/5.jpg), url(images/3.jpg), url(images/9.jpg), url(images/10.jpg), url(images/11.jpg), url(images/12.jpg), url(images/13.jpg), url(images/14.jpg), url(images/15.jpg);
    
	background-position:0px 100px, 300px 100px, 600px 100px, 900px 100px, 1200px 100px, 1500px 100px, 0px 400px, 300px 400px, 600px 400px, 900px 400px, 1200px 400px, 1500px 400px, 0px 700px, 300px 700px;
	
	background-size:299px 299px, 299px 299px, 299px 299px, 299px 299px, 299px 299px, 299px 299px, 299px 299px, 299px 299px;
  
	background-repeat: no-repeat, no-repeat, no-repeat, no-repeat, no-repeat, no-repeat, no-repeat,no-repeat,no-repeat,no-repeat;

}
.cropArea {
      background: #E9EAED;
	 /* background-image:url(xz.jpg);
      */
	  overflow: hidden;
      width:300px;
      height:300px;
    }
	
	/*Filter styles*/
.saturate {-webkit-filter: saturate(3);}
.grayscale {-webkit-filter: grayscale(100%);}
.contrast {-webkit-filter: contrast(160%);}
.brightness {-webkit-filter: brightness(0.25);}
.blur {-webkit-filter: blur(3px);}
.invert {-webkit-filter: invert(100%);}
.sepia {-webkit-filter: sepia(100%);}
.huerotate {-webkit-filter: hue-rotate(180deg);}
.rss.opacity {-webkit-filter: opacity(50%);}

</style>
</head>

<body style="background-color:#E9EAED" ng-app="app" ng-controller="Ctrl">
<section>
<div class="container" >
	<div class="row clearfix">
		<div class="box_top feedy">
		<div class="col-xs-12 col-md-12 column">
			<div class="row clearfix">
				<div class="col-xs-1 col-md-1 column">
				</div>
				<div class="col-xs-3 col-md-3 column"></br>
				<img src="http://www.muslate.com/_i/logo/MuslateLogoTransparentHover.png" alt="our_logo"></img>
				</div>
				<div class="col-xs-5 col-md-5 column">
				
				<h4 class="text-left text-primary">
						Search 
					</h4>
				    <input type="text" id="search_country" name='search_country' class="form-control" placeholder="Enter Country">
					<div id ="_confirm_country" style="color: #E9EAED;font-size: medium;">
	<p id="_confirm"></p>
	</div>
				</div>
				<div class="col-xs-3 col-md-3 column">
			
				</div>
			</div>
		</div>
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

<div class="container">
	<div class="row clearfix">
		<div class="col-xs-12 col-md-12 column">
			<div class="row clearfix">
				<div class="col-xs-1 col-md-1 column">
				</div>
				<div class="col-xs-4 col-md-4 column">
					<blockquote>
						<p>
						Welcome to MuSlate
						</p> <small>Organized Cloud<cite>Music</cite></small>
					</blockquote>
				</div>
				<div class="col-xs-2 col-md-2 column">
				</div>
				<div class="col-xs-2 col-md-2 column">
					<h5>
						<?php echo $username; ?>
					</h5>
				</div>
				<div class="col-xs-1 col-md-1 column">
				</div>
				<div class="col-xs-2 col-md-2 column">
									<!-- <button type="button" class="btn btn-sm btn-info" href="http://www.google.com">Log Out!</button>
									 -->
									 <a href="logout.php">Log Out!</a>

				</div>
			</div>
		</div>
		
	</div>
	<div class="row clearfix">
		<div class="col-xs-2 col-md-2 column">
	
			 <input type="file" id="fileInput" class="btn btn-success btn-sm">Upload Profile Picture</input>
		</div>
		<div class="col-xs-1 col-md-1 column">
		
		</div>
		<div class="col-xs-4 col-md-4 column">
		<div class="cropArea">
    <img-crop image="myImage" result-image="myCroppedImage"></img-crop>
  </div>
		</div>
		<div class="col-xs-1 col-md-1 column">
		</div>
		<div class="col-xs-4 col-md-4 column">
		<div>
		
		<img id="main_cropped_image" ng-src="{{myCroppedImage}}" /></div>
		</br>
		 

		</div>
		<div class="col-xs-1 col-md-1 column">
			<form id="avatar_form" enctype="multipart/form-data" method="post" action="php_parsers/photo_system.php">
			 <input type="submit" value="Upload">
			 </form>
			 <button type="button" id="modal-769990" href="#modal-container-769990" role="button" class="btn btn-sm btn-success" data-toggle="modal">Edit / Upload Picture</button>
			
			<div class="modal fade in" id="modal-container-769990" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title" id="myModalLabel">
								Click to select picture!
							</h4>
							 
 
						</div>
						<div class="modal-body">
<img class="edit_pic" ng-src="{{myCroppedImage}}" onclick="xyz(1)">
<img ng-src="{{myCroppedImage}}" class="saturate" onclick="xyz(2)">
<img ng-src="{{myCroppedImage}}" class="grayscale" onclick="xyz(3)">
<img ng-src="{{myCroppedImage}}" class="contrast" onclick="xyz(4)">
<img ng-src="{{myCroppedImage}}" class="brightness" onclick="xyz(5)">
<img ng-src="{{myCroppedImage}}" class="blur" onclick="xyz(6)">
<img ng-src="{{myCroppedImage}}" class="invert" onclick="xyz(7)">
<img ng-src="{{myCroppedImage}}" class="sepia" onclick="xyz(8)">
<img ng-src="{{myCroppedImage}}" class="huerotate" onclick="xyz(9)">
<img ng-src="{{myCroppedImage}}" class="rss opacity" onclick="xyz(10)">

						</div>
						<div class="modal-footer">
							 <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button> 
						</div>
					</div>
					
				</div>
				
			</div>
			
		</div>
	</div>
</div>
</body>
</html>
