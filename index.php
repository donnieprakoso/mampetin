<?php
session_start();
require_once('lib/base_settings.php');
require_once(BASE_ROOT.'com/mampetin/module/urlShort/UrlShort.php');
require_once(BASE_ROOT.'com/mampetin/module/urlShort/UrlShortAction.php');
require_once(BASE_ROOT.'com/mampetin/module/postTweet/PostTweet.php');
require_once(BASE_ROOT.'com/mampetin/module/postTweet/PostTweetAction.php');

?>
<!DOCTYPE html>
<html>
    <title>Subtu.be URL Shortener</title>
    <meta name="robots" content="noindex, nofollow">
    	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" href="./css/basic.css" type="text/css" />
	<link rel="stylesheet" href="./css/apps.css" type="text/css" />
	<link rel="stylesheet" href="./css/cssedit.css" type="text/css" />
</html>
<body class="main">
    <div class="title"><img src="image/logofooter.png" alt="Subtube Logo"> Subtu.be</div>
    <em>damn url shortener build by curiousity    </em>
<!--<div class="underlinemenu">
    <ul>
		<li >
			<a href="/">home</a>
		</li>

		<li id>
			<a href="/">brief info</a>
		</li>
		<li >
			<a href="/">our plan</a>
		</li>
		<li >
			<a href="/">about us</a>

		</li>
		<li>
			<a href="/">support</a>
		</li>

	</ul>

</div>-->
<h2>Spit your too long url below, cuh !</h2>

  <?php
    if(isset($_GET['error']))
    {
        echo $_GET['error'];
    }

    ?>
    <form method="post" action="short.php" >
        <input name="url" type="text" id="url" size="60" value="URL to shorten" onFocus="if(this.value=='URL to shorten')this.value='';">
        <br/>
        <br/>
        <input type=checkbox name="protected">
        Oh, yes.I want my url protected with key: 
        
      <input name="key" type="text" id="key" onFocus="if(this.value=='Enter passkey')this.value='';" value="Enter passkey" size="15">
<br/>
        <br/>
        <input type="submit" value="Shorten" id="shortenButton">
    </form>
    <?php
    if(isset($_SESSION['key']))
    {
        $url = PATH_ROOT.$_SESSION['key'];
        echo "<p class=result>Congrats ! Your shortened url would be:<br><span class=bigResult> <a href=".$url.">".$url."</a></span></p>";
    }
    ?>

<div id="footer">
    <p>Beautifully coded by <a href="http://twitter.com/donnieprakoso" target="_blank">@donnieprakoso</a> for  <a href="http://subtube.com" target="_blank">Subtube Studio</a> <br>
      Research &amp; Development Division &copy; 2010<br/>
    </p>
</div>

<?php
    session_destroy();
    ?>
</body>
</html>