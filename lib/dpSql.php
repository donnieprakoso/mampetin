<?php
/*
 * Created on Mar 26, 2008
 * Donnie Prakoso
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class preparedSQL {

    var $arraySQL;
    var $intPos;
    var $strSQL;

    function preparedSQL($strSQL) {
        $this->strSQL=$strSQL;
        $this->arraySQL=explode("?",$strSQL);
        $this->intPos=0;
    }

    function getArraySQL() {
        for($i=0;$i<$this->arraySQL;$i++) {
            echo "<br>";
            echo $this->arraySQL[$i];
        }
    }

    function getStrSQL() {
        return $this->strSQL;
    }

    function getIntPos() {
        echo "<br>".$this->intPos;
    }

    function setInt($int) {

        $this->arraySQL[$this->intPos].=$int;
        $this->intPos++;
    }

    function setStr($str) {
        if(is_null($str)) {
            $this->arraySQL[$this->intPos].="null";
        }
        else {
            $this->arraySQL[$this->intPos].="'".$str."'";
        }

        $this->intPos++;
    }

    function setLimit($lowerBound,$upperBound) {
        $this->strSQL.="LIMIT ".$lowerBound.",".$upperBound;

    }

    function joinArraySQL() {
        $this->strSQL="";
        for($i=0;$i<sizeof($this->arraySQL);$i++) {
            $this->strSQL.=$this->arraySQL[$i];
        }
    }


}


?>
