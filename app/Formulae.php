<?php
namespace App;
use DB;

class Formulae{

  //Covered mileage
  public static function CML($DDT,$VNO){
  	$CML = 0;
    $sql = "SELECT * FROM tbl136 where DDT='$DDT' and VNO='$VNO'";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $CML = $result[0]->CML;
    }
  	return $CML;
  }

  //Hours Worked
  public static function CHR($DDT,$VNO){
    $CHR = 0;
    $sql = "SELECT * FROM tbl136 where DDT='$DDT' and VNO='$VNO'";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $CHR = $result[0]->CHR;
    }
    return $CHR;
  }

  //Ride Hailing Rate
  public static function RHR($VNO){
    $RHR = 0;
    $RML = 0;
    $RMN = 0;
    $PLF = 1;
    $sql = "SELECT b.PLF FROM vehicle a,driver_platform b where a.driver_id=b.driver_id and a.VNO='$VNO'";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $PLF = $result[0]->PLF;
    }
    $sql = "SELECT * from tbl361 where id=$PLF";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $RML = $result[0]->RML;
      $RMN = $result[0]->RMN;
    }
    $RHR = $RML + $RMN;
    return $RHR;
  }

  //Baseline revenue to mileage ratio
  public static function BRM($VNO){
    $BRM = 0;
    $RHR = self::RHR($VNO);
    if($RHR != 0){
      $BRM = 1/$RHR;
    }
    return $BRM;
  }

  //Driver revenue to mileage score
  public static function DRM($SDT,$VNO){
    $DRM = 0;
    $SAL = 0;
    $CML =  self::CML($SDT,$VNO);
    $sql = "SELECT max(SPF) as SAL from tbl137 where SDT='$SDT' and VNO='$VNO'";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $SAL = $result[0]->SAL;
    }
    if($SAL !=0 ) $DRM = $CML/$SAL;
    return $DRM;
  }

  //Wastage/Offline Trips
  public static function CWI($DCR) {
    $SDT = "";
    $VNO = "";
    $sql = "SELECT * from tbl136 where id='$DCR'";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $SDT = $result[0]->DDT;
      $VNO = $result[0]->VNO;
    }
    $CWI = 0;
    $CML = self::CML($SDT,$VNO);
    $RHR = self::RHR($VNO);
    $DRM = self::DRM($SDT,$VNO);
    $BRM = self::BRM($VNO);
    $CWI_Z = 0;
    $CWI_d = 1;
    $sql = "SELECT * from tbl494";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $CWI_Z = $result[0]->CWI_Z;
      $CWI_d = $result[0]->CWI_d;
    }
    $CWI = pow(($DRM - $BRM),2);
    $CWI = $CWI_Z + $CWI;
    $CWI = $CWI/$CWI_d;
    $CWI = $RHR * $CWI;
    $CWI = $CML * $CWI;
    $CWI = $CWI/10000;
    return $CWI;
  }

  //Fuel Consumption
  public static function CON($VNO) {
    $ECY = 0;
    $sql = "SELECT * from vehicle where VNO='$VNO'";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $ECY = $result[0]->ECY;
    }
    $ECY = ($ECY * 1000);
    $ECY = pow($ECY,0.52);
    $ECY = 0.141 * $ECY;
    $CON = 100 * (0.195 + $ECY);
    return $CON;
  }

  public static function NWM(){
  	$sql = "SELECT NWM FROM tbl494";
    $result = DB::select(DB::raw($sql));
    $NWM = $result[0]->NWM;
  	return $NWM;
  }

  //Expected Sales
  //This is for cannot retrieve sales data
  public static function EXPS($SDT,$VNO){
    $CHR = 0;
    $CML = 0;
    $RML = 0;
    $RMN = 0;
    $RMS = 0;
    $TPF = 1;
    $sql = "SELECT * FROM tbl136 where VNO='$VNO' and DECL=0";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $CHR = $result[0]->CHR;
      $CML = $result[0]->CML;
    }
    //$sql = "select b.* from driver_platform a,tbl361 b where a.PLF=b.id and a.driver_id = (select driver_id from vehicle where VNO='$VNO')";
    $sql = "select * from tbl361 where id = 1";
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

  public static function CCEI2($DCR){
      $sql = "SELECT * FROM tbl494";
      $result = DB::select(DB::raw($sql));
      $CCEI_a = $result[0]->CCEI_a;
      $CCEI_b = $result[0]->CCEI_b;
      $CCEI_Sxx = $result[0]->CCEI_Sxx;
      $CCEI_n = $result[0]->CCEI_n;
      $CCEI_taSe = $result[0]->CCEI_taSe;
      $EXPS = self::EXPS2($DCR);
      $Y = ($CCEI_a * $EXPS) + $CCEI_b;
      $CCEI = pow(($EXPS - $CCEI_b),2);
      $CCEI = $CCEI / $CCEI_Sxx;
      $CCEI = $CCEI_n + $CCEI;
      $CCEI = sqrt($CCEI);
      $CCEI = $CCEI_taSe * $CCEI;
      $CCEI = $Y - $CCEI;
      return round($CCEI,2);
  }

  public static function EXPS2($DCR){
    $VNO = "";
    $CHR = 0;
    $CML = 0;
    $RML = 0;
    $RMN = 0;
    $RMS = 0;
    $TPF = 1;
    $sql = "SELECT max(TPF) as TRIPS FROM tbl137 where DCR='$DCR'";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      if($result[0]->TRIPS != "") $TPF = $result[0]->TRIPS;
    }

    $DNW = 0;
    $CRS = 0;
    $sql = "SELECT * FROM tbl136 where id='$DCR'";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $CHR = $result[0]->CHR;
      $CML = $result[0]->CML;
      $VNO = $result[0]->VNO;
      $DNW = $result[0]->DNW;
      $CRS = $result[0]->CRS;
    }

    $sql = "select b.* from driver_platform a,tbl361 b where a.PLF=b.id and a.driver_id = (select driver_id from vehicle where VNO='$VNO')";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $RML = $result[0]->RML;
      $RMN = $result[0]->RMN;
      $RMS = $result[0]->RMS;
    }

    if($DNW == 1 || $CRS == 1){
      $sql = "select * from tbl361 where id=1";
      $result = DB::select(DB::raw($sql));
      if(count($result)>0){
        $RML = $result[0]->RML;
        $RMN = $result[0]->RMN;
        $RMS = $result[0]->RMS;
      }
    }
    $EXPS=0;
    $EXPS = $CML * $RML + 60 * $CHR * $RMN + ($TPF * $RMS);
    return $EXPS;
  }


  //Fuel top up function FTP(min)
  public static function FTP($DCR){
    $DDT = "";
    $VNO = "";
    $sql = "SELECT * from tbl136 where id='$DCR'";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $DDT = $result[0]->DDT;
      $VNO = $result[0]->VNO;
    }
    $SAL = 0;
    $sql = "SELECT sum(RMT) as SAL from tbl137 where DCR='$DCR' and RST=1";
    $result = DB::select(DB::raw($sql));
    if(count($result)>0){
      $SAL = $result[0]->SAL;
    }
    $CON = SELF::con($VNO);    
    if($SAL ==0 ) $SAL = self::EXPS2($DCR);
    $BRM = self::BRM($VNO);
    $fuel_sales = $BRM * $SAL * $CON;
    $CML = self::CML($DDT,$VNO);
    $fuel_mileage = $CML * $CON;
    $FTP = 0;
    if($fuel_sales >= $fuel_mileage){
      $FTP = $fuel_sales;
    }else{      
      $FTP = $fuel_mileage;
    }
    $FTP = $FTP/10000;
    return $FTP;
  }

  //Cash collected Estimation Interval CCEI (min)
  public static function CCEI($SDT,$VNO){
    $sql = "SELECT * FROM tbl494";
    $result = DB::select(DB::raw($sql));
    $CCEI_a = $result[0]->CCEI_a;
    $CCEI_b = $result[0]->CCEI_b;
    $CCEI_Sxx = $result[0]->CCEI_Sxx;
    $CCEI_n = $result[0]->CCEI_n;
    $CCEI_taSe = $result[0]->CCEI_taSe;
    $EXPS = self::EXPS($SDT,$VNO);
    $Y = ($CCEI_a * $EXPS) + $CCEI_b;
    $CCEI = pow(($EXPS - $CCEI_b),2);
    $CCEI = $CCEI / $CCEI_Sxx;
    $CCEI = $CCEI_n + $CCEI;
    $CCEI = sqrt($CCEI);
    $CCEI = $CCEI_taSe * $CCEI;
    $CCEI = $Y - $CCEI;
    return round($CCEI,2);
  }

}
