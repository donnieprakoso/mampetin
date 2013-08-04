<?php
/*
Generated Action
donnie@pwwdp.com
Mon Feb 15 01:36:03 WIT 2010
*/
require_once(BASE_ROOT.'com/mampetin/module/referrer/Referrer.php');
require_once(BASE_ROOT.'com/mampetin/module/referrer/ReferrerDAO.php');
class ReferrerAction
{
private $dao;
public function ReferrerAction()
{
$this->dao=new ReferrerDAO();
}
public function BL_list()
{
return $this->DAO_list();
}
private function DAO_list()
{
$dao=$this->dao;
return $dao->listAll();
}
public function BL_listWithCriteria($sql)
{
return $this->DAO_listWithCriteria($sql);
}
private function DAO_listWithCriteria($sql)
{
$dao=$this->dao;
return $dao->listWithCriteria($sql);
}
public function BL_add($model)
{
return $this->DAO_add($model);
}
private function DAO_add($model)
{
$dao=$this->dao;
return $dao->add($model);
}
public function BL_update($model)
{
return $this->DAO_update($model);
}
private function DAO_update($model)
{
$dao=$this->dao;
return $dao->update($model);
}
public function BL_delete($model)
{
return $this->DAO_delete($model);
}
private function DAO_delete($model)
{
$dao=$this->dao;
return $dao->delete($model);
}
public function BL_getById($model)
{
return $this->DAO_getById($model);
}
private function DAO_getById($model)
{
$dao=$this->dao;
return $dao->getById($model);
}
}
?>