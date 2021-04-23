<?php

print "Login Link<br>";

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
print($user);
print("<br>");
print($pass);
print("<br>");

# Here we check if user exists
$sql = 'select u."Username", u."Password" from "Users" u where u."Username" = "'.$user.'"';
print($sql);

pg_send_query($pg_conn, $sql);
$result = pg_get_result($pg_conn);
print(pg_result_error($result));

if (!pg_num_rows($result)) {
  print("2 - User not found<br>");
} else 
{
  if ($row[1]==$pass)
  {
    print("1 - Login successful<br>");
  } else
  {
    print("3 - Invalid password<br>");
  }
}

print "After the database code<br>";
?>

