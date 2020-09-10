/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  08/09/2020 14:41:01                      */
/*==============================================================*/
USE sgpc;

drop table if exists tracability;
drop table if exists `user`;
drop table if exists productBySupplier;
drop table if exists storageCard;
drop table if exists shelvingUnit;
drop table if exists productByType;
drop table if exists productByDangerSymbol;
drop table if exists productByDangerNote;
drop table if exists productByCautionaryAdvice;
drop table if exists cupboard;
drop table if exists stock;
drop table if exists chimicalProduct;
drop table if exists ACL;
drop table if exists `type`;
drop table if exists supplier;
drop table if exists `status`;
drop table if exists `site`;
drop table if exists property;
drop table if exists privilege;
drop table if exists document;
drop table if exists dangerSymbol;
drop table if exists dangerNote;
drop table if exists cautionaryAdvice;

/*==============================================================*/
/* Table : cautionaryAdvice                                     */
/*==============================================================*/
create table cautionaryAdvice
(
   id_cautionaryAdvice      serial,
   name_cautionaryAdvice    varchar(50) not null,
   sentenceCautionaryAdvice varchar(500) not null,
   primary key (id_cautionaryAdvice)
);
/*==============================================================*/
/* Table : dangerNote                                           */
/*==============================================================*/
create table dangerNote
(
   id_dangerNote         serial,
   name_dangerNote       varchar(50) not null,
   sentenceDangerNote    varchar(500) not null,
   primary key (id_dangerNote)
);

/*==============================================================*/
/* Table : dangerSymbol                                         */
/*==============================================================*/
create table dangerSymbol
(
   id_dangerSymbol       serial,
   name_dangerSymbol     varchar(50) not null,
   icon                  longblob not null,
   primary key (id_dangerSymbol)
);

/*==============================================================*/
/* Table : document                                             */
/*==============================================================*/
create table document
(
   id_document           serial,
   name_document         varchar(250) not null,
   DATA                  text not null,
   primary key (id_document)
);

/*==============================================================*/
/* Table : privilege                                            */
/*==============================================================*/
create table privilege
(
   id_privilege          serial,
   keyPrivilege          varchar(50) not null,
   primary key (id_privilege)
);

/*==============================================================*/
/* Table : property                                             */
/*==============================================================*/
create table property
(
   id_property           serial,
   name_property         varchar(250) not null,
   primary key (id_property)
);

/*==============================================================*/
/* Table : site                                                 */
/*==============================================================*/
create table site
(
   id_site               serial,
   name_site             varchar(50) not null,
   fullnameSupervisor    varchar(250) not null,
   phoneNumber           char(10) not null,
   primary key (id_site)
);

/*==============================================================*/
/* Table : status                                               */
/*==============================================================*/
create table `status`
(
   id_status             serial,
   name_status           varchar(50) not null,
   primary key (id_status)
);

/*==============================================================*/
/* Table : supplier                                             */
/*==============================================================*/
create table supplier
(
   id_supplier           serial,
   name_supplier         varchar(250) not null,
   primary key (id_supplier)
);

/*==============================================================*/
/* Table : type                                                 */
/*==============================================================*/
create table `type`
(
   id_type               serial,
   name_type             varchar(50) not null,
   primary key (id_type)
);

/*==============================================================*/
/* Table : ACL                                                  */
/*==============================================================*/
create table ACL
(
   id_status             BIGINT UNSIGNED NOT NULL,
   id_privilege          BIGINT UNSIGNED NOT NULL,
   primary key (id_status, id_privilege)
);
alter table ACL add constraint FK_ACL_status foreign key (id_status)
      references `status` (id_status) on delete restrict on update restrict;

alter table ACL add constraint FK_ACL_privilege foreign key (id_privilege)
      references privilege (id_privilege) on delete restrict on update restrict;

