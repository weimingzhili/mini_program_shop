-- 项目数据库结构

-- banner 表
CREATE TABLE banner (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  banner_name VARCHAR(60) NOT NULL COMMENT '名称',
  banner_description VARCHAR(255) NOT NULL DEFAULT '' COMMENT '描述',
  create_time INT UNSIGNED NOT NULL COMMENT '创建时间',
  update_time INT UNSIGNED default null COMMENT '更新时间',
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
  list_order int unsigned not null default 0 comment '排序标志',
  create_time INT UNSIGNED NOT NULL COMMENT '创建时间',
  update_time INT UNSIGNED default null COMMENT '更新时间',
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
  update_time INT UNSIGNED default null COMMENT '更新时间',
  delete_time INT UNSIGNED DEFAULT NULL COMMENT '删除标识',
  primary key (id)
) comment '图片表';

-- 专题表
create table topic (
  id int unsigned not null auto_increment,
  topic_name varchar(60) not null comment '名称',
  topic_description varchar(255) default '' comment '专题描述',
  list_order int unsigned not null default 0 comment '排序标志',
  create_time int unsigned not null comment '创建时间',
  update_time int unsigned default null comment '更新时间',
  delete_time int unsigned default null comment '删除标识',
  primary key (id)
) comment '专题表';

-- 专题图片关联表
create table topic_image (
  topic_id int unsigned not null comment '专题id',
  image_id int unsigned not null comment '图片id',
  image_type tinyint unsigned not null default 1 comment '图片类型，1：首页配图，2：详情头图',
  create_time int unsigned not null comment '创建时间',
  delete_time int unsigned default null comment '删除标识',
  primary key (topic_id, image_id)
) comment '专题图片关联表';

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
  goods_price int unsigned not null comment '价格',
  goods_stock int not null default 0 comment '库存',
  main_image_id int default null comment '主图id',
  main_image_url varchar(255) default '' comment '主图路径',
  image_source tinyint not null default 1 comment '主图来源，1：本地，2：外网',
  goods_summary varchar(255) not null default '' comment '摘要',
  list_order int unsigned not null default 0 comment '排序标志',
  create_time int unsigned not null comment '创建时间',
  update_time int unsigned default null comment '更新时间',
  delete_time int unsigned default null comment '删除标识',
  primary key (id)
) comment '商品表';

-- 商品属性表
create table goods_attribute (
  id int unsigned not null auto_increment,
  goods_id int unsigned not null comment '商品id',
  attribute_name varchar(30) not null comment '属性名称',
  attribute_content varchar(255) not null comment '属性内容',
  create_time int unsigned not null comment '创建时间',
  delete_time int unsigned default null comment '删除标识',
  update_time int unsigned default null comment '更新时间',
  primary key (id)
) comment '商品属性表';

-- 商品图片表
create table goods_image (
  id int unsigned not null auto_increment,
  goods_id int unsigned not null comment '商品id',
  image_id int unsigned not null comment '图片id',
  list_order int unsigned not null default 0 comment '排序标志',
  create_time int unsigned not null comment '创建时间',
  update_time int unsigned default null comment '更新时间',
  delete_time int unsigned default null comment '删除标识',
  primary key (id)
) comment '商品图片表';

-- 分类表
create table category (
  id int unsigned not null auto_increment,
  category_name varchar(60) not null comment '分类名称',
  image_id int unsigned not null comment '分类图片id',
  category_description varchar(255) default '' comment '描述',
  list_order int unsigned not null default 0 comment '排序标志',
  create_time int unsigned not null comment '创建时间',
  update_time int unsigned default null comment '更新时间',
  delete_time int unsigned default null comment '删除标识',
  primary key (id)
) comment '分类表';

-- 用户表
create table user (
  id int unsigned not null auto_increment,
  openid varchar(30) not null comment '小程序openid',
  nickname varchar(60) not null default '' comment '昵称',
  create_time int unsigned not null comment '创建时间',
  update_time int unsigned default null comment '更新时间',
  delete_time int unsigned default null comment '删除标识',
  primary key (id)
) comment '用户表';

