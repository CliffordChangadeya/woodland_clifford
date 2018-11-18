<?php
include ('functions.php');
if (!isset($_SESSION['adminid']))
{
    header('location:login.php');
}
if (isset($_SESSION['userid']))
{
    header('location:login.php');
}
if (isset($_GET['req']))
{
    $req = $_GET['req'];
} else
{
    $req = "";
}  
$msg = array();
$editalert = "";
if (isset($_POST['updatebook']))
{
    $startdate = cleanup('startdate');
    $enddate = cleanup('enddate'); 
    $bookingid = cleanup('bid');
    $query = "UPDATE `woodland`.`books` SET `check_in` = '$startdate', `check_out` = '$enddate' WHERE `books`.`bookingid` = $bookingid;";
    $update = mysql_query($query, $dbh) or die(mysql_error());
    $editalert = "charged";
}
if (isset($_POST['updateprice']))
{
    $winter = cleanup('winter');
    $autumn = cleanup('autumn');
    $summer = cleanup('summer');
    $spring = cleanup('spring');
    $ctype = cleanup('type');
    $query = "UPDATE `woodland`.`price` SET `winter` = '$winter', `autumn` = '$autumn', `summer` = '$summer', `spring` = '$spring' WHERE `price`.`cabintype` = $ctype;";
    $update = mysql_query($query, $dbh) or die(mysql_error());
    $editalert = "charged";
}
if (isset($_POST['offer']))
{
    $start = cleanup('start');
    $end = cleanup('end');
    $dis = cleanup('dis');
    $cabinid = cleanup('cab');
    $title = cleanup('title');
    $cab_sql = "SELECT * from logcabins where cabinname = '$cabinid'";
    $cab_rets = mysql_query($cab_sql, $dbh) or die(mysql_error());
    $rets = mysql_fetch_array($cab_rets);
    $cabinid = $rets['cabinid'];
    $query = "INSERT INTO `woodland`.`offers` (`offerid`, `starts`, `ends`, `dis`, `title`, `cabid`) VALUES (NULL, '$start', '$end', '$dis', '$title', '$cabinid');";
    $insert = mysql_query($query, $dbh);
}
if (isset($_POST['addcab']))
{
    $cabin_type = cleanup('type');
    $adults = cleanup('adults');
    $children = cleanup('child');
    $feature = cleanup('feature');
    if ($cabin_type == 1){
        $cabin_name = "LXY-";
    }else if ($cabin_type == 2)
    {
            $cabin_name = "CTM-";
    } else if ($cabin_type == 3)
    {
        $cabin_name = "ORG-";
    }
    $cabin_name = $cabin_name . rand(1000, 9999);
    if (empty($feature))
    {
        $msg[] = 'Cabin features field cannot be empty';
    } else
    {
        //UPLOAD PICTURE PLUGIN
        $img = rand(1000, 10000) . $_FILES['image']['name']; //creating new photoname
        $img_loc = $_FILES['image']['tmp_name']; //getting the current location of the pic
        $img_size = $_FILES['image']['size']; // getting the size of the image
        $img_type = $_FILES['image']['type']; //getting the file type of the image
        $folder = "img/cabins/"; //creating folder to keep our uploaded images
        $img_ext = "error"; // Erro variable
        $gggg = basename($_FILES['image']['name']); //getting the name of the uploaded file
        $imgext = pathinfo($gggg, PATHINFO_EXTENSION); //getting the extention
        $imgext = strtolower($imgext); //converting the extention to small letters.
        if ($_FILES['image']["error"] > 0)
        {
            $msg[] = "No/Invalid Picture provided";
        } else
        {
            $check = getimagesize($img_loc); //check if not fake
            if ($check == false)
            {
                $msg[] = "Invalid Image";
            } else
            {
                if ($imgext != "jpg" && $imgext != "png" && $imgext != "jpeg" && $imgext !=
                    "gif")
                {
                    $msg[] = "Unsupported File format";
                } else
                {
                    $final_file = rand(93, 965) . "." . $imgext;
                    $d = move_uploaded_file($img_loc, $folder . $final_file);
                    $query = "INSERT INTO `woodland`.`logcabins` (`cabinid`, `cabinname`, `cabintype`, `cabinpicture`, `adults`, `children`, `features`) 
                                                                VALUES (NULL, '$cabin_name', '$cabin_type', '$final_file', '$adults', '$children', '$feature');";
                    $insert = mysql_query($query, $dbh);
                    if ($insert === true)
                    {
                        header('location:administrator.php?req=cabins');
                    } else
                    {
                        $msg[] = "Error, Please try again later";
                    }
                } //check for type
            } //check for fake
        } //check for upload error
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
			Woodlands Away
		</title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<link href="dist/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
		<link href="dist/bootstrap/css/bootstrap.css" rel="stylesheet"/>
        <link href="dist/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet"/>
        <link href="dist/fullcalendar/dist/fullcalendar.print.css" rel="stylesheet" media="print"/>        
	</head>
	<style> 	
        .nbm{
            border-radius:0px;  
            margin: 0px;  
            background-color: transparent;
            border: none; 
        }
        .big-titles{
            margin-bottom: 25px;  
            background-color: #102648; 
            color: #ffffff; 
            border-bottom: 4px solid #317589;
            margin-top: -40px;  
        }
        .maintron{
            height: 450px;  
            background-image: url('img/maintron.jpg');
            background-position: bottom;
            background-size: cover;
            background-repeat: no-repeat;
            margin-bottom: 10px;
        }
        .heading-holder{
            height: 70px;  
            background-image: url('img/maintron.jpg');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            margin-bottom: 10px;
        }
        .navbar-menu li a{
            padding: 15px;
            font-size: 16px;
            color: #ffffff; 
        }
        .navbar-menu li a:hover{
            background-color: #317589;
            color: #ffffff;
        }
        .navbar-menu li .active{
            background-color: #317589;
            color: #ffffff;
        } 
        .stylers{
            background-color: #DFF0D8;
        }
        .stylers th{
            color: #134E4A;
            padding: 12px 10px!important; 
            font-size: 15px; 
            border-bottom:none;
        }
        a{
            text-decoration: none;
            color: inherit;
        } 
        .priceinput input{
            width: 70px;
            text-align: right;
        }
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
            background-color: #5B5F68;
            color: #f9f9f9;
            padding: 10px 15px;
            font-size: 16px; 
            float: left;
        } 
	</style>
	<body>
    <div class="col-md-12 heading-holder">
	</div>
	<div class="container" style="padding: 0px 100px;">
		<div class="col-md-12" style="padding: 0px;">
			<div class="big-titles" style="overflow: hidden;">
				<div class="col-md-2" style="padding: 15px;">Woodland Admin</div>
                <div class="col-md-10" style="padding: 0px;">
                <nav class="navbar nbm" role="navigation"> 
                    <ul class="nav navbar-nav navbar-menu"> 
                        <li><a href="<?= $_SERVER['PHP_SELF'] ?>?req=bookings" class="<?php if($req == "bookings"){ echo 'active'; } ?>"> Bookings </a></li>
                        <li><a href="<?= $_SERVER['PHP_SELF'] ?>?req=offers" class="<?php if($req == "offers"){ echo 'active'; } ?>"> Special Offers</a></li>
                        <li><a href="<?= $_SERVER['PHP_SELF'] ?>?req=prices" class="<?php if($req == "prices"){ echo 'active'; } ?>"> Cabin prices</a></li>
                        <li><a href="<?= $_SERVER['PHP_SELF'] ?>?req=cabins" class="<?php if($req == "cabins"){ echo 'active'; } ?>"> Log Cabins </a></li>
                        <li><a href="<?= $_SERVER['PHP_SELF'] ?>?req=add" class="<?php if($req == "add"){ echo 'active'; } ?>"> Add Log Cabin</a></li>
                        <li><a href="logout.php"> Logout</a></li>
                     </ul>
                 </nav>
                </div> 
			</div>
		</div> 
    </div>   
        <div class="container" style=" padding: 0px 100px;">
        <?php  
            if($editalert == "charged"){ ?>
                <div class="col-md-12" style="padding: 0px 30px;">
                     <div class="alert alert-warning alert-dismissable text-center"> 
                         <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &times; </button> 
                         <h5 style="margin: 0px;">Successfully Updated</h5> 
                     </div>
                </div>
        <?php    }   
        if($req=='cabins'){ ?>  
        <div class="col-md-12"> 
            <div class="row"> 
            <?php $cab_sql = "SELECT * from logcabins order by cabinid desc";
            $cab_rets = mysql_query($cab_sql, $dbh) or die(mysql_error());
            while($cab_row = mysql_fetch_array($cab_rets)){ ?>
                <div class="col-md-3 cab-type">
                    <div class="cab-handle">
                    	<div class="cab-pic" style="background-image: url('img/cabins/<?= $cab_row['cabinpicture'] ?>')">
                    		<h4 class="c-title">
                    			<?= $cab_row['cabinname'] ?>
                    		</h4>
                    	</div>
                    </div>
                </div>
            <?php } ?> 
            </div> 
        </div>
        <?php }elseif($req=='bookings' || $req == ""){ 
            if(isset($_GET['edit']) && $_GET['edit']>0){
                $booking = $_GET['edit'];
                $sql = "SELECT * from books where bookingid = $booking";
                $bookingrets = mysql_query($sql, $dbh) or die(mysql_error());
                $bookingrets = mysql_fetch_array($bookingrets); 
                $cabin = $bookingrets['logid']; 
                $query = "SELECT * from logcabins where cabinid = $cabin";
                $rets = mysql_query($query, $dbh) or die(mysql_error()); 
                $cabins = mysql_fetch_array($rets);
                $x = $bookingrets['userid']; 
                $query = "SELECT * from users where userid = $x";
                $rets = mysql_query($query, $dbh) or die(mysql_error()); 
                $users = mysql_fetch_array($rets); 
            ?>  
                <div class="col-md-12">
                <div class="col-md-8 col-md-offset-2">
                         <div class="panel panel-success text-center" style="border-radius: 0px;">
                             <div class="panel-heading"><h4 style="margin: 0px;"> Change Booking Details</h4></div>
                             <div class="panel-body" style="padding:15px; padding-top: 30px;">
                             <form class="form" method="post" action="">  
                                    <h4 style="margin-bottom: 20px;">Client: <?= $users['firstname']." ".$users['lastname']; ?></h4> 
                                    <h4 style="margin-bottom: 20px;">Cabin:  <?= $cabins['cabinname'] ?></h4> 
                                    <h4 style="margin-bottom: 20px;">Type:  <?= findtype($cabins['cabintype']) ?> Cabin</h4>
                                    <div class="col-md-10 col-md-offset-1">
                                    <div class="col-md-6" style="margin-bottom: 20px;">
                                    <h4>Start Date</h4> <input class="form-control" type="text" name="startdate" value="<?= $bookingrets['check_in'] ?>"/>
                                    </div>
                                     <div class="col-md-6" style="margin-bottom: 20px;"> 
                                     <h4>End Date</h4>  <input class="form-control" type="text" name="enddate" value="<?= $bookingrets['check_out'] ?>"/> 
                                     </div>
                                 </div>
                                 
                                <input type="text" hidden="true" name="bid" value="<?= $bookingrets['bookingid'] ?>" />
                                <div class="col-md-12" style="margin-top: 15px; padding: 0px 10px;">
                                <button class="btn btn-primary" type="submit" name="updatebook" value="">Update Details</button>
                                <a class="btn btn-default" href="administrator.php?bookings">Cancel</a>
                                </div>
                              </form> 
                             </div>
                         </div>
                     </div>
                <div>  
         <?php  }else{
                $bookingsql = "SELECT * from books order by bookingid desc";
                $bookingrets = mysql_query($bookingsql, $dbh) or die(mysql_error());?>
                <div class="col-md-12"> 
                <table class="table table-hover">
                    <thead class="stylers">
                        <th>Client Name</th>
                        <th>Cabin</th>
                        <th>Cabin Type</th>
                        <th>Duration</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Booked on</th>
                        <th>
                        </th>
                    </thead>
            <?php 
                while($fetcher = mysql_fetch_array($bookingrets)){ 
                    
                    $q = $fetcher['userid']; 
                    
                    $query = "SELECT * from users where userid = $q";
                    $rets1 = mysql_query($query, $dbh) or die(mysql_error()); 
                    $users = mysql_fetch_array($rets1); 
                    
                    $cabinw = $fetcher['logid']; 
                    $query = "SELECT * from logcabins where cabinid = $cabinw";
                    $rets2 = mysql_query($query, $dbh) or die(mysql_error()); 
                    $cabins = mysql_fetch_array($rets2);  ?> 
                    
                   <tbody><tr><td><?= $users['firstname']." ".$users['lastname']; ?></td>
                   <td><?= $cabins['cabinname'] ?></td> <td><?= findtype($cabins['cabintype']) ?></td> <td><?= $fetcher['duration'] ?></td> <td><?= $fetcher['check_in'] ?></td>
                   <td><?= $fetcher['check_out'] ?></td> <td><?= $fetcher['datebook'] ?></td> 
                   <td><a class="btn btn-default btn-sm" href="<?= $_SERVER['PHP_SELF'] ?>?req=bookings&edit=<?= $fetcher['bookingid'] ?>">Edit</a></td></tr></tbody>
             <?php } } ?>   
            </table> 
        </div>
         <?php }elseif($req=='prices'){ ?>
        <div class="col-md-12">   
                 <table class="table tale-hover">
                    <thead class="stylers"><th>Cabin Type</th><th>Winter</th><th>Autumn</th><th>Summer</th><th>Spring</th><th></th></thead>
                    <tbody>
                    <?php
                    $queryx11 = "SELECT * from price";
                    $retsx11 = mysql_query($queryx11, $dbh) or die(mysql_error());  
                    while($price = mysql_fetch_array($retsx11)){ ?>
                    <form class="form" action="" method="post">
                        <tr>
                            <td><?= findtype($price['cabintype']) ?> Log Cabins</td>
                            <td class="priceinput"><input class="form-control" type="text" name="winter" value="<?= $price['winter'] ?>"/></td>
                            <td class="priceinput"><input class="form-control" type="text" name="autumn" value="<?= $price['autumn'] ?>"/></td>
                            <td class="priceinput"><input class="form-control" type="text" name="summer" value="<?= $price['summer'] ?>"/></td>
                            <td class="priceinput"><input class="form-control" type="text" name="spring" value="<?= $price['spring'] ?>"/></td>
                            <td><input type="text" hidden="true" name="type" value="<?= $price['cabintype'] ?>" />
                            <button class="btn btn-block btn-primary btn-sm" type="submit" name="updateprice" value="">Update</button></td>
                        </tr>
                    </form> <?php }  ?>
                    </tbody>
                 </table> 
             </div> 
        </div>
        <?php }elseif($req=='add'){ ?> 
        <?php if ($msg){ showerror($msg); }?>
        <div class="col-md-8"> 
            <form class="form-horizontal" role="form" method="post" action=""  enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Cabin Type</label> 
                    <div class="col-sm-8">
                        <select class="form-control" name="type"> 
                            <option value="1">Luxury Cabin</option> 
                            <option value="2">Contemporaly Cabin</option> 
                            <option value="3">Original Cabin</option> 
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Cabin Picture</label> 
                    <div class="col-sm-8">
                        <input type="file" name="image" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Number of Adults</label> 
                    <div class="col-sm-8">
                    <input type="text" name="adults" value="2" class="form-control" placeholder=""/>
                    </div> 
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Number of Children</label> 
                    <div class="col-sm-8">
                    <input type="text" name="child" value="2" class="form-control" placeholder=""/>
                    </div> 
                </div> 
                <div class="form-group">
                    <label class="col-sm-4 control-label">Cabin features</label> 
                    <div class="col-sm-8">
                        <textarea class="form-control" name="feature" rows="4"></textarea> 
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-4">
                        <button type="submit" value="submit" class="btn btn-default" name="addcab">Add Log Cabin</button>
                    </div>
                </div>
            </form>
        </div>
        <?php }elseif($req=='offers'){ ?>
        <div class="col-md-12" style="padding: 20px 100px; background-color: #f8f8f8;">
			<div id="calendar">
			</div>
		</div>
	</div>
	<div class="col-md-12" style="margin-top: 30px;">
	</div>
    <div id="triggeroffer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </div> 
    <div id="specialoffermodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        	<div class="modal-dialog">
        		<div class="modal-content">
        			<div class="modal-header">
        				<h4 class="modal-title">
        					Add Cabin Special Offer
        				</h4>
        			</div>
        			<div class="modal-body text-center" style="padding: 20px 40px; overflow: hidden;">
        				<p style="margin-bottom: 15px;">
        					Please provide all the requires details to successfully add the special offer
        				</p>
        				<div class="col-md-8 col-md-offset-2"> 
                        <form id="offerform" role="form" method="post" action="">
        					<div class="form-group">
        						<label class="control-label">
        							Enter Offer Title
        						</label>
        						<input type="text" name="title" id="otitle" value="Woodland Holiday Offer" class="form-control"/>
        					</div>
        					<div class="form-group">
        						<label class="control-label">
        							Select Offer Discount
        						</label>
        						<select class="form-control" name="dis" id="odis">
        							<option value="5">
        								5%
        							</option>
        							<option value="10">
        								10%
        							</option>
        							<option value="25">
        								25%
        							</option>
        							<option value="50">
        								50%
        							</option>
        							<option value="75">
        								75%
        							</option>
        						</select>
        					</div>
        					<div class="form-group">
        						<label class="control-label">
        							Select Cabin
        						</label>
        						<select class="form-control" name="cab" id="offertitle">
        							<?php $cab_sql2="SELECT * from logcabins"; 
                                            $cab_rets2=mysql_query($cab_sql2, $dbh) or die(mysql_error()); 
                                            while($cab_row2=mysql_fetch_array($cab_rets2)){ ?>
                								<option value="<?= $cab_row2['cabinname'] ?>">
                									<?=$cab_row2[ 'cabinname'] ?>
                								</option>
        							<?php } ?>
        						</select>
        					</div>
        					<input type="text" hidden="true" id="checkedin" name="start" value=""/>
        					<input type="text" hidden="true" id="checkedout" name="end" value=""/>
        					<input type="text" hidden="true" id="" name="offer" value=""/>
        				</form>
                        </div>
        			</div>
        			<div class="modal-footer">
        				<button type="button" class="btn btn-default closedismissal" data-dismiss="modal">
        					Close
        				</button>
        				<button type="button" class="btn btn-primary fsubmit" data-dismiss="modal">
        					Submit
        				</button>
        			</div>
        	  </div>
           </div> 
        </div>
        <?php }else{ 
             echo "Sorry we couldnt find what you are looking for";
        } ?>
        </div>  
	</div>
	<script src="dist/bootstrap/js/jquery.js">
	</script>
	<script src="dist/bootstrap/js/bootstrap.min.js">
	</script>
	<script src="dist/moment/min/moment.min.js">
	</script>
	<script src="dist/fullcalendar/dist/fullcalendar.js">
	</script>
	<script>  
     function loadcabin(){  
            $('#specialoffermodal').modal('show');
     }
    $(window).load(function() {	
        var date = new Date(),
            d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear(), 
            categoryClass;
        var calendar = $('#calendar').fullCalendar({
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          selectable: true,
          selectHelper: true,
          select: function(start, end, allDay) {
            $('#specialoffermodal').modal('show'); 
            started = start;
            ended = end;
            $(".fsubmit").on("click", function() {   
              var title = $("#offertitle").val(); 
              if (end) {
                ended = end;
              }
              categoryClass = $("#event_type").val();
              if (title) {
                calendar.fullCalendar('renderEvent', {
                    title: title,
                    start: started,
                    end: end 
                  },
                  true
                  ); 
                   var started2 = started.format("YYYY-MM-DD");
                    var ended2 = ended.format("YYYY-MM-DD"); 
                    $('#checkedin').attr('value',started2);
                    $('#checkedout').attr('value',ended2);                    
                    $('#offerform').submit(); 
              }
              $('#title').val('');
              started = "";
              ended = ""; 
              calendar.fullCalendar('unselect');
              $('.closedismissal').click();
              return false;
            });
          },
          eventClick: function(calEvent, jsEvent, view) {   
                $.ajax({ 
            		url: 'process.php',
                    type: 'POST', // Send post data
                    data: 'fetch=offer&qfetch='+calEvent.id+'&admin=1',
                    async: false,
                    success: function(s){
                        document.getElementById("triggeroffer").innerHTML=s                   
                    }
            	});
                $('#triggeroffer').modal('show');
          },
          editable: true,
          events: [
             <?php 
                $query = "SELECT * from offers";
                $results = mysql_query($query, $dbh) or die(mysql_error()); 
                while($row = mysql_fetch_array($results)){ ?>
                {"id":"<?= $row['offerid'] ?>","title":"<?= $row['title'] ?> <?= $row['dis'] ?>%","start":"<?= $row['starts'] ?>","end":"<?= $row['ends'] ?>","allDay":true},
            <?php } ?>  
            ]
        });
      });
	</script>
	</body>
	</html>