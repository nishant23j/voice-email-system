<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Voice Recoginition Email System</title>
    <link rel="icon" 
  type="image/jpg" 
  href="img/star.jpg">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
<?php
ini_set('display_errors', 1);

$senderEmail = filterInput($_POST['email']);
$recipientEmail = filterInput($_POST['remail']); 
$message = filterInput($_POST['message']);
$subject = filterInput($_POST['subject']);


echo $senderEmail. " has sent mail with subject ". $subject;
if(sendEmailWithAttachments($recipientEmail,$senderEmail,$subject,$message))
{  if($senderEmail)
    echo "<h3 class= \"section-heading\"> Email sent successfully!</h3> ";
   else if(!$senderEmail)
{
    echo "<h3 class= \"section-heading\"> Failed to send the email...!!!</h3> <h4 class= \"section-heading\"> For more Details contact : $recipientEmail</h4>";;
}
 
}
else
{
    echo "<h3 class= \"section-heading\"> Failed to send the email...!!!</h3> <h4 class= \"section-heading\"> For more Details contact : $recipientEmail</h4>";
}
 
function filterInput($data)
{
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
}
function sendEmailWithAttachments($recipientEmail,$senderEmail,$subject,$message){
 
     
    if(isset($_FILES)) {
echo " with attachment added !!";
        $allowedExtensions = array("pdf","doc","docx","gif","jpeg","jpg","JPG","png","PNG","rtf","txt","xml");
 
        $files = array();
        foreach($_FILES as $name=>$file) {
            //die("file size: ".$file['size']);
            if($file['size']>=5242880)//5mb
            {
                $fileSize=$file['size'];
                return false;
            }
            $file_name = $file['name']; 
            $temp_name = $file['tmp_name'];
            $file_type = $file['type'];
            $path_parts = pathinfo($file_name);
            $ext = $path_parts['extension'];
            if(!in_array($ext,$allowedExtensions)) {
                return false;
                die("File $file_name has the extensions $ext which is not allowed");
            }
 
            //move the file to the server, cannot be skipped
            $server_file="/tmp/$path_parts[basename]";
            move_uploaded_file($temp_name,$server_file);
            array_push($files,$server_file);
            //array_push($files,$temp_name);
        }
 
        // email fields
        $headers = "From: $senderEmail";
 
 
        // boundary 
        $semi_rand = md5(time()); 
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
 
        // headers for attachment 
        $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
 
        // multipart boundary 
        $message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
        $message .= "--{$mime_boundary}\n";
 
        // preparing attachments
        for($x=0;$x<count($files);$x++){
            $file = fopen($files[$x],"rb");
            $data = fread($file,filesize($files[$x]));
            fclose($file);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$files[$x]\"\n" . 
            "Content-Disposition: attachment;\n" . " filename=\"$files[$x]\"\n" . 
            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            $message .= "--{$mime_boundary}\n";
        }
 
        // send
        return @mail($recipientEmail, $subject, $message, $headers);
 
    }
}   
?>
<script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>