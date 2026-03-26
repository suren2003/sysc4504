<?php
// Suren Kulasegaram, 101220595
if (isset($_GET['reset'])) {
    header("Location: assignment3.php");            // on reset press we redirect back to assignment3.php without any url variables set from the form
    exit;
}

include 'includes/travel-config.inc.php';

try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT ContinentCode, ContinentName FROM Continents ORDER BY ContinentName";
    $result = $pdo->query($sql);

    // c.ISO is an shorthand for the Countries table, i is shorthand for ImageDetails table
    $sqlCountries = "
        SELECT c.ISO, c.CountryName
        FROM Countries c
        INNER JOIN ImageDetails i
            ON c.ISO = i.CountryCodeISO
        GROUP BY c.ISO, c.CountryName
        ORDER BY c.CountryName
    ";

    $resultCountries = $pdo->query($sqlCountries);

    $continent = $_GET['continent'] ?? '0';
    $country = $_GET['country'] ?? '0';
    $title = trim($_GET['title'] ?? '');

    $sqlImages = "
        SELECT ImageID, Title, Path
        FROM ImageDetails
    ";
    // Only use from one filter with priority order --> Continent, Country, Title
    if ($continent !== '0') {
        $sqlImages .= " WHERE ContinentCode = " . $pdo->quote($continent);
    }
    else if ($country !== '0') {
        $sqlImages .= " WHERE CountryCodeISO = " . $pdo->quote($country);
    }
    else if ($title !== '') {
        $sqlImages .= " WHERE Title LIKE " . $pdo->quote('%' . $title . '%');
    }

    $sqlImages .= " ORDER BY ImageID";

    $resultImages = $pdo->query($sqlImages);
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
    <header>
        <form action="assignment3.php" method="get" >
          <div class="form-inline">
          <select name="continent">
            <option value="0">Select Continent</option>
            <?php while ($row = $result->fetch()) { ?>                                              <!-- Fetch from query result until we go thru all of them -->
                <option value="<?php echo $row['ContinentCode']; ?>"
                    <?php if ($continent == $row['ContinentCode']) echo 'selected'; ?>>            <!-- Keep continent selected saved after submit -->
                    <?php echo $row['ContinentName']; ?>
                </option>
            <?php } ?>
          </select>
          
          <select name="country">
            <option value="0">Select Country</option>
            <?php while ($row = $resultCountries->fetch()) { ?>
                <option value="<?php echo $row['ISO']; ?>"
                    <?php if ($country == $row['ISO']) echo 'selected'; ?>>                         <!-- Keep country selection saved after submit -->
                    <?php echo $row['CountryName']; ?>
                </option>
            <?php } ?>
          </select>
          <input type="text" placeholder="Search title" name="title" value="<?php echo htmlspecialchars($title); ?>">       <!-- Keeps title saved after submitting -->
          <button type="submit" class="btn-primary">Filter</button>
          <button type="submit" name="reset" class="btn-secondary">Reset</button>             <!-- This button will tell us that we need to redirect to assignment3.php to clear any url variables -->
          </div>
        </form>
    </header>   
                                    
    <main>
      <ul>
          <?php while ($row = $resultImages->fetch()) { ?>
              <li>
                  <a href="detail.php?id=<?php echo $row['ImageID']; ?>">
                      <img src="images/square150/<?php echo $row['Path']; ?>" alt="<?php echo $row['Title']; ?>">         <!-- These photos are stored locally in images to make load time faster -->
                  </a>
              </li>
          <?php } ?>
      </ul>
    </main>

</body>

</html>