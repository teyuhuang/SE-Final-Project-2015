<?php
   $dbhost = "localhost";
   $dbuser = "root";
   $dbpass = "root";
   $dbname = "dbname";

   //Connect to MySQL Server
   mysql_connect($dbhost, $dbuser, $dbpass);

   //Select Database
   mysql_select_db($dbname) or die(mysql_error());

   // Retrieve data from Query String
   $age = $_POST['age'];
   $sex = $_POST['sex'];
   $wpm = $_POST['wpm'];
   $textid = $_POST['test'];
   $cookie = json_decode( $_COOKIE[ "login" ] );
   $expiry = $cookie->expiry;
   // Escape User Input to help prevent SQL Injection
   $age = mysql_real_escape_string($age);
   $sex = mysql_real_escape_string($sex);
   $wpm = mysql_real_escape_string($wpm);

   //build query
   $query = "SELECT * FROM ajax_example WHERE sex = '$sex'";

   if(is_numeric($age))
   $query .= " AND age <= $age";

   if(is_numeric($wpm))
	$query .= " AND wpm <= $wpm";

   //Execute query
   $qry_result = mysql_query($query) or die(mysql_error());

   //Build Result String
   $display_string = "<table>";
   $display_string .= "<tr>";
   $display_string .= "<th>Name</th>";
   $display_string .= "<th>Age</th>";
   $display_string .= "<th>Sex</th>";
   $display_string .= "<th>WPM</th>";
   $display_string .= "<th>test</th>";
   $display_string .= "</tr>";

   // Insert a new row in the table for each person returned
   while($row = mysql_fetch_array($qry_result)){
      $display_string .= "<tr>";
      $display_string .= "<td>$row[name]</td>";
      $display_string .= "<td>$row[age]</td>";
      $display_string .= "<td>$row[sex]</td>";
      $display_string .= "<td>$row[wpm]</td>";
      $display_string .= "<td>$textid</td>";
      $display_string .= "</tr>";
   }
   echo "<p id=timelf>Time left: ".($expiry-time()) . " Sec(s)"."</p>";
   echo "Query: " . $query . "<br />";
   $display_string .= "</table>";
   echo $display_string;
?>