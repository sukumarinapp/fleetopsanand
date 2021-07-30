 update tbl361 set RML=1.14,RMN=.35,RMS=4,RHT='N/A';

  
ALTER TABLE `driver_platform` CHANGE `PLF` `PLF` INT(11) NULL DEFAULT NULL;
alter table driver add WDY int(1) null default 1 after VPF;
alter table driver add MDY int(2) null default 1 after WDY;

alter table tbl136 drop CHR;
alter table tbl137 drop RTN;

alter table tbl137 add RTN varchar(50) DEFAULT NULl after WDY;

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
