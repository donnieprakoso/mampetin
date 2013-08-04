<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of XmlUtility
 *
 * @author Donnie Prakoso
 */
class XmlUtility
{
    public function XmlUtility()
    {
        date_default_timezone_set("Asia/Jakarta");
    }
    public function group($data,$categoryList)
    {
        $tweet=$data;
        $photo=1;
        $featuredUser=2;
        $news=3;
        $traffic=4;
        $timelines=5;
        if(stristr($tweet->getText(), "twitpic.com")!=FALSE )
        {
        //$dataPhoto[$i]=$tweet;
            $temp=explode(" ",$tweet->getText());
            for($j=0;$j<sizeof($temp);$j++)
            {
                if(stristr($temp[$j], "twitpic.com")!=FALSE)
                {
                    $tempText= explode("/",$temp[$j]);
                    $tweet->setPhotoUrl("http://twitpic.com/show/thumb/".$tempText[sizeof($tempText)-1]);
                    $tweet->setDefaultCategoryId($photo);
                    return $tweet;

                }
            }
        }
        else if(stristr($tweet->getText(), "tweetphoto.com")!=FALSE )
            {
            //$dataPhoto[$i]=$tweet;
                $temp=explode(" ",$tweet->getText());
                for($j=0;$j<sizeof($temp);$j++)
                {
                    if(stristr($temp[$j], "tweetphoto.com")!=FALSE)
                    {
                        $tweet->setPhotoUrl("http://TweetPhotoAPI.com/api/TPAPI.svc/imagefromurl?size=medium&url=".$temp[$j]);
                        break;
                    }
                }
                $tweet->setDefaultCategoryId($photo);
                //array_pop($data);
                return $tweet;
            }
        for($i=0;$i<sizeof($categoryList);$i++)
        {
            if($categoryList[$i]->getTwtUserId()==$tweet->getTwtUserId())
            {
                $tweet->setDefaultCategoryId($categoryList[$i]->getDefaultCategoryId());
                return $tweet;
            }
        }

        $tweet->setDefaultCategoryId($timelines);
        return $tweet;

    }


    public function groupPhotos()
    {
        for($i=0;$i<sizeof($data);$i++)
        {
        //Photo
            $tweet=$data[$i];
            if(stristr($tweet['text'], "twitpic.com")!=FALSE )
            {
            //$dataPhoto[$i]=$tweet;
                $temp=explode(" ",$tweet['text']);
                for($j=0;$j<sizeof($temp);$j++)
                {
                    if(stristr($temp[$j], "twitpic.com")!=FALSE)
                    {
                        $tempText= explode("/",$temp[$j]);
                        $tweet['photo_url']="http://twitpic.com/show/thumb/".$tempText[sizeof($tempText)-1];
                        break;
                    }
                }
                array_push($dataPhoto,$tweet);
                //array_pop($data);
                continue;
            }
            else if(stristr($tweet['text'], "tweetphoto.com")!=FALSE )
                {
                //$dataPhoto[$i]=$tweet;
                    $temp=explode(" ",$tweet['text']);
                    for($j=0;$j<sizeof($temp);$j++)
                    {
                        if(stristr($temp[$j], "tweetphoto.com")!=FALSE)
                        {
                            $tweet['photo_url']="http://TweetPhotoAPI.com/api/TPAPI.svc/imagefromurl?size=medium&url=".$temp[$j];
                            break;
                        }
                    }
                    array_push($dataPhoto,$tweet);
                    //array_pop($data);
                    continue;
                }

            //featured user
            if(in_array($tweet['screen_name'], $arr_featured))
            {
                array_push($dataFeatured,$tweet);
                //array_pop($data);
                continue;
            }

            //news
            if(in_array($tweet['screen_name'], $arr_news))
            {
                array_push($dataNews,$tweet);
                //array_pop($data);
                continue;
            }

            //traffic
            if(in_array($tweet['screen_name'], $arr_traffic))
            {
                array_push($dataTraffic,$tweet);
                //array_pop($data);
                continue;
            }

            //    echo "pushing to latest<br/>";
            array_push($dataLatest,$tweet);
        }


    }

