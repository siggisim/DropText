function dropText(config) {
  var defaults = {
    id:     'drop-text',
    video:  'A7MiR053DE8',
    start:  '0',
    text:   null,
    size:   null,
    font:   null,
    weight: null,
    
    // Options
    resizeTextBasedOnScreenWidth: false,
    maintainFullScreenVideoAspectRatio: false
  };
  
  config = Object.assign(defaults, config);
  
  var hiddenClass = 'droptext-hidden';
  var videoClass = 'droptext-video';
  var thumbnailClass = 'droptext-thumbnail';
  var overlayClass = 'droptext-overlay';
  var aspectRatioClass ='droptext-aspect-ratio';
  var resizeClass ='droptext-resize';
  
  var fontId = 'droptext-font'; 
  var youtubeId = 'droptext-youtube'; 

  var video;
  var thumbnail;
  var overlay;

  var root = document.getElementById(config.id);
  var rootContents = root.innerHTML;
  root.innerHTML = '';
  if (config.resizeTextBasedOnScreenWidth) root.classList.add(resizeClass);
  if (config.maintainFullScreenVideoAspectRatio) root.classList.add(aspectRatioClass);
  
  // Create video
  video = document.createElement('div');
  video.className = videoClass;
  root.appendChild(video);

  // Create thumbnail
  thumbnail = document.createElement('img');
  thumbnail.className = thumbnailClass;
  thumbnail.src = 'http://img.youtube.com/vi/' + config.video + '/hqdefault.jpg';
  root.appendChild(thumbnail);

  // Create overlay
  overlay = document.createElement('div');
  overlay.className = overlayClass;
  if (config.font) overlay.style.fontFamily = config.font + ', sans-serif';
  if (config.size) overlay.style.fontSize = config.size;
  if (config.weight) overlay.style.fontWeight = config.weight;
  if (config.text) {
    overlay.innerHTML = config.text;
  } else {
    overlay.innerHTML = rootContents;
  }
  root.appendChild(overlay);

  // Font configuration
  if (config.font && !document.getElementById(fontId + "-" + config.font.replace(" ", "-"))) {
    var fontLink = document.createElement('link');
    fontLink.id = fontId;
    if (config.font) fontLink.href = 'https://fonts.googleapis.com/css?family=' + config.font.replace(" ", "+") + ':' + config.weight || 300;
    fontLink.rel = 'stylesheet';
    fontLink.type = 'text/css';
    document.head.appendChild(fontLink);
  }
  
  // Load youtube script
  if (!document.getElementById(youtubeId)) {
    var youtube = document.createElement('script');
    youtube.id = youtubeId;
    youtube.src = 'https://www.youtube.com/iframe_api';
    document.head.appendChild(youtube);
  }
  
  var oldYoutubeReady = window.onYouTubeIframeAPIReady;
  window.onYouTubeIframeAPIReady = function onYouTubeIframeAPIReady() {
    // If there is already a ready function registered, call it
    if (oldYoutubeReady) {
      oldYoutubeReady();
    }
    
    // Don't play youtube video on platforms that don't support blend mode
    if(!('CSS' in window && 'supports' in window.CSS && 
        window.CSS.supports('mix-blend-mode','screen'))) return;

    // Create youtube player
    new YT.Player(video, {
      videoId: config.video,
      playerVars: {
        loop: 1, 
        controls: 0, 
        autoplay: 1, 
        start: config.start,
        suggestedQuality: 'highres',
        showinfo: 0,
      },
      events: {
        onReady: function onPlayerReady(event) {
          event.target.playVideo();
          event.target.mute();
        },
        onStateChange: function onPlayerStateChange(event) {
          // Hide thumbnail when video begins playing
          if (event.data == YT.PlayerState.PLAYING && thumbnail) {
            thumbnail.classList.add(hiddenClass);
          }
          
          // Start the video over when it ends
          if (event.data == YT.PlayerState.ENDED) {
            event.target.seekTo(config.start);
          }
        }
      }
    });   
  }
}