<?php
error_reporting(0); // turn off all error reporting
?>
<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $conn = mysql_connect($host, $user, $pass) or die("Couldn't connect to server");
    $db = "woodland";
    if (!mysql_select_db($db)) {
        $stmt = "CREATE DATABASE IF NOT EXISTS $db;";
        $rets = mysql_query($stmt, $conn);
        mysql_select_db($db);
        
        $stmt = "CREATE TABLE IF NOT EXISTS administrator (
admin_id int(11) NOT NULL,
  username varchar(30) NOT NULL,
  password varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;"; $rets = mysql_query($stmt, $conn);

$stmt = "INSERT INTO administrator (admin_id, username, password) VALUES 
(1, 'cliff', '2017');"; $rets = mysql_query($stmt, $conn);

$stmt = "CREATE TABLE IF NOT EXISTS books (
bookingid int(4) NOT NULL,
  logid int(4) NOT NULL,
  duration varchar(10) NOT NULL,
  check_in date NOT NULL,
  check_out date NOT NULL,
  adults int(2) NOT NULL,
  children int(2) NOT NULL,
  price float NOT NULL,
  userid int(4) NOT NULL,
  datebook date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;"; $rets = mysql_query($stmt, $conn); 

$stmt = "CREATE TABLE IF NOT EXISTS logcabins (
cabinid int(4) NOT NULL,
  cabinname varchar(30) NOT NULL,
  cabintype int(2) NOT NULL,
  cabinpicture varchar(120) NOT NULL,
  adults int(2) NOT NULL,
  children int(2) NOT NULL,
  features text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;"; $rets = mysql_query($stmt, $conn); 


$stmt = "CREATE TABLE IF NOT EXISTS offers (
offerid int(4) NOT NULL,
  starts date NOT NULL,
  ends date NOT NULL,
  dis int(4) NOT NULL,
  title varchar(120) NOT NULL,
  cabid int(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;"; $rets = mysql_query($stmt, $conn); 

$stmt = "CREATE TABLE IF NOT EXISTS price (
  cabintype int(2) NOT NULL,
  winter float NOT NULL,
  autumn float NOT NULL,
  summer float NOT NULL,
  spring float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;"; $rets = mysql_query($stmt, $conn); 

$stmt = "INSERT INTO price (cabintype, winter, autumn, summer, spring) VALUES
(1, 10, 10, 10, 10),
(2, 10, 10, 10, 10),
(3, 10, 10, 10, 10);"; $rets = mysql_query($stmt, $conn);

$stmt = "CREATE TABLE IF NOT EXISTS questions (
questionid int(11) NOT NULL,
  quest text NOT NULL,
  userid int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;"; $rets = mysql_query($stmt, $conn);

$stmt = "CREATE TABLE IF NOT EXISTS replies (
replyid int(2) NOT NULL,
  reply text NOT NULL,
  questionid int(2) NOT NULL,
  userid int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;"; $rets = mysql_query($stmt, $conn);

$stmt = "CREATE TABLE IF NOT EXISTS users (
userid int(11) NOT NULL,
  firstname varchar(30) NOT NULL,
  lastname varchar(30) NOT NULL,
  gender varchar(10) NOT NULL,
  location varchar(20) NOT NULL,
  postcode varchar(10) NOT NULL,
  currency int(2) NOT NULL,
  email varchar(120) NOT NULL,
  username varchar(120) NOT NULL,
  password varchar(120) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;"; $rets = mysql_query($stmt, $conn);

$stmt = "ALTER TABLE administrator
 ADD PRIMARY KEY (admin_id), ADD UNIQUE KEY username (username);"; $rets = mysql_query($stmt, $conn); 
 
$stmt = "ALTER TABLE books
 ADD PRIMARY KEY (bookingid), ADD KEY logid (logid), ADD KEY userid (userid);"; $rets = mysql_query($stmt, $conn); 

$stmt = "ALTER TABLE logcabins
 ADD PRIMARY KEY (cabinid);"; $rets = mysql_query($stmt, $conn); 

$stmt = "ALTER TABLE offers
 ADD PRIMARY KEY (offerid), ADD KEY cabid (cabid);"; $rets = mysql_query($stmt, $conn); 
 
$stmt = "ALTER TABLE price
 ADD PRIMARY KEY (cabintype);"; $rets = mysql_query($stmt, $conn); 

$stmt = "ALTER TABLE questions
 ADD PRIMARY KEY (questionid), ADD KEY userid (userid);"; $rets = mysql_query($stmt, $conn); 
 
$stmt = "ALTER TABLE replies
 ADD PRIMARY KEY (replyid), ADD KEY qid (questionid,userid), ADD KEY userid (userid);"; $rets = mysql_query($stmt, $conn); 

$stmt = "ALTER TABLE users
 ADD PRIMARY KEY (userid);"; $rets = mysql_query($stmt, $conn); 

$stmt = "ALTER TABLE administrator
MODIFY admin_id int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;"; $rets = mysql_query($stmt, $conn); 

$stmt = "ALTER TABLE books
MODIFY bookingid int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;"; $rets = mysql_query($stmt, $conn); 

$stmt = "ALTER TABLE logcabins
MODIFY cabinid int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;"; $rets = mysql_query($stmt, $conn); 

$stmt = "ALTER TABLE offers
MODIFY offerid int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;"; $rets = mysql_query($stmt, $conn); 

$stmt = "ALTER TABLE questions
MODIFY questionid int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;"; $rets = mysql_query($stmt, $conn); 

$stmt = "ALTER TABLE replies
MODIFY replyid int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;"; $rets = mysql_query($stmt, $conn); 

$stmt = "ALTER TABLE users
MODIFY userid int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;"; $rets = mysql_query($stmt, $conn); 

$stmt = "ALTER TABLE books
ADD CONSTRAINT books_ibfk_1 FOREIGN KEY (logid) REFERENCES logcabins (cabinid) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT books_ibfk_2 FOREIGN KEY (userid) REFERENCES users (userid) ON DELETE CASCADE ON UPDATE CASCADE;"; $rets = mysql_query($stmt, $conn); 

$stmt = "ALTER TABLE offers
ADD CONSTRAINT offers_ibfk_1 FOREIGN KEY (cabid) REFERENCES logcabins (cabinid) ON DELETE CASCADE ON UPDATE CASCADE;"; $rets = mysql_query($stmt, $conn); 

$stmt = "ALTER TABLE questions
ADD CONSTRAINT questions_ibfk_1 FOREIGN KEY (userid) REFERENCES users (userid) ON DELETE CASCADE ON UPDATE CASCADE;"; $rets = mysql_query($stmt, $conn); 

$stmt = "ALTER TABLE replies
ADD CONSTRAINT replies_ibfk_2 FOREIGN KEY (userid) REFERENCES users (userid) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT replies_ibfk_3 FOREIGN KEY (questionid) REFERENCES questions (questionid);"; $rets = mysql_query($stmt, $conn); 
    } 
?>
