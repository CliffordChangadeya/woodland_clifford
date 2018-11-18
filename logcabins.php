<?php
error_reporting(0); // turn off all error reporting
?>

<?php 
include('functions.php'); 
$_SESSION['pgname'] = "cabins"; 
include('header.php') ?>
    <div class="col-md-12 heading-holder"> </div>          
    <div class="container" style="padding: 0px 100px;"> 
    <div class="col-md-12" style="padding: 0px;"><h3 class="big-titles">Log Cabins</h3> </div>  
    <style>
        .cab-type{ 
            margin-bottom: 25px;
            overflow: hidden;
        }
        .cab-pic{
            height: 180px; 
            border-radius: 3px;
            background-color: gray;
            background-position: center;
            background-size: cover;
            overflow: hidden;                                
        }
        .cab-pic .c-title{
            margin-top: 120px; 
            background-color: #39A239;
            color: #f9f9f9;
            padding: 10px 15px;
            font-size: 16px; 
            float: left;
        } 
        .cab-pic .c-title a{
            color: inherit;
            text-decoration: none;
        }
        .c-title:hover{
            background-color: orange;
        }
    </style>
    <?php  
        $cab_sql = "SELECT * from logcabins order by cabinid desc";
        $cab_rets = mysql_query($cab_sql, $dbh) or die(mysql_error());
        while($cab_row = mysql_fetch_array($cab_rets)){
        cabin($cab_row);
        }
    ?> 
    </div> 
<?php include('footer.php') ?>