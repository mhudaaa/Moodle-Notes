<?php 

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

$temp_name = $_FILES['file']['tmp_name'];
$real_name = $_FILES['file']['name'];

$moodledata = '/Applications/MAMP/moodledata/';
$filedir = $moodledata.'filedir/';
$target_dir = $moodledata. 'temp/';
$target_file = $target_dir . basename($real_name);
$uploadOk = 1;
$ext = pathinfo($target_file, PATHINFO_EXTENSION);

if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'zip' || $ext == 'doc' || $ext == 'docx' || $ext == 'pdf') {
    if (move_uploaded_file($temp_name, $target_file)) {
        $contenthash = sha1_file($target_dir. "/" .$real_name);
        $firstdir = substr($contenthash, 0, 2);
        $scnddir = substr($contenthash, 2, 2);

        // Make dir
        if (!file_exists($filedir . $firstdir)) {
            mkdir($filedir.$firstdir, 0777, true);
        }

        if (!file_exists($filedir . $firstdir . '/'. $scnddir)) {
            mkdir($filedir . $firstdir. '/'. $scnddir, 0777, true);
        } 

        rename($target_file, $filedir.$firstdir.'/'.$scnddir.'/'.$contenthash);
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

} else {
    echo "Sorry, your file was not uploaded. file extension not allowed";  
}

?>