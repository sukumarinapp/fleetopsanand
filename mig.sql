DROP TABLE tbl136;
RENAME TABLE tbl135 TO tbl136;
alter table tbl136 add DES varchar(20) DEFAULT NULL after CML;
alter table tbl136 add DECL tinyint(1) DEFAULT 0 after DES;
update tbl136 set DES='A0',DECL=0;

alter table tbl137 add TIM varchar(20) DEFAULT NULL after RTN;	