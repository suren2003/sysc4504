<?php

include 'includes/travel-config.inc.php';

try {
   $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
      die("Invalid image id");
   }

   $id = (int) $_GET['id'];

   $sql = "
      SELECT 
         i.ImageID,
         i.Title,
         i.Description,
         i.Path,
         i.Exif,
         i.Colors,
         i.ActualCreator,
         i.CreatorURL,
         c.AsciiName AS CityName,
         co.CountryName
      FROM ImageDetails i
      LEFT JOIN Cities c
         ON i.CityCode = c.CityCode
      INNER JOIN Countries co
         ON i.CountryCodeISO = co.ISO
      WHERE i.ImageID = $id
   ";

   $result = $pdo->query($sql);
   $image = $result->fetch(PDO::FETCH_ASSOC);

   if (!$image) {
      die("Image not found");
   }

   $baseDetailUrl = "images/medium640/";

   // some images did not have camera details, so taking a precaution to not get a null error on them and gracefully say no data for that
   $exifData = json_decode($image['Exif'], true);
   if (!is_array($exifData)) {
      $exifData = [];
   }

   // I did not see any image without color data but just in case we will gracefully cover any missing data here too
   $colorData = json_decode($image['Colors'], true);
   if (!is_array($colorData)) {
      $colorData = [];
   }

   $cameraModel = $exifData['model'] ?? '';
   $isoValue = $exifData['iso'] ?? '';
   $apertureValue = $exifData['aperture'] ?? '';
   $exposureValue = $exifData['exposure_time'] ?? '';
   $focalLengthValue = $exifData['focal_length'] ?? '';
}
catch (PDOException $e) {
   die($e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Assignment 3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
   
    <link rel="stylesheet" href="css/styles.css" />

</head>

<body>                                    
   <main class="detail">
      <div>
         <img src="<?php echo $baseDetailUrl . $image['Path']; ?>" alt="<?php echo htmlspecialchars($image['Title']); ?>">
      </div>
      <div>
         <h1><?php echo htmlspecialchars($image['Title']); ?></h1>
         <h3><?php echo htmlspecialchars($image['CityName']); ?>, <?php echo htmlspecialchars($image['CountryName']); ?></h3>
         <p><?php echo htmlspecialchars($image['Description']); ?></p>

         <div class="box">
            <h3>Creator</h3>
            <a href="<?php echo htmlspecialchars($image['CreatorURL']); ?>" target="_blank">
               <?php echo htmlspecialchars($image['ActualCreator']); ?>
            </a>
         </div>
         
         <div class="box">
            <h3>Camera</h3>

            <?php if ($cameraModel !== '') { ?>
               <p><?php echo htmlspecialchars($cameraModel); ?></p>
               <p>
                     ISO <?php echo htmlspecialchars($isoValue); ?> |
                     f<?php echo htmlspecialchars($apertureValue); ?> |
                     <?php echo htmlspecialchars($exposureValue); ?> sec
               </p>
            <?php } else { ?>
               <p>No camera data available.</p>             <!-- Gracefully cover no camera details here -->
            <?php } ?>
         </div>

         <div class="box">
            <h3>Colors</h3>
            <?php if (!empty($colorData)) { ?>
               <div class="colorBoxes">
                     <?php foreach ($colorData as $color) { ?>
                        <span style="background-color: <?php echo htmlspecialchars($color); ?>;"></span>
                     <?php } ?>
               </div>
            <?php } else { ?>
               <p>No color data available.</p>          <!-- Gracefully cover no colours here as well -->
            <?php } ?>
         </div>
      </div>
   </main>
</body>

</html>