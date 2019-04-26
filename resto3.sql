/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50718
 Source Host           : 127.0.0.1
 Source Database       : resto3

 Target Server Type    : MySQL
 Target Server Version : 50718
 File Encoding         : utf-8

 Date: 04/26/2019 15:35:08 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `brands`
-- ----------------------------
DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `brand_name` (`name`,`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `brands`
-- ----------------------------
BEGIN;
INSERT INTO `brands` VALUES ('5', 'Dell', '1'), ('3', 'LG', '1'), ('4', 'Nationals', '1'), ('1', 'Philips', '1'), ('2', 'Samsungs', '1');
COMMIT;

-- ----------------------------
--  Table structure for `category`
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `category`
-- ----------------------------
BEGIN;
INSERT INTO `category` VALUES ('1', 'Meals', '1'), ('2', 'Drinks', '1'), ('3', 'Add Ons', '1'), ('4', 'Ala Carte', '1');
COMMIT;

-- ----------------------------
--  Table structure for `company`
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `service_charge_value` varchar(255) NOT NULL,
  `vat_charge_value` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `currency` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `company`
-- ----------------------------
BEGIN;
INSERT INTO `company` VALUES ('1', 'Maciang\'s Tapsi House', '', '0', '3655-A Heneral Luna St Bangkal Makati City', '25196198', 'Philippines', 'Home of the best tapsilog in town.', 'PHP');
COMMIT;

-- ----------------------------
--  Table structure for `customers`
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) DEFAULT NULL,
  `cs_id` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `cs_name_stat` (`customer_name`,`cs_id`,`is_status`),
  KEY `csid_stat` (`is_status`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `customers`
-- ----------------------------
BEGIN;
INSERT INTO `customers` VALUES ('1', 'San Miguel Corporation', 'CS-00000000001', '25 Main Street Pandacan Manila  Philippine\'s', 'Samboy Limpot', 'samboy@gmail.com', '1'), ('3', 'Manila Bulletin', 'CS-00000000003', '1256 Paco Manila Philippines', 'Ted Bumagit', 'ted.bumagit@gmail.com', '1'), ('4', 'Pagcor', 'CS-00000000004', '1234 Gen Luna St Quezon City Philippines', 'Marco Luna', 'marc.luna@gmail.com', '0'), ('5', 'tsgtsdgd', 'CS-00000000005', 'sdfsdfd', 'sdfdf', 'sdfsdf@fsdfd.com', '0'), ('6', 'San Miguel Corporation', 'CS-00000000006', '4681 Cuangco Street Pio Del Pilar', 'Andrew Pe', 'andrew.pe@gmail.com', '1'), ('7', 'San Miguel Corporation2', 'CS-00000000007', '4681 Cuangco Street Pio Del Pilar', 'Andrew Pe', 'andrew.pe@gmail.com', '1');
COMMIT;

-- ----------------------------
--  Table structure for `groups`
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  `permission` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `groups`
-- ----------------------------
BEGIN;
INSERT INTO `groups` VALUES ('1', 'Super Administrator', 'a:48:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:13:\"createProduct\";i:9;s:13:\"updateProduct\";i:10;s:11:\"viewProduct\";i:11;s:13:\"deleteProduct\";i:12;s:10:\"createCost\";i:13;s:10:\"updateCost\";i:14;s:8:\"viewCost\";i:15;s:10:\"deleteCost\";i:16;s:10:\"createSale\";i:17;s:10:\"updateSale\";i:18;s:8:\"viewSale\";i:19;s:10:\"deleteSale\";i:20;s:15:\"createWarehouse\";i:21;s:15:\"updateWarehouse\";i:22;s:13:\"viewWarehouse\";i:23;s:15:\"deleteWarehouse\";i:24;s:14:\"createDelivery\";i:25;s:14:\"updateDelivery\";i:26;s:12:\"viewDelivery\";i:27;s:14:\"deleteDelivery\";i:28;s:12:\"createPickup\";i:29;s:12:\"updatePickup\";i:30;s:10:\"viewPickup\";i:31;s:12:\"deletePickup\";i:32;s:14:\"createTransfer\";i:33;s:14:\"updateTransfer\";i:34;s:12:\"viewTransfer\";i:35;s:14:\"deleteTransfer\";i:36;s:16:\"createWithdrawal\";i:37;s:16:\"updateWithdrawal\";i:38;s:14:\"viewWithdrawal\";i:39;s:16:\"deleteWithdrawal\";i:40;s:14:\"createCustomer\";i:41;s:14:\"updateCustomer\";i:42;s:12:\"viewCustomer\";i:43;s:14:\"deleteCustomer\";i:44;s:13:\"createSetting\";i:45;s:13:\"updateSetting\";i:46;s:11:\"viewSetting\";i:47;s:13:\"deleteSetting\";}'), ('5', 'Staff', 'a:1:{i:0;s:11:\"viewProduct\";}'), ('6', 'Super Group', 'a:48:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:13:\"createProduct\";i:9;s:13:\"updateProduct\";i:10;s:11:\"viewProduct\";i:11;s:13:\"deleteProduct\";i:12;s:10:\"createCost\";i:13;s:10:\"updateCost\";i:14;s:8:\"viewCost\";i:15;s:10:\"deleteCost\";i:16;s:10:\"createSale\";i:17;s:10:\"updateSale\";i:18;s:8:\"viewSale\";i:19;s:10:\"deleteSale\";i:20;s:15:\"createWarehouse\";i:21;s:15:\"updateWarehouse\";i:22;s:13:\"viewWarehouse\";i:23;s:15:\"deleteWarehouse\";i:24;s:14:\"createDelivery\";i:25;s:14:\"updateDelivery\";i:26;s:12:\"viewDelivery\";i:27;s:14:\"deleteDelivery\";i:28;s:12:\"createPickup\";i:29;s:12:\"updatePickup\";i:30;s:10:\"viewPickup\";i:31;s:12:\"deletePickup\";i:32;s:14:\"createTransfer\";i:33;s:14:\"updateTransfer\";i:34;s:12:\"viewTransfer\";i:35;s:14:\"deleteTransfer\";i:36;s:16:\"createWithdrawal\";i:37;s:16:\"updateWithdrawal\";i:38;s:14:\"viewWithdrawal\";i:39;s:16:\"deleteWithdrawal\";i:40;s:14:\"createCustomer\";i:41;s:14:\"updateCustomer\";i:42;s:12:\"viewCustomer\";i:43;s:14:\"deleteCustomer\";i:44;s:13:\"createSetting\";i:45;s:13:\"updateSetting\";i:46;s:11:\"viewSetting\";i:47;s:13:\"deleteSetting\";}'), ('7', 'Sales Personnel', 'a:45:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:9:\"viewGroup\";i:5;s:13:\"createProduct\";i:6;s:13:\"updateProduct\";i:7;s:11:\"viewProduct\";i:8;s:13:\"deleteProduct\";i:9;s:10:\"createCost\";i:10;s:10:\"updateCost\";i:11;s:8:\"viewCost\";i:12;s:10:\"deleteCost\";i:13;s:10:\"createSale\";i:14;s:10:\"updateSale\";i:15;s:8:\"viewSale\";i:16;s:10:\"deleteSale\";i:17;s:15:\"createWarehouse\";i:18;s:15:\"updateWarehouse\";i:19;s:13:\"viewWarehouse\";i:20;s:15:\"deleteWarehouse\";i:21;s:14:\"createDelivery\";i:22;s:14:\"updateDelivery\";i:23;s:12:\"viewDelivery\";i:24;s:14:\"deleteDelivery\";i:25;s:12:\"createPickup\";i:26;s:12:\"updatePickup\";i:27;s:10:\"viewPickup\";i:28;s:12:\"deletePickup\";i:29;s:14:\"createTransfer\";i:30;s:14:\"updateTransfer\";i:31;s:12:\"viewTransfer\";i:32;s:14:\"deleteTransfer\";i:33;s:16:\"createWithdrawal\";i:34;s:16:\"updateWithdrawal\";i:35;s:14:\"viewWithdrawal\";i:36;s:16:\"deleteWithdrawal\";i:37;s:14:\"createCustomer\";i:38;s:14:\"updateCustomer\";i:39;s:12:\"viewCustomer\";i:40;s:14:\"deleteCustomer\";i:41;s:13:\"createSetting\";i:42;s:13:\"updateSetting\";i:43;s:11:\"viewSetting\";i:44;s:13:\"deleteSetting\";}'), ('8', 'Warehouse Personnel', 'a:19:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:9:\"viewGroup\";i:5;s:13:\"updateProduct\";i:6;s:11:\"viewProduct\";i:7;s:13:\"viewWarehouse\";i:8;s:14:\"updateDelivery\";i:9;s:12:\"viewDelivery\";i:10;s:12:\"updatePickup\";i:11;s:10:\"viewPickup\";i:12;s:14:\"updateTransfer\";i:13;s:12:\"viewTransfer\";i:14;s:16:\"updateWithdrawal\";i:15;s:14:\"viewWithdrawal\";i:16;s:14:\"updateCustomer\";i:17;s:12:\"viewCustomer\";i:18;s:11:\"viewSetting\";}'), ('10', 'OLD', 'a:36:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:11:\"createStore\";i:9;s:11:\"updateStore\";i:10;s:9:\"viewStore\";i:11;s:11:\"deleteStore\";i:12;s:11:\"createTable\";i:13;s:11:\"updateTable\";i:14;s:9:\"viewTable\";i:15;s:11:\"deleteTable\";i:16;s:14:\"createCategory\";i:17;s:14:\"updateCategory\";i:18;s:12:\"viewCategory\";i:19;s:14:\"deleteCategory\";i:20;s:13:\"createProduct\";i:21;s:13:\"updateProduct\";i:22;s:11:\"viewProduct\";i:23;s:13:\"deleteProduct\";i:24;s:11:\"createOrder\";i:25;s:11:\"updateOrder\";i:26;s:9:\"viewOrder\";i:27;s:11:\"deleteOrder\";i:28;s:10:\"viewReport\";i:29;s:13:\"updateCompany\";i:30;s:11:\"viewProfile\";i:31;s:13:\"updateSetting\";i:32;s:13:\"createExpense\";i:33;s:13:\"updateExpense\";i:34;s:11:\"viewExpense\";i:35;s:13:\"deleteExpense\";}');
COMMIT;

-- ----------------------------
--  Table structure for `products`
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pd_disp_id` varchar(15) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `max_quantity` int(11) DEFAULT '0',
  `running_balance` int(11) DEFAULT '0',
  `quantity_in_box` int(11) DEFAULT '0',
  `cost` decimal(15,2) DEFAULT NULL,
  `sale_price` decimal(15,2) DEFAULT NULL,
  `is_deleted` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `combo1` (`id`,`unit_id`,`is_deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `products`
-- ----------------------------
BEGIN;
INSERT INTO `products` VALUES ('1', 'PD-000000000001', 'Royal Cord Wire', 'PHIL-234234098', '1', '3', '10000', '0', '0', '260.00', '900.00', '1'), ('2', 'PD-000000000002', 'Respirator', 'PHIL-234234234', '2', '2', '10000', '0', '0', '1020.00', '5675.00', '0'), ('3', 'PD-000000000003', 'Pencil', 'PHIL-342342342', '0', '1', '1500', '0', '12', '1.00', '15.00', '0'), ('4', 'PD-00000000004', 'Flat Scren TV', 'PHIL-3234234234', '1', '2', '100', '0', '1', '15000.00', '30000.00', '0'), ('5', 'PD-00000000005', 'Laptop', 'SK23423', '5', '2', '10000', '0', '1', '150.00', '100.00', '0'), ('6', 'PD-00000000006', 'Notebook', 'SKU82349823', '5', '2', '156456', '0', '1', '200.00', '400.00', '0');
COMMIT;

-- ----------------------------
--  Table structure for `stock_details`
-- ----------------------------
DROP TABLE IF EXISTS `stock_details`;
CREATE TABLE `stock_details` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` int(11) unsigned DEFAULT NULL,
  `product_id` int(11) unsigned DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `cost` decimal(15,2) DEFAULT NULL,
  `sale_price` decimal(15,2) DEFAULT NULL,
  `is_deleted` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `is_mark_deleted` (`is_deleted`),
  KEY `expiry` (`expiry_date`),
  KEY `combo_details` (`stock_id`,`product_id`,`expiry_date`,`is_deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `stock_details`
-- ----------------------------
BEGIN;
INSERT INTO `stock_details` VALUES ('2', '1', '2', '200', '2019-02-01', '1020.00', '5675.00', '0'), ('3', '2', '2', '1000', '1970-01-01', '1020.00', '5675.00', '0'), ('14', '3', '2', '300', '1970-01-01', '1020.00', '5675.00', '0'), ('17', '4', '3', '20', '1970-01-01', '1.00', '15.00', '0'), ('18', '4', '4', '20', '1970-01-01', '15000.00', '30000.00', '0'), ('19', '4', '2', '200', '1970-01-01', '1020.00', '5375.00', '0');
COMMIT;

-- ----------------------------
--  Table structure for `stocks`
-- ----------------------------
DROP TABLE IF EXISTS `stocks`;
CREATE TABLE `stocks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sales_invoice_id` varchar(15) DEFAULT NULL,
  `store_id` int(11) unsigned DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `transaction_id` int(11) unsigned DEFAULT NULL,
  `supplier_name` varchar(200) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transid` (`transaction_id`),
  KEY `id_store_id` (`id`,`store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `stocks`
-- ----------------------------
BEGIN;
INSERT INTO `stocks` VALUES ('1', 'si-100001', '1', '2019-03-02 07:34:42', '1', null, '', null), ('2', 'SI-1010101', '1', '2019-03-03 17:22:05', '1', null, 'test', null), ('3', 'SI-00045035705', '2', '2019-03-03 17:35:42', '1', '2', null, null), ('4', 'SI-930420394', '1', '2019-03-20 06:07:01', '1', null, 'Test', 'Room C');
COMMIT;

-- ----------------------------
--  Table structure for `stores`
-- ----------------------------
DROP TABLE IF EXISTS `stores`;
CREATE TABLE `stores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `warehouse_disp_id` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `stores`
-- ----------------------------
BEGIN;
INSERT INTO `stores` VALUES ('1', 'Main Office', 'WH-00000000001', '27 main street pandacan manila', '1'), ('2', 'Arlegui', 'WH-00000000002', '27 main street pandacan manila', '1'), ('3', 'Buencamino', 'WH-00000000003', '27 main street pandacan manila', '1'), ('4', 'Raul', 'WH-00000000004', '27 main street pandacan manila', '1');
COMMIT;

-- ----------------------------
--  Table structure for `tokens`
-- ----------------------------
DROP TABLE IF EXISTS `tokens`;
CREATE TABLE `tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `tokens`
-- ----------------------------
BEGIN;
INSERT INTO `tokens` VALUES ('26', '0bcc19fa7f36800c73b8d862118452', '2', '2019-01-23'), ('27', '035cbb6bbf8f1a02a71a48f7c7b78c', '1', '2019-01-23'), ('28', '1dbaa7aeeed6aad98463c5e48f1a93', '1', '2019-01-23'), ('29', '7f2d9cc919a6dce2d07c222d78dab1', '1', '2019-01-23'), ('30', '3970641b317013c793142615b7fb0a', '1', '2019-01-23'), ('31', '879260384101cd7c17099fa16dbaaa', '2', '2019-01-23'), ('32', '50a60644b1e4d6f993accdbb07a2e2', '2', '2019-01-23'), ('33', '34a25ce460ab9c31b781afbe5bbad3', '1', '2019-01-23'), ('34', '0d1c58c5f51f8bd5642cba301fe187', '2', '2019-01-23'), ('35', '399b0860af28d6abac98117a9d7412', '2', '2019-01-23'), ('36', '32bc669d52f00fca1b82c6b12b4c98', '1', '2019-02-19'), ('37', '5781fbfc8b62da55251b2da9d7551e', '1', '2019-02-19'), ('38', '1611b9076df4174e1484a93287abb6', '1', '2019-02-19'), ('39', '9c114b4ff7d83cf0f25975509898f0', '1', '2019-02-19'), ('40', 'df2a5321e311a84e7b9e93d17282a1', '1', '2019-02-19'), ('41', '57e5e247a46a9e155b365b0cc466bb', '1', '2019-02-19'), ('42', '7304fae65ea73956b5b852bfda9ae1', '1', '2019-02-19'), ('43', 'b98929af4cafd827d7abbe744fe183', '1', '2019-02-19'), ('44', 'fd08197f4c8d78556b6ef91d6d62a2', '1', '2019-02-19'), ('45', '1f465bff8bdc06b29e19d2e9ee32fd', '1', '2019-02-19'), ('46', '25c73a58f0a0d595897b76192b74a2', '1', '2019-02-19'), ('47', '40b75945a4301e1e27775cb1ee7c57', '1', '2019-02-19'), ('48', '4b3b6b8eccdb578ac8aa431bd2468c', '1', '2019-02-19'), ('49', '4b2a296996dbba62d9779660fdedef', '1', '2019-02-19'), ('50', '6418e7896ebad60229cad24ef4c9fe', '1', '2019-02-19'), ('51', '49a675c320d761edc2ac0b2ab66c42', '1', '2019-02-19');
COMMIT;

-- ----------------------------
--  Table structure for `transaction_details`
-- ----------------------------
DROP TABLE IF EXISTS `transaction_details`;
CREATE TABLE `transaction_details` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) unsigned DEFAULT NULL,
  `product_id` int(11) unsigned DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `cost` decimal(15,2) DEFAULT NULL,
  `sale_price` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `transaction_details`
-- ----------------------------
BEGIN;
INSERT INTO `transaction_details` VALUES ('2', '1', '2', '200', '1020.00', '5675.00'), ('6', '4', '2', '100', '1020.00', '5675.00'), ('10', '5', '2', '1', '1020.00', '5675.00'), ('19', '2', '2', '300', '1020.00', '5675.00'), ('20', '3', '3', '10', '1.00', '15.00');
COMMIT;

-- ----------------------------
--  Table structure for `transactions`
-- ----------------------------
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `create_date` datetime DEFAULT NULL,
  `transaction_type` enum('delivery','pickup','transfer','withdrawal') DEFAULT NULL,
  `transaction_status` enum('pending','delivered','transferred','withdrew') DEFAULT 'pending',
  `display_id` varchar(50) DEFAULT NULL,
  `po_number` varchar(50) DEFAULT NULL,
  `customer_id` int(11) unsigned DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `store_id` int(11) unsigned DEFAULT NULL,
  `from_store_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trans1` (`transaction_type`,`transaction_status`),
  KEY `trans2` (`id`,`create_date`,`store_id`,`from_store_id`),
  KEY `transaction_type` (`transaction_type`,`transaction_status`,`store_id`,`from_store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `transactions`
-- ----------------------------
BEGIN;
INSERT INTO `transactions` VALUES ('1', '2019-03-03 17:17:37', 'withdrawal', 'withdrew', 'WD-MO-00000000001', null, null, null, '', '1', null), ('2', '2019-03-03 17:35:42', 'transfer', 'transferred', 'TR-MO-00000000002', null, '1', null, null, '2', '1'), ('3', '2019-03-03 17:48:41', 'delivery', 'delivered', 'DL-MO-00000000003', '2312312', '1', '4681 Cuangco Street Pio Del Pilar', '', '1', null), ('4', '2019-03-03 18:46:03', 'withdrawal', 'withdrew', 'WD-MO-00000000004', null, null, null, 'test', '1', null), ('5', '2019-03-05 20:08:07', 'pickup', 'delivered', 'PK-MO-00000000005', '423423423432', '1', null, '', '1', null);
COMMIT;

-- ----------------------------
--  Table structure for `units`
-- ----------------------------
DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `is_status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `unit_name_status` (`name`,`is_status`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `units`
-- ----------------------------
BEGIN;
INSERT INTO `units` VALUES ('1', 'boxes', '1'), ('4', 'feet', '1'), ('3', 'meters', '1'), ('6', 'Packs', '1'), ('2', 'pcs', '1'), ('5', 'Ream', '1');
COMMIT;

-- ----------------------------
--  Table structure for `user_group`
-- ----------------------------
DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `user_group`
-- ----------------------------
BEGIN;
INSERT INTO `user_group` VALUES ('1', '1', '6'), ('2', '2', '8'), ('3', '3', '5'), ('4', '4', '4'), ('5', '5', '8');
COMMIT;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', 'admin', '$2y$10$SohAExZ8jQuvIbQ92GzqXeo0zrhaTUPDFPCTDSqFgdl41hbeP5IRS', 'andrew.pe@gmail.com', 'Andrew', 'Pe', '0'), ('2', 'tester', '$2y$10$f8royWqboK0RqmLtfTtIS.yGVhJ0Kfh1HPeVzW.ss8AB019OmpZ9i', 'bulgogi.as.th10@gmail.com', 'test', 'test', '0'), ('3', 'staff', '$2y$10$q.Nz573rSwnk04fdTEBgmu3gjQIP7qFIR6HfJ4Pc/u.BpVXMZwC.2', 'staff@staff.com', 'staff', 'staff', '1');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
