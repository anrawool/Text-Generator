<?php
session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Text Generator</title>
</head>
<body>
    <header>
        <div class="header">
            <h1>Text Generator</h1>
        </div>
    </header>
    <div class="generate">
        <form action="generator_main.php" method="post" class="genform">
            <textarea name="text-input" id="input-generate" cols="30" rows="10"><?php echo $_SESSION['final'];?></textarea>
            <button type="submit" id="genbtn">Generate</button>
            <a href="clear.php" id="clearbtn">Clear</a>
        </form>
        
    </div>
</body>
</html>