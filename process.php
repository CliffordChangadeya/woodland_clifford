<?php
error_reporting(0); // turn off all error reporting
?>

<?php  
    include('functions.php');
    if(isset($_SESSION['userid'])){
        if(isset($_POST['booker'])){ 
        	$duration = $_POST['duration'];
            $start = $_POST['start'];
            $end = $_POST['end'];
            $adults = $_POST['adults'];
            $children = $_POST['children']; 
            $price = $_POST['price']; 
            $cabinid = $_POST['cabid'];
            $bookdate = date('Y-m-d');
            $query = "INSERT INTO `woodland`.`books` (`bookingid`, `logid`, `duration`, `check_in`, `check_out`, `adults`, `children`, `price`, `userid`, `datebook`) VALUES (NULL, '$cabinid', '$duration', '$start', '$end', '$adults', '$children', '$price', '$userxid', '$bookdate');";
            $insert = mysql_query($query, $dbh); 
            if ($insert){
                echo 1;
            }else{
                echo 2;
            } 
            
            $xcv = "SELECT * from users where userid =  $userxid";
            $xcx = mysql_query($xcv, $dbh) or die(mysql_error());
            $xcx = mysql_fetch_array($xcx); 
            $to = $xcx['email'];
            $curr = $xcx['currency'];
            
            $xcv = "SELECT * from logcabins where cabinid =  $cabinid";
            $xcx = mysql_query($xcv, $dbh) or die(mysql_error());
            $xcx = mysql_fetch_array($xcx); 
            $typed = $xcx['type'];
             
            $messagebody = "You have succefully booked a $typed Log Cabin from $start to $end at amount of $curr $price at Woodlands Away Holiday Park. Regards!";
            include('gmail.php');   
        }   
    }
    
    if(isset($_POST['fetch']) && $_POST['fetch']=="offer"){ 
        $offerid = $_POST['qfetch'];
        ?>
        <div class="modal-dialog">
        <div class="modal-content"> 
          <div class="modal-header"> 
          <h3 class="modal-title" style="color: red; margin: 0px;">Special Offer</h3>
           </div> 
          <div class="modal-body text-center" style="padding: 20px 40px; overflow: hidden;"> 
          <?php $query = "SELECT * from offers where offerid = $offerid";
                $results = mysql_query($query, $dbh) or die(mysql_error()); 
                $row = mysql_fetch_array($results);
                $cabinid = $row['cabid'];
                $query = "SELECT * from logcabins where cabinid = $cabinid";
                $results = mysql_query($query, $dbh) or die(mysql_error()); 
                $retslet = mysql_fetch_array($results);
                ?>
                <h3><?= $row['title'] ?> <?= $row['dis'] ?>% Discount </h3>
         
           <h3> <?= $retslet['cabinname'] ?> Log Cabin</h3>
                <div class="col-md-12">
                    <h4>Starts: <?= $row['starts'] ?></h4>
                    <h4>Ends: <?= $row['ends'] ?></h4>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default fclose" data-dismiss="modal">Close</button> 
            <a href="bookings.php?specialoffer=<?= $row['offerid'] ?>" class="btn btn-primary" >Book Now</a>
          </div>
        </div>
      </div>
    <?php }  ?>