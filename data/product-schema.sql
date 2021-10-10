
DROP TABLE IF EXISTS `product_Product`;

CREATE TABLE `product_Product` (
    `productID` int(12) NOT NULL AUTO_INCREMENT,
    `productCategoryID` int(12) NOT NULL,
    `siteID` int(12) NOT NULL,
    `creator` int(12) NOT NULL,
    `created` datetime NOT NULL,
    `updated` datetime NOT NULL,
    `deleted` int(1) NOT NULL,
    `productNameEnglish` varchar(255) NOT NULL,
    `productDescriptionEnglish` text NOT NULL,
    `productNameJapanese` varchar(255) NOT NULL,
    `productDescriptionJapanese` text NOT NULL,
	`productUnitPrice1` decimal(13,4) NOT NULL,
	`productUnitPrice2` decimal(13,4) NOT NULL,
	`productUnitPrice3` decimal(13,4) NOT NULL,
	`productUnitPrice4` decimal(13,4) NOT NULL,
	`productNotes` text NOT NULL,
    `productPublished` int(1) NOT NULL,
    `productURL` varchar(100) NOT NULL,
    `productFeatured` int(1) NOT NULL,
    PRIMARY KEY (`productID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `product_ProductCategory`;

CREATE TABLE `product_ProductCategory` (
    `productCategoryID` int(12) NOT NULL AUTO_INCREMENT,
    `siteID` int(12) NOT NULL,
    `creator` int(12) NOT NULL,
    `created` datetime NOT NULL,
    `updated` datetime NOT NULL,
    `deleted` int(1) NOT NULL,
    `productCategoryNameEnglish` varchar(255) NOT NULL,
    `productCategoryDescriptionEnglish` text NOT NULL,
    `productCategoryNameJapanese` varchar(255) NOT NULL,
    `productCategoryDescriptionJapanese` text NOT NULL,
    `productCategoryPublished` int(1) NOT NULL,
    `productCategoryURL` varchar(100) NOT NULL,
    `productCategoryDisplayOrder` int(4) NOT NULL,
    PRIMARY KEY (`productCategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `product_ProductSpecification`;

CREATE TABLE `product_ProductSpecification` (
    `productSpecificationID` int(12) NOT NULL AUTO_INCREMENT,
    `productID` int(12) NOT NULL,
    `siteID` int(12) NOT NULL,
    `creator` int(12) NOT NULL,
    `created` datetime NOT NULL,
    `updated` datetime NOT NULL,
    `deleted` int(1) NOT NULL,
    `productSpecificationNameEnglish` varchar(255) NOT NULL,
    `productSpecificationDescriptionEnglish` text NOT NULL,
    `productSpecificationNameJapanese` varchar(255) NOT NULL,
    `productSpecificationDescriptionJapanese` text NOT NULL,
    `productSpecificationPublished` int(1) NOT NULL,
    `productSpecificationDisplayOrder` int(4) NOT NULL,
    PRIMARY KEY (`productSpecificationID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `product_ProductFeature`;

CREATE TABLE `product_ProductFeature` (
    `productFeatureID` int(12) NOT NULL AUTO_INCREMENT,
    `productID` int(12) NOT NULL,
    `siteID` int(12) NOT NULL,
    `creator` int(12) NOT NULL,
    `created` datetime NOT NULL,
    `updated` datetime NOT NULL,
    `deleted` int(1) NOT NULL,
    `productFeatureNameEnglish` varchar(255) NOT NULL,
    `productFeatureDescriptionEnglish` text NOT NULL,
    `productFeatureNameJapanese` varchar(255) NOT NULL,
    `productFeatureDescriptionJapanese` text NOT NULL,
    `productFeaturePublished` int(1) NOT NULL,
    `productFeatureDisplayOrder` int(4) NOT NULL,
    PRIMARY KEY (`productFeatureID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

