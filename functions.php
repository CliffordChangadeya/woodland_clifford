<?php
error_reporting(0); // turn off all error reporting
?>

<?php 
    include ('connect.php');
    function restrict(){
        if(isset($_SESSION['adminid']) || isset($_SESSION['userid'])){ 
            header('location:index.php'); 
        }
    }
    function redirectme(){
        if(isset($_SESSION['adminid']) || isset($_SESSION['userid'])){ 
            header('location:index.php');   
        }     
    }
    function cleanup($x){
        return mysql_real_escape_string($_POST[$x]);
    }
    function posts($x){
        if (isset($_POST[$x])){ 
            echo $_POST[$x]; 
        }
    }
    function showerror($msg){ ?>
        <div class="alert alert-warning">
            <?php foreach($msg as $key => $mssg){?> 
                <p><?= $mssg ?></p>
            <?php } ?> 
        </div>
    <?php } 
    function cabin($rets){ ?>
        <div class="col-md-3 cab-type">
            <div class="cab-handle">
            	<div class="cab-pic" style="background-image: url('img/cabins/<?= $rets['cabinpicture'] ?>')">
            		<h4 class="c-title">
            			<a href="bookings.php?cab=<?= $rets['cabinid'] ?>"><?= $rets['cabinname'] ?> </a>
            		</h4>
            	</div>
            </div>
        </div>
    <?php } 
    function findtype($x){
        if($x==1){
            return "Luxury";
        }else if($x==2){
            return "Contemporaly";
        }else if($x==3){
            return "Original";
        }
    }
    function findcurrency($x){
        if ($x == 1){
            return "$";
        }elseif ($x == 2){
            return "&pound;";
        }elseif ($x == 3){
            return "&euro;";
        } 
    }
    function findseason(){
        $x = date('n');
        if($x > 0 && $x < 4){
            return "winter";
        }else if($x > 3 && $x < 7){
            return "autumn";
        }else if($x > 6 && $x < 10){
            return "summer";
        }else if($x > 9 && $x < 13){
            return "spring";
        }
    } 
?>