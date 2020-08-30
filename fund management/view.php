<?php
session_start();
// https://www.codexworld.com/upload-multiple-images-store-in-database-php-mysql/
// Remember to make change in php.ini file(search file_uploads)
//Make a dialogue box for succesfull update
//unable to upload file of size >10MB
// 3rd april
require 'config.php';
$uID = ($_SESSION['username']);

if(isset($_POST["view"])){
$target_dir="../uploads/".$uID."/";
if ($handle = opendir($target_dir)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
			$lin="<a href='download.php?file=".$entry." & userid=".$uID."'>".$entry."</a></br>";
			echo $lin;
    	    }
    	}
    	closedir($handle);
	}
}
?>