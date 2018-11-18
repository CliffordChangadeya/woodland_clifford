<?php
error_reporting(0); // turn off all error reporting
?>

<?php 
    include( 'functions.php'); 
    $_SESSION['pgname'] = "cabins"; 
    if(isset($_GET['specialoffer'])){
        $offerid = $_GET['specialoffer'];
        $query = "SELECT * from offers where offerid = $offerid";
        $results = mysql_query($query, $dbh) or die(mysql_error()); 
        $row = mysql_fetch_array($results);
        $cabinid = $row['cabid'];
        $discount = $row['dis']; 
        $xxstarts = $row['starts'];
        $xxends = $row['ends'];
    }else{
        $discount = 0;
        $cabinid = $_GET['cab'];
        $xxends = "";
        $xxstarts = "";
    } 
    $cab_sql = "SELECT * from logcabins where cabinid = $cabinid";
    $cab_rets = mysql_query($cab_sql, $dbh) or die(mysql_error());
    $rets = mysql_fetch_array($cab_rets);
    $usercurrency = "$";
    if(isset($_SESSION['userid'])){ 
        $xcv = "SELECT * from users where userid =  $userxid";
        $xcx = mysql_query($xcv, $dbh) or die(mysql_error());
        $xcx= mysql_fetch_array($xcx);
        $usercurrency = findcurrency($xcx['currency']);
    } 
    include( 'header.php'); 
?>
	<div class="col-md-12 heading-holder">
	</div>
	<div class="container" style="padding: 0px 100px;">
		<div class="col-md-12" style="padding: 0px;">
			<h3 class="big-titles">
				<?= findtype($rets['cabintype']) ?> Log Cabin
			</h3>
		</div>
		<div class="col-md-8">
			<h3>
				<?= $rets['cabinname'] ?> Log Cabin
			</h3>
            <?php 
                $season = findseason();
                $ctype = $rets['cabintype'];
                $cquery = "SELECT * from price where cabintype = $ctype";
                $crets = mysql_query($cquery, $dbh) or die(mysql_error());
                $crets = mysql_fetch_array($crets);
                $cabinprice = $crets[$season];
            ?>
            <div class="col-md-12" style="background-image: url('img/cabins/<?= $rets['cabinpicture'] ?>'); background-size: contain; background-repeat: no-repeat; height: 250px; margin-bottom: 15px;"> </div>
            <h3>
				Cabin Features
			</h3>
            <div class="col-md-12">
                <?= $rets['features'] ?>
            </div>
		</div>
		<div class="col-md-4">
			<h3 style="text-align: center;">
			<?php if(isset($_GET['specialoffer'])){ ?>
			     Special Offer <span style="color: red;"><?= $discount ?>% Off</span>
			<?php }else{ ?>
			     Book this Log Cabin
			<?php } ?>
            </h3>
            <div class="col-md-12" style="background-color: #5B5F68; padding: 20px;">
            <?php if(!isset($_SESSION['userid'])){ ?>
            <div class="box-footer"> 
                <h4 class="text-center" style="color: #f9f9f9;"> You need to Login to Book this Log Cabin</h4>
                <a href="login.php" class="btn btn-primary btn-block">Login Now</a>
            </div> 
            <?php }else{
                if(isset($_GET['specialoffer'])){ ?>
			     <form id="bookform" role="form" method="post" action="">  
                <div class="form-group">
                    <select class="form-control" id="fduration" name="duration">
                        <option value="">Select Ticket Duration</option>
                        <option value="Weekend" selected="">Weekend</option>
                        <option value="Weekdays">Weekdays</option> 
                    </select>
                </div> 
                <div class="form-group">
                    <input type="text" name="start" id="fstart" value="<?= $xxstarts ?>" class="form-control date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-format="yyyy-mm-dd" readonly="" placeholder="Check in"/> 
                </div> 
                <div class="form-group">
                    <input type="text" name="end" id="fend" value="<?= $xxends ?>" class="form-control date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-format="yyyy-mm-dd" readonly="" placeholder="Check out"/> 
                </div>
                <div class="form-group">
                    <select class="form-control" id="fadults" name="adults">
                        <option value="">Number of Adults</option>
                        <option value="2" selected="">2</option>
                        <option value="3">3</option> 
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" id="fchildren" name="children">
                        <option value="">Number of Children</option>
                        <option value="2" selected="">2</option>
                        <option value="3">3</option> 
                        <option value="4">4</option>
                    </select>
                </div>
                <input type="hidden" name="user" id="fuser" value="<?= $userxid ?>" />
                <input type="hidden" name="cabid" id="fcabid" value="<?= $cabinid ?>" />
                <input type="hidden" name="price" id="fprice" value="<?= $cabinprice-($cabinprice*($discount/100)) ?>" />
                <input type="hidden" name="booker" id="" value="" />
            </form> 
            <div class="box-footer"> 
                <button id="formcheck" name="login" class="btn btn-primary btn-block">CHECK AVAILABILITY</button>
            </div> 
			<?php }else{ ?> 
            <form id="bookform" role="form" method="post" action="">  
                <div class="form-group">
                    <select class="form-control" id="fduration" name="duration">
                        <option value="">Select Ticket Duration</option>
                        <option value="Weekend">Weekend</option>
                        <option value="Weekdays">Weekdays</option> 
                    </select>
                </div> 
                <div class="form-group">
                    <input type="text" name="start" id="fstart" value="" class="form-control date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-format="yyyy-mm-dd" readonly="" placeholder="Check in"/> 
                </div> 
                <div class="form-group">
                    <input type="text" name="end" id="fend" value="" class="form-control date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-format="yyyy-mm-dd" readonly="" placeholder="Check out"/> 
                </div>
                <div class="form-group">
                    <select class="form-control" id="fadults" name="adults">
                        <option value="">Number of Adults</option>
                        <option value="2">2</option>
                        <option value="3">3</option> 
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" id="fchildren" name="children">
                        <option value="">Number of Children</option>
                        <option value="2">2</option>
                        <option value="3">3</option> 
                        <option value="4">4</option>
                    </select>
                </div>
                <input type="hidden" name="user" id="fuser" value="<?= $userxid ?>" />
                <input type="hidden" name="cabid" id="fcabid" value="<?= $cabinid ?>" />
                <input type="hidden" name="price" id="fprice" value="<?= $cabinprice-($cabinprice*($discount/100)) ?>" />
                <input type="hidden" name="booker" id="" value="" />
            </form> 
            <div class="box-footer"> 
                <button id="formcheck" name="login" class="btn btn-primary btn-block">CHECK AVAILABILITY</button>
            </div> 
            <?php } } ?>
            </div>
		</div>
	</div>
  <div id="visitmod" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content"> 
          <div class="modal-header"> 
            <h4 class="modal-title">Booking Summary</h4>
          </div>
          <style>
          .bheds{
            font-size: 15px!important;
            font-weight: bold!important;
          }
          </style>
          <div class="modal-body" style="padding: 20px 40px;">
                <table class="table table-bordered" >
                    <tr><td class="bheds">Log Cabin</td><td id="xcabin"></td></tr>
                    <tr><td class="bheds">Duration Type</td><td id="xduration"></td></tr>
                    <tr><td class="bheds">Check In</td><td id="xin"></td></tr>
                    <tr><td class="bheds">Check Out</td><td id="xout"></td></tr>
                    <tr><td class="bheds">Adults</td><td id="xadults"></td></tr>
                    <tr><td class="bheds">Children</td><td id="xchildren"></td></tr>
                </table>
                <table class="table table-bordered">
                    <tr><td class="bheds">Cabin price</td><td class="bheds">Discount</td><td class="bheds">Total price</td></tr>
                    <tr><td id="xprice"></td><td id="xdiscount"></td><td id="xtotal"></td></tr> 
                </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" id="booknow" class="btn btn-primary antosubmit">BOOK NOW</button>
          </div>
        </div>
      </div>
    </div> 
    <div id="successmod" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content"> 
          <div class="modal-header"> 
            <h4 class="modal-title">Successfully Booked!</h4>
          </div> 
          <div class="modal-body text-center" style="padding: 20px 40px;"> 
                <h3 style="color: green;">You have Successfully booked </h3>
                <h3 style="color: orange;"><strong><?= $rets['cabinname'] ?> Cabin</strong></h3>
                <h4 style="color: gray; margin-top: 30px; font-size: 16px; line-height: 1.5em;">Please check your inbox, we have sent you<br /> Email confirming the booking details.</h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
          </div>
        </div>
      </div>
    </div>
    <div id="openmod" data-toggle="modal" data-target="#visitmod"></div>
