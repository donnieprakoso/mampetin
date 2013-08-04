<?php
/*
Generated Dao
donnie@pwwdp.com
Mon Feb 15 00:34:53 WIT 2010
*/
require_once(BASE_ROOT.'lib/dpSql.php');
require_once(BASE_ROOT.'lib/dpBaseDao.php');
class ShortenedurlsDAO extends dpBaseDao
{
private $selectSQL = "SELECT * FROM shortenedurls";
private $selectByIdSQL = "SELECT * FROM shortenedurls WHERE id=?";
private $insertSQL = "INSERT INTO shortenedurls(id,long_url,created,creator,referrals) VALUES(?,?,?,?,?)";
private $updateSQL = "UPDATE shortenedurls SET long_url=?,created=?,creator=?,referrals=? WHERE id=?";
private $deleteSQL = "DELETE FROM shortenedurls WHERE id=?";
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
$a->setInt($model->getId());
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
$a->setInt($model->getCreated());
$a->setStr($model->getCreator());
$a->setInt($model->getReferrals());
$a->setInt($model->getId());
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
$a->setInt($model->getId());
$a->setStr($model->getLongUrl());
$a->setInt($model->getCreated());
$a->setStr($model->getCreator());
$a->setInt($model->getReferrals());
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
$a->setInt($model->getId());
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
$vo=new Shortenedurls();
$vo->setId($object['id']);
$vo->setLongUrl($object['long_url']);
$vo->setCreated($object['created']);
$vo->setCreator($object['creator']);
$vo->setReferrals($object['referrals']);
return $vo;
}
}
?>