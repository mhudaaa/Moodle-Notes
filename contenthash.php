<?php
// sha1 encrypt

$file = '/5/user/draft/654732188/aaa.zip';
$contenthash = sha1($file);

echo $file . "<br>";
echo $contenthash;