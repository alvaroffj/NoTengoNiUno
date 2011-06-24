/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     15-02-2011 22:21:47                          */
/*==============================================================*/


drop table if exists CATEGORIA;

drop table if exists NIVEL_ACCESO;

drop table if exists PROYECTO;

drop table if exists REGISTRO;

drop table if exists REGISTRO_TAG;

drop table if exists TAG;

drop table if exists TIPO_MONEDA;

drop table if exists TIPO_REGISTRO;

drop table if exists USUARIO;

drop table if exists USUARIO_PROYECTO;

/*==============================================================*/
/* Table: CATEGORIA                                             */
/*==============================================================*/
create table CATEGORIA
(
   ID_CATEGORIA         int not null auto_increment,
   ID_PROYECTO          int not null,
   CATEGORIA            varchar(100),
   COLOR_CATEGORIA      varchar(6),
   ESTADO_CATEGORIA     smallint,
   primary key (ID_CATEGORIA)
);

/*==============================================================*/
/* Table: NIVEL_ACCESO                                          */
/*==============================================================*/
create table NIVEL_ACCESO
(
   ID_NIVEL_ACCESO      int not null auto_increment,
   NOM_NIVEL_ACCESO     varchar(50),
   primary key (ID_NIVEL_ACCESO)
);

/*==============================================================*/
/* Table: PROYECTO                                              */
/*==============================================================*/
create table PROYECTO
(
   ID_PROYECTO          int not null auto_increment,
   ID_TIPO_MONEDA       int not null,
   NOM_PROYECTO         varchar(100),
   DESC_PROYECTO        text,
   ESTADO_PROYECTO      smallint,
   primary key (ID_PROYECTO)
);

/*==============================================================*/
/* Table: REGISTRO                                              */
/*==============================================================*/
create table REGISTRO
(
   ID_REGISTRO          int not null auto_increment,
   ID_TIPO_REGISTRO     int not null,
   ID_CATEGORIA         int not null,
   ID_PROYECTO          int not null,
   MONTO_REGISTRO       numeric(8,0),
   FECHA_REGISTRO       date,
   DESC_REGISTRO        varchar(200),
   ESTADO_REGISTRO      smallint,
   primary key (ID_REGISTRO)
);

/*==============================================================*/
/* Table: REGISTRO_TAG                                          */
/*==============================================================*/
create table REGISTRO_TAG
(
   ID_REGISTRO_TAG      int not null auto_increment,
   ID_TAG               int not null,
   ID_REGISTRO          int not null,
   primary key (ID_REGISTRO_TAG)
);

/*==============================================================*/
/* Table: TAG                                                   */
/*==============================================================*/
create table TAG
(
   ID_TAG               int not null auto_increment,
   ID_USUARIO           int not null,
   TAG                  varchar(100),
   primary key (ID_TAG)
);

/*==============================================================*/
/* Table: TIPO_MONEDA                                           */
/*==============================================================*/
create table TIPO_MONEDA
(
   ID_TIPO_MONEDA       int not null auto_increment,
   TIPO_MONEDA          varchar(20),
   SIMBOLO_MONEDA       varchar(10),
   ESTADO_TIPO_MONEDA   smallint,
   primary key (ID_TIPO_MONEDA)
);

/*==============================================================*/
/* Table: TIPO_REGISTRO                                         */
/*==============================================================*/
create table TIPO_REGISTRO
(
   ID_TIPO_REGISTRO     int not null auto_increment,
   TIPO_REGISTRO        varchar(20),
   ESTADO_TIPO_REGISTRO smallint,
   primary key (ID_TIPO_REGISTRO)
);

/*==============================================================*/
/* Table: USUARIO                                               */
/*==============================================================*/
create table USUARIO
(
   ID_USUARIO           int not null auto_increment,
   FECHA_SIGN           datetime,
   NOM_USUARIO          varchar(100),
   APE_USUARIO          varchar(100),
   EMA_USUARIO          varchar(200),
   FB_ACCESS_TOKEN      varchar(200),
   FB_SECRET            varchar(200),
   FB_SESSION_KEY       varchar(200),
   FB_SIG               varchar(200),
   FB_UID               varchar(200),
   primary key (ID_USUARIO)
);

/*==============================================================*/
/* Table: USUARIO_PROYECTO                                      */
/*==============================================================*/
create table USUARIO_PROYECTO
(
   ID_USUARIO_PROYECTO  int not null auto_increment,
   ID_USUARIO           int not null,
   ID_PROYECTO          int not null,
   ID_NIVEL_ACCESO      int not null,
   primary key (ID_USUARIO_PROYECTO)
);

alter table CATEGORIA add constraint FK_FK_RELATIONSHIP_8 foreign key (ID_PROYECTO)
      references PROYECTO (ID_PROYECTO) on delete restrict on update restrict;

alter table PROYECTO add constraint FK_RELATIONSHIP_12 foreign key (ID_TIPO_MONEDA)
      references TIPO_MONEDA (ID_TIPO_MONEDA) on delete restrict on update restrict;

alter table REGISTRO add constraint FK_FK_RELATIONSHIP_10 foreign key (ID_TIPO_REGISTRO)
      references TIPO_REGISTRO (ID_TIPO_REGISTRO) on delete restrict on update restrict;

alter table REGISTRO add constraint FK_FK_RELATIONSHIP_11 foreign key (ID_CATEGORIA)
      references CATEGORIA (ID_CATEGORIA) on delete restrict on update restrict;

alter table REGISTRO add constraint FK_FK_RELATIONSHIP_3 foreign key (ID_PROYECTO)
      references PROYECTO (ID_PROYECTO) on delete restrict on update restrict;

alter table REGISTRO_TAG add constraint FK_FK_RELATIONSHIP_6 foreign key (ID_REGISTRO)
      references REGISTRO (ID_REGISTRO) on delete restrict on update restrict;

alter table REGISTRO_TAG add constraint FK_FK_RELATIONSHIP_7 foreign key (ID_TAG)
      references TAG (ID_TAG) on delete restrict on update restrict;

alter table TAG add constraint FK_FK_RELATIONSHIP_9 foreign key (ID_USUARIO)
      references USUARIO (ID_USUARIO) on delete restrict on update restrict;

alter table USUARIO_PROYECTO add constraint FK_RELATIONSHIP_10 foreign key (ID_USUARIO)
      references USUARIO (ID_USUARIO) on delete restrict on update restrict;

alter table USUARIO_PROYECTO add constraint FK_RELATIONSHIP_11 foreign key (ID_NIVEL_ACCESO)
      references NIVEL_ACCESO (ID_NIVEL_ACCESO) on delete restrict on update restrict;

alter table USUARIO_PROYECTO add constraint FK_RELATIONSHIP_9 foreign key (ID_PROYECTO)
      references PROYECTO (ID_PROYECTO) on delete restrict on update restrict;

