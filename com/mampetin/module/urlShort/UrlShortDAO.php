<?php
/*
Generated Dao
donnie@pwwdp.com
Mon Feb 15 00:34:53 WIT 2010
*/
require_once(BASE_ROOT.'lib/dpSql.php');
require_once(BASE_ROOT.'lib/dpBaseDao.php');
class UrlShortDAO extends dpBaseDao
{
private $selectSQL = "SELECT * FROM url_short";
private $selectByIdSQL = "SELECT * FROM url_short WHERE URL_SHORT_ID=?";
private $insertSQL = "INSERT INTO url_short(URL_SHORT_ID,LONG_URL,SHORT_URL,IP_REQUEST,HITS,PROTECTED,PROTECTED_KEY,CREATE_TIMESTAMP) VALUES(null,?,?,?,?,?,?,now())";
private $updateSQL = "UPDATE url_short SET LONG_URL=?,SHORT_URL=?,IP_REQUEST=?,HITS=?,PROTECTED=?,PROTECTED_KEY=?,CREATE_TIMESTAMP=? WHERE URL_SHORT_ID=?";
private $deleteSQL = "DELETE FROM url_short WHERE URL_SHORT_ID=?";
public function listAll()
{
$dobjReturn=null;
$dobjResult=null;
$sql = $this->selectSQL;
$a = new preparedSQL($sql);
/*please add this section */
$a->joinArraySQL();
$sql = $a ->  getStrSQL();
$dobjResult = parent::DAOQuerySQL($sql);
if(sizeof($dobjResult)==0)
{
$dobjReturn = null;
}
else
{
$dobjReturn = $this ->getList($dobjResult);
}
return $dobjReturn;
}

public function listWithCriteria($sqlAddendum)
{
$dobjReturn=null;
$dobjResult=null;
$sql = $this->selectSQL;
$a = new preparedSQL($sql);
/*please add this section */
$a->joinArraySQL();
$sql = $a ->  getStrSQL();
$sql.= " WHERE " .$sqlAddendum;
$dobjResult = parent::DAOQuerySQL($sql);
if(sizeof($dobjResult)==0)
{
$dobjReturn = null;
}
else
{
$dobjReturn = $this ->getList($dobjResult);
}
return $dobjReturn;
}

public function getById($model)
{
$dobjReturn=null;
$dobjResult=null;
$sql = $this->selectByIdSQL;
$a = new preparedSQL($sql);
$a->setInt($model->getUrlShortId());
$a->joinArraySQL();
$sql = $a ->  getStrSQL();
$dobjResult = parent::DAOQuerySQL($sql);
if(sizeof($dobjResult)==0)
{
$dobjReturn = null;
}
else
{
$dobjReturn = $this ->getSingle($dobjResult);
}
return $dobjReturn;
}

public function update($model)
{
$dobjResult= false;
$sql=$this->updateSQL;
$a=new preparedSQL($sql);
$a->setStr($model->getLongUrl());
$a->setStr($model->getShortUrl());
$a->setStr($model->getIpRequest());
$a->setInt($model->getHits());
$a->setInt($model->getProtected());
$a->setStr($model->getProtectedKey());
$a->setStr($model->getCreateTimestamp());
$a->setInt($model->getUrlShortId());
$a->joinArraySQL();
$sql=$a->getStrSQL();
$dobjResult = parent::DAOExecuteSQL($sql);
return $dobjResult;
}
public function add($model)
{
$dobjResult= false;
$sql=$this->insertSQL;
$a=new preparedSQL($sql);
//$a->setInt($model->getUrlShortId());
$a->setStr($model->getLongUrl());
$a->setStr($model->getShortUrl());
$a->setStr($model->getIpRequest());
$a->setInt($model->getHits());
$a->setInt($model->getProtected());
$a->setStr($model->getProtectedKey());
//$a->setStr($model->getCreateTimestamp());
$a->joinArraySQL();
$sql=$a->getStrSQL();

$dobjResult = parent::DAOExecuteSQL($sql);
return $dobjResult;
}
public function delete($model)
{
$dobjResult= false;
$sql=$this->deleteSQL;
$a=new preparedSQL($sql);
$a->setInt($model->getUrlShortId());
$a->joinArraySQL();
$sql=$a->getStrSQL();
$dobjResult = parent::DAOExecuteSQL($sql);
return $dobjResult;
}
private function getList($objects)
{
$arrays = array();
for($i=0;$i<sizeof($objects);$i++)
{
$vo=$this->rs2vo($objects[$i]);
array_push($arrays,$vo);
}
return $arrays;
}
private function getSingle($object)
{
$vo=$this->rs2vo($object[0]);
return $vo;
}
private function rs2vo($object)
{
$vo=new UrlShort();
$vo->setUrlShortId($object['URL_SHORT_ID']);
$vo->setLongUrl($object['LONG_URL']);
$vo->setShortUrl($object['SHORT_URL']);
$vo->setIpRequest($object['IP_REQUEST']);
$vo->setHits($object['HITS']);
$vo->setProtected($object['PROTECTED']);
$vo->setProtectedKey($object['PROTECTED_KEY']);
$vo->setCreateTimestamp($object['CREATE_TIMESTAMP']);
return $vo;
}
}
?>