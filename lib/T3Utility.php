<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of XmlUtility
 *
 * @author root
 */
class T3Utility
{
    public function parseFriendsTimeline($content)
    {
        $doc = new DOMDocument();
        $doc->loadXML($content);
        $elStatus=$doc->getElementsByTagName("status");
        $data = array();
        $i=0;
        foreach($elStatus as $listStatus)
        {
            $tweetList=$listStatus->getElementsByTagName("text");
            $tweet=$tweetList->item(0)->nodeValue;
            $data[$i]['tweet']=$tweet;
            $attributes=$listStatus->getElementsByTagName("user");
            foreach($attributes as $attribute)
            {
                $elScreenname=$attribute->getElementsByTagName("screen_name");
            }
            $i++;
        }

        return $data;
    }
    /*
    public function JparseFriendsTimeline($content) {
        $data_json=json_decode($content);

        $data=array();
        for($i=0;$i<sizeof($data_json);$i++) {
            $data[$i]['status_id']=$data_json[$i]->id;
            $data[$i]['text']=$data_json[$i]->text;
            $data[$i]['source']=$data_json[$i]->source;
            $data[$i]['created_at']=$data_json[$i]->created_at;
            $data[$i]['screen_name']=$data_json[$i]->user->screen_name;
            $data[$i]['profile_image_url']=$data_json[$i]->user->profile_image_url;
            $data[$i]['url']=$data_json[$i]->user->url;
        }
        return $data;
    }
    */
    public function JparseFriendsTimeline($content)
    {
        $data_json=json_decode($content);

        $data_return=array();
        for($i=0;$i<sizeof($data_json);$i++)
        {
            $data['status_id']=$data_json[$i]->id;
            $data['text']=$data_json[$i]->text;
            $data['source']=$data_json[$i]->source;
            $data['created_at']=$data_json[$i]->created_at;
            $data['screen_name']=$data_json[$i]->user->screen_name;
            $data['profile_image_url']=$data_json[$i]->user->profile_image_url;
            $data['url']=$data_json[$i]->user->url;
            array_push($data_return, $data);
        }
        return $data_return;
    }
    public function parseText($content)
    {
        $arr=explode(" ", $content);
        for($i=0;$i<sizeof($arr);$i++)
        {
            $txt=$arr[$i];
            if(stristr($txt, "http:"))
            {
                $text="<a href=".$txt.">".$txt."</a>";
                $arr[$i]=$text;
            }
            else if(stristr($txt, "@"))
                {
                    $notIncluded=array("@",":");
                    $replacedTo=array("","");
                    $text="<a href=\"http://twitter.com/".str_replace($notIncluded,$replacedTo,$txt)."\">".$txt."</a>";
                    $arr[$i]=$text;
                }
        }
        $data=implode(" ", $arr);
        return $data;
    }

    function relativeDate($timestamp,$type)
    {
        date_default_timezone_set('Asia/Jakarta');
        $timestamp = strtotime($timestamp);
        $timediff = time() - $timestamp ;

        if ($timediff < 3600)
        {
            if ($timediff < 120)
            {
                $returndate = "1 minute ago";
            }
            else
            {
                $returndate =  intval($timediff / 60) . " minutes Ago.";
            }
        }

        else if ($timediff < 7200)
            {
                $returndate = "1 hour ago.";
            }
            else if ($timediff < 86400)
                {
                    $returndate = intval($timediff / 3600) . " hours ago.";
                }

                else if ($timediff < 7200)
                    {
                        $returndate = "1 hour ago.";
                    }
                    else if ($timediff < 86400)
                        {
                            $returndate = intval($timediff / 3600) . " hours ago.";
                        }

                        else if ($timediff < 1209600)
                            {
                                $returndate = "1 week ago.";
                            }
                            else if ($timediff < 3024000)
                                {
                                    $returndate = intval($timediff / 604900) . " weeks ago.";
                                }

                                else
                                {
                                    $returndate = @date('n-j-Y', $timestamp);
                                    if($type=="fulldate")
                                    {
                                        $returndate = @date('n-j-y, H:i', $timestamp);

                                    }

                                    else if ($type=="time")
                                        {

                                            $returndate = @date('H:i', $timestamp);

                                        }

                                }
        echo $returndate;
    }

    function printTweet($data)
    {
        for($i=0;$i<sizeof($data);$i++)
        {
            echo "<div class=\"wrapContainer\">";
            echo "<p class=\"image-left\"> <img class=\"img_avatar\" src=".$data[$i]['profile_image_url']."></p>";
            echo "<div>";
            echo "<br/>";
            echo "<b>".strtoupper($data[$i]['screen_name'])."</b>";
            echo "<br/>";
            echo         $this->relativeDate($data[$i]['created_at'],"fulldate");
            echo "<br/>";
            echo "from ".$data[$i]['source'];

            echo "</div>";
            echo "</div>";

            echo "<p>";
            echo $this->parseText($data[$i]['text']);
            echo "</p>";
            echo " > reply > retweet > <a href=\"?status=".urlencode("RT @".$data[$i]['screen_name']." ".$data[$i]['text'])."\">quote </a> > direct message";
            echo "<br/>";
            echo "<hr/>";

        }
    }

    function printTicker($data)
    {
        for($i=0;$i<sizeof($data);$i++)
        {
            echo "<br/>";
            echo "<div class=\"wrapContainer\">";

            echo "<div>";
            echo "<b>".strtoupper($data[$i]['screen_name'])."</b>";
            echo " | ";
            echo         $this->relativeDate($data[$i]['created_at'],"fulldate");
            echo " | ";
            echo $data[$i]['source'];

            echo "</div>";
            echo "</div>";
            echo "<br/>";
            echo "<p>";
            echo $this->parseText($data[$i]['text']);
            echo "</p>";
            //echo " > reply > retweet > <a href=\"?status=".urlencode("RT @".$data[$i]['screen_name']." ".$data[$i]['text'])."\">quote </a> > direct message";

            echo "<hr/>";

        }
    }
    function printPhotoTweet($data)
    {
        for($i=0;$i<sizeof($data);$i++)
        {
            echo "<div class=\"wrapContainer\">";
            echo "<div>";

            echo "<p class=\"image-left\"><img class=\"img_avatar\" src=".$data[$i]['profile_image_url']."></p>";
            echo "<br/>";
            echo "<b>".strtoupper($data[$i]['screen_name'])."</b>";

            echo "<br/>";
            echo         $this->relativeDate($data[$i]['created_at'],"fulldate");
            echo "<br/>";
            echo "from ".$data[$i]['source'];
            echo "</div>";
            echo "</div>";
            echo "<img width=\"200px\" src=\"".$data[$i]['photo_url']."\">";
            echo "<br/>";
            echo $this->parseText($data[$i]['text']);

            echo "<p>";

            echo "</p>";
            echo " > reply > retweet > <a href=\"?status=".urlencode("RT @".$data[$i]['screen_name']." ".$data[$i]['text'])."\">quote </a> > direct message";
            echo "<br/>";
            echo "<hr/>";
        }
    }
}

?>
