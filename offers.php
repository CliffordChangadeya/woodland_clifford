<?php
error_reporting(0); // turn off all error reporting
?>

<?php  
include( 'functions.php');
$_SESSION['pgname'] = "offers";  
include( 'header.php') ?>
    <div class="col-md-12 heading-holder">
    </div>
    <div class="container" style="padding: 0px 100px;">
    	<div class="col-md-12" style="padding: 0px;">
    		<h3 class="big-titles">
    			Special Offers
    		</h3>
    	</div>
    	<div class="col-md-12" style="padding: 20px 80px; background-color: #f8f8f8;">
    		<div id="calendar">
    		</div>
    	</div>
    </div>
    <div class="col-md-12" style="margin-top: 35px;">
    </div>
    <div id="triggeroffer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </div>
    <footer>
    	<div class="col-md-12 text-center">
    		<p>
    			&copy; 2017 Woodlands Away
    		</p>
    	</div>
    	<div class="col-md-12 text-center">
    		<p>
    			Site Administrator -
    			<a href="login.php?req=admin"><strong>Login</strong></a>
    		</p>
    	</div>
    </footer>
	<script src="dist/bootstrap/js/jquery.js">
	</script>
	<script src="dist/bootstrap/js/bootstrap.min.js">
	</script>
	<script src="dist/moment/min/moment.min.js">
	</script>
	<script src="dist/fullcalendar/dist/fullcalendar.js">
	</script>
	<script>
		//Bootstrap Full Calendar Plugin
          $(window).load(function() {
            var date = new Date(),
                d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear(),
                started,
                categoryClass;
            var calendar = $('#calendar').fullCalendar({
              header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
              },
              selectable: false,
              selectHelper: true,
              editable: true, 
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
              events: [ //pulling out special offers
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