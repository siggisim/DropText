<?
  // Example:
  // http://si.gg/test.php?text=Snapchat&video=jeQ0alGlsPg&font=Roboto&size=250
  $defaults = array(
    'text'    => 'DropText',
    'video'   => 'A7MiR053DE8',
    'size'    => '200',
    'start'   => '55',
    'font'    => 'Roboto'
  );
  
  $text     = $_GET['text'] ? $_GET['text'] : $defaults['text'];
  $video    = $_GET['video'] ? $_GET['video'] : $defaults['video'];
  $size     = $_GET['size'] ? $_GET['size'] : $defaults['size'];
  $start    = $_GET['start'] ? $_GET['start'] : $defaults['start'];
  $font_url = $_GET['font'] ? $_GET['font'] : $defaults['font'];
  $font     = str_replace('+', ' ', $font_url);
?>

<html>
  <head>
    <title><?=$text?></title>
    <style>
       body {
         align-items: center;
         display: flex;
         padding: 0;
         justify-content: center;
      	-webkit-font-smoothing: antialiased;
       }
       
       iframe {
         pointer-events: none;
         position: absolute;
         top: 0;
         left: 0;
       }
       
       .overlay {
         margin-left: -8px;
         margin-top: -85px;
         mix-blend-mode: screen;
         text-align: center;
       }
       
       .overlay:before {
         background-color: #fff;
         bottom: 0;
         content: '';
         display: block;
         left: 0;
         position: absolute;
         right: 0;
         top: 0;
         z-index: -1;
       }
       
       .thumbnail {
         left: 0;
         position: absolute;
         top: 0;
         width: 100%;
         height: 100%;
 -webkit-filter: blur(20px);
         filter: blur(20px);
         opacity: 1;
       }
       
       .hidden {
          transition: opacity 1s ease-in-out;
          opacity: 0;
       }
       
       .title {
         color: #000;
         font-family: '<?=$font?>', sans-serif;
         font-size: <?=$size?>;
         font-weight: 900;
         line-height: .9em;
         
       }
       
       .title::selection {
         background: #888;
       }
       
    </style>
    <script src="https://www.youtube.com/iframe_api"></script>
    <link href='https://fonts.googleapis.com/css?family=<?=$font_url?>:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
    <script>
      var thumbnailId = 'thumbnail';
    
      function onYouTubeIframeAPIReady() {
        new YT.Player('video', {
          height: '100%',
          width: '100%',
          videoId: '<?=$video?>',
          playerVars: {
            loop: 1, 
            controls: 0, 
            autoplay: 1, 
            start: <?=$start?>,
            suggestedQuality: 'highres',
          },
          events: {
            onReady: onPlayerReady,
            onStateChange: onPlayerStateChange
          }
        });
      }
    
      function onPlayerReady(event) {
        event.target.playVideo();
        event.target.mute();
      }
      
      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && document.getElementById(thumbnailId)) {
          document.getElementById(thumbnailId).classList.add('hidden');
        }
        if (event.data == YT.PlayerState.ENDED) {
          event.target.seekTo(<?=$start?>);
        }
      }
    </script>
  </head>
  <body>
    <div id="video"></div>
    <img id="thumbnail" src="http://img.youtube.com/vi/<?=$video?>/hqdefault.jpg" class="thumbnail" />
    <div class="overlay">
      <div class="title"><?=$text?></div>
    </div>
  </body>
</html>
