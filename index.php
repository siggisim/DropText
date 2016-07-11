<?
$config = array(
  'text'    => isset($_GET['text'])   ? $_GET['text']   : 'DropText',
  'video'   => isset($_GET['video'])  ? $_GET['video']  : 'A7MiR053DE8',
  'size'    => isset($_GET['size'])   ? $_GET['size']   : '200',
  'start'   => isset($_GET['start'])  ? $_GET['start']  : '55',
  'font'    => isset($_GET['font'])   ? $_GET['font']   : 'Roboto',
  'weight'  => isset($_GET['weight']) ? $_GET['weight'] : '900'
);
?>

<html>
  <head>
    <title>DropText</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="dropText.css" rel="stylesheet" type="text/css">
    <script src="dropText.js" type="text/javascript"></script>
    <style>
      #drop-text {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
      }
    </style>
  </head>
  <body>
    <div id="drop-text"></div>
    <script>
      dropText({
        id:     'drop-text',
        text:   '<?=$config['text']?>',
        video:  '<?=$config['video']?>',
        size:   '<?=$config['size']?>',
        start:  '<?=$config['start']?>',
        font:   '<?=$config['font']?>',
        weight: '<?=$config['weight']?>'
      });
    </script>
  </body>
</html>
