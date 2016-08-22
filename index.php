<?php
  // Nimmt eingabe entgegen und speichert in eine variable.
  $domain = $_POST["eingabe"];

  // workaround damit api abfrage nur dann gemacht wird, wenn formular abgesendet wurde.
  if( empty($_POST) ) {
    // tut nix
  } else {
    // Taetigt API abfrage und speichert resultat in eine variable.
    // Die API ermoeglicht 150 anfragen pro Minute.
    $json = file_get_contents('http://ip-api.com/json/'.$domain.'?fields=country');
  }

  // keine ahnung was da genau passiert...
  // Aus dem PHP Manual kopiert.
  $obj = json_decode($json);
  $ausgabe = $obj->country;
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Prüfe, ob Du beim Besuch Deiner Lieblingswebsite überwacht wirst</title>
  <meta name="description" content="Finde heraus ob du beim besuchen deiner lieblings Webseiten überwacht wirst.">

  <!-- CSS-->
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/footer.css" rel="stylesheet">
  <link href="css/font-awesome.css" rel="stylesheet">
</head>
<body>

  <div class="container">
    <div class="page-header">
      <h1>Prüfe, ob Du beim Besuch Deiner Lieblingswebsite überwacht wirst</h1>
    </div>
    <p>Die sogenannte Kabelaufklärung ermöglicht es, dem Nachrichtendienst grenzüberschreitende Kommunikation zu überwachen. Die Befürworter behaupten, dass Schweizer somit nicht von der Massenüberwachung betroffen seien. <a href="https://www.nachrichtendienstgesetz.com/">Doch das stimmt nicht ganz</a>: Die meisten (vielleicht sogar alle) Deiner Lieblingswebsites werden im Ausland gehostet. Nachfolgend kannst Du prüfen, ob das stimmt.</p>

    <hr>

    <form class="form-inline" action="index.php" method="post">
      <div class="form-group">
      <input class="form-control" id="eingabe" name="eingabe" placeholder="www.blick.ch">
      </div>
      <button type="submit" class="btn btn-default">Testen</button>
    </form>

    <hr>

    <?php
    if ($ausgabe == 'Switzerland') {
        echo "<div class=\"panel panel-warning\"> <div class=\"panel-heading\"> <h3 class=\"panel-title\">Glückwunsch, du wirst nicht überwacht!</h3> </div> <div class=\"panel-body\">Naja, zumindest nicht ganz. Die Webseite $domain wird in $ausgabe gehostet. Der Nachrichtendienst kann den Inhalt der Kommunikation nicht mitschneiden. Du hinterlässt jedoch Büpf sei dank diverse Metadaten.</div> </div>";
    } else {
        echo "<div class=\"panel panel-danger\"> <div class=\"panel-heading\"> <h3 class=\"panel-title\">Du wirst überwacht!</h3> </div> <div class=\"panel-body\">Die Webseite $domain wird in $ausgabe gehostet. Beim aufrufen von $domain findet Grenzüberschreitende Kommunikation statt. Dabei wirst du überwacht!</div> </div>";
    }
    ?>

  </div>

  <footer class="footer">
    <div class="container">
      <p class="text-muted"><a href="https://github.com/mritzmann/NDG-traffic-surveillance"><i class="fa fa-github" aria-hidden="true"></i> GitHub</a></p>
    </div>
  </footer>

  <!-- jQuery -->
  <script src="js/jquery.js"></script>

  <!-- Bootstrap JS -->
  <script src="js/bootstrap.js"></script>
</body>
</html>
