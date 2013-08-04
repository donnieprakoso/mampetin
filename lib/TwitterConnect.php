<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 * Donnie Prakoso
 * donnie@pwwdp.com
 */
require_once('twitteroauth/twitterOAuth.php');
class TwitterConnect
{
    private $account_verify_credentials="http://twitter.com/account/verify_credentials.json";
    private $search="http://search.twitter.com/search.json";
    private $getOpt= array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER         => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING       => "",
    CURLOPT_USERAGENT      => "socialmap",
    CURLOPT_AUTOREFERER    => true,
    CURLOPT_CONNECTTIMEOUT => 120,
    CURLOPT_TIMEOUT        => 120,
    CURLOPT_MAXREDIRS      => 10,
    );

    private $postOpt= array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER         => false,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING       => "",
    CURLOPT_USERAGENT      => "socialmap",
    CURLOPT_AUTOREFERER    => true,
    CURLOPT_CONNECTTIMEOUT => 120,
    CURLOPT_TIMEOUT        => 120,
    CURLOPT_MAXREDIRS      => 10,
    CURLOPT_FAILONERROR => 1,
    CURLOPT_POST =>1,

    );

    public function doAuth($oauth_token)
    {
        session_start();
        $state = $_SESSION['oauth_state'];
        $session_token = $_SESSION['oauth_request_token'];
        if($oauth_token==null)
        {
            if($_SESSION['oauth_token']==null)
            {
                $oauth_token=$_SESSION['oauth_token'];
            }
        }
        $section = $_REQUEST['section'];
   

        if ($oauth_token != NULL && $_SESSION['oauth_state'] == 'start')
        {/*{{{*/
            $_SESSION['oauth_state'] = $state = 'returned';            
        }

        if ($oauth_token != NULL)
        {/*{{{*/
            $_SESSION['oauth_token']=$oauth_token;
        }


        if ($_SESSION['oauth_state'] =='returned')
        {
            if ($_SESSION['oauth_access_token'] === NULL && $_SESSION['oauth_access_token_secret'] === NULL)
            {
                $to = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
                $tok = $to->getAccessToken();
                $_SESSION['oauth_access_token'] = $tok['oauth_token'];
                $_SESSION['oauth_access_token_secret'] = $tok['oauth_token_secret'];
            }
        //header("Location: home.php");

        }
        else
        {
            $to = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
            $tok = $to->getRequestToken();
            $_SESSION['oauth_request_token'] = $token = $tok['oauth_token'];
            $_SESSION['oauth_request_token_secret'] = $tok['oauth_token_secret'];
            $_SESSION['oauth_state'] = "start";
            $request_link = $to->getAuthorizeURL($token);

            $content = $request_link;
        }
        return $content;
    }

    private function post($url,$keyValue)
    {

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $this->postOpt );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $keyValue); // add POST fields
        $result = curl_exec($ch);
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close($ch);
        $response['errno']   = $err;
        $response['errmsg']  = $errmsg;
        $response['content'] = $result;
        $response['header']=$header;
        return $response;
    }

    private function postAuth($url,$keyValue,$auth,$username,$password)
    {

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $this->postOpt );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $keyValue); // add POST fields
        curl_setopt($curl_handle, CURLOPT_USERPWD, "$username:$password");
        $result = curl_exec($ch);
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close($ch);
        $response['errno']   = $err;
        $response['errmsg']  = $errmsg;
        $response['content'] = $result;
        $response['header']=$header;
        return $response;
    }

    private function getAuth($url,$keyValue,$username,$password)
    {

        $ch      = curl_init( $url."?".$keyValue);

        curl_setopt_array( $ch, $this->getOpt );
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        $result = curl_exec($ch);
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close($ch);
        $response['errno']   = $err;
        $response['errmsg']  = $errmsg;
        $response['content'] = $result;
        $response['header']=$header;
        return $response;
    }

    private function get($url,$keyValue)
    {

        $ch      = curl_init( $url."?".$keyValue );
        curl_setopt_array( $ch, $this->getOpt );
        $result = curl_exec($ch);
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close($ch);
        $response['errno']   = $err;
        $response['errmsg']  = $errmsg;
        $response['content'] = $result;
        $response['header']=$header;
        return $response;
    }

    public function verifyAccount($username,$password)
    {
        $response=$this->getAuth($this->account_verify_credentials,null,$username,$password);
        $responses=explode("\n",$response['content']);
        $content = json_decode($responses[sizeof($responses)-1]);


        return $content;
    }

    public function search($query)
    {
        $response=$this->get($this->search,"q=".urlencode($query));
        $responses=explode("\n",$response['content']);
        $content = json_decode($responses[sizeof($responses)-1]);
        return $content;
    }

}

?>
