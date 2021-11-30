alter table alarm add resolved tinyint(1) DEFAULT 0 after packet;
alter table alarm add resolved_time DATETIME DEFAULT NULL after resolved;
alter table alarm add resolved_by varchar(20) DEFAULT NULL after resolved_time;

alter table current_location modify odometer decimal(12,3);

 insert into current_location (terminal_id,capture_date,capture_datetime,capture_time,latitude,longitude,ground_speed,odometer,direction,engine_on) values ('233500623977','2021-11-28','2021-11-28 00:00:08','000008.000','5.569616666666667','-0.16900333333333334','0.00','41775.977','212.36','0');

select * from current_location where terminal_id='233500623977' group by capture_datetime order by  capture_datetime desc LIMIT 3;

SELECT * FROM current_location A where terminal_id='233500623977' and 2 = (SELECT count(1)   FROM current_location B WHERE B.capture_datetime>A.capture_datetime);

DROP TABLE `tracker_status`;

CREATE TABLE `tracker_status` (
  id int(11) NOT NULL AUTO_INCREMENT,
  TID varchar(20) DEFAULT NULL,
  latitude varchar(50) DEFAULT NULL,
  longitude varchar(50) DEFAULT NULL,
  off_time DATETIME DEFAULT NULL,
  on_time DATETIME DEFAULT NULL,
  status tinyint(1) DEFAULT 0,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


alter table tbl136 add block_off_time DATETIME DEFAULT NULL after alarm_off_time;


DROP TABLE `sales_audit` ;

CREATE TABLE `sales_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ADT` date DEFAULT NULL,
  DCR int(11) DEFAULT 0,
  RHN int(11) DEFAULT 0,
  RHV int(11) DEFAULT 0,
  `SPF` decimal(10,2) DEFAULT NULL,
  `CPF` decimal(10,2) DEFAULT NULL,
  `TPF` int(11) DEFAULT NULL,
`TIM` DATETIME DEFAULT NULL,  
`USR` varchar(20) DEFAULT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

drop TABLE `alarm` ;
CREATE TABLE `alarm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alert_time` varchar(50) DEFAULT NULL,
  `terminal_id` varchar(50) DEFAULT NULL,
  `command` varchar(20) DEFAULT NULL,
  `alert` varchar(2000) DEFAULT NULL,
  `packet` varchar(5000) DEFAULT NULL,
  PRIMARY KEY(id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `sms_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PHN` varchar(20) DEFAULT NULL,
  `MSG` varchar(2000) DEFAULT NULL,
  `DAT` date DEFAULT NULL,
  `TIM` varchar(10) DEFAULT NULL,
  `NAM` varchar(50) DEFAULT NULL,
  `CTX` varchar(50) DEFAULT NULL,
  `STA` varchar(20) DEFAULT NULL,
  id PR
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE sms_log;
CREATE TABLE sms_log (
    id int(11) NOT NULL AUTO_INCREMENT,
    PHN varchar(20) DEFAULT NULL,
    MSG varchar(2000) DEFAULT NULL,
    DAT date DEFAULT NULL,
    TIM varchar(10) DEFAULT NULL,
    `NAM` varchar(50) DEFAULT NULL,
    CTX varchar(50) DEFAULT NULL,
    STA varchar(20) DEFAULT NULL,
    PRIMARY KEY(id)
  ) ENGINE=InnoDB;


select id,parent_id,UAN,usertype,email from users where UTV=1 order by parent_id;


select * from tbl137 a,vehicle b where a.VNO=b.VNO and RST=0 and attempts <= 3;


select concat(capture_date," ",concat(concat(substring(capture_time,1,2),":",substring(capture_time,3,2)),":",substring(capture_time,5,2))) as a,capture_time from current_location limit 2;

alter table current_location add capture_datetime DATETIME DEFAULT NULL after capture_date;
update current_location set capture_datetime=concat(capture_date," ",concat(concat(substring(capture_time,1,2),":",substring(capture_time,3,2)),":",substring(capture_time,5,2)));
select capture_date,capture_datetime,capture_time from current_location order by id desc limit 10;


 
alter table tbl136 add CRS int(11) DEFAULT 0 after DNW;

alter table tbl136 add attempts int(11) DEFAULT 0 after driver_id;

alter table tbl137 add TIM4 varchar(20) DEFAULT NULL after TIM3;
alter table tbl137 add TIM5 varchar(20) DEFAULT NULL after TIM4;

alter table users add CBK varchar(50) DEFAULT NULL after CMB;

select id,name,CZN,CMT,CMA,CMN,CMB,CBK from users where usertype='client';

select id,name,CMT,CMA,CMN,CMB,CBK from users;

  CREATE TABLE sales_rh (
    id int(11) NOT NULL AUTO_INCREMENT,
    DCR int(11) DEFAULT 0,
    SDT date DEFAULT NULL,
    CAN varchar(20) DEFAULT NULL,
    VNO varchar(20) DEFAULT NULL,
    RHN int(11) DEFAULT 0,
    EXPS decimal(10,2) DEFAULT NULL,
    CCEI decimal(10,2) DEFAULT NULL,
    PRIMARY KEY(id)
  ) ENGINE=InnoDB;

  CREATE TABLE sales_rental (
    id int(11) NOT NULL AUTO_INCREMENT,
    DCR int(11) DEFAULT 0,
    SDT date DEFAULT NULL,
    CAN varchar(20) DEFAULT NULL,
    VNO varchar(20) DEFAULT NULL,
    SSA decimal(10,2) DEFAULT NULL,
    PRIMARY KEY(id)
  ) ENGINE=InnoDB;





drop TABLE vehicle_log;
CREATE TABLE vehicle_log (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  CAN varchar(20) DEFAULT NULL,
  VNO varchar(20) DEFAULT NULL,
  `DID` int(11) DEFAULT 0,
  ATN varchar(20)  DEFAULT NULL,
  UAN varchar(50) DEFAULT NULL,
  `TIM` varchar(20) DEFAULT NULL,
   PRIMARY KEY(id)
) ENGINE=InnoDB;

alter table tbl140 add WCI varchar(20) DEFAULT NULL after WST;
alter table tbl024 add DCR int(11) DEFAULT 0 after id;
CREATE TABLE tbl140 (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  DCR int(11) DEFAULT 0,
  `WST` date DEFAULT NULL,
  WCI varchar(50) DEFAULT NULL,
  `UAN` varchar(20) DEFAULT NULL,
  `CAN` varchar(20) DEFAULT NULL,
  `VNO` varchar(20) DEFAULT NULL,
  `WNB` varchar(20) DEFAULT NULL,
  `WTP` varchar(50) DEFAULT NULL,
  `WCD` date DEFAULT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE vehicle_log (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  CAN varchar(20) DEFAULT NULL,
  VNO varchar(20) DEFAULT NULL,
  `DNM` varchar(20) DEFAULT NULL,
  UAN varchar(20) DEFAULT NULL,
  `TIM` varchar(20) DEFAULT NULL,
   PRIMARY KEY(id)
) ENGINE=InnoDB;

 Workflow Case Open Date/Time
UAN User Account No.
CAN Client Account No.
VNO Vehicle Reg. No.
WCI Case Initiator (UAN, CAN, DNM or P-CS System)
WNB Workflow Number
WNM Workflow Title
WSM Stage Manager
WCD Workflow Case Close Date/Time



__________________________________________________________________
alter table tbl136 add VBM varchar(20) DEFAULT NULl after DECL;
alter table tbl136 add driver_id int(11) DEFAULT 0 after VBM;

select * from tbl135;
select * from tbl136;
select * from tbl137;
select * from tbl141;
select * from tbl138;

DROP TABLE `tbl135`;
CREATE TABLE `tbl135` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `DDT` date DEFAULT NULL,
  `CAN` varchar(20) DEFAULT NULL,
  `VNO` varchar(20) DEFAULT NULL,
  `CHR` decimal(10,2) DEFAULT NULL,
  `CML` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB;


DROP TABLE `tbl136`;
CREATE TABLE `tbl136` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `DDT` date DEFAULT NULL,
  `CAN` varchar(20) DEFAULT NULL,
  `VNO` varchar(20) DEFAULT NULL,
  `DES` varchar(20) DEFAULT NULL,
  `DECL` tinyint(1) DEFAULT 0,
  PRIMARY KEY(id)
) ENGINE=InnoDB;

DROP TABLE `tbl137`;
CREATE TABLE `tbl137` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `DCR` int(11) NOT NULL,
  `SDT` date DEFAULT NULL,
  `CAN` varchar(20) DEFAULT NULL,
  `VNO` varchar(20) DEFAULT NULL,
  `RCN` varchar(20) DEFAULT NULL,
  `RHN` int(11) DEFAULT NULL,
  `SPF` decimal(10,2) DEFAULT NULL,
  `CPF` decimal(10,2) DEFAULT NULL,
  `TPF` int(11) DEFAULT NULL,
  `SSR` varchar(20) DEFAULT NULL,
  RTN varchar(50) DEFAULT NULL,  
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE `tbl141`;
CREATE TABLE `tbl141` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `DCR` int(11) NOT NULL,
  `SDT` date DEFAULT NULL,
  `CAN` varchar(20) DEFAULT NULL,
  `VNO` varchar(20) DEFAULT NULL,
  `RCN` varchar(20) DEFAULT NULL,
  `SSA` decimal(10,2) DEFAULT 0.00,
  `SSR` varchar(20) DEFAULT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE `tbl138`;
CREATE TABLE `tbl138` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `RDT` date DEFAULT NULL,
  `DCR` int(11) NOT NULL,
  `CAN` varchar(20) DEFAULT NULL,
  `VNO` varchar(20) DEFAULT NULL,
  `RCN` varchar(20) DEFAULT NULL,
  `RMT` decimal(10,2) DEFAULT NULL,
  `ROI` varchar(50) DEFAULT NULL,
   RST tinyint(1) DEFAULT 0,
  `SSR` varchar(20) DEFAULT NULL,
   RTN varchar(50) DEFAULT NULL,  
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
