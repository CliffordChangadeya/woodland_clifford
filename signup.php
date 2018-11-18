<?php
error_reporting(0); // turn off all error reporting
?>

<?php 
    include('functions.php');
    restrict();
    $success = "";
    $msg = array(); 
    $_SESSION['pgname'] = "signup"; 
    if (isset($_POST['submit'])){ 
        $firstname = cleanup('firstname');
        $lastname = cleanup('lastname');
        $gender = cleanup('gender');
        $location = cleanup('location');
        $postcode = cleanup('postcode'); 
        $currency = cleanup('currency');
        $email = cleanup('email');
        $username = cleanup('username'); 
        $password = cleanup('passwords');
        $passwordtwo = cleanup('passwordtwo');  
        if(empty($firstname)){
            $msg[] = 'Firstname field should not be empty'; 
        }
        if(empty($lastname)){
            $msg[] = 'Lastname field should not be empty'; 
        }   
        if(empty($postcode)){
            $msg[] = 'Postcode field should not be empty'; 
        }
        if(empty($location)){
            $msg[] = 'Location field should not be empty'; 
        } 
        if(!empty($username)){   
            $query = "SELECT userid FROM users where username='$username'";
            $results = mysql_query($query, $dbh) or die(mysql_error());
            if (mysql_num_rows($results)>0){
                $msg[] = "Someone already uses this username";
            }
        }else{
            $msg[] = 'Username field should not be empty';
        }
        if(empty($email)){
            $msg[] = 'Email field should not be empty'; 
        } 
        if(!empty($password)){
            if($password != $passwordtwo){
                $msg[] = 'The two passwords mismatch';
            } 
        }else{
            $msg[] = 'password field should not be empty';
        }  
        if(!$msg){
            $password = sha1($password);
            $query = "INSERT INTO `woodland`.`users` (`userid`, `firstname`, `lastname`, `gender`, `location`, `postcode`, `currency`, `email`, `username`, `password`) VALUES (NULL, '$firstname', '$lastname', '$gender', '$location', '$postcode', '$currency', '$email', '$username', '$password');";
            $insert = mysql_query($query, $dbh); 
            if ($insert === TRUE){
                $success = 1;
            }  
        } 
    } 
    
    include('header.php') ?>
    <div class="col-md-12 heading-holder"> </div>          
    <div class="container" style="padding: 0px 100px;"> 
    <div class="col-md-12"style="padding: 0px;"><h3 class="big-titles">Create a New Account</h3> </div>  
    <div class="col-md-12 col-sm-12 col-xs-12 wrapper <?php if ($success){ echo "text-center"; } ?>">
    <?php if ($success){ ?>
     <div class="alert alert-dismissable"> 
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &times; </button> 
         <h2>Registration Successful!</h2> 
     </div>
     
    <?php }else{  if ($msg){ showerror($msg); }?>
    <form role="form" class="form-horizontal" method="post" action="">  
      <div class="col-md-6 col-sm-12 col-xs-12"> 
    
        <div class="form-group">
            <label class="col-md-4">Email Address</label>
            <div class="col-md-8">
                <input type="email" name="email" value="<?php posts('email'); ?>" class="form-control"/>
            </div>
        </div> 
        <div class="form-group">
            <label class="col-md-4">Username</label>
            <div class="col-md-8">
                <input type="text" name="username" value="<?php posts('username'); ?>" class="form-control"/>
            </div>
        </div>  
        <div class="form-group">
            <label class="col-md-4">Password</label>
            <div class="col-md-8">
                <input type="password" name="passwords" value="" class="form-control"/>
            </div>
        </div> 
        <div class="form-group">
            <label class="col-md-4">Retype Password</label>
            <div class="col-md-8">
                <input type="password" name="passwordtwo" value="" class="form-control"/> 
            </div>
        </div>
         <div class="form-group">
                    <label class="col-md-4">Currency</label>
                    <div class="col-md-8">
                        <select class="form-control" name="currency">
                            <option value="1">Dollar ($)</option>
                            <option value="2">Pound (&pound;)</option>
                            <option value="3">Euro (&euro;)</option>
                        </select>
                    </div>
                </div>   
    </div>
        <div class="col-md-6 col-sm-12 col-xs-12"> 
                <div class="form-group">
                    <label class="col-md-4">Firstname</label>
                    <div class="col-md-8">
                        <input type="text"  name="firstname" value="<?php posts('firstname'); ?>" class="form-control"/>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-md-4">Lastname</label>
                    <div class="col-md-8">
                        <input type="text"   name="lastname" value="<?php posts('lastname'); ?>" class="form-control"/>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-md-4">Gender</label>
                    <div class="col-md-8">
                        <select class="form-control" name="gender">
                        <option value="Male">Male</option>
                        <option value="Female" >Female</option>
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-md-4">Location</label>
                    <div class="col-md-8">
                        <input type="text" name="location" value="<?php posts('location') ?>" class="form-control"/>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-md-4">Post Code</label>
                    <div class="col-md-8">
                        <input type="text" name="postcode" value="<?php posts('postcode') ?>" class="form-control"/>
                    </div>
                </div>   
    </div> 
  
</div> 
    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 15px;">
    <div class="box-footer text-center">  
    <input type="submit" name="submit" class="btn btn-primary btn-md" value="Signup" /> 
    <a class="btn btn-default" href="index.php">Cancel</a> 
    </div> </div>
</form>
    <?php } ?></div> 
    </div> 
<?php include('footer.php') ?>