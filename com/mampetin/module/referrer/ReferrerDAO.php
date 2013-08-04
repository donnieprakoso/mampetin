<?php
/*
Generated Dao
donnie@pwwdp.com
Mon Feb 15 01:36:03 WIT 2010
*/
require_once(BASE_ROOT.'lib/dpSql.php');
require_once(BASE_ROOT.'lib/dpBaseDao.php');
class ReferrerDAO extends dpBaseDao
{
    private $selectSQL = "SELECT * FROM referrer";
    private $selectByIdSQL = "SELECT * FROM referrer WHERE REFERRER_ID=?";
    private $insertSQL = "INSERT INTO referrer(REFERRER_ID,URL_SHORT_ID,IP_REQUEST,REFFERAL,CREATE_TIMESTAMP) VALUES(null,?,?,?,now())";
    private $updateSQL = "UPDATE referrer SET URL_SHORT_ID=?,IP_REQUEST=?,REFFERAL=?,CREATE_TIMESTAMP=? WHERE REFERRER_ID=?";
    private $deleteSQL = "DELETE FROM referrer WHERE REFERRER_ID=?";
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
        $a->setInt($model->getReferrerId());
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
        $a->setInt($model->getUrlShortId());
        $a->setStr($model->getIpRequest());
        $a->setStr($model->getRefferal());
        $a->setStr($model->getCreateTimestamp());
        $a->setInt($model->getReferrerId());
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
    //    $a->setInt($model->getReferrerId());
        $a->setInt($model->getUrlShortId());
        $a->setStr($model->getIpRequest());
        $a->setStr($model->getRefferal());
    //    $a->setStr($model->getCreateTimestamp());
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
        $a->setInt($model->getReferrerId());
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
        $vo=new Referrer();
        $vo->setReferrerId($object['REFERRER_ID']);
        $vo->setUrlShortId($object['URL_SHORT_ID']);
        $vo->setIpRequest($object['IP_REQUEST']);
        $vo->setRefferal($object['REFFERAL']);
        $vo->setCreateTimestamp($object['CREATE_TIMESTAMP']);
        return $vo;
    }
}
?>