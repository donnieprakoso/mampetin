<?php
session_start();
/*
 *
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

//check param
if(isset($_POST['url']))
{
    if(!empty($_POST['url']))
    {
        if(isset($_POST['protected']))
        {
            if(isset($_POST['key']))
            {
                if(!empty($_POST['key']))
                {
                    $protected=true;
                    $protected_key=$_POST['key'];
                }
                else
                {
                    header("Location: index.php?error=Please insert your key if you want it to be protected");
                    exit;
                }

            }
            else
            {
                header("Location: index.php?error=Please insert your key if you want it to be protected");
                exit;
            }
        }
        $url= get_magic_quotes_gpc() ? stripslashes(trim($_POST['url'])) : trim($_POST['url']);
        //check shortened already ?
        $urlShortAction = new UrlShortAction();
        $listUrl = $urlShortAction->BL_listByUrl($url);
        if(sizeof($listUrl)==0)
        {
        //check valid url ?
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch,  CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($ch);
            $validUrl=false;
            if(curl_getinfo($ch, CURLINFO_HTTP_CODE) != '404')
            {
                $validUrl=true;
            }
            curl_close($ch);
            if($validUrl)
            {

            //shortened
                $noRedundant=false;
                while(!$noRedundant)
                {
                    $code = md5(uniqid(time(), true));
                    $key = substr($code,0,5);
                    $listUrlTemp = $urlShortAction->BL_listByUrl($url);
                    if(sizeof($listUrlTemp)==0)
                    {
                        $noRedundant=true;
                    }
                }

                //insert to db
                $urlShort=new UrlShort();

                if(isset($_POST['protected']))
                {
                    $urlShort->setProtected(1);
                    $urlShort->setProtectedKey($protected_key);
                }
                else
                {
                    $urlShort->setProtected(0);
                }
                $urlShort->setLongUrl($url);
                $urlShort->setShortUrl($key);
                $urlShort->setHits(0);
                $urlShort->setIpRequest($_SERVER['REMOTE_ADDR']);
                $urlShortAction->BL_add($urlShort);
                $_SESSION['key']=$key;
                header('Location: index.php');
            }
            else
            {
                header("Location: index.php?error=Errm, i think this is not a valid url");
                exit;

            }
        }
        else
        {
            header("Location: index.php?error=This url already been shortened. Don't play play laa");
            exit;

        }
    }
    else
    {
        header("Location: index.php?error=Come on, give me your url");
        exit;
    }
}
else
{
    header("Location: index.php?error=Come on, give me your url");
    exit;
}

?>