-- 收货地址表
create table shipping_address (
  id int unsigned not null auto_increment,
  user_id int unsigned not null comment '用户id',
  consignee_name varchar(60) not null comment '收货人姓名',
  consignee_phone varchar(15) not null comment '收货人手机',
  province_name varchar(60) not null comment '省名称',
  province_code varchar(10) not null default '' comment '省编码',
  city_name varchar(60) not null comment '市名称',
  city_code varchar(10) not null default '' comment '市编码',
  area_name varchar(60) not null comment '区名称',
  area_code varchar(10) not null default '' comment '区编码',
  street_name varchar(60) not null default '' comment '街道名称',
  street_code varchar(10) not null default '' comment '街道编码',
  detailed_address varchar(255) not null comment '详细地址',
  address_type tinyint unsigned not null default 0 comment '类型，0：非默认，1：默认',
  create_time int unsigned not null comment '创建时间',
  update_time int unsigned default null comment '更新时间',
  delete_time int unsigned default null comment '删除标识',
  primary key (id)
) comment '收货地址表';

-- 应有设计
/*create table shipping_address (
  id int unsigned not null auto_increment,
  user_id int unsigned not null comment '用户id',
  consignee_name varchar(60) not null comment '收货人姓名',
  consignee_phone varchar(15) not null comment '收货人手机',
  province_name varchar(60) not null comment '省名称',
  province_code varchar(10) not null comment '省编码',
  city_name varchar(60) not null comment '市名称',
  city_code varchar(10) not null comment '市编码',
  area_name varchar(60) not null comment '区名称',
  area_code varchar(10) not null comment '区编码',
  street_name varchar(60) not null default '' comment '街道名称',
  street_code varchar(10) not null default '' comment '街道编码',
  detailed_address varchar(255) not null comment '详细地址',
  address_type tinyint unsigned not null default 0 comment '类型，0：非默认，1：默认',
  create_time int unsigned not null comment '创建时间',
  update_time int unsigned default null comment '更新时间',
  delete_time int unsigned default null comment '删除标识',
  primary key (id)
) comment '收货地址表';
*/
-- 订单表
create table orders (
  id int unsigned not null auto_increment,
  orders_number varchar(20) not null comment '订单号',
  user_id int unsigned not null comment '用户id',
  orders_goods_total int unsigned not null comment '商品总数',
  orders_total_price int unsigned not null comment '订单总价',
  shipping_address_id int unsigned not null comment '收货地址id',
  snapshot_consignee_name varchar(60) not null comment '收货人姓名快照',
  snapshot_consignee_phone varchar(15) not null comment '收货人手机快照',
  snapshot_shipping_address varchar(255) not null comment '收货地址快照',
  orders_state int unsigned not null default 1 comment '订单状态，1：未支付，2：已支付，3：已发货，4：已支付但库存不足',
  prepay_id varchar(128) not null default '' comment '预支付交易会话标识',
  payment_time int unsigned default null comment '支付时间',
  create_time int unsigned not null comment '创建时间',
  update_time int unsigned default null comment '更新时间',
  delete_time int unsigned default null comment '删除标识',
  primary key (id)
) comment '订单表';

-- 订单快照表
create table orders_snapshot (
  id int unsigned not null auto_increment,
  orders_id int unsigned not null comment '订单id',
  goods_id int unsigned not null comment '商品id',
  snapshot_goods_title varchar(128) not null comment '商品标题快照',
  snapshot_goods_price int unsigned not null comment '商品价格快照',
  snapshot_main_image varchar(255) default '' comment '商品主图快照',
  snapshot_goods_quantity int unsigned not null comment '商品数量快照',
  snapshot_total_price int unsigned not null comment '商品总价快照',
  create_time int unsigned not null comment '创建时间',
  update_time int unsigned default null comment '更新时间',
  delete_time int unsigned default null comment '删除标识',
  primary key (id)
) comment '订单快照表';