    public function parseAccount($data)
    {
        $twtUser = new TwtUser();
        //$userArray=array();
        $twtUser->setTwtUserId($data->id);

        $twtUser->setName($data->name);
        $twtUser->setScreenName($data->screen_name);
        $twtUser->setLocation($data->location);
        $twtUser->setDescription($data->description);
        $twtUser->setProfileImageUrl($data->profile_image_url);
        $twtUser->setUrl($data->url);
        $twtUser->setProtected($data->protected);
        $twtUser->setFollowersCount($data->followers_count);
        $twtUser->setProfileBackgroundColor($data->profile_background_color);
        $twtUser->setProfileTextColor($data->profile_text_color);
        $twtUser->setProfileLinkColor($data->profile_link_color);
        $twtUser->setProfileSidebarFillColor($data->profile_sidebar_fill_color);
        $twtUser->setProfileSidebarBorderColor($data->profile_sidebar_border_color);
        $twtUser->setFriendsCount($data->friends_count);
        $twtUser->setCreatedAt(strftime("%Y-%m-%d %H:%M:%S",strtotime($data->created_at)));
        $twtUser->setFavouritesCount($data->favourites_count);
        $twtUser->setUtcOffset($data->utc_offset);
        $twtUser->setTimeZone($data->time_zone);
        $twtUser->setProfileBackgroundImageUrl($data->profile_background_image_url);
        $twtUser->setProfileBackgroundTitle($data->profile_background_title);
        $twtUser->setStatusesCount($data->statuses_count);
        $twtUser->setNotifications($data->notifications);
        $twtUser->setGeoEnabled($data->geo_enabled);
        $twtUser->setVerified($data->verified);
        $twtUser->setFollowing($data->following);

        return $twtUser;
    }
    public function parseStatuses($data,$twtUserId)
    {

        $data_return=array();
        for($i=0;$i<sizeof($data);$i++)
        {
            $twtStatus = new TwtStatus();
            $twtStatus->setUserId($twtUserId);
            $twtStatus->setDefaultCategoryId(0);
            $twtStatus->setTwtStatusId($data[$i]->id);
            $twtStatus->setText($data[$i]->text);
            $twtStatus->setSource($data[$i]->source);
            $twtStatus->setTruncated($data[$i]->truncated);
            $twtStatus->setInReplyToStatusId($data[$i]->in_reply_to_status_id);
            $twtStatus->setInReplyToUserId($data[$i]->in_reply_to_user_id);
            $twtStatus->setFavorited($data[$i]->favorited);
            $twtStatus->setInReplyToScreenName($data[$i]->in_reply_to_screen_name);
            $twtStatus->setRetweetedStatus($data[$i]->retweeted_status->id);
            $twtStatus->setTwtUserId($data[$i]->user->id);
            $twtStatus->setTwtScreenName($data[$i]->user->screen_name);
            $twtStatus->setCreatedAt(strftime("%Y-%m-%d %H:%M:%S",strtotime($data[$i]->created_at)));
            $twtStatus->setRetrieved(0);
            array_push($data_return, $twtStatus);
        }
        return $data_return;
    }
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

    function printTweet($data,$account)
    {

    //echo '<div id="itemTweets">';
        echo '<div class="avatar">
					<img src="'.$account->getProfileImageUrl().'" />
				</div>
				<div class="user"><strong>'.strtoupper($data->getTwtScreenName()).'</strong><br />';
        echo $this->relativeDate($data->getCreatedAt(),"fulldate").'<br />
					from '.$data->getSource().'
				</div>
				<div class="bodyTweet">'.$this->parseText($data->getText()).'
            		<p>> <a href="?status='.urlencode('@'.$data->getTwtScreenName()).'">reply</a> > <a href="?status='.urlencode('RT @'.$data->getTwtScreenName().' '.$data->getText()).'">RT</a></p>
				</div>
            <hr/>';
    //echo '</div>';

    }

    function printTicker($data)
    {
        for($i=0;$i<sizeof($data);$i++)
        {
        //echo '<div id="itemTraffics">';
            echo '<div class="avatar">
					<img src="'.$data[$i]["profile_image_url"].'" />
				</div>
				<div class="user"><strong>'.strtoupper($data[$i]["screen_name"]).'</strong><br />';
            echo $this->relativeDate($data[$i]["created_at"],"fulldate").'<br />
					from '.$data[$i]["source"].'
				</div>
				<div class="bodyTweet">'.$this->parseText($data[$i]["text"]).'
            		<p>> <a href="?status='.urlencode('@'.$data[$i]["screen_name"]).'">reply</a> > <a href="?status='.urlencode('RT @'.$data[$i]["screen_name"].' '.$data[$i]["text"]).'">RT</a></p>
				</div>
            <hr/>';
        //echo '</div>';
        }
    }
    function printPhotoTweet($data,$account)
    {
        if(stristr($data->getText(), "twitpic.com")!=FALSE )
        {
        //$dataPhoto[$i]=$tweet;
            $temp=explode(" ",$data->getText());
            for($j=0;$j<sizeof($temp);$j++)
            {
                if(stristr($temp[$j], "twitpic.com")!=FALSE)
                {
                    $tempText= explode("/",$temp[$j]);
                    $data->setPhotoUrl("http://twitpic.com/show/thumb/".$tempText[sizeof($tempText)-1]);
                }
            }
        }
        else if(stristr($data->getText(), "tweetphoto.com")!=FALSE )
            {
            //$dataPhoto[$i]=$tweet;
                $temp=explode(" ",$data->getText());
                for($j=0;$j<sizeof($temp);$j++)
                {
                    if(stristr($temp[$j], "tweetphoto.com")!=FALSE)
                    {
                        $data->setPhotoUrl("http://TweetPhotoAPI.com/api/TPAPI.svc/imagefromurl?size=medium&url=".$temp[$j]);
                    }
                }
            }
            


        //echo '<div id="itemPhotos">';
        echo '<div class="avatar">
					<img src="'.$account->getProfileImageUrl().'" />
				</div>
				<div class="user">
					<strong>'.strtoupper($data->getTwtScreenName()).'</strong><br />';
        echo $this->relativeDate($data->getCreatedAt(),"fulldate").'<br />
            		from '.$data->getSource().'
				</div>
            	<div class="pic">
					<img src="'.$data->getPhotoUrl().'" width="200" height="auto" border="0" />
				</div>'.
            $this->parseText($data->getText()).'
            	<p>> <a href="?status='.urlencode('@'.$data->getTwtScreenName()).'">reply</a> > <a href="?status='.urlencode('RT @'.$data->getTwtScreenName().' '.$data->getText()).'">RT</a></p>
				<hr/>';
    //echo '</div>';

    }
}
?>