/*==============================================================*/
/* Table : chimicalProduct                                      */
/*==============================================================*/
create table chimicalProduct
(
   id_chimicalProduct    serial,
   id_document           BIGINT UNSIGNED NOT NULL,
   name_chimicalProduct  varchar(250) not null,
   formula               varchar(250),
   purity                varchar(50),
   CASNumber             varchar(25),
   isCMR                 bool not null,
   primary key (id_chimicalProduct)
);
alter table chimicalProduct add constraint FK_chimicalProduct_document foreign key (id_document)
      references document (id_document) on delete restrict on update restrict;

/*==============================================================*/
/* Table : stock                                                */
/*==============================================================*/
create table stock
(
   id_stock              serial,
   id_site               BIGINT UNSIGNED NOT NULL,
   name_stock            varchar(100) not null,
   primary key (id_stock)
);
alter table stock add constraint FK_stock_site foreign key (id_site)
      references site (id_site) on delete restrict on update restrict;
      
/*==============================================================*/
/* Table : cupboard                                             */
/*==============================================================*/
create table cupboard
(
   id_cupboard           serial,
   id_stock              BIGINT UNSIGNED NOT NULL,
   name_cupboard         varchar(100) not null,
   primary key (id_cupboard)
);
alter table cupboard add constraint FK_cupboard_stock foreign key (id_stock)
      references stock (id_stock) on delete restrict on update restrict;
      
/*==============================================================*/
/* Table : productByCautionaryAdvice                            */
/*==============================================================*/
create table productByCautionaryAdvice
(
   id_chimicalProduct    BIGINT UNSIGNED NOT NULL,
   id_cautionaryAdvice   BIGINT UNSIGNED NOT NULL,
   primary key (id_chimicalProduct, id_cautionaryAdvice)
);
alter table productByCautionaryAdvice add constraint FK_productByCautionaryAdvice_chimicalProduct foreign key (id_chimicalProduct)
      references chimicalProduct (id_chimicalProduct) on delete restrict on update restrict;

alter table productByCautionaryAdvice add constraint FK_productByCautionaryAdvice_cautionaryAdvice foreign key (id_cautionaryAdvice)
      references cautionaryAdvice (id_cautionaryAdvice) on delete restrict on update restrict;

/*==============================================================*/
/* Table : productByDangerNote                                  */
/*==============================================================*/
create table productByDangerNote
(
   id_chimicalProduct    BIGINT UNSIGNED NOT NULL,
   id_dangerNote         BIGINT UNSIGNED NOT NULL,
   primary key (id_chimicalProduct, id_dangerNote)
);
alter table productByDangerNote add constraint FK_productByDangerNote_chimicalProduct foreign key (id_chimicalProduct)
      references chimicalProduct (id_chimicalProduct) on delete restrict on update restrict;

alter table productByDangerNote add constraint FK_productByDangerNote_dangerNote foreign key (id_dangerNote)
      references dangerNote (id_dangerNote) on delete restrict on update restrict;

/*==============================================================*/
/* Table : productByDangerSymbol                                */
/*==============================================================*/
create table productByDangerSymbol
(
   id_chimicalProduct    BIGINT UNSIGNED NOT NULL,
   id_dangerSymbol       BIGINT UNSIGNED NOT NULL,
   primary key (id_chimicalProduct, id_dangerSymbol)
);
alter table productByDangerSymbol add constraint FK_productByDangerSymbol_chimicalProduct foreign key (id_chimicalProduct)
      references chimicalProduct (id_chimicalProduct) on delete restrict on update restrict;

alter table productByDangerSymbol add constraint FK_productByDangerSymbol_dangerSymbol foreign key (id_dangerSymbol)
      references dangerSymbol (id_dangerSymbol) on delete restrict on update restrict;
      
