<?php
error_reporting(0); // turn off all error reporting
?>

<?php 
    include( 'functions.php'); 
    if(!isset($_SESSION['userid'])){ 
        header('location:login.php');   
    }
    $_SESSION['pgname'] = "forum"; 
    if(isset($_POST['submit'])){
        $ask = cleanup('quest');
        if($ask != "" || !empty($ask) ){
            $query = "INSERT INTO `woodland`.`questions` (`questionid`, `quest`, `userid`) VALUES (NULL, '$ask', '$userxid');";
            $insert = mysql_query($query, $dbh);
            header('location:forum.php');
        } 
    }
    if(isset($_POST['reply']) && isset($_GET['q']) && $_GET['q'] > 0){
        $qx = $_GET['q'];
        $ask = cleanup('quest');
        if($ask != "" || !empty($ask)){
            $query = "INSERT INTO `woodland`.`replies` (`replyid`, `reply`, `questionid`, `userid`) VALUES (NULL, '$ask', '$qx', '$userxid');";
            $insert = mysql_query($query, $dbh);
        }
    }
    include( 'header.php'); 
?>
	<div class="col-md-12 heading-holder">
	</div>
	<div class="container" style="padding: 0px 100px;">
		<div class="col-md-12" style="padding: 0px;">
			<h3 class="big-titles">
				Forum
			</h3>
		</div> 
		<div class="col-md-12" style="padding: 0px;">
			<ul class="nav nav-tabs">
				<li>
					<a href="#quests" data-toggle="tab">Questions</a>
				</li> 
                <li>
					<a href="#addquest" data-toggle="tab">Post Question</a>
				</li>  
			</ul>
            <style>
                .questss{
                    padding: 15px 0px; 
                    border-bottom: 1px solid #f1f1f1;
                }
                .questss a{
                    margin: 0px;
                    margin-bottom: 10px;
                    color: #5CB85C;
                    font-size: 18px;
                }
                .questss a:hover{
                    color: orange;
                    text-decoration: none;
                }
                .questss h5{
                    margin: 0px;
                    color: #888888;
                }
            </style>
            <?php function quest($rets,$dbh){ 
                $qquestionid = $rets['questionid'];
                $userid = $rets['userid']; ?>
				 <div class="col-md-12 questss">
    				<a class="col-md-12" href="forum.php?q=<?= $qquestionid ?>&req=view" role="button">
    					<?= $rets['quest'] ?>
    				</a>
                    <h5 class="col-md-3" style="padding-left: 25px;">
    					       by:<?php 
                                    $query = "SELECT * from users where userid = $userid";
                                    $rets = mysql_query($query, $dbh) or die(mysql_error()); 
                                    $user = mysql_fetch_array($rets); 
                                    echo $user['firstname']." ".$user['lastname'];
                                 ?>
    				</h5> 
    				<h5 class="col-md-8">
    					replies: <?php 
                                    $query = "SELECT * from replies where questionid = $qquestionid";
                                    $rets = mysql_query($query, $dbh) or die(mysql_error()); 
                                    echo mysql_num_rows($rets); 
                                 ?>
    				</h5>
    			</div> 
           <?php } ?>
        <div class="tab-content" style="min-height: 320px; padding: 10px 0px;">
            <div class="tab-pane fade <?php if (!isset($_GET['q'])){ echo "in active"; } ?>" id="quests">
                <?php  
                    $query = "SELECT * from questions order by questionid desc";
                    $rets = mysql_query($query, $dbh) or die(mysql_error());
                    while($row = mysql_fetch_array($rets)){
                        quest($row,$dbh); 
                    }
                ?>
            </div>
            <div class="tab-pane fade" id="addquest">
                 <div class="col-md-6" style="padding-left: 30px;">
                     <form class="form-horizontal" role="form" method="post" action=""  enctype="multipart/form-data"> 
                        <div class="form-group">
                            <label class="control-label" style="margin-bottom: 10px;">Type your question here</label>  
                            <textarea class="form-control" name="quest" rows="6"></textarea>  
                        </div> 
                        <div class="form-group"> 
                            <button type="submit" value="submit" class="btn btn-primary" name="submit">Post Question</button> 
                        </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade <?php if(isset($_GET['q']) && $_GET['q'] > 0 ){ echo "in active"; } ?>" id="view">
              <?php if(isset($_GET['q']) && $_GET['q'] > 0 ){ 
                $queid = $_GET['q'];
                $query = "SELECT * from questions where questionid = $queid";
                $retsq = mysql_query($query, $dbh) or die(mysql_error()); 
                $quer = mysql_fetch_array($retsq);
                ?> 
                <div class="col-md-12">
    				<h3 class="col-md-12">
    					<strong><?= $quer['quest'] ?></strong>
    				</h3> 
                    <h5 class="col-md-3" style="padding-left: 25px; margin-top: 5px;">
    					By: <?php 
                                    $xuser = $quer['userid'];
                                    $query = "SELECT * from users where userid = $xuser";
                                    $rets = mysql_query($query, $dbh) or die(mysql_error()); 
                                    $user = mysql_fetch_array($rets); 
                                    echo $user['firstname']." ".$user['lastname'];
                                 ?>
    				</h5> 
    				<?php 
                        $query = "SELECT * from replies where questionid = $queid";
                        $rets = mysql_query($query, $dbh) or die(mysql_error()); 
                        $replies = mysql_num_rows($rets); 
                     ?>
                    <h5 class="col-md-8" style="margin-top: 5px;">
    					Replies: <?= $replies ?>
    				</h5>
                </div> 
                <?php 
                    if ($replies>0){ 
                        while($rep = mysql_fetch_array($rets)){ ?>
                            <div class="col-md-8" style="padding: 0px 30px;">
                                <h5 style="line-height: 1.5em; color: gray;"><span style="margin-bottom: 0px;"><?= $rep['reply'] ?></span>
                                <br /><span style="color: #5CB85C; margin-top: 5px; font-weight: bold;"><?php 
                                    $ask = $rep['userid']; 
                                    $query = "SELECT * from users where userid = $ask";
                                    $results = mysql_query($query, $dbh) or die(mysql_error()); 
                                    $user= mysql_fetch_array($results); 
                                    echo $user['firstname']." ".$user['lastname'];
                                 ?></span></h5>
               			    </div>
                    <?php }  }else{?>
                        <div class="col-md-8" style="padding: 0px 30px; font-style: italic; color: #888888;"> No replies found</div>
                    <?php } ?> 
                <div class="col-md-6" style="padding-left:40px; margin-top: 15px;">
                     <form class="form-horizontal" role="form" method="post" action=""  enctype="multipart/form-data"> 
                        <div class="form-group">
                            <label class="control-label" style="margin-bottom: 5px;">Type a reply here</label>  
                            <textarea class="form-control" name="quest" rows="3"></textarea>  
                        </div> 
                        <div class="form-group"> 
                            <button type="submit" value="submit" class="btn btn-primary" name="reply">Reply</button> 
                        </div>
                    </form>
                </div>
        <?php } ?>
            </div>  
        </div>
    </div>
	<?php  include( 'footer.php') ?>