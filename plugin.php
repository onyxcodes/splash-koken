<?php

class Splash extends KokenPlugin {

  function __construct()
  {
    // $this->require_setup = true;

    // Register our class's add_widget function with the before_closing_head hook.
    $this->register_hook('after_opening_head', 'addStyle');
    // $this->register_hook('after_opening_body', 'hideSplash');

    // Register our class's remove_widget function with the before_closing_body hook.
    // It would be more correct to call the function at the beginning of the body but
    // because of an issue with koken, the hook 'after_opening_body' doesn't work.
    $this->register_hook('before_closing_body', 'showSplash');
  }

  function addStyle()
  {
      echo "<style>
      /* 
  Based on this article from Divya Manian - 
  http://nimbupani.com/using-background-clip-for-text-with-css-fallback.html
*/

* {
    margin: 0;
    padding: 0;
}

*,
:before,
:after {
    -webkit-box-sizing: border-box;
       -moz-box-sizing: border-box;
            box-sizing: border-box;
}

html,
body {
    min-height: 100%;
}

body {
    font-family: 'Oswald', sans-serif;
    color: #fff;
    background-color: #000;
}

.splash {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    background: black;
    z-index: 200;
}

.wrapper {
    /*Centering tecnique from https://css-tricks.com/quick-css-trick-how-to-center-an-object-exactly-in-the-center*/
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

/* Clip text element */
.clip-text {
    font-size: 12vh;
    font-weight: bold;
    line-height: 1;
    position: relative;
    display: inline-block;
    margin: .25em;
    padding: .5em .75em;
    text-align: right;
    /* Color fallback */
    color: #fff;
    -webkit-background-clip: text;

    -webkit-text-fill-color: transparent;
}

.clip-text:before,
.clip-text:after {
    position: absolute;
    content: '';
}

/* Background */
.clip-text:before {
    z-index: -2;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-image: inherit;
}

/* Text Background (black zone) */
.clip-text:after {
    position: absolute;
    z-index: -1;
    top: .125em;
    right: .125em;
    bottom: .125em;
    left: .125em;
    background-color: #000;
}

/* Change the background position to display letter when the black zone isn't here */
.clip-text--no-textzone:before {
    background-position: -.65em 0;
}

.clip-text--no-textzone:after {
    content: none;
}

/* Use Background-size cover for photo background and no-repeat background */
.clip-text--cover,
.clip-text--cover:before {
    background-repeat: no-repeat;
    -webkit-background-size: cover;
            background-size: cover;
  background-position: 50% 50%;
}

.clip-text_fourteen {
    background-image: url(https://onyx.codes/i.php?/000/009/comet,medium_large.1521969855.png);
}

      </style>";
  }

  // This function is called just before the closing </body> tag in the published site.
  // It triggers the loading screen only on the home page (index.lens)
  function showSplash()
  {
    echo <<<OUT
    <koken:if data="{{ location.template }}" equals="index">
        <div class='splash'>
            <div class='wrapper'>
                <div class='clip-text clip-text_fourteen clip-text--cover'>onyx<br>.codes</div>
            </div>
        </div>
        <script>
        $(this).delay(2000).queue(function() {
            $('.splash').fadeOut();
            $(this).dequeue();
        });</script>
    <koken:else>
        <!-- False, do this -->
    </koken:if>
OUT;
  }
}