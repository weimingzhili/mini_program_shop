-- 项目数据库结构

-- banner 表
CREATE TABLE banner (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  banner_name VARCHAR(60) NOT NULL COMMENT '名称',
  banner_description VARCHAR(255) NOT NULL DEFAULT '' COMMENT '描述',
  create_time INT UNSIGNED NOT NULL COMMENT '创建时间',
  update_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  delete_time INT UNSIGNED DEFAULT NULL COMMENT '删除标识',
  PRIMARY KEY (id)
) COMMENT 'banner表';

-- banner 子项表
CREATE TABLE banner_item (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  banner_id INT UNSIGNED NOT NULL COMMENT 'banner表id',
  image_id INT UNSIGNED NOT NULL COMMENT 'image表id',
  key_word varchar(100) NOT NULL COMMENT '执行关键字，根据不同的type含义不同',
  type TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT '跳转类型，0：无导向；1：导向商品；2：导向专题',
  create_time INT UNSIGNED NOT NULL COMMENT '创建时间',
  update_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  delete_time INT UNSIGNED DEFAULT NULL COMMENT '删除标识',
  PRIMARY KEY (id),
  KEY (banner_id),
  KEY (image_id)
) COMMENT 'banner子项表';

-- 图片表
create table image (
  id int unsigned not null auto_increment,
  image_url varchar(255) not null comment '图片路径',
  image_source tinyint unsigned not null default 1 comment '图片来源，1：本地，2：外网',
  create_time INT UNSIGNED NOT NULL COMMENT '创建时间',
  update_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  delete_time INT UNSIGNED DEFAULT NULL COMMENT '删除标识',
  primary key (id)
) comment '图片表';

-- 专题表
create table topic (
  id int unsigned not null auto_increment,
  topic_name varchar(60) not null comment '名称',
  topic_description varchar(255) default '' comment '专题描述',
  topic_image_id int unsigned not null comment '配图',
  top_image_id int unsigned not null comment '头图',
  create_time int unsigned not null comment '创建时间',
  update_time int unsigned default null comment '更新时间',
  delete_time int unsigned default null comment '删除标识',
  primary key (id)
) comment '专题表';

-- 专题商品关联表
create table topic_goods (
  topic_id int unsigned not null comment '专题id',
  goods_id int unsigned not null comment '商品id',
  create_time int unsigned not null comment '创建时间',
  delete_time int unsigned default null comment '删除标识',
  primary key (topic_id, goods_id)
) comment '专题商品关联表';

-- 商品表
create table goods (
  id int unsigned not null auto_increment,
  goods_title varchar(128) not null comment '标题',
  category_id int not null comment '分类id',
  goods_price decimal(10,2) not null comment '价格',
  goods_stock int not null default 0 comment '库存',
  main_image_id int default null comment '主图id',
  main_image_url varchar(255) default '' comment '主图路径',
  main_image_source tinyint not null default 1 comment '主图来源，1：本地，2：外网',
  goods_summary varchar(255) not null default '' comment '摘要',
  create_time int unsigned not null comment '创建时间',
  update_time int unsigned default null comment '更新时间',
  delete_time int unsigned default null comment '删除标识',
  primary key (id)
) comment '商品表';