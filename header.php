<?php
error_reporting(0); // turn off all error reporting
?>

<?php 
if(isset($_SESSION['adminid'])){
    header('location:administrator.php'); 
} 
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title> Woodlands Away </title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<link href="dist/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
		<link href="dist/bootstrap/css/bootstrap.css" rel="stylesheet"/>
        <link href="dist/css/custom.css" rel="stylesheet"/>
        <link href="dist/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet"/>
        <link href="dist/fullcalendar/dist/fullcalendar.print.css" rel="stylesheet" media="print"/> 
        <link href="dist/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen"/>
	</head>
	<style>
    	.content{
    	   margin-top: 10px;
           margin-bottom: 20px;
           clear: both;
           overflow: hidden;
    	}	
        .nbm{
            border-radius:0px;
            border: none;  
            margin-bottom: 0px; 
            background-color: #102648;  
        }
        .maintron{
            height: 350px;  
            background-image: url('img/maintron.jpg');
            background-position: bottom;
            background-size: cover;
            background-repeat: no-repeat;
            margin-bottom: 10px;
        } 
        .big-titles{
            margin-bottom: 25px;  
            background-color: #317589; 
            color: #ffffff;  
            margin-top: 0px; 
            padding: 10px 15px;
            font-size: 20px;
            margin-top: 10px;
        }
        .headings{ 
            text-align: center; 
            margin-top: 0px;  
            color: #317589;
            margin-bottom: 30px;
            font-weight: bold;
            font-size: 32px; 
        }
        .btn-primary{
            background-color: #317589;
        }
        .btn-primary:hover{
            background-color: #1f4956;
        }
	</style>
	<body>
        <nav class="navbar nbm" role="navigation">
            <div class="container" style="padding: 0px 100px;">
                <div class="col-md-2" style="padding: 0px; padding-top: 10px;"> 
                    <h3 style="margin: 0px; margin-top: 10px; float: left; color: #ffffff;">Woodlands</h3>
                </div>
                <div class="col-md-10">  
                <style>
                .navbar-right li a{
                    padding: 21px 21px;
                    font-size: 16px;
                    color: #ffffff;
                }
                .navbar-right li a:hover{
                    background-color: #317589;
                    color: #ffffff;
                }
                .navbar-right li .active{
                    background-color: #317589;
                    color: #ffffff;
                }
                </style>
                    <ul class="nav navbar-nav navbar-right">
                        <?php $pgname = $_SESSION['pgname']; ?>
                            <li> <a href="index.php" <?php if($pgname == "index"){ echo 'class="active"'; } ?>>Home</a> </li>
                            <li> <a href="logcabins.php" <?php if($pgname == "cabins"){ echo 'class="active"'; } ?>>Log Cabins</a> </li>
                            <li> <a href="offers.php" <?php if($pgname == "offers"){ echo 'class="active"'; } ?>>Special Offers</a> </li> 
                        <?php if(isset($_SESSION['userid'])){ ?> 
                            <li> <a href="forum.php" <?php if($pgname == "forum"){ echo 'class="active"'; } ?>>Forum</a> </li>
                            <li> <a href="logout.php">Logout</a> </li>
                        <?php }else{ ?>
                            <li> <a href="login.php" <?php if($pgname == "login"){ echo 'class="active"'; } ?>>Login</a> </li>
                            <li> <a href="signup.php" <?php if($pgname == "signup"){ echo 'class="active"'; } ?>>Signup</a> </li>
                        <?php } ?>
                    </ul>  
                </div>
            </div>
        </nav>  