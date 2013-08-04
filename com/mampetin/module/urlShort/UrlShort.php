<?php
/*
Generated Model
donnie@pwwdp.com
Mon Feb 15 00:34:50 WIT 2010
*/
class UrlShort{
	protected $urlShortId;
	protected $longUrl;
	protected $shortUrl;
	protected $ipRequest;
	protected $hits;
	protected $protected;
	protected $protectedKey;
	protected $createTimestamp;
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
	public function getLongUrl()
	{
		if(!is_null($this->longUrl))
		return $this->longUrl;
		else
		return null;
	}
	public function setLongUrl($LongUrl)
	{
		$this->longUrl=$LongUrl;
	}
	public function getShortUrl()
	{
		if(!is_null($this->shortUrl))
		return $this->shortUrl;
		else
		return null;
	}
	public function setShortUrl($ShortUrl)
	{
		$this->shortUrl=$ShortUrl;
	}
	public function getIpRequest()
	{
		if(!is_null($this->ipRequest))
		return $this->ipRequest;
		else
		return null;
	}
	public function setIpRequest($IpRequest)
	{
		$this->ipRequest=$IpRequest;
	}
	public function getHits()
	{
		if(!is_null($this->hits))
		return $this->hits;
		else
		return null;
	}
	public function setHits($Hits)
	{
		$this->hits=$Hits;
	}
	public function getProtected()
	{
		if(!is_null($this->protected))
		return $this->protected;
		else
		return null;
	}
	public function setProtected($Protected)
	{
		$this->protected=$Protected;
	}
	public function getProtectedKey()
	{
		if(!is_null($this->protectedKey))
		return $this->protectedKey;
		else
		return null;
	}
	public function setProtectedKey($ProtectedKey)
	{
		$this->protectedKey=$ProtectedKey;
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