-- MySQL dump 10.13  Distrib 8.0.32, for macos11.7 (x86_64)
--
-- Host: 127.0.0.1    Database: bridgemonkcorp_v2_try
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `addressable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addressable_id` bigint unsigned NOT NULL,
  `country_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_country` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_billing` tinyint(1) NOT NULL DEFAULT '0',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_addressable_type_addressable_id_index` (`addressable_type`,`addressable_id`),
  KEY `addresses_country_id_foreign` (`country_id`),
  CONSTRAINT `addresses_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `author_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` longtext COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_slug_unique` (`slug`),
  KEY `articles_author_id_foreign` (`author_id`),
  CONSTRAINT `articles_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bans`
--

DROP TABLE IF EXISTS `bans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bans` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `bannable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bannable_id` bigint unsigned NOT NULL,
  `created_by_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by_id` bigint unsigned DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `expired_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bans_bannable_type_bannable_id_index` (`bannable_type`,`bannable_id`),
  KEY `bans_created_by_type_created_by_id_index` (`created_by_type`,`created_by_id`),
  KEY `bans_expired_at_index` (`expired_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bans`
--

LOCK TABLES `bans` WRITE;
/*!40000 ALTER TABLE `bans` DISABLE KEYS */;
/*!40000 ALTER TABLE `bans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carousel_slides`
--

DROP TABLE IF EXISTS `carousel_slides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carousel_slides` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `carousel_id` bigint unsigned NOT NULL,
  `linkable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkable_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carousel_slides_carousel_id_foreign` (`carousel_id`),
  KEY `carousel_slides_linkable_type_linkable_id_index` (`linkable_type`,`linkable_id`),
  CONSTRAINT `carousel_slides_carousel_id_foreign` FOREIGN KEY (`carousel_id`) REFERENCES `carousels` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carousel_slides`
--

LOCK TABLES `carousel_slides` WRITE;
/*!40000 ALTER TABLE `carousel_slides` DISABLE KEYS */;
/*!40000 ALTER TABLE `carousel_slides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carousels`
--

DROP TABLE IF EXISTS `carousels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carousels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `carousels_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carousels`
--

LOCK TABLES `carousels` WRITE;
/*!40000 ALTER TABLE `carousels` DISABLE KEYS */;
/*!40000 ALTER TABLE `carousels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_discounts`
--

DROP TABLE IF EXISTS `cart_discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_discounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` bigint unsigned NOT NULL,
  `cart_item_id` bigint unsigned DEFAULT NULL,
  `discount_id` bigint unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('fixed','percentage','shipping') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_discounts_cart_id_foreign` (`cart_id`),
  KEY `cart_discounts_cart_item_id_foreign` (`cart_item_id`),
  KEY `cart_discounts_discount_id_foreign` (`discount_id`),
  CONSTRAINT `cart_discounts_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_discounts_cart_item_id_foreign` FOREIGN KEY (`cart_item_id`) REFERENCES `cart_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_discounts_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_discounts`
--

LOCK TABLES `cart_discounts` WRITE;
/*!40000 ALTER TABLE `cart_discounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart_discounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `variant_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_items_cart_id_foreign` (`cart_id`),
  KEY `cart_items_product_id_foreign` (`product_id`),
  KEY `cart_items_variant_id_foreign` (`variant_id`),
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_method` bigint unsigned DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_customer_id_foreign` (`customer_id`),
  KEY `carts_shipping_method_foreign` (`shipping_method`),
  CONSTRAINT `carts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carts_shipping_method_foreign` FOREIGN KEY (`shipping_method`) REFERENCES `shipping_zone_rates` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collection_product`
--

DROP TABLE IF EXISTS `collection_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `collection_product` (
  `collection_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  KEY `collection_product_collection_id_foreign` (`collection_id`),
  KEY `collection_product_product_id_foreign` (`product_id`),
  CONSTRAINT `collection_product_collection_id_foreign` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `collection_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collection_product`
--

LOCK TABLES `collection_product` WRITE;
/*!40000 ALTER TABLE `collection_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `collection_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collections`
--

DROP TABLE IF EXISTS `collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `collections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `seo_title` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(320) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collections`
--

LOCK TABLES `collections` WRITE;
/*!40000 ALTER TABLE `collections` DISABLE KEYS */;
/*!40000 ALTER TABLE `collections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `native` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso2` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso3` char(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phonecode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capital` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subregion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emoji` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emojiU` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'Afghanistan','افغانستان','AF','AFG','93','Kabul','AFN','Afghan afghani','؋','Asia','Southern Asia','🇦🇫','U+1F1E6 U+1F1EB','2018-07-21 07:11:03','2022-05-21 21:06:00'),(2,'Aland Islands','Åland','AX','ALA','358','Mariehamn','EUR','Euro','€','Europe','Northern Europe','🇦🇽','U+1F1E6 U+1F1FD','2018-07-21 07:11:03','2022-05-21 21:06:00'),(3,'Albania','Shqipëria','AL','ALB','355','Tirana','ALL','Albanian lek','Lek','Europe','Southern Europe','🇦🇱','U+1F1E6 U+1F1F1','2018-07-21 07:11:03','2022-05-21 21:06:00'),(4,'Algeria','الجزائر','DZ','DZA','213','Algiers','DZD','Algerian dinar','دج','Africa','Northern Africa','🇩🇿','U+1F1E9 U+1F1FF','2018-07-21 07:11:03','2022-05-21 21:06:00'),(5,'American Samoa','American Samoa','AS','ASM','1','Pago Pago','USD','US Dollar','$','Oceania','Polynesia','🇦🇸','U+1F1E6 U+1F1F8','2018-07-21 07:11:03','2022-05-21 21:06:00'),(6,'Andorra','Andorra','AD','AND','376','Andorra la Vella','EUR','Euro','€','Europe','Southern Europe','🇦🇩','U+1F1E6 U+1F1E9','2018-07-21 07:11:03','2022-05-21 21:06:00'),(7,'Angola','Angola','AO','AGO','244','Luanda','AOA','Angolan kwanza','Kz','Africa','Middle Africa','🇦🇴','U+1F1E6 U+1F1F4','2018-07-21 07:11:03','2022-05-21 21:06:00'),(8,'Anguilla','Anguilla','AI','AIA','1','The Valley','XCD','East Caribbean dollar','$','Americas','Caribbean','🇦🇮','U+1F1E6 U+1F1EE','2018-07-21 07:11:03','2022-05-21 21:06:00'),(9,'Antarctica','Antarctica','AQ','ATA','672','','AAD','Antarctican dollar','$','Polar','','🇦🇶','U+1F1E6 U+1F1F6','2018-07-21 07:11:03','2022-05-21 21:06:00'),(10,'Antigua And Barbuda','Antigua and Barbuda','AG','ATG','1','St. John\'s','XCD','Eastern Caribbean dollar','$','Americas','Caribbean','🇦🇬','U+1F1E6 U+1F1EC','2018-07-21 07:11:03','2022-05-21 21:06:00'),(11,'Argentina','Argentina','AR','ARG','54','Buenos Aires','ARS','Argentine peso','$','Americas','South America','🇦🇷','U+1F1E6 U+1F1F7','2018-07-21 07:11:03','2022-05-21 21:06:00'),(12,'Armenia','Հայաստան','AM','ARM','374','Yerevan','AMD','Armenian dram','֏','Asia','Western Asia','🇦🇲','U+1F1E6 U+1F1F2','2018-07-21 07:11:03','2022-05-21 21:06:00'),(13,'Aruba','Aruba','AW','ABW','297','Oranjestad','AWG','Aruban florin','ƒ','Americas','Caribbean','🇦🇼','U+1F1E6 U+1F1FC','2018-07-21 07:11:03','2022-05-21 21:06:00'),(14,'Australia','Australia','AU','AUS','61','Canberra','AUD','Australian dollar','$','Oceania','Australia and New Zealand','🇦🇺','U+1F1E6 U+1F1FA','2018-07-21 07:11:03','2022-05-21 21:06:00'),(15,'Austria','Österreich','AT','AUT','43','Vienna','EUR','Euro','€','Europe','Western Europe','🇦🇹','U+1F1E6 U+1F1F9','2018-07-21 07:11:03','2022-05-21 21:06:00'),(16,'Azerbaijan','Azərbaycan','AZ','AZE','994','Baku','AZN','Azerbaijani manat','m','Asia','Western Asia','🇦🇿','U+1F1E6 U+1F1FF','2018-07-21 07:11:03','2022-05-21 21:06:00'),(17,'The Bahamas','Bahamas','BS','BHS','1','Nassau','BSD','Bahamian dollar','B$','Americas','Caribbean','🇧🇸','U+1F1E7 U+1F1F8','2018-07-21 07:11:03','2022-05-21 21:06:00'),(18,'Bahrain','‏البحرين','BH','BHR','973','Manama','BHD','Bahraini dinar','.د.ب','Asia','Western Asia','🇧🇭','U+1F1E7 U+1F1ED','2018-07-21 07:11:03','2022-05-21 21:11:20'),(19,'Bangladesh','Bangladesh','BD','BGD','880','Dhaka','BDT','Bangladeshi taka','৳','Asia','Southern Asia','🇧🇩','U+1F1E7 U+1F1E9','2018-07-21 07:11:03','2022-05-21 21:11:20'),(20,'Barbados','Barbados','BB','BRB','1','Bridgetown','BBD','Barbadian dollar','Bds$','Americas','Caribbean','🇧🇧','U+1F1E7 U+1F1E7','2018-07-21 07:11:03','2022-05-21 21:11:20'),(21,'Belarus','Белару́сь','BY','BLR','375','Minsk','BYN','Belarusian ruble','Br','Europe','Eastern Europe','🇧🇾','U+1F1E7 U+1F1FE','2018-07-21 07:11:03','2022-05-21 21:11:20'),(22,'Belgium','België','BE','BEL','32','Brussels','EUR','Euro','€','Europe','Western Europe','🇧🇪','U+1F1E7 U+1F1EA','2018-07-21 07:11:03','2022-05-21 21:11:20'),(23,'Belize','Belize','BZ','BLZ','501','Belmopan','BZD','Belize dollar','$','Americas','Central America','🇧🇿','U+1F1E7 U+1F1FF','2018-07-21 07:11:03','2022-05-21 21:11:20'),(24,'Benin','Bénin','BJ','BEN','229','Porto-Novo','XOF','West African CFA franc','CFA','Africa','Western Africa','🇧🇯','U+1F1E7 U+1F1EF','2018-07-21 07:11:03','2022-05-21 21:11:20'),(25,'Bermuda','Bermuda','BM','BMU','1','Hamilton','BMD','Bermudian dollar','$','Americas','Northern America','🇧🇲','U+1F1E7 U+1F1F2','2018-07-21 07:11:03','2022-05-21 21:11:20'),(26,'Bhutan','ʼbrug-yul','BT','BTN','975','Thimphu','BTN','Bhutanese ngultrum','Nu.','Asia','Southern Asia','🇧🇹','U+1F1E7 U+1F1F9','2018-07-21 07:11:03','2022-05-21 21:11:20'),(27,'Bolivia','Bolivia','BO','BOL','591','Sucre','BOB','Bolivian boliviano','Bs.','Americas','South America','🇧🇴','U+1F1E7 U+1F1F4','2018-07-21 07:11:03','2022-05-21 21:11:20'),(28,'Bosnia and Herzegovina','Bosna i Hercegovina','BA','BIH','387','Sarajevo','BAM','Bosnia and Herzegovina convertible mark','KM','Europe','Southern Europe','🇧🇦','U+1F1E7 U+1F1E6','2018-07-21 07:11:03','2022-05-21 21:11:20'),(29,'Botswana','Botswana','BW','BWA','267','Gaborone','BWP','Botswana pula','P','Africa','Southern Africa','🇧🇼','U+1F1E7 U+1F1FC','2018-07-21 07:11:03','2022-05-21 21:11:20'),(30,'Bouvet Island','Bouvetøya','BV','BVT','47','','NOK','Norwegian Krone','kr','','','🇧🇻','U+1F1E7 U+1F1FB','2018-07-21 07:11:03','2022-05-21 21:11:20'),(31,'Brazil','Brasil','BR','BRA','55','Brasilia','BRL','Brazilian real','R$','Americas','South America','🇧🇷','U+1F1E7 U+1F1F7','2018-07-21 07:11:03','2022-05-21 21:11:20'),(32,'British Indian Ocean Territory','British Indian Ocean Territory','IO','IOT','246','Diego Garcia','USD','United States dollar','$','Africa','Eastern Africa','🇮🇴','U+1F1EE U+1F1F4','2018-07-21 07:11:03','2022-05-21 21:11:20'),(33,'Brunei','Negara Brunei Darussalam','BN','BRN','673','Bandar Seri Begawan','BND','Brunei dollar','B$','Asia','South-Eastern Asia','🇧🇳','U+1F1E7 U+1F1F3','2018-07-21 07:11:03','2022-05-21 21:11:20'),(34,'Bulgaria','България','BG','BGR','359','Sofia','BGN','Bulgarian lev','Лв.','Europe','Eastern Europe','🇧🇬','U+1F1E7 U+1F1EC','2018-07-21 07:11:03','2022-05-21 21:11:20'),(35,'Burkina Faso','Burkina Faso','BF','BFA','226','Ouagadougou','XOF','West African CFA franc','CFA','Africa','Western Africa','🇧🇫','U+1F1E7 U+1F1EB','2018-07-21 07:11:03','2022-05-21 21:11:20'),(36,'Burundi','Burundi','BI','BDI','257','Bujumbura','BIF','Burundian franc','FBu','Africa','Eastern Africa','🇧🇮','U+1F1E7 U+1F1EE','2018-07-21 07:11:03','2022-05-21 21:11:20'),(37,'Cambodia','Kâmpŭchéa','KH','KHM','855','Phnom Penh','KHR','Cambodian riel','KHR','Asia','South-Eastern Asia','🇰🇭','U+1F1F0 U+1F1ED','2018-07-21 07:11:03','2022-05-21 21:11:20'),(38,'Cameroon','Cameroon','CM','CMR','237','Yaounde','XAF','Central African CFA franc','FCFA','Africa','Middle Africa','🇨🇲','U+1F1E8 U+1F1F2','2018-07-21 07:11:03','2022-05-21 21:11:20'),(39,'Canada','Canada','CA','CAN','1','Ottawa','CAD','Canadian dollar','$','Americas','Northern America','🇨🇦','U+1F1E8 U+1F1E6','2018-07-21 07:11:03','2022-05-21 21:11:20'),(40,'Cape Verde','Cabo Verde','CV','CPV','238','Praia','CVE','Cape Verdean escudo','$','Africa','Western Africa','🇨🇻','U+1F1E8 U+1F1FB','2018-07-21 07:11:03','2022-05-21 21:11:20'),(41,'Cayman Islands','Cayman Islands','KY','CYM','1','George Town','KYD','Cayman Islands dollar','$','Americas','Caribbean','🇰🇾','U+1F1F0 U+1F1FE','2018-07-21 07:11:03','2022-05-21 21:11:20'),(42,'Central African Republic','Ködörösêse tî Bêafrîka','CF','CAF','236','Bangui','XAF','Central African CFA franc','FCFA','Africa','Middle Africa','🇨🇫','U+1F1E8 U+1F1EB','2018-07-21 07:11:03','2022-05-21 21:11:20'),(43,'Chad','Tchad','TD','TCD','235','N\'Djamena','XAF','Central African CFA franc','FCFA','Africa','Middle Africa','🇹🇩','U+1F1F9 U+1F1E9','2018-07-21 07:11:03','2022-05-21 21:11:20'),(44,'Chile','Chile','CL','CHL','56','Santiago','CLP','Chilean peso','$','Americas','South America','🇨🇱','U+1F1E8 U+1F1F1','2018-07-21 07:11:03','2022-05-21 21:11:20'),(45,'China','中国','CN','CHN','86','Beijing','CNY','Chinese yuan','¥','Asia','Eastern Asia','🇨🇳','U+1F1E8 U+1F1F3','2018-07-21 07:11:03','2022-05-21 21:11:20'),(46,'Christmas Island','Christmas Island','CX','CXR','61','Flying Fish Cove','AUD','Australian dollar','$','Oceania','Australia and New Zealand','🇨🇽','U+1F1E8 U+1F1FD','2018-07-21 07:11:03','2022-05-21 21:11:20'),(47,'Cocos (Keeling) Islands','Cocos (Keeling) Islands','CC','CCK','61','West Island','AUD','Australian dollar','$','Oceania','Australia and New Zealand','🇨🇨','U+1F1E8 U+1F1E8','2018-07-21 07:11:03','2022-05-21 21:11:20'),(48,'Colombia','Colombia','CO','COL','57','Bogotá','COP','Colombian peso','$','Americas','South America','🇨🇴','U+1F1E8 U+1F1F4','2018-07-21 07:11:03','2022-05-21 21:11:20'),(49,'Comoros','Komori','KM','COM','269','Moroni','KMF','Comorian franc','CF','Africa','Eastern Africa','🇰🇲','U+1F1F0 U+1F1F2','2018-07-21 07:11:03','2022-05-21 21:11:20'),(50,'Congo','République du Congo','CG','COG','242','Brazzaville','XAF','Central African CFA franc','FC','Africa','Middle Africa','🇨🇬','U+1F1E8 U+1F1EC','2018-07-21 07:11:03','2022-05-21 21:11:20'),(51,'Democratic Republic of the Congo','République démocratique du Congo','CD','COD','243','Kinshasa','CDF','Congolese Franc','FC','Africa','Middle Africa','🇨🇩','U+1F1E8 U+1F1E9','2018-07-21 07:11:03','2022-05-21 21:13:35'),(52,'Cook Islands','Cook Islands','CK','COK','682','Avarua','NZD','Cook Islands dollar','$','Oceania','Polynesia','🇨🇰','U+1F1E8 U+1F1F0','2018-07-21 07:11:03','2022-05-21 21:13:35'),(53,'Costa Rica','Costa Rica','CR','CRI','506','San Jose','CRC','Costa Rican colón','₡','Americas','Central America','🇨🇷','U+1F1E8 U+1F1F7','2018-07-21 07:11:03','2022-05-21 21:13:35'),(54,'Cote D\'Ivoire (Ivory Coast)','','CI','CIV','225','Yamoussoukro','XOF','West African CFA franc','CFA','Africa','Western Africa','🇨🇮','U+1F1E8 U+1F1EE','2018-07-21 07:11:03','2022-05-21 21:13:35'),(55,'Croatia','Hrvatska','HR','HRV','385','Zagreb','HRK','Croatian kuna','kn','Europe','Southern Europe','🇭🇷','U+1F1ED U+1F1F7','2018-07-21 07:11:03','2022-05-21 21:13:35'),(56,'Cuba','Cuba','CU','CUB','53','Havana','CUP','Cuban peso','$','Americas','Caribbean','🇨🇺','U+1F1E8 U+1F1FA','2018-07-21 07:11:03','2022-05-21 21:13:35'),(57,'Cyprus','Κύπρος','CY','CYP','357','Nicosia','EUR','Euro','€','Europe','Southern Europe','🇨🇾','U+1F1E8 U+1F1FE','2018-07-21 07:11:03','2022-05-21 21:13:35'),(58,'Czech Republic','Česká republika','CZ','CZE','420','Prague','CZK','Czech koruna','Kč','Europe','Eastern Europe','🇨🇿','U+1F1E8 U+1F1FF','2018-07-21 07:11:03','2022-05-21 21:13:35'),(59,'Denmark','Danmark','DK','DNK','45','Copenhagen','DKK','Danish krone','Kr.','Europe','Northern Europe','🇩🇰','U+1F1E9 U+1F1F0','2018-07-21 07:11:03','2022-05-21 21:13:35'),(60,'Djibouti','Djibouti','DJ','DJI','253','Djibouti','DJF','Djiboutian franc','Fdj','Africa','Eastern Africa','🇩🇯','U+1F1E9 U+1F1EF','2018-07-21 07:11:03','2022-05-21 21:17:53'),(61,'Dominica','Dominica','DM','DMA','1','Roseau','XCD','Eastern Caribbean dollar','$','Americas','Caribbean','🇩🇲','U+1F1E9 U+1F1F2','2018-07-21 07:11:03','2022-05-21 21:17:53'),(62,'Dominican Republic','República Dominicana','DO','DOM','1','Santo Domingo','DOP','Dominican peso','$','Americas','Caribbean','🇩🇴','U+1F1E9 U+1F1F4','2018-07-21 07:11:03','2022-05-21 21:17:53'),(63,'East Timor','Timor-Leste','TL','TLS','670','Dili','USD','United States dollar','$','Asia','South-Eastern Asia','🇹🇱','U+1F1F9 U+1F1F1','2018-07-21 07:11:03','2022-05-21 21:17:53'),(64,'Ecuador','Ecuador','EC','ECU','593','Quito','USD','United States dollar','$','Americas','South America','🇪🇨','U+1F1EA U+1F1E8','2018-07-21 07:11:03','2022-05-21 21:17:53'),(65,'Egypt','مصر‎','EG','EGY','20','Cairo','EGP','Egyptian pound','ج.م','Africa','Northern Africa','🇪🇬','U+1F1EA U+1F1EC','2018-07-21 07:11:03','2022-05-21 21:17:53'),(66,'El Salvador','El Salvador','SV','SLV','503','San Salvador','USD','United States dollar','$','Americas','Central America','🇸🇻','U+1F1F8 U+1F1FB','2018-07-21 07:11:03','2022-05-21 21:17:53'),(67,'Equatorial Guinea','Guinea Ecuatorial','GQ','GNQ','240','Malabo','XAF','Central African CFA franc','FCFA','Africa','Middle Africa','🇬🇶','U+1F1EC U+1F1F6','2018-07-21 07:11:03','2022-05-21 21:17:53'),(68,'Eritrea','ኤርትራ','ER','ERI','291','Asmara','ERN','Eritrean nakfa','Nfk','Africa','Eastern Africa','🇪🇷','U+1F1EA U+1F1F7','2018-07-21 07:11:03','2022-05-21 21:17:53'),(69,'Estonia','Eesti','EE','EST','372','Tallinn','EUR','Euro','€','Europe','Northern Europe','🇪🇪','U+1F1EA U+1F1EA','2018-07-21 07:11:03','2022-05-21 21:17:53'),(70,'Ethiopia','ኢትዮጵያ','ET','ETH','251','Addis Ababa','ETB','Ethiopian birr','Nkf','Africa','Eastern Africa','🇪🇹','U+1F1EA U+1F1F9','2018-07-21 07:11:03','2022-05-21 21:20:25'),(71,'Falkland Islands','Falkland Islands','FK','FLK','500','Stanley','FKP','Falkland Islands pound','£','Americas','South America','🇫🇰','U+1F1EB U+1F1F0','2018-07-21 07:11:03','2022-05-21 21:20:25'),(72,'Faroe Islands','Føroyar','FO','FRO','298','Torshavn','DKK','Danish krone','Kr.','Europe','Northern Europe','🇫🇴','U+1F1EB U+1F1F4','2018-07-21 07:11:03','2022-05-21 21:20:25'),(73,'Fiji Islands','Fiji','FJ','FJI','679','Suva','FJD','Fijian dollar','FJ$','Oceania','Melanesia','🇫🇯','U+1F1EB U+1F1EF','2018-07-21 07:11:03','2022-05-21 21:20:25'),(74,'Finland','Suomi','FI','FIN','358','Helsinki','EUR','Euro','€','Europe','Northern Europe','🇫🇮','U+1F1EB U+1F1EE','2018-07-21 07:11:03','2022-05-21 21:20:25'),(75,'France','France','FR','FRA','33','Paris','EUR','Euro','€','Europe','Western Europe','🇫🇷','U+1F1EB U+1F1F7','2018-07-21 07:11:03','2022-05-21 21:20:25'),(76,'French Guiana','Guyane française','GF','GUF','594','Cayenne','EUR','Euro','€','Americas','South America','🇬🇫','U+1F1EC U+1F1EB','2018-07-21 07:11:03','2022-05-21 21:20:25'),(77,'French Polynesia','Polynésie française','PF','PYF','689','Papeete','XPF','CFP franc','₣','Oceania','Polynesia','🇵🇫','U+1F1F5 U+1F1EB','2018-07-21 07:11:03','2022-05-21 21:20:25'),(78,'French Southern Territories','Territoire des Terres australes et antarctiques fr','TF','ATF','262','Port-aux-Francais','EUR','Euro','€','Africa','Southern Africa','🇹🇫','U+1F1F9 U+1F1EB','2018-07-21 07:11:03','2022-05-21 21:20:25'),(79,'Gabon','Gabon','GA','GAB','241','Libreville','XAF','Central African CFA franc','FCFA','Africa','Middle Africa','🇬🇦','U+1F1EC U+1F1E6','2018-07-21 07:11:03','2022-05-21 21:20:25'),(80,'Gambia The','Gambia','GM','GMB','220','Banjul','GMD','Gambian dalasi','D','Africa','Western Africa','🇬🇲','U+1F1EC U+1F1F2','2018-07-21 07:11:03','2022-05-21 21:20:25'),(81,'Georgia','საქართველო','GE','GEO','995','Tbilisi','GEL','Georgian lari','ლ','Asia','Western Asia','🇬🇪','U+1F1EC U+1F1EA','2018-07-21 07:11:03','2022-05-21 21:20:25'),(82,'Germany','Deutschland','DE','DEU','49','Berlin','EUR','Euro','€','Europe','Western Europe','🇩🇪','U+1F1E9 U+1F1EA','2018-07-21 07:11:03','2022-05-21 21:20:25'),(83,'Ghana','Ghana','GH','GHA','233','Accra','GHS','Ghanaian cedi','GH₵','Africa','Western Africa','🇬🇭','U+1F1EC U+1F1ED','2018-07-21 07:11:03','2022-05-21 21:20:25'),(84,'Gibraltar','Gibraltar','GI','GIB','350','Gibraltar','GIP','Gibraltar pound','£','Europe','Southern Europe','🇬🇮','U+1F1EC U+1F1EE','2018-07-21 07:11:03','2022-05-21 21:20:25'),(85,'Greece','Ελλάδα','GR','GRC','30','Athens','EUR','Euro','€','Europe','Southern Europe','🇬🇷','U+1F1EC U+1F1F7','2018-07-21 07:11:03','2022-05-21 21:20:25'),(86,'Greenland','Kalaallit Nunaat','GL','GRL','299','Nuuk','DKK','Danish krone','Kr.','Americas','Northern America','🇬🇱','U+1F1EC U+1F1F1','2018-07-21 07:11:03','2022-05-21 21:20:25'),(87,'Grenada','Grenada','GD','GRD','1','St. George\'s','XCD','Eastern Caribbean dollar','$','Americas','Caribbean','🇬🇩','U+1F1EC U+1F1E9','2018-07-21 07:11:03','2022-05-21 21:20:25'),(88,'Guadeloupe','Guadeloupe','GP','GLP','590','Basse-Terre','EUR','Euro','€','Americas','Caribbean','🇬🇵','U+1F1EC U+1F1F5','2018-07-21 07:11:03','2022-05-21 21:20:25'),(89,'Guam','Guam','GU','GUM','1','Hagatna','USD','US Dollar','$','Oceania','Micronesia','🇬🇺','U+1F1EC U+1F1FA','2018-07-21 07:11:03','2022-05-21 21:20:25'),(90,'Guatemala','Guatemala','GT','GTM','502','Guatemala City','GTQ','Guatemalan quetzal','Q','Americas','Central America','🇬🇹','U+1F1EC U+1F1F9','2018-07-21 07:11:03','2022-05-21 21:20:25'),(91,'Guernsey and Alderney','Guernsey','GG','GGY','44','St Peter Port','GBP','British pound','£','Europe','Northern Europe','🇬🇬','U+1F1EC U+1F1EC','2018-07-21 07:11:03','2022-05-21 21:32:07'),(92,'Guinea','Guinée','GN','GIN','224','Conakry','GNF','Guinean franc','FG','Africa','Western Africa','🇬🇳','U+1F1EC U+1F1F3','2018-07-21 07:11:03','2022-05-21 21:32:07'),(93,'Guinea-Bissau','Guiné-Bissau','GW','GNB','245','Bissau','XOF','West African CFA franc','CFA','Africa','Western Africa','🇬🇼','U+1F1EC U+1F1FC','2018-07-21 07:11:03','2022-05-21 21:32:07'),(94,'Guyana','Guyana','GY','GUY','592','Georgetown','GYD','Guyanese dollar','$','Americas','South America','🇬🇾','U+1F1EC U+1F1FE','2018-07-21 07:11:03','2022-05-21 21:32:07'),(95,'Haiti','Haïti','HT','HTI','509','Port-au-Prince','HTG','Haitian gourde','G','Americas','Caribbean','🇭🇹','U+1F1ED U+1F1F9','2018-07-21 07:11:03','2022-05-21 21:32:07'),(96,'Heard Island and McDonald Islands','Heard Island and McDonald Islands','HM','HMD','672','','AUD','Australian dollar','$','','','🇭🇲','U+1F1ED U+1F1F2','2018-07-21 07:11:03','2022-05-21 21:32:07'),(97,'Honduras','Honduras','HN','HND','504','Tegucigalpa','HNL','Honduran lempira','L','Americas','Central America','🇭🇳','U+1F1ED U+1F1F3','2018-07-21 07:11:03','2022-05-21 21:32:07'),(98,'Hong Kong S.A.R.','香港','HK','HKG','852','Hong Kong','HKD','Hong Kong dollar','$','Asia','Eastern Asia','🇭🇰','U+1F1ED U+1F1F0','2018-07-21 07:11:03','2022-05-21 21:32:07'),(99,'Hungary','Magyarország','HU','HUN','36','Budapest','HUF','Hungarian forint','Ft','Europe','Eastern Europe','🇭🇺','U+1F1ED U+1F1FA','2018-07-21 07:11:03','2022-05-21 21:32:07'),(100,'Iceland','Ísland','IS','ISL','354','Reykjavik','ISK','Icelandic króna','kr','Europe','Northern Europe','🇮🇸','U+1F1EE U+1F1F8','2018-07-21 07:11:03','2022-05-21 21:32:07'),(101,'India','भारत','IN','IND','91','New Delhi','INR','Indian rupee','₹','Asia','Southern Asia','🇮🇳','U+1F1EE U+1F1F3','2018-07-21 07:11:03','2022-05-21 21:32:07'),(102,'Indonesia','Indonesia','ID','IDN','62','Jakarta','IDR','Indonesian rupiah','Rp','Asia','South-Eastern Asia','🇮🇩','U+1F1EE U+1F1E9','2018-07-21 07:11:03','2022-05-21 21:32:07'),(103,'Iran','ایران','IR','IRN','98','Tehran','IRR','Iranian rial','﷼','Asia','Southern Asia','🇮🇷','U+1F1EE U+1F1F7','2018-07-21 07:11:03','2022-05-21 21:32:07'),(104,'Iraq','العراق','IQ','IRQ','964','Baghdad','IQD','Iraqi dinar','د.ع','Asia','Western Asia','🇮🇶','U+1F1EE U+1F1F6','2018-07-21 07:11:03','2022-05-21 21:32:07'),(105,'Ireland','Éire','IE','IRL','353','Dublin','EUR','Euro','€','Europe','Northern Europe','🇮🇪','U+1F1EE U+1F1EA','2018-07-21 07:11:03','2022-05-21 21:32:07'),(106,'Israel','יִשְׂרָאֵל','IL','ISR','972','Jerusalem','ILS','Israeli new shekel','₪','Asia','Western Asia','🇮🇱','U+1F1EE U+1F1F1','2018-07-21 07:11:03','2022-05-21 21:32:07'),(107,'Italy','Italia','IT','ITA','39','Rome','EUR','Euro','€','Europe','Southern Europe','🇮🇹','U+1F1EE U+1F1F9','2018-07-21 07:11:03','2022-05-21 21:32:07'),(108,'Jamaica','Jamaica','JM','JAM','1','Kingston','JMD','Jamaican dollar','J$','Americas','Caribbean','🇯🇲','U+1F1EF U+1F1F2','2018-07-21 07:11:03','2022-05-21 21:32:07'),(109,'Japan','日本','JP','JPN','81','Tokyo','JPY','Japanese yen','¥','Asia','Eastern Asia','🇯🇵','U+1F1EF U+1F1F5','2018-07-21 07:11:03','2022-05-21 21:32:07'),(110,'Jersey','Jersey','JE','JEY','44','Saint Helier','GBP','British pound','£','Europe','Northern Europe','🇯🇪','U+1F1EF U+1F1EA','2018-07-21 07:11:03','2022-05-21 21:32:07'),(111,'Jordan','الأردن','JO','JOR','962','Amman','JOD','Jordanian dinar','ا.د','Asia','Western Asia','🇯🇴','U+1F1EF U+1F1F4','2018-07-21 07:11:03','2022-05-21 21:32:07'),(112,'Kazakhstan','Қазақстан','KZ','KAZ','7','Astana','KZT','Kazakhstani tenge','лв','Asia','Central Asia','🇰🇿','U+1F1F0 U+1F1FF','2018-07-21 07:11:03','2022-05-21 21:32:07'),(113,'Kenya','Kenya','KE','KEN','254','Nairobi','KES','Kenyan shilling','KSh','Africa','Eastern Africa','🇰🇪','U+1F1F0 U+1F1EA','2018-07-21 07:11:03','2022-05-21 21:32:07'),(114,'Kiribati','Kiribati','KI','KIR','686','Tarawa','AUD','Australian dollar','$','Oceania','Micronesia','🇰🇮','U+1F1F0 U+1F1EE','2018-07-21 07:11:03','2022-05-21 21:32:07'),(115,'North Korea','북한','KP','PRK','850','Pyongyang','KPW','North Korean Won','₩','Asia','Eastern Asia','🇰🇵','U+1F1F0 U+1F1F5','2018-07-21 07:11:03','2022-05-21 21:32:07'),(116,'South Korea','대한민국','KR','KOR','82','Seoul','KRW','Won','₩','Asia','Eastern Asia','🇰🇷','U+1F1F0 U+1F1F7','2018-07-21 07:11:03','2022-05-21 21:32:07'),(117,'Kuwait','الكويت','KW','KWT','965','Kuwait City','KWD','Kuwaiti dinar','ك.د','Asia','Western Asia','🇰🇼','U+1F1F0 U+1F1FC','2018-07-21 07:11:03','2022-05-21 21:32:07'),(118,'Kyrgyzstan','Кыргызстан','KG','KGZ','996','Bishkek','KGS','Kyrgyzstani som','лв','Asia','Central Asia','🇰🇬','U+1F1F0 U+1F1EC','2018-07-21 07:11:03','2022-05-21 21:32:07'),(119,'Laos','ສປປລາວ','LA','LAO','856','Vientiane','LAK','Lao kip','₭','Asia','South-Eastern Asia','🇱🇦','U+1F1F1 U+1F1E6','2018-07-21 07:11:03','2022-05-21 21:32:07'),(120,'Latvia','Latvija','LV','LVA','371','Riga','EUR','Euro','€','Europe','Northern Europe','🇱🇻','U+1F1F1 U+1F1FB','2018-07-21 07:11:03','2022-05-21 21:32:07'),(121,'Lebanon','لبنان','LB','LBN','961','Beirut','LBP','Lebanese pound','£','Asia','Western Asia','🇱🇧','U+1F1F1 U+1F1E7','2018-07-21 07:11:03','2022-05-21 21:32:07'),(122,'Lesotho','Lesotho','LS','LSO','266','Maseru','LSL','Lesotho loti','L','Africa','Southern Africa','🇱🇸','U+1F1F1 U+1F1F8','2018-07-21 07:11:03','2022-05-21 21:32:07'),(123,'Liberia','Liberia','LR','LBR','231','Monrovia','LRD','Liberian dollar','$','Africa','Western Africa','🇱🇷','U+1F1F1 U+1F1F7','2018-07-21 07:11:03','2022-05-21 21:32:07'),(124,'Libya','‏ليبيا','LY','LBY','218','Tripolis','LYD','Libyan dinar','د.ل','Africa','Northern Africa','🇱🇾','U+1F1F1 U+1F1FE','2018-07-21 07:11:03','2022-05-21 21:32:07'),(125,'Liechtenstein','Liechtenstein','LI','LIE','423','Vaduz','CHF','Swiss franc','CHf','Europe','Western Europe','🇱🇮','U+1F1F1 U+1F1EE','2018-07-21 07:11:03','2022-05-21 21:32:07'),(126,'Lithuania','Lietuva','LT','LTU','370','Vilnius','EUR','Euro','€','Europe','Northern Europe','🇱🇹','U+1F1F1 U+1F1F9','2018-07-21 07:11:03','2022-05-21 21:32:07'),(127,'Luxembourg','Luxembourg','LU','LUX','352','Luxembourg','EUR','Euro','€','Europe','Western Europe','🇱🇺','U+1F1F1 U+1F1FA','2018-07-21 07:11:03','2022-05-21 21:32:07'),(128,'Macau S.A.R.','澳門','MO','MAC','853','Macao','MOP','Macanese pataca','$','Asia','Eastern Asia','🇲🇴','U+1F1F2 U+1F1F4','2018-07-21 07:11:03','2022-05-21 21:32:07'),(129,'Macedonia','Северна Македонија','MK','MKD','389','Skopje','MKD','Denar','ден','Europe','Southern Europe','🇲🇰','U+1F1F2 U+1F1F0','2018-07-21 07:11:03','2022-05-21 21:32:07'),(130,'Madagascar','Madagasikara','MG','MDG','261','Antananarivo','MGA','Malagasy ariary','Ar','Africa','Eastern Africa','🇲🇬','U+1F1F2 U+1F1EC','2018-07-21 07:11:03','2022-05-21 21:32:07'),(131,'Malawi','Malawi','MW','MWI','265','Lilongwe','MWK','Malawian kwacha','MK','Africa','Eastern Africa','🇲🇼','U+1F1F2 U+1F1FC','2018-07-21 07:11:03','2022-05-21 21:32:07'),(132,'Malaysia','Malaysia','MY','MYS','60','Kuala Lumpur','MYR','Malaysian ringgit','RM','Asia','South-Eastern Asia','🇲🇾','U+1F1F2 U+1F1FE','2018-07-21 07:11:03','2022-05-21 21:32:07'),(133,'Maldives','Maldives','MV','MDV','960','Male','MVR','Maldivian rufiyaa','Rf','Asia','Southern Asia','🇲🇻','U+1F1F2 U+1F1FB','2018-07-21 07:11:03','2022-05-21 21:32:07'),(134,'Mali','Mali','ML','MLI','223','Bamako','XOF','West African CFA franc','CFA','Africa','Western Africa','🇲🇱','U+1F1F2 U+1F1F1','2018-07-21 07:11:03','2022-05-21 21:32:07'),(135,'Malta','Malta','MT','MLT','356','Valletta','EUR','Euro','€','Europe','Southern Europe','🇲🇹','U+1F1F2 U+1F1F9','2018-07-21 07:11:03','2022-05-21 21:32:07'),(136,'Man (Isle of)','Isle of Man','IM','IMN','44','Douglas, Isle of Man','GBP','British pound','£','Europe','Northern Europe','🇮🇲','U+1F1EE U+1F1F2','2018-07-21 07:11:03','2022-05-21 21:32:07'),(137,'Marshall Islands','M̧ajeļ','MH','MHL','692','Majuro','USD','United States dollar','$','Oceania','Micronesia','🇲🇭','U+1F1F2 U+1F1ED','2018-07-21 07:11:03','2022-05-21 21:32:07'),(138,'Martinique','Martinique','MQ','MTQ','596','Fort-de-France','EUR','Euro','€','Americas','Caribbean','🇲🇶','U+1F1F2 U+1F1F6','2018-07-21 07:11:03','2022-05-21 21:32:07'),(139,'Mauritania','موريتانيا','MR','MRT','222','Nouakchott','MRO','Mauritanian ouguiya','MRU','Africa','Western Africa','🇲🇷','U+1F1F2 U+1F1F7','2018-07-21 07:11:03','2022-05-21 21:32:07'),(140,'Mauritius','Maurice','MU','MUS','230','Port Louis','MUR','Mauritian rupee','₨','Africa','Eastern Africa','🇲🇺','U+1F1F2 U+1F1FA','2018-07-21 07:11:03','2022-05-21 21:32:07'),(141,'Mayotte','Mayotte','YT','MYT','262','Mamoudzou','EUR','Euro','€','Africa','Eastern Africa','🇾🇹','U+1F1FE U+1F1F9','2018-07-21 07:11:03','2022-05-21 21:32:07'),(142,'Mexico','México','MX','MEX','52','Ciudad de México','MXN','Mexican peso','$','Americas','Central America','🇲🇽','U+1F1F2 U+1F1FD','2018-07-21 07:11:03','2022-05-21 21:32:07'),(143,'Micronesia','Micronesia','FM','FSM','691','Palikir','USD','United States dollar','$','Oceania','Micronesia','🇫🇲','U+1F1EB U+1F1F2','2018-07-21 07:11:03','2022-05-21 21:32:07'),(144,'Moldova','Moldova','MD','MDA','373','Chisinau','MDL','Moldovan leu','L','Europe','Eastern Europe','🇲🇩','U+1F1F2 U+1F1E9','2018-07-21 07:11:03','2022-05-21 21:32:07'),(145,'Monaco','Monaco','MC','MCO','377','Monaco','EUR','Euro','€','Europe','Western Europe','🇲🇨','U+1F1F2 U+1F1E8','2018-07-21 07:11:03','2022-05-21 21:32:07'),(146,'Mongolia','Монгол улс','MN','MNG','976','Ulan Bator','MNT','Mongolian tögrög','₮','Asia','Eastern Asia','🇲🇳','U+1F1F2 U+1F1F3','2018-07-21 07:11:03','2022-05-21 21:32:07'),(147,'Montenegro','Црна Гора','ME','MNE','382','Podgorica','EUR','Euro','€','Europe','Southern Europe','🇲🇪','U+1F1F2 U+1F1EA','2018-07-21 07:11:03','2022-05-21 21:32:07'),(148,'Montserrat','Montserrat','MS','MSR','1','Plymouth','XCD','Eastern Caribbean dollar','$','Americas','Caribbean','🇲🇸','U+1F1F2 U+1F1F8','2018-07-21 07:11:03','2022-05-21 21:32:07'),(149,'Morocco','المغرب','MA','MAR','212','Rabat','MAD','Moroccan dirham','DH','Africa','Northern Africa','🇲🇦','U+1F1F2 U+1F1E6','2018-07-21 07:11:03','2022-05-21 21:32:07'),(150,'Mozambique','Moçambique','MZ','MOZ','258','Maputo','MZN','Mozambican metical','MT','Africa','Eastern Africa','🇲🇿','U+1F1F2 U+1F1FF','2018-07-21 07:11:03','2022-05-21 21:32:07'),(151,'Myanmar','မြန်မာ','MM','MMR','95','Nay Pyi Taw','MMK','Burmese kyat','K','Asia','South-Eastern Asia','🇲🇲','U+1F1F2 U+1F1F2','2018-07-21 07:11:03','2022-05-21 21:32:07'),(152,'Namibia','Namibia','NA','NAM','264','Windhoek','NAD','Namibian dollar','$','Africa','Southern Africa','🇳🇦','U+1F1F3 U+1F1E6','2018-07-21 07:11:03','2022-05-21 21:32:07'),(153,'Nauru','Nauru','NR','NRU','674','Yaren','AUD','Australian dollar','$','Oceania','Micronesia','🇳🇷','U+1F1F3 U+1F1F7','2018-07-21 07:11:03','2022-05-21 21:32:07'),(154,'Nepal','नपल','NP','NPL','977','Kathmandu','NPR','Nepalese rupee','₨','Asia','Southern Asia','🇳🇵','U+1F1F3 U+1F1F5','2018-07-21 07:11:03','2022-05-21 21:32:07'),(155,'Bonaire, Sint Eustatius and Saba','Caribisch Nederland','BQ','BES','599','Kralendijk','USD','United States dollar','$','Americas','Caribbean','🇧🇶','U+1F1E7 U+1F1F6','2018-07-21 07:11:03','2022-05-21 21:32:07'),(156,'Netherlands','Nederland','NL','NLD','31','Amsterdam','EUR','Euro','€','Europe','Western Europe','🇳🇱','U+1F1F3 U+1F1F1','2018-07-21 07:11:03','2022-05-21 21:32:07'),(157,'New Caledonia','Nouvelle-Calédonie','NC','NCL','687','Noumea','XPF','CFP franc','₣','Oceania','Melanesia','🇳🇨','U+1F1F3 U+1F1E8','2018-07-21 07:11:03','2022-05-21 21:32:07'),(158,'New Zealand','New Zealand','NZ','NZL','64','Wellington','NZD','New Zealand dollar','$','Oceania','Australia and New Zealand','🇳🇿','U+1F1F3 U+1F1FF','2018-07-21 07:11:03','2022-05-21 21:32:07'),(159,'Nicaragua','Nicaragua','NI','NIC','505','Managua','NIO','Nicaraguan córdoba','C$','Americas','Central America','🇳🇮','U+1F1F3 U+1F1EE','2018-07-21 07:11:03','2022-05-21 21:32:07'),(160,'Niger','Niger','NE','NER','227','Niamey','XOF','West African CFA franc','CFA','Africa','Western Africa','🇳🇪','U+1F1F3 U+1F1EA','2018-07-21 07:11:03','2022-05-21 21:32:07'),(161,'Nigeria','Nigeria','NG','NGA','234','Abuja','NGN','Nigerian naira','₦','Africa','Western Africa','🇳🇬','U+1F1F3 U+1F1EC','2018-07-21 07:11:03','2022-05-21 21:32:07'),(162,'Niue','Niuē','NU','NIU','683','Alofi','NZD','New Zealand dollar','$','Oceania','Polynesia','🇳🇺','U+1F1F3 U+1F1FA','2018-07-21 07:11:03','2022-05-21 21:32:07'),(163,'Norfolk Island','Norfolk Island','NF','NFK','672','Kingston','AUD','Australian dollar','$','Oceania','Australia and New Zealand','🇳🇫','U+1F1F3 U+1F1EB','2018-07-21 07:11:03','2022-05-21 21:32:07'),(164,'Northern Mariana Islands','Northern Mariana Islands','MP','MNP','1','Saipan','USD','United States dollar','$','Oceania','Micronesia','🇲🇵','U+1F1F2 U+1F1F5','2018-07-21 07:11:03','2022-05-21 21:32:07'),(165,'Norway','Norge','NO','NOR','47','Oslo','NOK','Norwegian krone','kr','Europe','Northern Europe','🇳🇴','U+1F1F3 U+1F1F4','2018-07-21 07:11:03','2022-05-21 21:32:07'),(166,'Oman','عمان','OM','OMN','968','Muscat','OMR','Omani rial','.ع.ر','Asia','Western Asia','🇴🇲','U+1F1F4 U+1F1F2','2018-07-21 07:11:03','2022-05-21 21:32:07'),(167,'Pakistan','Pakistan','PK','PAK','92','Islamabad','PKR','Pakistani rupee','₨','Asia','Southern Asia','🇵🇰','U+1F1F5 U+1F1F0','2018-07-21 07:11:03','2022-05-21 21:32:07'),(168,'Palau','Palau','PW','PLW','680','Melekeok','USD','United States dollar','$','Oceania','Micronesia','🇵🇼','U+1F1F5 U+1F1FC','2018-07-21 07:11:03','2022-05-21 21:32:07'),(169,'Palestinian Territory Occupied','فلسطين','PS','PSE','970','East Jerusalem','ILS','Israeli new shekel','₪','Asia','Western Asia','🇵🇸','U+1F1F5 U+1F1F8','2018-07-21 07:11:03','2022-05-21 21:32:07'),(170,'Panama','Panamá','PA','PAN','507','Panama City','PAB','Panamanian balboa','B/.','Americas','Central America','🇵🇦','U+1F1F5 U+1F1E6','2018-07-21 07:11:03','2022-05-21 21:32:07'),(171,'Papua new Guinea','Papua Niugini','PG','PNG','675','Port Moresby','PGK','Papua New Guinean kina','K','Oceania','Melanesia','🇵🇬','U+1F1F5 U+1F1EC','2018-07-21 07:11:03','2022-05-21 21:32:07'),(172,'Paraguay','Paraguay','PY','PRY','595','Asuncion','PYG','Paraguayan guarani','₲','Americas','South America','🇵🇾','U+1F1F5 U+1F1FE','2018-07-21 07:11:03','2022-05-21 21:32:07'),(173,'Peru','Perú','PE','PER','51','Lima','PEN','Peruvian sol','S/.','Americas','South America','🇵🇪','U+1F1F5 U+1F1EA','2018-07-21 07:11:03','2022-05-21 21:32:07'),(174,'Philippines','Pilipinas','PH','PHL','63','Manila','PHP','Philippine peso','₱','Asia','South-Eastern Asia','🇵🇭','U+1F1F5 U+1F1ED','2018-07-21 07:11:03','2022-05-21 21:32:07'),(175,'Pitcairn Island','Pitcairn Islands','PN','PCN','870','Adamstown','NZD','New Zealand dollar','$','Oceania','Polynesia','🇵🇳','U+1F1F5 U+1F1F3','2018-07-21 07:11:03','2022-05-21 21:32:07'),(176,'Poland','Polska','PL','POL','48','Warsaw','PLN','Polish złoty','zł','Europe','Eastern Europe','🇵🇱','U+1F1F5 U+1F1F1','2018-07-21 07:11:03','2022-05-21 21:32:07'),(177,'Portugal','Portugal','PT','PRT','351','Lisbon','EUR','Euro','€','Europe','Southern Europe','🇵🇹','U+1F1F5 U+1F1F9','2018-07-21 07:11:03','2022-05-21 21:32:07'),(178,'Puerto Rico','Puerto Rico','PR','PRI','1','San Juan','USD','United States dollar','$','Americas','Caribbean','🇵🇷','U+1F1F5 U+1F1F7','2018-07-21 07:11:03','2022-05-21 21:32:07'),(179,'Qatar','قطر','QA','QAT','974','Doha','QAR','Qatari riyal','ق.ر','Asia','Western Asia','🇶🇦','U+1F1F6 U+1F1E6','2018-07-21 07:11:03','2022-05-21 21:32:07'),(180,'Reunion','La Réunion','RE','REU','262','Saint-Denis','EUR','Euro','€','Africa','Eastern Africa','🇷🇪','U+1F1F7 U+1F1EA','2018-07-21 07:11:03','2022-05-21 21:32:07'),(181,'Romania','România','RO','ROU','40','Bucharest','RON','Romanian leu','lei','Europe','Eastern Europe','🇷🇴','U+1F1F7 U+1F1F4','2018-07-21 07:11:03','2022-05-21 21:32:07'),(182,'Russia','Россия','RU','RUS','7','Moscow','RUB','Russian ruble','₽','Europe','Eastern Europe','🇷🇺','U+1F1F7 U+1F1FA','2018-07-21 07:11:03','2022-05-21 21:32:07'),(183,'Rwanda','Rwanda','RW','RWA','250','Kigali','RWF','Rwandan franc','FRw','Africa','Eastern Africa','🇷🇼','U+1F1F7 U+1F1FC','2018-07-21 07:11:03','2022-05-21 21:32:07'),(184,'Saint Helena','Saint Helena','SH','SHN','290','Jamestown','SHP','Saint Helena pound','£','Africa','Western Africa','🇸🇭','U+1F1F8 U+1F1ED','2018-07-21 07:11:03','2022-05-21 21:32:07'),(185,'Saint Kitts And Nevis','Saint Kitts and Nevis','KN','KNA','1','Basseterre','XCD','Eastern Caribbean dollar','$','Americas','Caribbean','🇰🇳','U+1F1F0 U+1F1F3','2018-07-21 07:11:03','2022-05-21 21:32:07'),(186,'Saint Lucia','Saint Lucia','LC','LCA','1','Castries','XCD','Eastern Caribbean dollar','$','Americas','Caribbean','🇱🇨','U+1F1F1 U+1F1E8','2018-07-21 07:11:03','2022-05-21 21:32:07'),(187,'Saint Pierre and Miquelon','Saint-Pierre-et-Miquelon','PM','SPM','508','Saint-Pierre','EUR','Euro','€','Americas','Northern America','🇵🇲','U+1F1F5 U+1F1F2','2018-07-21 07:11:03','2022-05-21 21:32:07'),(188,'Saint Vincent And The Grenadines','Saint Vincent and the Grenadines','VC','VCT','1','Kingstown','XCD','Eastern Caribbean dollar','$','Americas','Caribbean','🇻🇨','U+1F1FB U+1F1E8','2018-07-21 07:11:03','2022-05-21 21:39:27'),(189,'Saint-Barthelemy','Saint-Barthélemy','BL','BLM','590','Gustavia','EUR','Euro','€','Americas','Caribbean','🇧🇱','U+1F1E7 U+1F1F1','2018-07-21 07:11:03','2022-05-21 21:39:27'),(190,'Saint-Martin (French part)','Saint-Martin','MF','MAF','590','Marigot','EUR','Euro','€','Americas','Caribbean','🇲🇫','U+1F1F2 U+1F1EB','2018-07-21 07:11:03','2022-05-21 21:39:27'),(191,'Samoa','Samoa','WS','WSM','685','Apia','WST','Samoan tālā','SAT','Oceania','Polynesia','🇼🇸','U+1F1FC U+1F1F8','2018-07-21 07:11:03','2022-05-21 21:39:27'),(192,'San Marino','San Marino','SM','SMR','378','San Marino','EUR','Euro','€','Europe','Southern Europe','🇸🇲','U+1F1F8 U+1F1F2','2018-07-21 07:11:03','2022-05-21 21:39:27'),(193,'Sao Tome and Principe','São Tomé e Príncipe','ST','STP','239','Sao Tome','STD','Dobra','Db','Africa','Middle Africa','🇸🇹','U+1F1F8 U+1F1F9','2018-07-21 07:11:03','2022-05-21 21:39:27'),(194,'Saudi Arabia','المملكة العربية السعودية','SA','SAU','966','Riyadh','SAR','Saudi riyal','﷼','Asia','Western Asia','🇸🇦','U+1F1F8 U+1F1E6','2018-07-21 07:11:03','2022-05-21 21:39:27'),(195,'Senegal','Sénégal','SN','SEN','221','Dakar','XOF','West African CFA franc','CFA','Africa','Western Africa','🇸🇳','U+1F1F8 U+1F1F3','2018-07-21 07:11:03','2022-05-21 21:39:27'),(196,'Serbia','Србија','RS','SRB','381','Belgrade','RSD','Serbian dinar','din','Europe','Southern Europe','🇷🇸','U+1F1F7 U+1F1F8','2018-07-21 07:11:03','2022-05-21 21:39:27'),(197,'Seychelles','Seychelles','SC','SYC','248','Victoria','SCR','Seychellois rupee','SRe','Africa','Eastern Africa','🇸🇨','U+1F1F8 U+1F1E8','2018-07-21 07:11:03','2022-05-21 21:39:27'),(198,'Sierra Leone','Sierra Leone','SL','SLE','232','Freetown','SLL','Sierra Leonean leone','Le','Africa','Western Africa','🇸🇱','U+1F1F8 U+1F1F1','2018-07-21 07:11:03','2022-05-21 21:39:27'),(199,'Singapore','Singapore','SG','SGP','65','Singapur','SGD','Singapore dollar','$','Asia','South-Eastern Asia','🇸🇬','U+1F1F8 U+1F1EC','2018-07-21 07:11:03','2022-05-21 21:39:27'),(200,'Slovakia','Slovensko','SK','SVK','421','Bratislava','EUR','Euro','€','Europe','Eastern Europe','🇸🇰','U+1F1F8 U+1F1F0','2018-07-21 07:11:03','2022-05-21 21:39:27'),(201,'Slovenia','Slovenija','SI','SVN','386','Ljubljana','EUR','Euro','€','Europe','Southern Europe','🇸🇮','U+1F1F8 U+1F1EE','2018-07-21 07:11:03','2022-05-21 21:39:27'),(202,'Solomon Islands','Solomon Islands','SB','SLB','677','Honiara','SBD','Solomon Islands dollar','Si$','Oceania','Melanesia','🇸🇧','U+1F1F8 U+1F1E7','2018-07-21 07:11:03','2022-05-21 21:39:27'),(203,'Somalia','Soomaaliya','SO','SOM','252','Mogadishu','SOS','Somali shilling','Sh.so.','Africa','Eastern Africa','🇸🇴','U+1F1F8 U+1F1F4','2018-07-21 07:11:03','2022-05-21 21:39:27'),(204,'South Africa','South Africa','ZA','ZAF','27','Pretoria','ZAR','South African rand','R','Africa','Southern Africa','🇿🇦','U+1F1FF U+1F1E6','2018-07-21 07:11:03','2022-05-21 21:39:27'),(205,'South Georgia','South Georgia','GS','SGS','500','Grytviken','GBP','British pound','£','Americas','South America','🇬🇸','U+1F1EC U+1F1F8','2018-07-21 07:11:03','2022-05-21 21:39:27'),(206,'South Sudan','South Sudan','SS','SSD','211','Juba','SSP','South Sudanese pound','£','Africa','Middle Africa','🇸🇸','U+1F1F8 U+1F1F8','2018-07-21 07:11:03','2022-05-21 21:39:27'),(207,'Spain','España','ES','ESP','34','Madrid','EUR','Euro','€','Europe','Southern Europe','🇪🇸','U+1F1EA U+1F1F8','2018-07-21 07:11:03','2022-05-21 21:39:27'),(208,'Sri Lanka','śrī laṃkāva','LK','LKA','94','Colombo','LKR','Sri Lankan rupee','Rs','Asia','Southern Asia','🇱🇰','U+1F1F1 U+1F1F0','2018-07-21 07:11:03','2022-05-21 21:39:27'),(209,'Sudan','السودان','SD','SDN','249','Khartoum','SDG','Sudanese pound','.س.ج','Africa','Northern Africa','🇸🇩','U+1F1F8 U+1F1E9','2018-07-21 07:11:03','2022-05-21 21:39:27'),(210,'Suriname','Suriname','SR','SUR','597','Paramaribo','SRD','Surinamese dollar','$','Americas','South America','🇸🇷','U+1F1F8 U+1F1F7','2018-07-21 07:11:03','2022-05-21 21:39:27'),(211,'Svalbard And Jan Mayen Islands','Svalbard og Jan Mayen','SJ','SJM','47','Longyearbyen','NOK','Norwegian Krone','kr','Europe','Northern Europe','🇸🇯','U+1F1F8 U+1F1EF','2018-07-21 07:11:03','2022-05-21 21:39:27'),(212,'Swaziland','Swaziland','SZ','SWZ','268','Mbabane','SZL','Lilangeni','E','Africa','Southern Africa','🇸🇿','U+1F1F8 U+1F1FF','2018-07-21 07:11:03','2022-05-21 21:39:27'),(213,'Sweden','Sverige','SE','SWE','46','Stockholm','SEK','Swedish krona','kr','Europe','Northern Europe','🇸🇪','U+1F1F8 U+1F1EA','2018-07-21 07:11:03','2022-05-21 21:39:27'),(214,'Switzerland','Schweiz','CH','CHE','41','Bern','CHF','Swiss franc','CHf','Europe','Western Europe','🇨🇭','U+1F1E8 U+1F1ED','2018-07-21 07:11:03','2022-05-21 21:39:27'),(215,'Syria','سوريا','SY','SYR','963','Damascus','SYP','Syrian pound','LS','Asia','Western Asia','🇸🇾','U+1F1F8 U+1F1FE','2018-07-21 07:11:03','2022-05-21 21:39:27'),(216,'Taiwan','臺灣','TW','TWN','886','Taipei','TWD','New Taiwan dollar','$','Asia','Eastern Asia','🇹🇼','U+1F1F9 U+1F1FC','2018-07-21 07:11:03','2022-05-21 21:39:27'),(217,'Tajikistan','Тоҷикистон','TJ','TJK','992','Dushanbe','TJS','Tajikistani somoni','SM','Asia','Central Asia','🇹🇯','U+1F1F9 U+1F1EF','2018-07-21 07:11:03','2022-05-21 21:39:27'),(218,'Tanzania','Tanzania','TZ','TZA','255','Dodoma','TZS','Tanzanian shilling','TSh','Africa','Eastern Africa','🇹🇿','U+1F1F9 U+1F1FF','2018-07-21 07:11:03','2022-05-21 21:39:27'),(219,'Thailand','ประเทศไทย','TH','THA','66','Bangkok','THB','Thai baht','฿','Asia','South-Eastern Asia','🇹🇭','U+1F1F9 U+1F1ED','2018-07-21 07:11:03','2022-05-21 21:39:27'),(220,'Togo','Togo','TG','TGO','228','Lome','XOF','West African CFA franc','CFA','Africa','Western Africa','🇹🇬','U+1F1F9 U+1F1EC','2018-07-21 07:11:03','2022-05-21 21:39:27'),(221,'Tokelau','Tokelau','TK','TKL','690','','NZD','New Zealand dollar','$','Oceania','Polynesia','🇹🇰','U+1F1F9 U+1F1F0','2018-07-21 07:11:03','2022-05-21 21:39:27'),(222,'Tonga','Tonga','TO','TON','676','Nuku\'alofa','TOP','Tongan paʻanga','$','Oceania','Polynesia','🇹🇴','U+1F1F9 U+1F1F4','2018-07-21 07:11:03','2022-05-21 21:39:27'),(223,'Trinidad And Tobago','Trinidad and Tobago','TT','TTO','1','Port of Spain','TTD','Trinidad and Tobago dollar','$','Americas','Caribbean','🇹🇹','U+1F1F9 U+1F1F9','2018-07-21 07:11:03','2022-05-21 21:39:27'),(224,'Tunisia','تونس','TN','TUN','216','Tunis','TND','Tunisian dinar','ت.د','Africa','Northern Africa','🇹🇳','U+1F1F9 U+1F1F3','2018-07-21 07:11:03','2022-05-21 21:39:27'),(225,'Turkey','Türkiye','TR','TUR','90','Ankara','TRY','Turkish lira','₺','Asia','Western Asia','🇹🇷','U+1F1F9 U+1F1F7','2018-07-21 07:11:03','2022-05-21 21:39:27'),(226,'Turkmenistan','Türkmenistan','TM','TKM','993','Ashgabat','TMT','Turkmenistan manat','T','Asia','Central Asia','🇹🇲','U+1F1F9 U+1F1F2','2018-07-21 07:11:03','2022-05-21 21:39:27'),(227,'Turks And Caicos Islands','Turks and Caicos Islands','TC','TCA','1','Cockburn Town','USD','United States dollar','$','Americas','Caribbean','🇹🇨','U+1F1F9 U+1F1E8','2018-07-21 07:11:03','2022-05-21 21:39:27'),(228,'Tuvalu','Tuvalu','TV','TUV','688','Funafuti','AUD','Australian dollar','$','Oceania','Polynesia','🇹🇻','U+1F1F9 U+1F1FB','2018-07-21 07:11:03','2022-05-21 21:39:27'),(229,'Uganda','Uganda','UG','UGA','256','Kampala','UGX','Ugandan shilling','USh','Africa','Eastern Africa','🇺🇬','U+1F1FA U+1F1EC','2018-07-21 07:11:03','2022-05-21 21:39:27'),(230,'Ukraine','Україна','UA','UKR','380','Kiev','UAH','Ukrainian hryvnia','₴','Europe','Eastern Europe','🇺🇦','U+1F1FA U+1F1E6','2018-07-21 07:11:03','2022-05-21 21:39:27'),(231,'United Arab Emirates','دولة الإمارات العربية المتحدة','AE','ARE','971','Abu Dhabi','AED','United Arab Emirates dirham','إ.د','Asia','Western Asia','🇦🇪','U+1F1E6 U+1F1EA','2018-07-21 07:11:03','2022-05-21 21:39:27'),(232,'United Kingdom','United Kingdom','GB','GBR','44','London','GBP','British pound','£','Europe','Northern Europe','🇬🇧','U+1F1EC U+1F1E7','2018-07-21 07:11:03','2022-05-21 21:39:27'),(233,'United States','United States','US','USA','1','Washington','USD','United States dollar','$','Americas','Northern America','🇺🇸','U+1F1FA U+1F1F8','2018-07-21 07:11:03','2022-05-21 21:39:27'),(234,'United States Minor Outlying Islands','United States Minor Outlying Islands','UM','UMI','1','','USD','United States dollar','$','Americas','Northern America','🇺🇲','U+1F1FA U+1F1F2','2018-07-21 07:11:03','2022-05-21 21:39:27'),(235,'Uruguay','Uruguay','UY','URY','598','Montevideo','UYU','Uruguayan peso','$','Americas','South America','🇺🇾','U+1F1FA U+1F1FE','2018-07-21 07:11:03','2022-05-21 21:39:27'),(236,'Uzbekistan','O‘zbekiston','UZ','UZB','998','Tashkent','UZS','Uzbekistani soʻm','лв','Asia','Central Asia','🇺🇿','U+1F1FA U+1F1FF','2018-07-21 07:11:03','2022-05-21 21:39:27'),(237,'Vanuatu','Vanuatu','VU','VUT','678','Port Vila','VUV','Vanuatu vatu','VT','Oceania','Melanesia','🇻🇺','U+1F1FB U+1F1FA','2018-07-21 07:11:03','2022-05-21 21:39:27'),(238,'Vatican City State (Holy See)','Vaticano','VA','VAT','379','Vatican City','EUR','Euro','€','Europe','Southern Europe','🇻🇦','U+1F1FB U+1F1E6','2018-07-21 07:11:03','2022-05-21 21:39:27'),(239,'Venezuela','Venezuela','VE','VEN','58','Caracas','VEF','Bolívar','Bs','Americas','South America','🇻🇪','U+1F1FB U+1F1EA','2018-07-21 07:11:03','2022-05-21 21:39:27'),(240,'Vietnam','Việt Nam','VN','VNM','84','Hanoi','VND','Vietnamese đồng','₫','Asia','South-Eastern Asia','🇻🇳','U+1F1FB U+1F1F3','2018-07-21 07:11:03','2022-05-21 21:39:27'),(241,'Virgin Islands (British)','British Virgin Islands','VG','VGB','1','Road Town','USD','United States dollar','$','Americas','Caribbean','🇻🇬','U+1F1FB U+1F1EC','2018-07-21 07:11:03','2022-05-21 21:39:27'),(242,'Virgin Islands (US)','United States Virgin Islands','VI','VIR','1','Charlotte Amalie','USD','United States dollar','$','Americas','Caribbean','🇻🇮','U+1F1FB U+1F1EE','2018-07-21 07:11:03','2022-05-21 21:39:27'),(243,'Wallis And Futuna Islands','Wallis et Futuna','WF','WLF','681','Mata Utu','XPF','CFP franc','₣','Oceania','Polynesia','🇼🇫','U+1F1FC U+1F1EB','2018-07-21 07:11:03','2022-05-21 21:39:27'),(244,'Western Sahara','الصحراء الغربية','EH','ESH','212','El-Aaiun','MAD','Moroccan Dirham','MAD','Africa','Northern Africa','🇪🇭','U+1F1EA U+1F1ED','2018-07-21 07:11:03','2022-05-21 21:39:27'),(245,'Yemen','اليَمَن','YE','YEM','967','Sanaa','YER','Yemeni rial','﷼','Asia','Western Asia','🇾🇪','U+1F1FE U+1F1EA','2018-07-21 07:11:03','2022-05-21 21:39:27'),(246,'Zambia','Zambia','ZM','ZMB','260','Lusaka','ZMW','Zambian kwacha','ZK','Africa','Eastern Africa','🇿🇲','U+1F1FF U+1F1F2','2018-07-21 07:11:03','2022-05-21 21:39:27'),(247,'Zimbabwe','Zimbabwe','ZW','ZWE','263','Harare','ZWL','Zimbabwe Dollar','$','Africa','Eastern Africa','🇿🇼','U+1F1FF U+1F1FC','2018-07-21 07:11:03','2022-05-21 21:39:27'),(248,'Kosovo','Republika e Kosovës','XK','XKX','383','Pristina','EUR','Euro','€','Europe','Eastern Europe','🇽🇰','U+1F1FD U+1F1F0','2020-08-16 02:33:50','2022-05-21 21:39:27'),(249,'Curaçao','Curaçao','CW','CUW','599','Willemstad','ANG','Netherlands Antillean guilder','ƒ','Americas','Caribbean','🇨🇼','U+1F1E8 U+1F1FC','2020-10-26 01:54:20','2022-05-21 21:39:27'),(250,'Sint Maarten (Dutch part)','Sint Maarten','SX','SXM','1','Philipsburg','ANG','Netherlands Antillean guilder','ƒ','Americas','Caribbean','🇸🇽','U+1F1F8 U+1F1FD','2020-12-06 00:03:39','2022-05-21 21:39:27');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_country` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discount_collection`
--

DROP TABLE IF EXISTS `discount_collection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_collection` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `discount_id` bigint unsigned NOT NULL,
  `collection_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `discount_collection_discount_id_foreign` (`discount_id`),
  KEY `discount_collection_collection_id_foreign` (`collection_id`),
  CONSTRAINT `discount_collection_collection_id_foreign` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `discount_collection_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discount_collection`
--

LOCK TABLES `discount_collection` WRITE;
/*!40000 ALTER TABLE `discount_collection` DISABLE KEYS */;
/*!40000 ALTER TABLE `discount_collection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discount_product`
--

DROP TABLE IF EXISTS `discount_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount_product` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `discount_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `discount_product_discount_id_foreign` (`discount_id`),
  KEY `discount_product_product_id_foreign` (`product_id`),
  CONSTRAINT `discount_product_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `discount_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discount_product`
--

LOCK TABLES `discount_product` WRITE;
/*!40000 ALTER TABLE `discount_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `discount_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discounts`
--

DROP TABLE IF EXISTS `discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('fixed','percentage') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percentage',
  `value` decimal(12,2) NOT NULL,
  `usage_limit` int DEFAULT NULL,
  `usage_count` int NOT NULL DEFAULT '0',
  `applies_to` enum('collections','products','orders') COLLATE utf8mb4_unicode_ci NOT NULL,
  `starts_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `discounts_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discounts`
--

LOCK TABLES `discounts` WRITE;
/*!40000 ALTER TABLE `discounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `discounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `bio` text COLLATE utf8mb4_unicode_ci,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint unsigned NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `media_order_column_index` (`order_column`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `linkable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkable_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `incentive` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_items_menu_id_foreign` (`menu_id`),
  KEY `menu_items_parent_id_foreign` (`parent_id`),
  KEY `menu_items_linkable_type_linkable_id_index` (`linkable_type`,`linkable_id`),
  CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `menu_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menus_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metas`
--

DROP TABLE IF EXISTS `metas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `metas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `metable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metable_id` bigint unsigned NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `metas_metable_type_metable_id_index` (`metable_type`,`metable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metas`
--

LOCK TABLES `metas` WRITE;
/*!40000 ALTER TABLE `metas` DISABLE KEYS */;
/*!40000 ALTER TABLE `metas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_100000_create_password_resets_table',1),(2,'2017_03_04_000000_create_bans_table',1),(3,'2019_12_14_000001_create_personal_access_tokens_table',1),(4,'2022_11_08_030517_create_jobs_table',1),(5,'2022_11_08_030617_create_failed_jobs_table',1),(6,'2022_11_08_030710_create_sessions_table',1),(7,'2022_11_08_031241_create_employees_table',1),(8,'2022_11_08_031248_create_customers_table',1),(9,'2022_11_09_080032_create_media_table',1),(10,'2022_11_09_081441_create_settings_table',1),(11,'2022_11_09_090810_create_countries_table',1),(12,'2022_11_09_090820_create_addresses_table',1),(13,'2022_11_09_091019_create_collections_table',1),(14,'2022_11_09_091033_create_products_table',1),(15,'2022_11_09_091130_create_collection_product_table',1),(16,'2022_11_09_091212_create_options_table',1),(17,'2022_11_09_091246_create_option_values_table',1),(18,'2022_11_09_091314_create_variants_table',1),(19,'2022_11_09_091325_create_variant_attributes_table',1),(20,'2022_11_09_091458_create_shipping_zones_table',1),(21,'2022_11_09_091547_create_shipping_zone_countries_table',1),(22,'2022_11_09_091741_create_shipping_zone_rates_table',1),(23,'2022_11_09_091742_create_tax_zones_table',1),(24,'2022_11_09_091743_create_tax_zone_countries_table',1),(25,'2022_11_09_091744_create_tax_zone_rates_table',1),(26,'2022_11_09_091755_create_discounts_table',1),(27,'2022_11_09_091765_create_discount_collection_table',1),(28,'2022_11_09_091775_create_discount_product_table',1),(29,'2022_11_09_091805_create_payment_methods_table',1),(30,'2022_11_09_091833_create_carts_table',1),(31,'2022_11_09_091841_create_cart_items_table',1),(32,'2022_11_09_091842_create_cart_discounts_table',1),(33,'2022_11_09_091852_create_orders_table',1),(34,'2022_11_09_091907_create_order_items_table',1),(35,'2022_11_09_091908_create_order_discounts_table',1),(36,'2022_11_09_091910_create_payments_table',1),(37,'2022_11_09_091920_create_refunds_table',1),(38,'2022_11_09_091930_create_refund_items_table',1),(39,'2022_11_09_092000_create_shipments_table',1),(40,'2022_11_09_092003_create_shipment_items_table',1),(41,'2023_01_05_090525_create_reviews_table',1),(42,'2023_02_03_021456_create_metas_table',1),(43,'2023_05_04_021653_create_webhook_calls_table',1),(44,'2023_05_10_015616_create_general_settings',1),(45,'2023_05_11_091956_create_layout_settings',1),(46,'2023_05_11_231923_create_menus_table',1),(47,'2023_05_11_231927_create_menu_items_table',1),(48,'2023_05_14_010052_create_brand_settings',1),(49,'2023_05_15_230134_create_carousels_table',1),(50,'2023_05_15_230140_create_carousel_slides_table',1),(51,'2023_05_17_065916_create_template_settings',1),(52,'2023_05_19_030414_create_articles_table',1),(53,'2023_05_22_014214_create_tags_table',1),(54,'2023_05_22_014429_create_taggables_table',1),(55,'2023_05_24_063541_create_checkout_settings',1),(56,'2023_05_26_081055_create_pages_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `option_values`
--

DROP TABLE IF EXISTS `option_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `option_values` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `option_id` bigint unsigned NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `option_values_product_id_foreign` (`product_id`),
  KEY `option_values_option_id_foreign` (`option_id`),
  CONSTRAINT `option_values_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`) ON DELETE CASCADE,
  CONSTRAINT `option_values_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `option_values`
--

LOCK TABLES `option_values` WRITE;
/*!40000 ALTER TABLE `option_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `option_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visual` enum('text','color','image') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `options_product_id_foreign` (`product_id`),
  CONSTRAINT `options_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_discounts`
--

DROP TABLE IF EXISTS `order_discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_discounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `order_item_id` bigint unsigned DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('fixed','percentage','shipping') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_discounts_order_id_foreign` (`order_id`),
  KEY `order_discounts_order_item_id_foreign` (`order_item_id`),
  CONSTRAINT `order_discounts_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_discounts_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_discounts`
--

LOCK TABLES `order_discounts` WRITE;
/*!40000 ALTER TABLE `order_discounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_discounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `variant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `quantity` int NOT NULL DEFAULT '1',
  `subtotal` decimal(12,2) GENERATED ALWAYS AS ((`price` * `quantity`)) STORED,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  KEY `order_items_variant_id_foreign` (`variant_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `order_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned DEFAULT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `payment_method_id` bigint unsigned NOT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `shipping_rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `shipping_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unshipped',
  `tax_breakdown` json NOT NULL,
  `meta` json DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_customer_id_foreign` (`customer_id`),
  KEY `orders_payment_method_id_foreign` (`payment_method_id`),
  CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `template` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_methods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `instructions` text COLLATE utf8mb4_unicode_ci,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `is_third_party` tinyint(1) NOT NULL DEFAULT '0',
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_methods_identifier_unique` (`identifier`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` VALUES (1,'Cash on Delivery','Cash on Delivery','cash_on_delivery','Pay with cash on delivery',NULL,1,0,0,NULL,NULL,NULL),(2,'Bank deposit','Bank deposit','bank_deposit','Pay with bank deposit',NULL,0,0,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_order_id_foreign` (`order_id`),
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'DRAFT',
  `seo_title` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(320) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refund_items`
--

DROP TABLE IF EXISTS `refund_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `refund_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `refund_id` bigint unsigned NOT NULL,
  `order_id` bigint unsigned NOT NULL,
  `order_item_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `is_shipped` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `refund_items_refund_id_foreign` (`refund_id`),
  KEY `refund_items_order_id_foreign` (`order_id`),
  KEY `refund_items_order_item_id_foreign` (`order_item_id`),
  CONSTRAINT `refund_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `refund_items_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `refund_items_refund_id_foreign` FOREIGN KEY (`refund_id`) REFERENCES `refunds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_items`
--

LOCK TABLES `refund_items` WRITE;
/*!40000 ALTER TABLE `refund_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refunds`
--

DROP TABLE IF EXISTS `refunds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `refunds` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `refunds_order_id_foreign` (`order_id`),
  CONSTRAINT `refunds_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refunds`
--

LOCK TABLES `refunds` WRITE;
/*!40000 ALTER TABLE `refunds` DISABLE KEYS */;
/*!40000 ALTER TABLE `refunds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned NOT NULL,
  `rating` tinyint unsigned NOT NULL DEFAULT '5',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_customer_id_foreign` (`customer_id`),
  KEY `reviews_order_id_foreign` (`order_id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  CONSTRAINT `reviews_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `payload` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_group_name_unique` (`group`,`name`),
  KEY `settings_group_index` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'general','store_name',0,'\"bridgemonkcorp\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(2,'general','contact_email',0,'\"\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(3,'general','contact_phone',0,'\"\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(4,'general','cookie_consent_enabled',0,'false','2023-08-04 18:32:23','2023-08-04 18:32:23'),(5,'general','cookie_consent_message',0,'\"We uses cookies to ensure you get the best experience on our website.\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(6,'general','cookie_consent_agree',0,'\"Allow cookies\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(7,'general','cookie_consent_reject',0,'\"Decline\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(8,'general','license_key',0,'\"eyJpdiI6Ikhhd25ZWStEYno0Nkt1UW5xM3FkcFE9PSIsInZhbHVlIjoiNTk2ZEZqOXhuZmo5czB6SVpYVGE4Zz09IiwibWFjIjoiNmY1OWM5MzEzMTg5M2IwZTU4Mjg1YTZkMzVkMWU5YTQ0NmY1YzlmMWI0M2I4YTM2MjZmMmUwMTA3ZDI2Mzc3ZSIsInRhZyI6IiJ9\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(9,'general','license_user',0,'\"eyJpdiI6ImdGU3A4aG95emdETnpnaTU3aWFiMmc9PSIsInZhbHVlIjoiN1plTVE0R2kvVFhXUGNUMTJBK1c0UT09IiwibWFjIjoiNzZjNjBkMjI3Njk5NmIxNTNkMWIyZGViMzljODZhZmViNDdhOWZjYjk2M2RjNGMzODU2NTVkOTYxMGY4YWMyOSIsInRhZyI6IiJ9\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(10,'general','license_vendor',0,'\"Envato\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(11,'general','license_active',0,'false','2023-08-04 18:32:23','2023-08-04 18:32:23'),(12,'general','setup_finished',0,'false','2023-08-04 18:32:23','2023-08-04 18:32:23'),(13,'layout','header_top_bar_enabled',0,'true','2023-08-04 18:32:23','2023-08-04 18:32:23'),(14,'layout','header_top_bar_message',0,'\"Welcome to our store!\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(15,'layout','header_top_bar_menu_handle',0,'\"\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(16,'layout','header_main_menu_handle',0,'\"\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(17,'layout','footer_bottom_bar_enabled',0,'true','2023-08-04 18:32:23','2023-08-04 18:32:23'),(18,'layout','footer_bottom_bar_message',0,'\"© 2023 All rights reserved.\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(19,'layout','footer_bottom_bar_menu_handle',0,'\"\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(20,'layout','footer_main_menu_handle',0,'\"\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(21,'brand','slogan',0,'\"Modernize Your Home, Simplify Your Day with Our Appliances and Gadgets.\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(22,'brand','short_description',0,'\"Discover a vast selection of top-notch home appliances and electronic gadgets. Elevate your living with innovative, energy-efficient solutions.\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(23,'brand','logo_path',0,'\"\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(24,'brand','favicon_path',0,'\"\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(25,'brand','cover_path',0,'\"\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(26,'brand','social_links',0,'[{\"url\": \"\", \"name\": \"Facebook\", \"url_placeholder\": \"https://facebook.com/bridgemonkcorp\"}, {\"url\": \"\", \"name\": \"Twitter\", \"url_placeholder\": \"https://twitter.com/bridgemonkcorp\"}, {\"url\": \"\", \"name\": \"Pinterest\", \"url_placeholder\": \"https://pinterest.com/bridgemonkcorp\"}, {\"url\": \"\", \"name\": \"Instagram\", \"url_placeholder\": \"https://instagram.com/bridgemonkcorp\"}, {\"url\": \"\", \"name\": \"TikTok\", \"url_placeholder\": \"https://tiktok.com/@bridgemonkcorp\"}, {\"url\": \"\", \"name\": \"Tumblr\", \"url_placeholder\": \"https://bridgemonkcorp.tumblr.com\"}, {\"url\": \"\", \"name\": \"Snapchat\", \"url_placeholder\": \"https://snapchat.com/add/bridgemonkcorp\"}, {\"url\": \"\", \"name\": \"YouTube\", \"url_placeholder\": \"https://youtube.com/c/bridgemonkcorp\"}, {\"url\": \"\", \"name\": \"Vimeo\", \"url_placeholder\": \"https://vimeo.com/bridgemonkcorp\"}]','2023-08-04 18:32:23','2023-08-04 18:32:23'),(27,'template','home_page_title',0,'\"Modernize Your Home, Simplify Your Day with Our Appliances and Gadgets.\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(28,'template','home_page_description',0,'\"Discover a vast selection of top-notch home appliances and electronic gadgets. Elevate your living with innovative, energy-efficient solutions.\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(29,'template','home_page_hero_carousel_handle',0,'\"\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(30,'template','home_page_perk_carousel_handle',0,'\"\"','2023-08-04 18:32:23','2023-08-04 18:32:23'),(31,'template','home_page_sections',0,'[]','2023-08-04 18:32:23','2023-08-04 18:32:23'),(32,'checkout','requires_login',0,'false','2023-08-04 18:32:24','2023-08-04 18:32:24');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipment_items`
--

DROP TABLE IF EXISTS `shipment_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipment_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shipment_id` bigint unsigned NOT NULL,
  `order_id` bigint unsigned NOT NULL,
  `order_item_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipment_items_shipment_id_foreign` (`shipment_id`),
  KEY `shipment_items_order_id_foreign` (`order_id`),
  KEY `shipment_items_order_item_id_foreign` (`order_item_id`),
  CONSTRAINT `shipment_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `shipment_items_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`),
  CONSTRAINT `shipment_items_shipment_id_foreign` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipment_items`
--

LOCK TABLES `shipment_items` WRITE;
/*!40000 ALTER TABLE `shipment_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `shipment_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipments`
--

DROP TABLE IF EXISTS `shipments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `shipping_carrier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking_url` text COLLATE utf8mb4_unicode_ci,
  `is_physical` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipments_order_id_foreign` (`order_id`),
  CONSTRAINT `shipments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipments`
--

LOCK TABLES `shipments` WRITE;
/*!40000 ALTER TABLE `shipments` DISABLE KEYS */;
/*!40000 ALTER TABLE `shipments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipping_zone_countries`
--

DROP TABLE IF EXISTS `shipping_zone_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipping_zone_countries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shipping_zone_id` bigint unsigned NOT NULL,
  `country_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipping_zone_countries_shipping_zone_id_foreign` (`shipping_zone_id`),
  KEY `shipping_zone_countries_country_id_foreign` (`country_id`),
  CONSTRAINT `shipping_zone_countries_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `shipping_zone_countries_shipping_zone_id_foreign` FOREIGN KEY (`shipping_zone_id`) REFERENCES `shipping_zones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipping_zone_countries`
--

LOCK TABLES `shipping_zone_countries` WRITE;
/*!40000 ALTER TABLE `shipping_zone_countries` DISABLE KEYS */;
/*!40000 ALTER TABLE `shipping_zone_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipping_zone_rates`
--

DROP TABLE IF EXISTS `shipping_zone_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipping_zone_rates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shipping_zone_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `description` text COLLATE utf8mb4_unicode_ci,
  `based_on` enum('weight','price') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_value` decimal(12,2) DEFAULT NULL,
  `max_value` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipping_zone_rates_shipping_zone_id_foreign` (`shipping_zone_id`),
  CONSTRAINT `shipping_zone_rates_shipping_zone_id_foreign` FOREIGN KEY (`shipping_zone_id`) REFERENCES `shipping_zones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipping_zone_rates`
--

LOCK TABLES `shipping_zone_rates` WRITE;
/*!40000 ALTER TABLE `shipping_zone_rates` DISABLE KEYS */;
/*!40000 ALTER TABLE `shipping_zone_rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipping_zones`
--

DROP TABLE IF EXISTS `shipping_zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipping_zones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipping_zones`
--

LOCK TABLES `shipping_zones` WRITE;
/*!40000 ALTER TABLE `shipping_zones` DISABLE KEYS */;
/*!40000 ALTER TABLE `shipping_zones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taggables`
--

DROP TABLE IF EXISTS `taggables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taggables` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` bigint unsigned NOT NULL,
  `taggable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taggable_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `taggables_tag_id_taggable_id_taggable_type_unique` (`tag_id`,`taggable_id`,`taggable_type`),
  KEY `taggables_taggable_type_taggable_id_index` (`taggable_type`,`taggable_id`),
  CONSTRAINT `taggables_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taggables`
--

LOCK TABLES `taggables` WRITE;
/*!40000 ALTER TABLE `taggables` DISABLE KEYS */;
/*!40000 ALTER TABLE `taggables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tax_zone_countries`
--

DROP TABLE IF EXISTS `tax_zone_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tax_zone_countries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tax_zone_id` bigint unsigned NOT NULL,
  `country_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tax_zone_countries_tax_zone_id_foreign` (`tax_zone_id`),
  KEY `tax_zone_countries_country_id_foreign` (`country_id`),
  CONSTRAINT `tax_zone_countries_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tax_zone_countries_tax_zone_id_foreign` FOREIGN KEY (`tax_zone_id`) REFERENCES `tax_zones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tax_zone_countries`
--

LOCK TABLES `tax_zone_countries` WRITE;
/*!40000 ALTER TABLE `tax_zone_countries` DISABLE KEYS */;
/*!40000 ALTER TABLE `tax_zone_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tax_zone_rates`
--

DROP TABLE IF EXISTS `tax_zone_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tax_zone_rates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tax_zone_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage` decimal(8,2) NOT NULL,
  `priority` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tax_zone_rates_tax_zone_id_foreign` (`tax_zone_id`),
  CONSTRAINT `tax_zone_rates_tax_zone_id_foreign` FOREIGN KEY (`tax_zone_id`) REFERENCES `tax_zones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tax_zone_rates`
--

LOCK TABLES `tax_zone_rates` WRITE;
/*!40000 ALTER TABLE `tax_zone_rates` DISABLE KEYS */;
/*!40000 ALTER TABLE `tax_zone_rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tax_zones`
--

DROP TABLE IF EXISTS `tax_zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tax_zones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tax_zones`
--

LOCK TABLES `tax_zones` WRITE;
/*!40000 ALTER TABLE `tax_zones` DISABLE KEYS */;
/*!40000 ALTER TABLE `tax_zones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variant_attributes`
--

DROP TABLE IF EXISTS `variant_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `variant_attributes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `variant_id` bigint unsigned NOT NULL,
  `option_id` bigint unsigned NOT NULL,
  `option_value_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `variant_attributes_product_id_foreign` (`product_id`),
  KEY `variant_attributes_variant_id_foreign` (`variant_id`),
  KEY `variant_attributes_option_id_foreign` (`option_id`),
  KEY `variant_attributes_option_value_id_foreign` (`option_value_id`),
  CONSTRAINT `variant_attributes_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`),
  CONSTRAINT `variant_attributes_option_value_id_foreign` FOREIGN KEY (`option_value_id`) REFERENCES `option_values` (`id`),
  CONSTRAINT `variant_attributes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `variant_attributes_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variant_attributes`
--

LOCK TABLES `variant_attributes` WRITE;
/*!40000 ALTER TABLE `variant_attributes` DISABLE KEYS */;
/*!40000 ALTER TABLE `variant_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variants`
--

DROP TABLE IF EXISTS `variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `variants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `compare_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `cost_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `stock_tracking` tinyint(1) NOT NULL DEFAULT '1',
  `stock_value` int NOT NULL DEFAULT '0',
  `shipping_type` enum('physical','digital') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'physical',
  `weight_value` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `weight_unit` enum('lb','oz','kg','g') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kg',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `variants_sku_unique` (`sku`),
  UNIQUE KEY `variants_barcode_unique` (`barcode`),
  KEY `variants_product_id_foreign` (`product_id`),
  CONSTRAINT `variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variants`
--

LOCK TABLES `variants` WRITE;
/*!40000 ALTER TABLE `variants` DISABLE KEYS */;
/*!40000 ALTER TABLE `variants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `webhook_calls`
--

DROP TABLE IF EXISTS `webhook_calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `webhook_calls` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` json DEFAULT NULL,
  `payload` json DEFAULT NULL,
  `exception` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `webhook_calls`
--

LOCK TABLES `webhook_calls` WRITE;
/*!40000 ALTER TABLE `webhook_calls` DISABLE KEYS */;
/*!40000 ALTER TABLE `webhook_calls` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-05  8:32:43
