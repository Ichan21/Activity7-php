<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Result</title>
</head>
<body>
<?php
     $fullname = (isset($_GET['name'])) ? $_GET['name']:"";
     $sampleage = (isset($_GET['age'])) ? $_GET['age']:"";
     $sex = (isset($_GET['gender'])) ? $_GET['gender']:"";
    
     $result ="";
     $result=($sampleage >= 19 )?"ADULT": "MINOR";

    ?>
<h2>Name:<?php echo $fullname;?></h2>
    <h2>Age:<?php echo $sapleage;?></h2>
    <h2>gender:<?php echo $sex;?></h2>
    <h2>Result:<?php echo $result;?></h2>
</body>
</html>