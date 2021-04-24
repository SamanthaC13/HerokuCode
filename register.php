<?php

print "Register Link<br>";

# This function reads your DATABASE_URL config var and returns a connection
# string suitable for pg_connect. 
function pg_connection_string_from_database_url() {
  extract(parse_url($_ENV["DATABASE_URL"]));
  return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
}

# Here we establish the connection.
$pg_conn = pg_connect(pg_connection_string_from_database_url());

# Here we get parameters from the URL
$user = $_GET['username'];
$pass = $_GET['password'];
$first = $_GET['firstname'];
$last = $_GET['lastname'];

# Here we add user to database
#$sql = 'select u."Username", trim(u."Password") "Password" from "Users" u where u."Username" = \''.$user.'\'';
$sql = 'INSERT INTO public."Users"(
  "Password", "Username", "FirstName", "LastName")
  VALUES (\''.$pass.'\', \''.$user.'\', \''.$first.'\', \''.$last.'\')';
print($sql);
print("<br>");

pg_send_query($pg_conn, $sql);
$result = pg_get_result($pg_conn);
print(pg_result_error($result));


print "After the database code<br>";
?>
