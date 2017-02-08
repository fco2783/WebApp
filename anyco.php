<?php // File: anyco.php

require('anyco_ui.inc');

// Create a database connection


ui_print_header('EMPLOYEES');

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $conn = oci_connect('hr', 'hr', '//localhost/XE');   
  if (!$conn) {
    $e = oci_error();
    trigger_error('Could not connect to database: ' . $e['message'], E_USER_ERROR);
  }
  
  $stid = oci_parse($conn, "SELECT * FROM EMPLOYEES WHERE EMPLOYEE_ID = '" . $username ."' AND EMAIL = '" . $password ."'");

  $r = oci_execute($stid, OCI_DEFAULT);
  $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
  $item = oci_num_rows($stid);

  if ($item > 0) {
    $conn = oci_connect('hr', 'hr', '//localhost/XE');   
    do_query($conn, 'SELECT * FROM EMPLOYEES');  
  }
}

ui_print_footer(date('Y-m-d H:i:s'));

// Execute query and display results 
function do_query($conn, $query)
{ 
  $stid = oci_parse($conn, $query);
  if (!$stid) {
    $e = oci_error();
    trigger_error('Could not parse statement: ' . $e['message'], E_USER_ERROR);
  }  

  $r = oci_execute($stid, OCI_DEFAULT);
  if (!$r) {
    $e = oci_error();
    trigger_error('Could not execute statement: ' . $e['message'], E_USER_ERROR);
  }    

  print '<table border="1">';
//  while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS)) {
  while (($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) !=FALSE) {

    print '<tr>';
    foreach ($row as $item) {
      print '<td>'. ($item ? htmlentities($item) : '&nbsp;').'</td>';
    }
    print '</tr>';
  }
  print '</table>';
}

?>


<!DOCTYPE html>
<html>
    <head>
        <title>Sample Project</title>
    <style>
      body{
          background-size: cover;
          background-repeat: no-repeat;
          background-position: center center;
          background-image: url("light.jpg");
      }    
    </style>
    </head>
<body>

</body>
</html>
