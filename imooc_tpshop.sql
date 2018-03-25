-- 项目数据库结构

-- banner 表
CREATE TABLE banner (
  banner_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  banner_name VARCHAR(60) NOT NULL COMMENT '名称',
  banner_description VARCHAR(255) NOT NULL DEFAULT '' COMMENT '描述',
  create_time INT UNSIGNED NOT NULL COMMENT '创建时间',
  update_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  delete_time INT UNSIGNED DEFAULT NULL COMMENT '删除标识',
  PRIMARY KEY (banner_id)
) COMMENT 'banner表';

-- banner 子项表
CREATE TABLE banner_item (
  banner_item_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  banner_id INT UNSIGNED NOT NULL COMMENT 'banner表id',
  image_id INT UNSIGNED NOT NULL COMMENT 'image表id',
  key_word varchar(100) NOT NULL COMMENT '执行关键字，根据不同的type含义不同',
  type TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT '跳转类型，0：无导向；1：导向商品；2：导向专题',
  create_time INT UNSIGNED NOT NULL COMMENT '创建时间',
  update_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  delete_time INT UNSIGNED DEFAULT NULL COMMENT '删除标识',
  PRIMARY KEY (banner_item_id),
  KEY (banner_id),
  KEY (image_id)
) COMMENT 'banner子项表';

