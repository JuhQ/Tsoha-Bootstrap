$(document).ready(function(){
  console.log(
    '%cih%can%caa',
    'background: green; color: white; padding: 3px; font-family: monospace; font-size: 20px;',
    'background: yellow; color: black; padding: 3px; font-family: monospace; font-size: 20px;',
    'background: red; color: white; padding: 3px; font-family: monospace; font-size: 20px;'
    );
});


/*!
 * Emoji Cursor.js
 * - 90's cursors collection
 * -- https://github.com/tholman/90s-cursor-effects
 * -- https://codepen.io/tholman/full/rxJpdQ
 */

$(document).ready(function(){
  var emoji = document.getElementById('emoji');
  var $emoji = $(emoji);
  $('.askare')
    .on('mouseenter', function() {
      $emoji.addClass('active')
    })
    .on('mouseleave', function() {
      $emoji.removeClass('active')
    });

  (function emojiCursor() {
    var possibleEmoji = '🌈';
    var width = window.innerWidth;
    var height = window.innerHeight;
    var cursor = {x: width/2, y: width/2};
    var particles = [];

    function init() {
      bindEvents();
      loop();
    }

    // Bind events that are needed
    function bindEvents() {
      document.addEventListener('mousemove', onMouseMove);
      window.addEventListener('resize', onWindowResize);
    }

    function onWindowResize(e) {
      width = window.innerWidth;
      height = window.innerHeight;
    }

    function onMouseMove(e) {
      cursor.x = e.pageX;
      cursor.y = e.pageY;

      if ($emoji.hasClass('active')) {
        addParticle(cursor.x, cursor.y, possibleEmoji);

        emoji.style.top = (cursor.y + 5) + 'px';
        emoji.style.left = (cursor.x + 5) + 'px';
      }
    }

    function addParticle(x, y, character) {
      var particle = new Particle();
      particle.init(x, y, character);
      particles.push(particle);
    }

    function updateParticles() {
      // Updated
      for( var i = 0; i < particles.length; i++ ) {
        particles[i].update();
      }

      // Remove dead particles
      for( var i = particles.length -1; i >= 0; i-- ) {
        if( particles[i].lifeSpan < 0 ) {
          particles[i].die();
          particles.splice(i, 1);
        }
      }

    }

    function loop() {
      requestAnimationFrame(loop);
      updateParticles();
    }

    /**
     * Particles
     */

    function Particle() {

      this.lifeSpan = 120; //ms
      this.initialStyles ={
        'position': 'absolute',
        'display': 'block',
        'pointerEvents': 'none',
        'z-index': '10000000',
        'fontSize': '16px',
        'will-change': 'transform'
      };

      // Init, and set properties
      this.init = function(x, y, character) {

        this.velocity = {
          x:  (Math.random() < 0.5 ? -1 : 1) * (Math.random() / 2),
          y: 1
        };

        this.position = {x: x - 10, y: y - 20};

        this.element = document.createElement('span');
        this.element.innerHTML = character;
        applyProperties(this.element, this.initialStyles);
        this.update();

        document.body.appendChild(this.element);
      };

      this.update = function() {
        this.position.x += this.velocity.x;
        this.position.y += this.velocity.y;
        this.lifeSpan--;

        this.element.style.transform = 'scale(' + (this.lifeSpan / 120) + ')';
        this.element.style.top = this.position.y + 'px';
        this.element.style.left = this.position.x + 'px';
      }

      this.die = function() {
        this.element.parentNode.removeChild(this.element);
      }

    }

    /**
     * Utils
     */

    // Applies css `properties` to an element.
    function applyProperties( target, properties ) {
      for( var key in properties ) {
        target.style[ key ] = properties[ key ];
      }
    }

    init();
  })();

});
