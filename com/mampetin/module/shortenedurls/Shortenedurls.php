<?php
/*
Generated Model
donnie@pwwdp.com
Mon Feb 15 00:34:50 WIT 2010
*/
class Shortenedurls{
	protected $id;
	protected $longUrl;
	protected $created;
	protected $creator;
	protected $referrals;
	public function getId()
	{
		if(!is_null($this->id))
		return $this->id;
		else
		return null;
	}
	public function setId($Id)
	{
		$this->id=$Id;
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
	public function getCreated()
	{
		if(!is_null($this->created))
		return $this->created;
		else
		return null;
	}
	public function setCreated($Created)
	{
		$this->created=$Created;
	}
	public function getCreator()
	{
		if(!is_null($this->creator))
		return $this->creator;
		else
		return null;
	}
	public function setCreator($Creator)
	{
		$this->creator=$Creator;
	}
	public function getReferrals()
	{
		if(!is_null($this->referrals))
		return $this->referrals;
		else
		return null;
	}
	public function setReferrals($Referrals)
	{
		$this->referrals=$Referrals;
	}
}?>