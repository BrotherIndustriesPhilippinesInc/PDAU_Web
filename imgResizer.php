 <?php
    if(isset($_POST['submit'])){
      if (isset ($_FILES['new_image'])){              
          $imagename = $_FILES['new_image']['name'];
          $source = $_FILES['new_image']['tmp_name'];
          $target = "images/".$imagename;
          $type=$_FILES["new_image"]["type"];

          if($type=="image/jpeg" || $type=="image/jpg"){
          move_uploaded_file($source, $target);
          //orginal image making part

          $imagepath = $imagename;
          $save = "images/" . $imagepath; //This is the new file you saving
          $file = "images/" . $imagepath; //This is the original file
          list($width, $height) = getimagesize($file) ;
          $modwidth = 1000;
          $diff = $width / $modwidth;
          $modheight = $height / $diff;   
          $tn = imagecreatetruecolor($modwidth, $modheight) ;
          $image = imagecreatefromjpeg($file) ;
          imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;
          echo "Large image: <img src='images/".$imagepath."'><br>";                     
          imagejpeg($tn, $save, 100) ;

          //thumbnail image making part
          $save = "images/thumb/" . $imagepath; //This is the new file you saving
          $file = "images/" . $imagepath; //This is the original file   
          list($width, $height) = getimagesize($file) ;
          $modwidth = 150;
          $diff = $width / $modwidth;
          $modheight = $height / $diff;
          $tn = imagecreatetruecolor($modwidth, $modheight) ;
          $image = imagecreatefromjpeg($file) ;
          imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;
        //echo "Thumbnail: <img src='images/sml_".$imagepath."'>";
          imagejpeg($tn, $save, 100) ;
          }
        else{
            echo "File is not image";
            }
      }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
<form action="<?php echo $_SERVER["PHP_SELF"];  ?>" method="post" enctype="multipart/form-data" id="something" class="uniForm">
    <input name="new_image" id="new_image" size="30" type="file" class="fileUpload" />
    <button name="submit" type="submit" class="submitButton">Upload Image</button>
</form>
</body>
</html>