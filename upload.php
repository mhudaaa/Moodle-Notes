<?php 

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

$temp_name = $_FILES['file']['tmp_name'];
$real_name = $_FILES['file']['name'];

// echo $temp_name . " - ". $real_name;
$target_dir = "uploads/temp/";
$target_file = $target_dir . basename($real_name);
$uploadOk = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

$check = getimagesize($temp_name);
if($check !== false) {
    echo "File is an image - " . $check['mime'] . ".";
    $uploadOk = 1;
} else {
    echo "File is not an image.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($temp_name, $target_file)) {
        $contenthash = sha1_file($target_dir. "/" .$real_name);
        $firstdir = substr($contenthash, 0, 2);
        $scnddir = substr($contenthash, 2, 2);
        echo "<br>Content hash : ".$contenthash;
        echo "<br>First dir : ".$firstdir;
        echo "<br>Scnd dir : ".$scnddir;
        echo "<br>The file ". basename($real_name). " has been uploaded.";

        // Make dir
        if (!file_exists('uploads/' . $firstdir)) {
            mkdir('uploads/'.$firstdir, 0777, true);

            if (!file_exists('uploads/' . $firstdir . '/'. $scnddir)) {
                mkdir('uploads/' .$firstdir. '/'. $scnddir, 0777, true);

            }
        }

        rename($target_file, 'uploads/' .$firstdir. '/'. $scnddir .'/'. $contenthash);


    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

?>