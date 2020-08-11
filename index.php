
<!DOCTYPE html>
<html>
    <head>
       <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    </head>
    <body>
        <div id="container">
            <!-- zone de connexion -->
            <form method="post" enctype="multipart/form-data">
            <h1>Authentication</h1>
                <p>
                <div>    
                <label><b>Choisir une image</b></label></div>
                <div>
                <input type="file" name="fileToUpload" id="fileToUpload"></div>
                <input type="submit" value="Connexion" name="submit"></div>
                </p>
</form>

</body>

</html>

<?php
//Use Recognition Client
require 'vendor/autoload.php';
use Aws\Rekognition\RekognitionClient;

//Get Rekognition Access
$rekognitionClient = RekognitionClient::factory(array(
    		'region'	=> "us-east-1",
    		'version'	=> 'latest'
));

//Calling Compare Face function
if( isset($_POST['submit']) ){
$compareFaceResults= $rekognitionClient->compareFaces([
        'SimilarityThreshold' => 70,
        'SourceImage' => [
            'Bytes' => file_get_contents("im.jpg")
        ],
        'TargetImage' => [
            'Bytes' => file_get_contents($_FILES['fileToUpload']['tmp_name'])
        ],
]);
if (count($compareFaceResults['FaceMatches']) == 0) {
    
    echo' authentification Echec';
  }
  else {
    header('Location: principal.php');
  exit();
    //$similarity = $compareFaceResults['FaceMatches'][0]['Similarity'];
    //$markup = 'authentification reuisit avec succes.  image authentification est  ' . $similarity . '% similaire to the Profile picture';
    
//echo"$markup";
  }
}
?>