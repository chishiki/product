
SET @now = now();

REPLACE INTO `perihelion_Lang` VALUES ('product','Product',0,'プロダクト',0,@now),
('productCategory','Product Category',0,'製品区分',0,@now),
('productConfirmDelete','Confirm Product Delete',0,'製品削除確認',0,@now),
('productCreate','Product Create',0,'製品新規作成',0,@now),
('productDeleteSuccessful','Product was deleted successfully.',0,'製品は削除済みです。',0,@now),
('productDescription','Description',0,'製品明細',0,@now),
('productDescriptionEnglish','Product Description (English)',0,'製品明細（英語）',0,@now),
('productDescriptionJapanese','Product Description (Japanese)',0,'製品明細（日本語）',0,@now),
('productID','Product ID',0,'製品',0,@now),
('productIDRMASearch','Product ID',0,'製品番号',0,@now),
('productImportError_duplicate','productImportError_duplicate',0,'登録済みの製品名です。重複登録はできません。',0,@now),
('productImportError_nullname','productImportError_nullname',0,'製品名がありません。新規登録に製品名は必須です。',0,@now),
('productImportError_numeric','productImportError_numeric',0,'金額のフィールドに入力できるのは数値のみです。',0,@now),
('productImportSuccessful','productImportSuccessful',0,'インポートファイルの登録処理が成功しました',0,@now),
('productInventoryStatus','Product Inventory Status',0,'製品在庫状況',0,@now),
('productIsNotRequiredForThisPurchaseOrder','This product is not required for this PO.',0,'入力された製品は入力された発注書に合わないです。',0,@now),
('productMasterRegister','Product Master Register',0,'製品マスター登録',0,@now),
('productModalButtonAnchor','Product Reference',0,'製品一覧参照',0,@now),
('productName','Product Name',0,'製品名',0,@now),
('productNotes','Notes',0,'備考',0,@now),
('productNumber','Product Number',0,'プロダクト番号',0,@now),
('productOrService','Product or Service',0,'商品・サービス',0,@now),
('productPurchase','Purchase',0,'発注管理',0,@now),
('productRegister','Product Register',0,'製品登録',0,@now),
('productRegistErr','THIS PRODUCT ALREADY EXISTS',0,'登録済みの製品です',0,@now),
('productReservations','Reservations',0,'予約管理',0,@now),
('products','Products',0,'製品',0,@now),
('productsAndServices','Products &amp; Services',0,'商品＆サービス',0,@now),
('productSerialAvailable','Available',0,'入手可能',0,@now),
('productService','Product / Service',0,'商品・サービス',0,@now),
('productType','Type',0,'区分',0,@now),
('productTypeFee','Fee',0,'料金',0,@now),
('productTypeProduct','Product',0,'製品',0,@now),
('productTypeService','Service',0,'サービス',0,@now),
('productUnitBestPriceYen','Best Price (Yen)',0,'日本ベスト単価',0,@now),
('productUnitPriceDollar','Unit Price USD',0,'US単価',0,@now),
('productUnitPriceYen','Unit Price JPY',0,'日本単価',0,@now),
('productUpdate','Product Update',0,'製品更新',0,@now),
('productUpdateSuccessful','Product was updated successfully.',0,'製品は更新済みです。',0,@now),
('productUsesSerialNumber','Uses Serial Numbers',0,'シリアル番号使用',0,@now),
('productUsesSerialNumberShort','Serial',0,'シリアル',0,@now),
('productWasNotAddedToSalesOrder','Product was not added to Sales Order.',0,'製品は受注に追加されませんでした。',0,@now),
('productFeatures','Features',0,'特徴',0,@now),
('productSpecifications','Specifications',0,'仕様',0,@now),
('productImages','Images',0,'イメージ',0,@now),
('productFiles','Files',0,'ファイル',0,@now),
('productList','Product List',0,'製品一覧',0,@now),
('productPublished','Published',0,'公開',0,@now),
('productFeatured','Featured',0,'特徴',0,@now),
('featuredProducts','Featured Products',0,'特徴製品',0,@now),
('productfeatureNameEnglish','Feature (English)',0,'特徴名(英語)',0,@now),
('productfeatureNameJapanese','Feature (Japanese)',0,'特徴名(日本語)',0,@now),
('productSpecificationNameEnglish','Specification (English)',0,'仕様名(英語)',0,@now),
('productSpecificationDescriptionEnglish','Details (English)',0,'仕様詳細(英語)',0,@now),
('productSpecificationNameJapanese','Specification (Japanese)',0,'仕様名(日本語)',0,@now),
('productSpecificationDescriptionJapanese','Details (Japanese)',0,'仕様詳細(日本語)',0,@now),
('productNameEnglish','Product (English)',0,'製品名(英語)',0,@now),
('productNameJapanese','Product (Japanese)',0,'製品名(日本語)',0,@now),
('productFeatureManager','Feature Manager',0,'特徴管理',0,@now),
('productSpecificationManager','Specification Manager',0,'仕様管理',0,@now),
('addNewFeatureHere','Add new feature here.',0,'新規特徴をここに入力して下さい。',0,@now),
('productCategoryUpdateSuccessful','Category Update Successful',0,'カテゴリーは更新済みです。',0,@now),
('productCategoryUpdate','Category Update',0,'カテゴリー更新',0,@now),
('productCategoryCreate','Category Create',0,'カテゴリー作成',0,@now),
('productCategoryNameEnglish','Category (English)',0,'カテゴリー名(英語)',0,@now),
('productCategoryDescriptionEnglish','Description (English)',0,'詳細(英語)',0,@now),
('productCategoryNameJapanese','Category (Japanese)',0,'カテゴリー名(日本語)',0,@now),
('productCategoryDescriptionJapanese','Description (Japanese)',0,'詳細(日本語)',0,@now),
('productCategoryList','Category List',0,'カテゴリー一覧',0,@now),
('productCategoryID','ID',0,'ID',0,@now),
('productCategoryName','Category',0,'カテゴリー名',0,@now),
('productCategoryConfirmDelete','Confirm Category Delete',0,'カテゴリー削除確認',0,@now),
('productURL','URL',0,'URL',0,@now),
('productDownloads','Downloads',0,'ダウンロード',0,@now);

-- ('xxxxxxx','xxxxxxx',0,'xxxxxxx',0,@now),
