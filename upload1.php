<?php
$con = mysqli_connect('localhost', 'root', '', 'fyp');
$count= "SELECT max(ID) from test";
$result = mysqli_query($con,$count);
$currentdata = mysqli_fetch_array($result);
$newno = $currentdata[0] + 1;
$test = $_POST['totalclass'];



$ext = pathinfo($_FILES["imageupload"]["name"],PATHINFO_EXTENSION);

$imagetmp = file_get_contents($_FILES['imageupload']['tmp_name']);

$newname = "images/"."Picture".$newno.".".strtolower($ext);

if(move_uploaded_file($_FILES['imageupload']['tmp_name'],$newname));{
	$imagename = addslashes($newname);
	$sql = "INSERT INTO test(name) VALUES ('$imagename')";
	$run = mysqli_query($con,$sql);
	echo "successful upload";
	
	if($run){
		$id = mysqli_insert_id($con);
		header('Location: show2.php?id='.$id);
		
		
	}
}
?>
//$insert_image="INSERT INTO test VALUES('$imagetmp','$target_file')";
//$result = mysqli_query($con,$insert_image);




directory

1) $target_loc = "images/" -> specifies the directory where the file is going to be placed.
2) $target_file -> specifies the path of the file to be uploaded.
3) $imageFileType ->  holds the file extension of the file (in lower case).

-->