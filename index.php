<?php

function compressImage($source_url, $destination_url, $quality)
{
  $info = getimagesize($source_url);

  if ($info['mime'] == 'image/jpeg')
    $image = imagecreatefromjpeg($source_url);
  if ($info['mime'] == 'image/gif')
    $image = imagecreatefromgif($source_url);
  if ($info['mime'] == 'image/png')
    $image = imagecreatefrompng($source_url);
  else
    $image = imagecreatefromjpeg($source_url);

  //save image
  imagejpeg($image, $destination_url, $quality);

  //return compressed image
  return $destination_url;
}

if (isset($_POST['submit'])) {

  $upload_path = "img/";
  $file_name = $_FILES['image_file']['name'];
  $imageUploadPath = $upload_path . $file_name;
  $file_type = pathinfo($imageUploadPath, PATHINFO_EXTENSION);

  //allow certain file types
  $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

  if (in_array($file_type, $allowTypes)) {
    $tmp_name = $_FILES['image_file']['tmp_name'];

    if (file_exists($upload_path . $file_name)) {
      echo "file already exists";
    } else {
      $compressesImage = compressImage($tmp_name, $upload_path . $file_name, 50);

      if ($compressesImage) {
        echo " Image compressed successfully. ";
      } else {
        echo " Image not compressed. ";
      }
    }
  } else {
    echo 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compress Image</title>
</head>

<body>

  <form action='' method='POST' enctype='multipart/form-data'>
    <!-- accept="image/*" is use to accespt anykind of image -->
    <input name="image_file" type="file" accept="image/*">
    <button type="submit" name="submit">SUBMIT</button>
  </form>

</body>

</html>