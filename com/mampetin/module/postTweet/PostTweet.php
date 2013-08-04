<?php
/*
Generated Model
donnie@pwwdp.com
Mon Feb 15 00:34:50 WIT 2010
*/
class PostTweet{
	protected $twtUserId;
	protected $twtScreenName;
	protected $text;
	protected $urlShortId;
	protected $createTimestamp;
	public function getTwtUserId()
	{
		if(!is_null($this->twtUserId))
		return $this->twtUserId;
		else
		return null;
	}
	public function setTwtUserId($TwtUserId)
	{
		$this->twtUserId=$TwtUserId;
	}
	public function getTwtScreenName()
	{
		if(!is_null($this->twtScreenName))
		return $this->twtScreenName;
		else
		return null;
	}
	public function setTwtScreenName($TwtScreenName)
	{
		$this->twtScreenName=$TwtScreenName;
	}
	public function getText()
	{
		if(!is_null($this->text))
		return $this->text;
		else
		return null;
	}
	public function setText($Text)
	{
		$this->text=$Text;
	}
	public function getUrlShortId()
	{
		if(!is_null($this->urlShortId))
		return $this->urlShortId;
		else
		return null;
	}
	public function setUrlShortId($UrlShortId)
	{
		$this->urlShortId=$UrlShortId;
	}
	public function getCreateTimestamp()
	{
		if(!is_null($this->createTimestamp))
		return $this->createTimestamp;
		else
		return null;
	}
	public function setCreateTimestamp($CreateTimestamp)
	{
		$this->createTimestamp=$CreateTimestamp;
	}
}?>