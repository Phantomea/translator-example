<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Translator example</title>
</head>

<body>
<?php
require __DIR__ . '/vendor/autoload.php';

$translator = new \App\Translator();

if (isset($_GET['language'])) {
    $translator->setLang($_GET['language']);
}

?>

<h1>Not Translated - Heading example</h1>
<p>Translation example: <?php echo $translator->translate('homepage.perex', 'This is homepage perex');  ?></p>

<h2>Change language</h2>
<form method="get" action="index.php">
    <select name="language" id="langs">
		<?php foreach ($translator->getLangs() as $lg) { echo "<option value='".$lg."' >".$lg."</option>"; } ?>
    </select>
    <br>
    <input type="submit" value="Change language">
</form>

</body>
</html>