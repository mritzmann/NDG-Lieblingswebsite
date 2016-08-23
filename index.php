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

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@ueberwacht_ch" />
  <meta name="twitter:title" content="Wirst Du überwacht?" />
  <meta name="twitter:description" content="Wirst du beim Besuch deiner Lieblingswebsite überwacht? Hiermit findest du es heraus." />
  <meta name="twitter:image" content="https://ueberwacht.ch/img/twitter_image.jpg" />

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
    <p>Am 25. September 2016 dürfen wir über das neue Nachrichtendienst (kurz NDG) abstimmen. Mit dem neuen Gesetzt wird die sogenannte Kabelaufklärung eingeführt.</p>
    <p><b>Die Kabelaufklärung ermöglicht dem Nachrichtendienst, grenzüberschreitende Kommunikation zu überwachen.</b> Es reicht, wenn ein Teilnehmer der Verbindung (also meistens der Server) im Ausland steht und das ist fast immer der Fall. <b>Die meisten (vielleicht sogar alle) Deiner Lieblingswebsites werden im Ausland gehostet.</b> Nachfolgend kannst Du prüfen, ob das stimmt.</p>

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
      echo "<div class=\"panel panel-default\"> <div class=\"panel-heading\"> <h3 class=\"panel-title\">Technische Umsetzung</h3> </div> <div class=\"panel-body\">Diese Webseite prüft anhand einer Geo-IP API in welchem Land die zu prüfende Webseite steht. Das Resultat wird Dir direkt mitgeteilt.</div> </div>";
    } else {

      if ($ausgabe == 'Switzerland') {
          echo "<div class=\"panel panel-warning\"> <div class=\"panel-heading\"> <h3 class=\"panel-title\">Glückwunsch, du wirst vielleicht nicht überwacht!</h3> </div> <div class=\"panel-body\">Die Webseite $domain wird in $ausgabe gehostet. Es besteht die möglichkeit, dass der Nachrichtendienst den Inhalt der Kommunikation nicht mitschneiden darf.</br></br>Behalte jedoch immer im Hinterkopf: Dank dem Büpf hinterlässt Du dennoch Metadaten. Der Nachrichtendienst kann auf diese zugreifen. Zudem besteht die Möglichkeit, dass die Route ins Ausland und anschliessend wieder zurück in die Schweiz führt.</div> </div>";
      } else {
          echo "<div class=\"panel panel-danger\"> <div class=\"panel-heading\"> <h3 class=\"panel-title\">Du wirst überwacht!</h3> </div> <div class=\"panel-body\">Die Webseite $domain wird in $ausgabe gehostet. Beim Aufrufen von $domain findet grenzüberschreitende Kommunikation statt. Dabei wirst Du überwacht!</br></br>Weitere Informationen:</br><ul><li><a href=\"https://www.nachrichtendienstgesetz.ch/\" target=\"_blank\">5 Gründe gegen den Ausbau der Überwachung</a></li><li><a href=\"http://schnueffelstaat.ch/\" target=\"_blank\">Referendumskomitee: NEIN zum Schnüffelstaat</a></li><li><a href=\"https://www.nachrichtendienstgesetz.com/\" target=\"_blank\">Abhörsystem Codename ISCO</a></li></ul></div> </div> <div class=\"panel panel-default\"> <div class=\"panel-heading\"> <h3 class=\"panel-title\">Teile Dein Ergebnis</h3> </div> <div class=\"panel-body\">Teile Dein Ergebnis! Du hilfst damit, andere auf diesen Missstand aufmerksam zu machen.<hr><a type=\"button\" href=\"https://twitter.com/intent/tweet?url=$url&text=Meine%20Lieblingswebsite%20wird%20%C3%BCberwacht.%20Und%20deine%3F%20Finde%20es%20heraus%3A&original_referer=&via=ueberwacht_ch&hashtags=NDGNein%2C\" class=\"btn btn-default\"><i class=\"fa fa-twitter\"></i> Twitter</a> <a type=\"button\" href=\"https://www.facebook.com/sharer/sharer.php?u=$url\" class=\"btn btn-default\"><i class=\"fa fa-facebook\"></i> Facebook</a> <a type=\"button\" href=\"mailto:?&subject=Prüfe ob Du beim Besuch Deiner Lieblingswebsite überwacht wirst&body=Die%20sogenannte%20Kabelaufkl%C3%A4rung%20erm%C3%B6glicht%20es%2C%20dem%20Nachrichtendienst%20grenz%C3%BCberschreitende%20Kommunikation%20zu%20%C3%BCberwachen.%20Die%20Bef%C3%BCrworter%20behaupten%2C%20dass%20Schweizer%20somit%20nicht%20von%20der%20Massen%C3%BCberwachung%20betroffen%20seien.%20Doch%20das%20stimmt%20nicht%20ganz%3A%20Die%20meisten%20(vielleicht%20sogar%20alle)%20Deiner%20Lieblingswebsites%20werden%20im%20Ausland%20gehostet.%20Nachfolgend%20kannst%20Du%20pr%C3%BCfen%2C%20ob%20das%20stimmt.%0A%0A$url\" class=\"btn btn-default\"><i class=\"fa fa-envelope\"></i> E-Mail</a></div> </div>";
      }
    }
    ?>

  </div>

  <footer class="footer">
    <div class="container">
      <p class="text-muted"><a href="https://github.com/mritzmann/NDG-Lieblingswebsite"><i class="fa fa-github" aria-hidden="true"></i> GitHub</a> | Ein Projekt von <a href="https://twitter.com/RitzmannMarkus">@RitzmannMarkus</a>, inspiriert von <a href="https://twitter.com/schulerswiss/status/767699766763462656">@schulerswiss</a></p>
    </div>
  </footer>

  <!-- jQuery -->
  <script src="js/jquery.js"></script>

  <!-- Bootstrap JS -->
  <script src="js/bootstrap.js"></script>


  <!-- Piwik Tracking
  Die letzen Bytes der IP-Adresse wird vor dem Speichern entfernt / Anonymisiert
  -->
  <script type="text/javascript">
    var _paq = _paq || [];
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
      var u="//stat.ueberwacht.ch/";
      _paq.push(['setTrackerUrl', u+'piwik.php']);
      _paq.push(['setSiteId', '1']);
      var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
      g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
  </script>
  <noscript><p><img src="//stat.ueberwacht.ch/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
  <!-- End Piwik Code -->
</body>
</html>
