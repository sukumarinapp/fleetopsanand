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
  	$sql = "SELECT * FROM tracker where veh_date='$SDT' and VNO='$VNO'";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
		  $CML = $result[0]->CML;
    }else{
		  $SDT = date('Y-m-d', strtotime("-2 days"));
	  	$sql = "SELECT * FROM tracker where veh_date='$SDT' and VNO='$VNO'";
	    $result = DB::select(DB::raw($sql));
	    $CML = $result[0]->CML;
    }
  	return $CML;
  }

  public static function CHR($VNO){
    $CHR = 0;
    $SDT = date('Y-m-d', strtotime("-1 days"));
    $sql = "SELECT * FROM tracker where veh_date='$SDT' and VNO='$VNO'";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $CHR = $result[0]->CHR;
    }else{
      $SDT = date('Y-m-d', strtotime("-2 days"));
      $sql = "SELECT * FROM tracker where veh_date='$SDT' and VNO='$VNO'";
      $result = DB::select(DB::raw($sql));
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

  public static function expected_sales($VNO){
  	return 8000;
  }

}
