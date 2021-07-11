<?php

namespace App;
use DB;

class Formulae 
{
  
  public static function fuel_consumption($ECY) {
    $ECY = $ECY * 10000;
    $ECY = pow($ECY,0.52);
    $CON = 100 * (0.195 + 0.141 * $ECY);
    return $CON;
  }

  public static function CML($VNO){
  	$CML = 0;
  	$SDT = date('Y-m-d', strtotime("-1 days"));
    $sql = "SELECT * FROM tbl137 where SDT='$SDT' and VNO='$VNO'";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $CML = $result[0]->CML;
    }
  	return $CML;
  }

  public static function CHR($VNO){
    $CHR = 0;
    $SDT = date('Y-m-d', strtotime("-1 days"));
    $sql = "SELECT * FROM tbl137 where SDT='$SDT' and VNO='$VNO'";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $CHR = $result[0]->CHR;
    }
    return $CHR;
  }

  public static function NWM(){
  	$sql = "SELECT NWM FROM tbl494";
    $result = DB::select(DB::raw($sql));
    $NWM = $result[0]->NWM;
  	return $NWM;
  }

  public static function expected_sales($VNO,$TPF){
    $SDT = date('Y-m-d', strtotime("-1 days"));
    $CHR = 0;
    $CML = 0;
    $RML = 0;
    $RMN = 0;
    $RMS = 0;
    $sql = "SELECT * FROM tbl137 where SDT='$SDT' and VNO='$VNO'";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $CHR = $result[0]->CHR;
      $CML = $result[0]->CML;
    }
    $sql = "select b.* from driver_platform a,tbl361 b where a.PLF=b.id and a.driver_id = (select driver_id from vehicle where VNO='$VNO')";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $RML = $result[0]->RML;
      $RMN = $result[0]->RMN;
      $RMS = $result[0]->RMS;
    }
    $EXPS=0;
    $EXPS = $CML * $RML + 60 * $CHR * $RMN + ($TPF * $RMS);
    return $EXPS;
  }
}
