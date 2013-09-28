<?
// Simple script to deny access to the killboard according to forum
// accounts.

require('/etc/emcom/mybbauth_config.php');
// The name of the forum the user has to be able to "view".
// This has to be a direct permission, not an inherited permission.
$forum_name = "Internal";

// No need to change anything after this.

if(!isset($_COOKIE['mybbuser'])) {
    die("Access denied. Log in to the forums.");
}

$link = mysql_connect($db_host, $db_user, $db_pass)
         or die("Cannot connect to database: " . mysql_error());
mysql_select_db($db_name)
  or die("Could not select db.");

$logon = explode("_", $_COOKIE['mybbuser'], 2);
$uid = mysql_escape_string($logon[0]);
$loginkey = mysql_escape_string($logon[1]);
$request = mysql_query("SELECT username,
                               CONCAT(usergroup, ',', additionalgroups)
                        FROM mybb_users
                        WHERE uid = '$uid'
                          AND loginkey = '$loginkey'
                        LIMIT 1")
               or die("Query failed: " . mysql_error());

$result = mysql_fetch_array($request);
if (!isset($result)) {
    die("Access denied. Log in to the forums.");
}

$username = $result[0];
define('EM_USERNAME', $username);
$gids = $result[1];
if ($gids[strlen($gids)-1] == ",") {
    $gids = substr($gids, 0, -1);
}
if (!$gids) {
    die("Access denied. You need to log in to the forums.");
}
$name = mysql_escape_string($forum_name);
$query = "SELECT COUNT(*)
          FROM mybb_forums AS forums
               INNER JOIN mybb_forumpermissions AS perm
                 ON forums.fid = perm.fid
          WHERE forums.name = '$name'
            AND perm.gid IN ($gids)
            AND perm.canview = 1";
$request = mysql_query($query)
               or die("Query failed: " . mysql_error());
$result = mysql_fetch_array($request);
if ($result[0] < 1) {
    die("Access denied. Your forum account does not have the appropriate permissions.");
}
?>
