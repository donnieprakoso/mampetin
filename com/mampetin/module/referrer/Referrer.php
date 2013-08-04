<?php
/*
Generated Model
donnie@pwwdp.com
Mon Feb 15 01:36:00 WIT 2010
*/
class Referrer{
	protected $referrerId;
	protected $urlShortId;
	protected $ipRequest;
	protected $refferal;
	protected $createTimestamp;
	public function getReferrerId()
	{
		if(!is_null($this->referrerId))
		return $this->referrerId;
		else
		return null;
	}
	public function setReferrerId($ReferrerId)
	{
		$this->referrerId=$ReferrerId;
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
	public function getRefferal()
	{
		if(!is_null($this->refferal))
		return $this->refferal;
		else
		return null;
	}
	public function setRefferal($Refferal)
	{
		$this->refferal=$Refferal;
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