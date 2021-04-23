<?php

print "Leader Board Information<br>";

# This function reads your DATABASE_URL config var and returns a connection
# string suitable for pg_connect. 
function pg_connection_string_from_database_url() {
  extract(parse_url($_ENV["DATABASE_URL"]));
  return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
}

# Here we establish the connection.
$pg_conn = pg_connect(pg_connection_string_from_database_url());

# Here we query for the leaders
$sql = 'select u."Username", s."RewardLevel", s."BestTime", s."WinLossRatio"
from "UserStats" s join "Users" u on (s."Userid"=u."Userid")
order by s."BestTime"';
#$sql = 'select u."Username" from "Users" u';
#$sql = "SELECT relname FROM pg_stat_user_tables WHERE schemaname='public'";
#print($sql);

#$result = pg_query($pg_conn, $sql);
pg_send_query($pg_conn, $sql);
$result = pg_get_result($pg_conn);
print(pg_result_error($result));

#print(pg_num_rows($result));

#print "<pre>\n";
if (!pg_num_rows($result)) {
  print("No results\n");
} else {
  while ($row = pg_fetch_row($result)) { print("$row[0],$row[1],$row[2],$row[3]<br>"); }
}
#print "\n";

print "After the database code\n";
?>

