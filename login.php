<?php
error_reporting(0); // turn off all error reporting
?>

<?php 
include('functions.php'); 
$errorcollector = "";  
redirectme();//function to redirect
if(isset($_GET['access']) && $_GET['access']=="admin"){ $access = 1; }else{ $access = 0; } 
if (isset($_POST['login'])){  
     if ((isset($_POST['username'])) && (!empty($_POST['username'])) && (isset($_POST['password'])) && (!empty($_POST['password'])) ){
        $user = cleanup('username');
        $pass = cleanup('password');  
        if($access == 1){
            $query = "SELECT * FROM administrator where username='$user' and password='$pass'";
        }else if ($access == 0){
            $pass =  sha1($pass);
            $query = "SELECT * FROM users where username='$user' and password='$pass'";
        } 
        $stmt = mysql_query($query, $dbh)or die(mysql_error());
        if (mysql_num_rows($stmt)>0){
            $stmt = mysql_fetch_array($stmt);  
            if($access == 1){ 
                $_SESSION['adminid'] = $stmt['admin_id']; 
            }else if ($access == 0){ 
                $_SESSION['userid'] = $stmt['userid'];
            } 
            header("Location:index.php"); //redirecting
        }else{
            $errorcollector = "Incorrect Username and Password";
        } 
    }else{
            $errorcollector = "Please fill in all fields";
    }
}
$_SESSION['pgname'] = "login"; include('header.php') ?>
     <div class="col-md-12 heading-holder"> </div>          
    <div class="container" style="padding: 0px 100px;"> 
    <div class="col-md-12" style="padding: 0px;"><h3 class="big-titles" style="text-align: center;">
        <?php if($access == 1){ 
                echo "Administrator Account"; 
            }else if ($access == 0){ 
                echo "User Account";
            }  ?></h3> </div>  
                <div class="panel panel-default center-block" style="width: 320px; margin-top: 110px;"> 
                    <div class="panel-body"> 
                        <div class="col-md-12">  
                                <div class="text-center" style="padding-bottom: 10px; margin-top: 15px;">
                                    <?php 
                                        if($errorcollector){
                                            echo '<p style="color: red;">'.$errorcollector.'</p>'; 
                                        }else{ 
                                            echo '<p>Please Enter Username and Password</p>';
                                        } 
                                    ?>
                                </div>
                                <form role="form" method="post" action="" style="margin-bottom: 20px;">  
                                    <div class="form-group">
                                        <input type="text" name="username" value="" class="form-control" placeholder="Enter Username"/>
                                    </div> 
                                    <div class="form-group">
                                        <input type="password" name="password" value="" class="form-control" placeholder="Enter Password"/> 
                                    </div> 
                                    <div class="box-footer"> 
                                        <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                                    </div> 
                                </form>    
                        </div> 
                    </div> 
                </div> 
        </div>  
        <?php include('footer.php') ?>