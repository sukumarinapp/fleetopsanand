$('#example1').DataTable( {
        initComplete: function() {
           $('.buttons-excel').html('<i class="fa fa-file-excel" style="color:green"/>')
           $('.buttons-pdf').html('<i class="fa fa-file-pdf" style="color:red"/>')
           $('.buttons-print').html('<i class="fa fa-print" style="color:#0d5b9e"/>')
        },
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print','colvis','pageLength'
        ]
    } );

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

alter table vehicle_log add LDT date DEFAULT NULL after id;

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
