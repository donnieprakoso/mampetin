<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 * Donnie Prakoso
 * donnie@pwwdp.com
 *
 */
include_once('base_settings.php');
include_once(BASE_ROOT.'com/socialmap/module/placeDetail/PlaceDetail.php');
class Utility
{
    public function checkEmail($email)
    {
        $regex="/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD ";
        if(preg_match($regex , $email))
        {
            list($username,$domain)=split('@',$email);
            if(!checkdnsrr($domain,'MX'))
            {
                return false;
            }
            return true;
        }
        return false;
    }
    
    public function getDate($format,$date,$time)
    {
        $tempDate=explode("-", $date);
        $year=$tempDate[0];
        $month=$tempDate[1];
        $day=$tempDate[2];
        $tempTime=explode(":",$time);
        $hour=$tempTime[0];
        $minute=$tempTime[1];
        $second=$tempTime[2];
        return date($format, mktime($hour, $minute, $second, $month, $day, $year));
    }
    public function getCurrentDate($format,$date)
    {
        $tempDate=explode("-", $date);
        $year=$tempDate[0];
        $month=$tempDate[1];
        $day=$tempDate[2];
        $hour=0;
        $minute=0;
        $second=0;
        return date($format, mktime($hour, $minute, $second, $month, $day, $year));
    }

    public function convertBbLinks($url)
    {
        $tempUrl = explode("?",$url);
        $tempParams = explode("&",$tempUrl[1]);

        for($i=0;$i<sizeof($tempParams);$i++)
        {
            $temp=explode("=", $tempParams[$i]);
            $values[$temp[0]]=$temp[1];
        }
        return $values;
    }

    public function convertGmLinks($url)
    {

        $tempUrl = explode("?",$url);
        $tempParams = explode("&",$tempUrl[1]);

        for($i=0;$i<sizeof($tempParams);$i++)
        {
            $temp=explode("=", $tempParams[$i]);
            if($temp[0]=="ll")
            {
                $tempValues=explode(",",$temp[1]);
                $values['lat']=$tempValues[0];
                $values['lon']=$tempValues[1];
                break;
            }


        }
        return $values;
    }

    public function getPlaceDetailFromLl($lat,$lon)
    {
        $address=$lat.",".$lon;
        echo $address;
        $urlGeocode = 'http://maps.google.com/maps/geo?q='.$address.'&key=ABQIAAAASic6cPmUc_YwAb_DquJzMhRolSSgzZYvftURtDSUlupvsdw3ORRBGTh1_9JIpjcKpLrptIXEwF6Bng&sensor=false&output=json&gl=ID';
        if ($stream = fopen($urlGeocode, 'r'))
        {
            $obj=stream_get_contents($stream);
            fclose($stream);
            $obj=json_decode($obj);
        }
        else
        {
            return null;
        }
        $placemarks=sizeof($obj->Placemark);
        $i=0;
        if($placemarks!=0)
        {
            foreach($obj->Placemark as $place)
            {
            //                            echo "<pre>";
            //                            print_r($obj);
            //                            echo "</pre>";
            //                echo "<br/>";

                $latitude=$place->Point->coordinates[1];
                $longitude=$place->Point->coordinates[0];
                echo "<a href=showImage.php?longitude=".$longitude."&latitude=".$latitude.">{$place->address}</a><br/>";
                if($i==0)
                {

                    $result=$this->json2model($place);
                    break;
                }
                $i+=1;
            }
        }
        else
        {
            echo "Oops, didn't find what you looking for <br/>";
        }
        return $result;
    }

    public function json2model($obj)
    {

        $place=new PlaceDetail();
        //$placeMarks=$obj->Placemark;
        $place->setAccuracy($obj->AddressDetails->Accuracy);
        $place->setAddress($obj->address);
        //$place->setAddressLine($AddressLine);
        $place->setAdmAreaName($obj->AddressDetails->Country->AdministrativeArea->AdministrativeAreaName);
        $place->setCountryId($obj->AddressDetails->Country->CountryNameCode);
        $place->setCountryName($obj->AddressDetails->Country->CountryName);
        $place->setDepLocalityName($obj->AddressDetails->Country->AdministrativeArea->Locality->DependentLocality->DependentLocalityName);
        $place->setLlEast($obj->ExtendedData->LatLonBox->east);
        $place->setLlNorth($obj->ExtendedData->LatLonBox->north);
        $place->setLlSouth($obj->ExtendedData->LatLonBox->south);
        $place->setLlWest($obj->ExtendedData->LatLonBox->west);
        $place->setLocalityName($obj->AddressDetails->Country->AdministrativeArea->Locality->LocalityName);
        $place->setPExtra($obj->Point->coordinates[2]);
        $place->setPLl($obj->Point->coordinates[1]." ".$obj->Point->coordinates[0]);
        $place->setPlaceDetailId(null);
        //$place->setPostalCode($PostalCode);
        return $place;
    }

    public function getMd5($str)
    {
        $str.=$str.time();
        return md5($str);
    }

    public function tweetsOrderByDate($obj)
    {
        $arr=array();
        $results=array();
        for($i=0;$i<sizeof($obj);$i++)
        {
            $result = $obj[$i];
            $date=date( "Y-m-d",strtotime($result->created_at));
            if(!in_array($date,$arr))
            {
                array_push($arr,$date);
                $results[$date][0]=$result;
            //array_push($results[$date],$result);

            }
            else
            {
                $results[$date][sizeof($results[$date])]=$result;
            //array_push($results[$date],$result);
            }

        }
        return $results;
    }

}
?>