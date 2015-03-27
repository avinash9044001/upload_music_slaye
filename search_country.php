<?php
$connection = mysql_connect('localhost', 'avinash', '12345');
$db = mysql_select_db('social', $connection);
$term = strip_tags(substr($_POST['searchit'],0, 100));
$term = mysql_real_escape_string($term); // Attack Prevention
if($term=="")
echo "Enter Something to search";
else{
$query = mysql_query("select country,state,id from autocomp where country like '{$term}%' ", $connection);
$string = '';
$userlist='';
$profile_pic='';
$uw='';
$x_state='';

if (mysql_num_rows($query)){
while($row = mysql_fetch_assoc($query)){
        $u = $row["country"];
		$state=$row["state"];
		$state_arr=explode(",",$state);
		$avatar = 'image_country/'.$row["id"].'.png';
		$xy=$row["id"];
		$userlist .= '<p href="#"><img src="'.$avatar.'"alt="'.$u.'" onclick="xyz('."'$u'".')" ">'.$u.'</p>';
		  foreach($state_arr as $stat)
		  {
		  $x_state.='<option value='.'"'.$stat.'">'.$stat.'</option>'.'</br>';
		  }}}
else{
$userlist = "No matches found!";
}
echo $userlist;
echo $uw;
}
?>

