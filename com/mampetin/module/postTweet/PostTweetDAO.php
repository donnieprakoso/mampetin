<?php
/*
Generated Dao
donnie@pwwdp.com
Mon Feb 15 00:34:53 WIT 2010
*/
require_once(BASE_ROOT.'lib/dpSql.php');
require_once(BASE_ROOT.'lib/dpBaseDao.php');
class PostTweetDAO extends dpBaseDao
{
private $selectSQL = "SELECT * FROM post_tweet";
private $selectByIdSQL = "SELECT * FROM post_tweet WHERE TWT_USER_ID=?";
private $insertSQL = "INSERT INTO post_tweet(TWT_USER_ID,TWT_SCREEN_NAME,TEXT,URL_SHORT_ID,CREATE_TIMESTAMP) VALUES(?,?,?,?,?)";
private $updateSQL = "UPDATE post_tweet SET TWT_SCREEN_NAME=?,TEXT=?,URL_SHORT_ID=?,CREATE_TIMESTAMP=? WHERE TWT_USER_ID=?";
private $deleteSQL = "DELETE FROM post_tweet WHERE TWT_USER_ID=?";
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
$a->setStr($model->getTwtUserId());
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
$a->setStr($model->getTwtScreenName());
$a->setStr($model->getText());
$a->setInt($model->getUrlShortId());
$a->setStr($model->getCreateTimestamp());
$a->setStr($model->getTwtUserId());
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
$a->setStr($model->getTwtUserId());
$a->setStr($model->getTwtScreenName());
$a->setStr($model->getText());
$a->setInt($model->getUrlShortId());
$a->setStr($model->getCreateTimestamp());
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
$a->setStr($model->getTwtUserId());
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
$vo=new PostTweet();
$vo->setTwtUserId($object['TWT_USER_ID']);
$vo->setTwtScreenName($object['TWT_SCREEN_NAME']);
$vo->setText($object['TEXT']);
$vo->setUrlShortId($object['URL_SHORT_ID']);
$vo->setCreateTimestamp($object['CREATE_TIMESTAMP']);
return $vo;
}
}
?>