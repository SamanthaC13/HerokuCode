<?php

print "Leader Board Information\n";

# This function reads your DATABASE_URL config var and returns a connection
# string suitable for pg_connect. 
function pg_connection_string_from_database_url() {
  extract(parse_url($_ENV["DATABASE_URL"]));
  return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
}

# Here we establish the connection.
$pg_conn = pg_connect(pg_connection_string_from_database_url());

# Here we query for the leaders
$result = pg_query($pg_conn, "select u.Username, s.RewardLevel, s.BestTime, s.WinLossRatio
from UserStats s join Users u on (s.Userid=u.Userid)
order by s.BestTime");

#print "<pre>\n";
if (!pg_num_rows($result)) {
  print("No results\n");
} else {
  while ($row = pg_fetch_row($result)) { print("$row[0]\n"); }
}
#print "\n";

print "After the database code\n";
?>

