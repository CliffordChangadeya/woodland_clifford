<?php
error_reporting(0); // turn off all error reporting
?>

<?php 
    include('setup.php');
    include('functions.php'); 
    $_SESSION['pgname'] = "index"; 
    include( 'header.php') 
?>
	<div class="maintron">
		<div style="text-align: center; color: #ffffff; padding: 20px;">
			<h1 style="margin-top: 100px; font-size: 58px;">
				Woodlands Away Park
			</h1>
			<p style="font-size: 22px;">
				we serve you the best holiday times
			</p>
		</div>
	</div>
    <div class="container" style="padding: 0px 100px; padding-top: 25px;">
	<div class="content">
		<h3 class="headings">
			Our Log Cabins
		</h3>
		<style>
            .svc-cover{
                margin-bottom:30px;
            }
            .svc-handle .svc-pic{
                height: 200px; 
                background-size: cover;
            }
            .s-details h3{ 
                color: #317589; 
                font-weight: bold;
            } 
            .s-details h4{
                font-size: 16px;  
                color: #333333;
            }
		</style>
		<?php function svc($title,$pic){ 
		  
          $cdetails = "These type of hotel cabins are only found at the midle of hotels in 20nth century, 
                    and they are so lovely and super cooled.";
          
          ?>
        <div class="col-md-4 svc-cover">  
                <div class="col-md-12 svc-type">
    				<div class="svc-handle">
    					<div class="svc-pic" style="background-image: url('img/<?= $pic ?>.jpg');">
    					</div> 
    				</div>
    			</div>
                <div class="col-md-12 s-details">
                    <h3><?= $title ?> Cabins </h3>
                    <p><?= $cdetails ?></p>
                    <h4><strong>Cabin includes:</strong></h4>
                    <h4>Hot Tubs, A/C, Televison, WiFi</h4>
                </div> 
            </div> 
			<?php } svc( 'Luxury','lux'); svc( 'Contemporaly','cont'); svc( 'Original','org'); ?>
	</div></div>
	<div class="container" style="margin-top: 0px; padding: 0px 100px;">
    <h3 class="headings">
			Park Facilities
		</h3>
		<style>
            .cab-handle{
            padding: 5px;
            background: #ffffff;
            }
            .cab-pic{
            height: 220px;
            }
            .cab-pic .c-title{
            margin-top: 150px;
            float: right;
            background-color: #317589;
            color: #f9f9f9;
            padding: 7px 10px;
            } 
		</style>
<?php function cab($title,$pic){ ?>
	<div class="col-md-4 cab-type">
		<div class="cab-handle">
			<div class="cab-pic" style="background-size: cover; background-image: url('img/<?= $pic ?>.jpg');">
        <h4 class="c-title"> Our 
        <?=$title ?> 
                </h4>
            </div>
            </div>
        </div>
        <?php } cab( 'Restaurant','retra'); cab( 'Swimming Pool','pool'); cab( 'Supermarket','mkt'); ?>
        </div>

  <div class="col-md-12" style=" color: #317589; padding: 25px 40px; text-align: center; margin-top: 25px;">  
  <div class="container" style="padding: 0px 100px;">
	
		<h2 style="font-weight: bold;">
			Join Our Customer Forum
		</h2>
        <div style="padding: 0px 150px;">
			<h4 style="font-size: 20px;margin: 20px 0px;">
				Join our Customer forum conversations now, and get answers to your question from other customers.
			</h4>
			<a href="forum.php" class="btn btn-primary btn-lg">Join Forum</a>
		</div>
	</div>
</div>
<?php include('footer.php') ?>