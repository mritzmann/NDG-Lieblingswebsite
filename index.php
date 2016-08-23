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

  // kuemmert sich darum, dass das Formular auch nach dem absenden anzeigt was eingegeben wurde.
  $placeholder = "www.blick.ch";
  if( empty($_POST) ) {
    // tut nix
  } else {
    // ueberschreibt placeholder
    $placeholder = $domain;
  }

  // speichert die aktuelle url (aus der Browser adressleiste) in eine Variable.
  $url = ((empty($_SERVER['HTTPS'])) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
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
      <input class="form-control" id="eingabe" name="eingabe" placeholder="<?php echo $placeholder ?>">
      </div>
      <button type="submit" class="btn btn-default"><i class="fa fa-paper-plane"></i> Website Testen</button>
    </form>

    <hr>

    <?php
    if( empty($ausgabe) ) {
      // tut nix
    } else {

      if ($ausgabe == 'Switzerland') {
          echo "<div class=\"panel panel-warning\"> <div class=\"panel-heading\"> <h3 class=\"panel-title\">Glückwunsch, du wirst nicht überwacht!</h3> </div> <div class=\"panel-body\">Die Webseite $domain wird in $ausgabe gehostet. Der Nachrichtendienst kann den Inhalt der Kommunikation nicht mitschneiden. Behalte jedoch immer im Hinterkopf: Dank dem Büpf hinterlässt Du dennoch Metadaten. Der Nachrichtendienst kann auf diese zugreifen.</div> </div>";
      } else {
          echo "<div class=\"panel panel-danger\"> <div class=\"panel-heading\"> <h3 class=\"panel-title\">Du wirst überwacht!</h3> </div> <div class=\"panel-body\">Die Webseite $domain wird in $ausgabe gehostet. Beim Aufrufen von $domain findet grenzüberschreitende Kommunikation statt. Dabei wirst Du überwacht!</div> </div> <div class=\"panel panel-default\"> <div class=\"panel-heading\"> <h3 class=\"panel-title\">Teile Dein Ergebnis</h3> </div> <div class=\"panel-body\">Teile Dein Ergebnis! Du hilfst damit, andere auf diesen Missstand aufmerksam zu machen.<hr><a type=\"button\" href=\"https://twitter.com/intent/tweet?url=$url&text=Meine%20Lieblingswebsite%20wird%20%C3%BCberwacht.%20Und%20deine%3F%20Finde%20es%20heraus%3A&original_referer=&via=ueberwacht_ch&hashtags=NDGNein%2C\" class=\"btn btn-default\"><i class=\"fa fa-twitter\"></i> Twitter</a> <a type=\"button\" href=\"https://www.facebook.com/sharer/sharer.php?u=$url\" class=\"btn btn-default\"><i class=\"fa fa-facebook\"></i> Facebook</a> <a type=\"button\" class=\"btn btn-default\"><i class=\"fa fa-envelope\"></i> E-Mail</a></div> </div>";
      }
    }
    ?>

  </div>

  <footer class="footer">
    <div class="container">
      <p class="text-muted"><a href="https://github.com/mritzmann/NDG-traffic-surveillance"><i class="fa fa-github" aria-hidden="true"></i> GitHub</a> | Ein Projekt von <a href="https://twitter.com/RitzmannMarkus">@RitzmannMarkus</a>, inspiriert von <a href="https://twitter.com/schulerswiss/status/767699766763462656">@schulerswiss</a></p>
    </div>
  </footer>

  <!-- jQuery -->
  <script src="js/jquery.js"></script>

  <!-- Bootstrap JS -->
  <script src="js/bootstrap.js"></script>
</body>
</html>
