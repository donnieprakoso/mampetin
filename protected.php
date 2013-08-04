<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 * Donnie Prakoso
 * donnie@pwwdp.com
 */
require_once('lib/base_settings.php');
require_once(BASE_ROOT.'com/mampetin/module/urlShort/UrlShort.php');
require_once(BASE_ROOT.'com/mampetin/module/urlShort/UrlShortAction.php');
require_once(BASE_ROOT.'com/mampetin/module/postTweet/PostTweet.php');
require_once(BASE_ROOT.'com/mampetin/module/postTweet/PostTweetAction.php');
require_once(BASE_ROOT.'com/mampetin/module/referrer/Referrer.php');
require_once(BASE_ROOT.'com/mampetin/module/referrer/ReferrerAction.php');

$short=$_POST['short'];
$key=$_POST['key'];
$urlShortAction = new UrlShortAction();
$listUrlTemp = $urlShortAction->BL_listByUrl($short);
if(sizeof($listUrlTemp)==1)
{
    $urlShort=$listUrlTemp[0];
    if($urlShort->getProtectedKey()==$key)
    {
        if ($_SERVER["HTTP_REFERER"])
        {
            $referrer = $_SERVER["HTTP_REFERER"];

        }
        $referrerMod=new Referrer();
        $referrerMod->setRefferal($referrer);
        $referrerMod->setUrlShortId($urlShort->getUrlShortId());
        $referrerMod->setIpRequest($_SERVER['REMOTE_ADDR']);

        $refAction = new ReferrerAction();
        $refAction->BL_add($referrerMod);
        $hits=$urlShort->getHits();
        $hits+=1;
        $urlShort->setHits($hits);
        $urlShortAction->BL_update($urlShort);
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' .  $urlShort->getLongUrl());
        exit;
    }
    else
    {
        ?>
Your key is wrong.
<form method="post" action="protected.php" >
    <label for="longurl">Key</label> <input type="text" name="key" id="key">
    <input type="hidden" name="short" value="<?php echo $urlShort->getShortUrl();?>">
    <input type="submit" value="Go">

</form>
    <?php
    }
}
?>