<?php include( 'footer.php') ?>
<script> 
    $('#formcheck').click( function (){
        document.getElementById("xcabin").innerHTML = "<?= $rets['cabinname'] ?>";
        document.getElementById("xduration").innerHTML = $('#fduration').val();
        document.getElementById("xin").innerHTML = $('#fstart').val();
        document.getElementById("xout").innerHTML = $('#fend').val();
        document.getElementById("xadults").innerHTML = $('#fadults').val();
        document.getElementById("xchildren").innerHTML = $('#fchildren').val();
        document.getElementById("xprice").innerHTML = "<?= $usercurrency ?><?= $cabinprice ?>";
        document.getElementById("xdiscount").innerHTML = "<?= $discount ?>%";
        document.getElementById("xtotal").innerHTML = "<?= $usercurrency ?><?= $cabinprice-($cabinprice*($discount/100)) ?>"; 
        $('#openmod').click();
    });
    $('#booknow').click( function(){
        $('#bookform').submit();
    }); 
     $('#bookform').submit(function(e){
         e.preventDefault(); 
         $.ajax({ 
    		url: 'process.php',
            type: 'POST',  
            data: $('#bookform').serialize(),
            async: false,
            success: function(s){
                $("#visitmod").modal('hide'); 
                $('#successmod').modal('show'); 
            }
    	});
     }); 
     $('#successmod').on('hide.bs.modal', function () { 
        window.location.href = "logcabins.php";
     }); 
</script>