/*==============================================================*/
/* Table : productByType                                        */
/*==============================================================*/
create table productByType
(
   id_chimicalProduct    BIGINT UNSIGNED NOT NULL,
   id_type               BIGINT UNSIGNED NOT NULL,
   primary key (id_chimicalProduct, id_type)
);
alter table productByType add constraint FK_productByType_chimicalProduct foreign key (id_chimicalProduct)
      references chimicalProduct (id_chimicalProduct) on delete restrict on update restrict;

alter table productByType add constraint FK_productByType_type foreign key (id_type)
      references `type` (id_type) on delete restrict on update restrict;

/*==============================================================*/
/* Table : shelvingUnit                                         */
/*==============================================================*/
create table shelvingUnit
(
   id_shelvingUnit       serial,
   id_cupboard           BIGINT UNSIGNED NOT NULL,
   name_shelvingUnit     varchar(100) not null,
   primary key (id_shelvingUnit)
);
alter table shelvingUnit add constraint FK_shelvingUnit_cupboard foreign key (id_cupboard)
      references cupboard (id_cupboard) on delete restrict on update restrict;
      
/*==============================================================*/
/* Table : storageCard                                          */
/*==============================================================*/
create table storageCard
(
   id_storageCard        serial,
   id_shelvingUnit       BIGINT UNSIGNED NOT NULL,
   id_chimicalProduct    BIGINT UNSIGNED NOT NULL,
   id_property           BIGINT UNSIGNED NOT NULL,
   stockQuantity         BIGINT UNSIGNED NOT NULL,
   capacity              BIGINT UNSIGNED NOT NULL,
   serialNumber          varchar(50),
   openDate              date,
   expirationDate        date,
   isArchived            bool not null,
   primary key (id_storageCard)
);
alter table storageCard add constraint FK_storageCard_property foreign key (id_property)
      references property (id_property) on delete restrict on update restrict;

alter table storageCard add constraint FK_storageCard_chimicalProduct foreign key (id_chimicalProduct)
      references chimicalProduct (id_chimicalProduct) on delete restrict on update restrict;

alter table storageCard add constraint FK_storageCard_shelvingUnit foreign key (id_shelvingUnit)
      references shelvingUnit (id_shelvingUnit) on delete restrict on update restrict;
      
/*==============================================================*/
/* Table : productBySupplier                                    */
/*==============================================================*/
create table productBySupplier
(
   id_supplier            BIGINT UNSIGNED NOT NULL,
   id_storageCard         BIGINT UNSIGNED NOT NULL,
   `reference`            varchar(100),
   primary key (id_supplier, id_storageCard)
);
alter table productBySupplier add constraint FK_productBySupplier_supplier foreign key (id_supplier)
      references supplier (id_supplier) on delete restrict on update restrict;

alter table productBySupplier add constraint FK_productBySupplier_storageCard foreign key (id_storageCard)
      references storageCard (id_storageCard) on delete restrict on update restrict;
      
/*==============================================================*/
/* Table : user                                                 */
/*==============================================================*/
create table `user`
(
   id_user                serial,
   id_status              BIGINT UNSIGNED NOT NULL,
   `login`                varchar(250) not null,
   fullName               varchar(250) not null,
   mail                   varchar(250) not null,
   `password`             varchar(250) not null,
   endRightDate           date,
   primary key (id_user)
);
alter table `user` add constraint FK_user_status foreign key (id_status)
      references `status` (id_status) on delete restrict on update restrict;

/*==============================================================*/
/* Table : tracability                                          */
/*==============================================================*/
create table tracability
(
   id_user               BIGINT UNSIGNED NOT NULL,
   id_storageCard        BIGINT UNSIGNED NOT NULL,
   retireDate            date not null,
   retireQuantity        int not null,
   primary key (id_user, id_storageCard)
);
alter table tracability add constraint FK_tracability_user foreign key (id_user)
      references `user` (id_user) on delete restrict on update restrict;

alter table tracability add constraint FK_tracability_storageCard foreign key (id_storageCard)
      references storageCard (id_storageCard) on delete restrict on update restrict;