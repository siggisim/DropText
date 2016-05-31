<?
  // Example:
  // http://si.gg/droptext/?text=DropText&video=A7MiR053DE8&size=200&start=55&font=Roboto
  
  // Default values
  $defaults = array(
    'text'    => 'DropText',
    'video'   => 'A7MiR053DE8',
    'size'    => '200',
    'start'   => '55',
    'font'    => 'Roboto'
  );
  
  // Initialize variables with query parameters or defaults
  $text     = $_GET['text']  ? $_GET['text']  : $defaults['text'];
  $video    = $_GET['video'] ? $_GET['video'] : $defaults['video'];
  $size     = $_GET['size']  ? $_GET['size']  : $defaults['size'];
  $start    = $_GET['start'] ? $_GET['start'] : $defaults['start'];
  $font_url = $_GET['font']  ? $_GET['font']  : $defaults['font'];
  $font     = str_replace('+', ' ', $font_url);
?>

<html>
  <head>
    <title><?=$text?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
      body {
        font-family: '<?=$font?>', sans-serif;
        font-size: <?=$size?>px;
        font-weight: 900;
        height: 100%;
        margin: 0;
        overflow: hidden;
        padding: 0;
        width: 100%;
      	-webkit-font-smoothing: antialiased;
      }
       
      .video {
        height: 100%;
        left: 0;
        pointer-events: none;
        position: absolute;
        top: 0;
        width: 100%;
      }
       
      .thumbnail {
        height: 100%;
        left: 0;
        opacity: 1;
        position: absolute;
        top: 0;
        width: 100%;
        -webkit-filter: blur(20px);
                filter: blur(20px);
      }
       
      .overlay {
        align-items: center;
        background-color: #fff;
        color: #000;
        display: flex;
        height: 100%;
        justify-content: center;
        left: 0;
        line-height: .9em;
        mix-blend-mode: screen;
        position: absolute;
        text-align: center;
        top: 0;
        width: 100%;
      }
       
      .overlay::selection {
        background: #888;
      }
       
      .hidden {
        opacity: 0;
        transition: opacity 1s ease-in-out;
      }
      
      /* Maintain aspect ratio of video to avoid black bars */
      @media screen and (min-aspect-ratio: 16/9) {
        .video {
          min-height: 56vw;
          margin-top: calc(50vh - 28vw);
        }
      }
      @media screen and (max-aspect-ratio: 16/9) {
        .video {
          min-width: 178vh;
          margin-left: calc(50vw - 89vh);
        }
      }

      /* Resize text based on screen size */
      @media screen and (max-width: 900px) {
        .overlay { font-size: .8em; }
      }
      @media screen and (max-width: 750px) {
        .overlay { font-size: .6em; }
      }
      @media screen and (max-width: 550px) {
        .overlay { font-size: .4em; }
      }
      @media screen and (max-width: 350px) {
        .overlay { font-size: .3em; }
      }
       
    </style>
    <script src="https://www.youtube.com/iframe_api"></script>
    <link href='https://fonts.googleapis.com/css?family=<?=$font_url?>:900' rel='stylesheet' type='text/css'>
    <script>
      var videoId = '<?=$video?>';
      var start = <?=$start?>;
      var thumbnailId = 'thumbnail';
      var hiddenClass = 'hidden';
    
      function onYouTubeIframeAPIReady() {
        // Don't play youtube video on platforms that don't support blend mode
        if(!('CSS' in window && 'supports' in window.CSS && 
            window.CSS.supports('mix-blend-mode','screen'))) return;

        new YT.Player('video', {
          videoId: videoId,
          playerVars: {
            loop: 1, 
            controls: 0, 
            autoplay: 1, 
            start: start,
            suggestedQuality: 'highres',
            showinfo: 0,
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
        var thumbnail = document.getElementById(thumbnailId);
        
        // Hide thumbnail when video begins playing
        if (event.data == YT.PlayerState.PLAYING && thumbnail) {
          thumbnail.classList.add(hiddenClass);
        }
        
        // Start the video over when it ends
        if (event.data == YT.PlayerState.ENDED) {
          event.target.seekTo(start);
        }
      }
    </script>
  </head>
  <body>
    <div id="video" class="video"></div>
    <img id="thumbnail" class="thumbnail" src="http://img.youtube.com/vi/<?=$video?>/hqdefault.jpg" />
    <div class="overlay"><?=$text?></div>
  </body>
</html>