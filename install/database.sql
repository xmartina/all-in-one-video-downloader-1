-- --------------------------------------------------------

--
-- Table structure for table `tbl_active_log`
--

CREATE TABLE `tbl_active_log` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `date_time` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `password`, `email`, `image`) VALUES
(1, 'admin', 'admin', 'viaviwebtech@gmail.com', 'profile.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cid` int(11) NOT NULL,
  `category_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `category_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`cid`, `category_name`, `category_image`, `status`) VALUES
(1, 'Animation', '63095_Animation.jpg', 1),
(2, 'Comedy', '91287_Comedy1.jpg', 1),
(3, 'Fashion', '11419_fashion-images.jpg', 1),
(4, 'Music', '10543_music.jpg', 1),
(5, 'Sports', '26013_Sports.png', 1),
(6, 'Car', '53424_category.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comments`
--

CREATE TABLE `tbl_comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `user_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `comment_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dt_rate` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_home_banner`
--

CREATE TABLE `tbl_home_banner` (
  `id` int(11) NOT NULL,
  `banner_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `banner_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `banner_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_home_banner`
--

INSERT INTO `tbl_home_banner` (`id`, `banner_name`, `banner_image`, `banner_url`) VALUES
(1, 'Android Drawing', '97286_android_drawing.jpg', 'https://codecanyon.net/item/android-drawing/8193028'),
(2, 'Daily Motion', '9680_Daily_Motion.jpg', 'https://codecanyon.net/item/daily-motion/8239582'),
(3, 'Alphabet', '40905_alphabet.jpg', 'https://codecanyon.net/item/alphabet/8108766');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rating`
--

CREATE TABLE `tbl_rating` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rate` int(11) NOT NULL,
  `dt_rate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reports`
--

CREATE TABLE `tbl_reports` (
  `id` int(10) NOT NULL,
  `post_id` int(5) NOT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `user_id` int(5) NOT NULL,
  `report` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `report_on` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `email_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `onesignal_app_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `onesignal_rest_key` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `envato_buyer_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `envato_purchase_code` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `envato_buyer_email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `envato_purchased_status` int(1) NOT NULL DEFAULT 0,
  `envato_ios_purchase_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `envato_ios_purchased_status` int(2) NOT NULL DEFAULT 0,
  `package_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ios_bundle_identifier` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `app_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `app_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `app_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `app_version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `app_author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `app_contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `app_website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `app_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `app_developed_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `app_privacy_policy` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `api_all_order_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `api_latest_limit` int(3) NOT NULL,
  `api_cat_order_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `api_cat_post_order_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `publisher_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `interstital_ad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `interstital_ad_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `interstital_ad_click` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `banner_ad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `banner_ad_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `publisher_id_ios` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `app_id_ios` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `interstital_ad_ios` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `interstital_ad_id_ios` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `interstital_ad_click_ios` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `banner_ad_ios` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `banner_ad_id_ios` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `banner_ad_type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'admob',
  `banner_facebook_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `interstital_ad_type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'admob',
  `interstital_facebook_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `native_ad` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'false',
  `native_ad_type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'admob',
  `native_ad_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `native_facebook_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `native_position` int(10) NOT NULL,
  `app_update_status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'false',
  `app_new_version` double NOT NULL DEFAULT 1,
  `app_update_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `app_redirect_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cancel_update_status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'false',
  `account_delete_intruction` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `app_update_status_ios` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'false',
  `app_new_version_ios` double NOT NULL DEFAULT 1,
  `app_update_desc_ios` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `app_redirect_url_ios` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cancel_update_status_ios` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'false',
  `banner_unity_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `interstitial_unity_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `banner_applovin_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `interstitial_applovin_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `native_applovin_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `banner_wortise_id` varchar(255) DEFAULT NULL,
  `interstitial_wortise_id` varchar(255) DEFAULT NULL,
  `native_wortise_id` varchar(255) DEFAULT NULL,
  `wortise_app_id` varchar(255) DEFAULT NULL,
  `start_ads_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `unity_game_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `android_ad_network` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `banner_ad_type_ios` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `banner_facebook_id_ios` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `interstitial_facebook_id_ios` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `interstitial_ad_type_ios` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `email_from`, `onesignal_app_id`, `onesignal_rest_key`, `envato_buyer_name`, `envato_purchase_code`, `envato_buyer_email`, `envato_purchased_status`, `envato_ios_purchase_code`, `envato_ios_purchased_status`, `package_name`, `ios_bundle_identifier`, `app_name`, `app_logo`, `app_email`, `app_version`, `app_author`, `app_contact`, `app_website`, `app_description`, `app_developed_by`, `app_privacy_policy`, `api_all_order_by`, `api_latest_limit`, `api_cat_order_by`, `api_cat_post_order_by`, `publisher_id`, `interstital_ad`, `interstital_ad_id`, `interstital_ad_click`, `banner_ad`, `banner_ad_id`, `publisher_id_ios`, `app_id_ios`, `interstital_ad_ios`, `interstital_ad_id_ios`, `interstital_ad_click_ios`, `banner_ad_ios`, `banner_ad_id_ios`, `banner_ad_type`, `banner_facebook_id`, `interstital_ad_type`, `interstital_facebook_id`, `native_ad`, `native_ad_type`, `native_ad_id`, `native_facebook_id`, `native_position`, `app_update_status`, `app_new_version`, `app_update_desc`, `app_redirect_url`, `cancel_update_status`, `account_delete_intruction`, `app_update_status_ios`, `app_new_version_ios`, `app_update_desc_ios`, `app_redirect_url_ios`, `cancel_update_status_ios`, `banner_unity_id`, `interstitial_unity_id`, `banner_applovin_id`, `interstitial_applovin_id`, `native_applovin_id`, `banner_wortise_id`, `interstitial_wortise_id`, `native_wortise_id`, `wortise_app_id`, `start_ads_id`, `unity_game_id`, `android_ad_network`, `banner_ad_type_ios`, `banner_facebook_id_ios`, `interstitial_facebook_id_ios`, `interstitial_ad_type_ios`) VALUES
(1, '-', '', '', '', '', 'info@viaviweb.com', 0, '', 0, 'com.example.allinonevideo', 'com.viaviwebtech.AllInOneVideos', 'All In One Video', 'icon256.png', 'info@viaviweb.in', '1.0.0', 'viaviwebtech', '+91 922 7777 522', 'http://www.viaviweb.com/', '<p>This Application is best application for Video, User can play their favourite videos through applications.</p>\r\n\r\n<ul>\r\n	<li>Easy to play video</li>\r\n	<li>Great UI</li>\r\n	<li>You can set video to favourite list</li>\r\n	<li>Userfriendly</li>\r\n</ul>\r\n\r\n<p>AllInOneVideo Application is designed and developed by Viavi Webtech (INDIA), for more Applications contact viaviwebtech@gmail.com</p>\r\n\r\n<p>Website: www.viaviweb.com</p>\r\n\r\n<p>We also develop custom applications, if you need any kind of custom application contact us on given Email or Contact No.</p>\r\n\r\n<p><strong>Email:</strong> viaviwebtech@gmail.com<br />\r\n<strong>WhatsApp:</strong> +919227777522<br />\r\n<strong>Website:</strong> www.viaviweb.com</p>\r\n', 'Viavi Webtech', '<p><strong>We are committed to protecting your privacy</strong></p>\n\n<p>We collect the minimum amount of information about you that is commensurate with providing you with a satisfactory service. This policy indicates the type of processes that may result in data being collected about you. Your use of this website gives us the right to collect that information.&nbsp;</p>\n\n<p><strong>Information Collected</strong></p>\n\n<p>We may collect any or all of the information that you give us depending on the type of transaction you enter into, including your name, address, telephone number, and email address, together with data about your use of the website. Other information that may be needed from time to time to process a request may also be collected as indicated on the website.</p>\n\n<p><strong>Information Use</strong></p>\n\n<p>We use the information collected primarily to process the task for which you visited the website. Data collected in the UK is held in accordance with the Data Protection Act. All reasonable precautions are taken to prevent unauthorised access to this information. This safeguard may require you to provide additional forms of identity should you wish to obtain information about your account details.</p>\n\n<p><strong>Cookies</strong></p>\n\n<p>Your Internet browser has the in-built facility for storing small files - &quot;cookies&quot; - that hold information which allows a website to recognise your account. Our website takes advantage of this facility to enhance your experience. You have the ability to prevent your computer from accepting cookies but, if you do, certain functionality on the website may be impaired.</p>\n\n<p><strong>Disclosing Information</strong></p>\n\n<p>We do not disclose any personal information obtained about you from this website to third parties unless you permit us to do so by ticking the relevant boxes in registration or competition forms. We may also use the information to keep in contact with you and inform you of developments associated with us. You will be given the opportunity to remove yourself from any mailing list or similar device. If at any time in the future we should wish to disclose information collected on this website to any third party, it would only be with your knowledge and consent.&nbsp;</p>\n\n<p>We may from time to time provide information of a general nature to third parties - for example, the number of individuals visiting our website or completing a registration form, but we will not use any information that could identify those individuals.&nbsp;</p>\n\n<p>In addition Dummy may work with third parties for the purpose of delivering targeted behavioural advertising to the Dummy website. Through the use of cookies, anonymous information about your use of our websites and other websites will be used to provide more relevant adverts about goods and services of interest to you. For more information on online behavioural advertising and about how to turn this feature off, please visit youronlinechoices.com/opt-out.</p>\n\n<p><strong>Changes to this Policy</strong></p>\n\n<p>Any changes to our Privacy Policy will be placed here and will supersede this version of our policy. We will take reasonable steps to draw your attention to any changes in our policy. However, to be on the safe side, we suggest that you read this document each time you use the website to ensure that it still meets with your approval.</p>\n\n<p><strong>Contacting Us</strong></p>\n\n<p>If you have any questions about our Privacy Policy, or if you want to know what information we have collected about you, please email us at hd@dummy.com. You can also correct any factual errors in that information or require us to remove your details form any list under our control.</p>\n', 'ASC', 15, 'category_name', 'DESC', 'pub-9456493320432553', 'true', 'ca-app-pub-3940256099942544/1033173712', '5', 'true', 'ca-app-pub-3940256099942544/6300978111', 'pub-9456493320432553', '-', 'true', 'ca-app-pub-3940256099942544/29347357167', '5', 'true', 'ca-app-pub-3940256099942544/2934735716', 'wortise', 'IMG_16_9_APP_INSTALL#288347782353524_288349185686717', 'wortise', 'IMG_16_9_APP_INSTALL#288347782353524_288396272348675', 'true', 'wortise', 'ca-app-pub-3940256099942544/2247696110', 'IMG_16_9_APP_INSTALL#288347782353524_288348195686816', 5, 'false', 1, 'kindly you can update new version app', 'https://play.google.com/store/apps/developer?id=Viaan+Parmar', 'false', '<p><strong>Contact&nbsp;</strong></p>\r\n\r\n<p><strong>Email :-&nbsp;&nbsp;</strong><strong>info@viaviweb.com</strong></p>', 'false', 1, 'kindly you can update new version app', 'https://play.google.com/store/apps/developer?id=Viaan+Parmar', 'false', 'Banner_Android', 'Interstitial_Android', '3221a2640039c8a8', '06b9bf27824eb7f6', '0d3c3740628feba8', 'a2562302-14ce-476b-94d4-0c6431f1f927', 'ed6fc25c-9855-485e-9513-fed0d3acc528', 'cf65ed35-4765-4955-96fc-a33cf43d5340', 'a4e76baa-c4ce-4672-ba85-f2f7190bd19b', '208651629', '4613148', 'wortise', 'facebook', '3221a2640039c8a8', 'ca-app-pub-3940256099942544/2934735716', 'admob');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_smtp_settings`
--

CREATE TABLE `tbl_smtp_settings` (
  `id` int(5) NOT NULL,
  `smtp_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'server',
  `smtp_host` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `smtp_email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `smtp_password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `smtp_secure` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `port_no` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `smtp_ghost` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `smtp_gemail` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `smtp_gpassword` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `smtp_gsecure` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gport_no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_smtp_settings`
--

INSERT INTO `tbl_smtp_settings` (`id`, `smtp_type`, `smtp_host`, `smtp_email`, `smtp_password`, `smtp_secure`, `port_no`, `smtp_ghost`, `smtp_gemail`, `smtp_gpassword`, `smtp_gsecure`, `gport_no`) VALUES
(1, 'server', '', '', '', 'ssl', '465', 'smtp.gmail.com', '', '', 'ssl', 465);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `user_type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `auth_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `confirm_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 1,
  `register_on` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `user_type`, `auth_id`, `name`, `email`, `password`, `phone`, `confirm_code`, `status`, `register_on`) VALUES
(1, 'Normal', '0', 'Demo', 'demo@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1234567890', NULL, 1, '1631271602'),
(13, 'Google', '108485595040876318359', 'Hitesh Dangar', 'hitesh.viaviweb@gmail.com', '', '', NULL, 1, '1671685636'),
(19, 'Normal', '0', 'demoapp', 'ddemoapp@gmail.com', '8ce135b5a2361f7eecb83a42f2df15e2', '', NULL, 1, '1671686677'),
(20, 'Normal', '0', 'demoapp', '1demoapp@gmail.com', '8ce135b5a2361f7eecb83a42f2df15e2', '', NULL, 1, '1671686741'),
(21, 'Normal', '0', 'demo app', 'demoapp@gmail.com', '8ce135b5a2361f7eecb83a42f2df15e2', '', NULL, 1, '1671686771');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_video`
--

CREATE TABLE `tbl_video` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `video_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `video_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `video_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `video_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `video_thumbnail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `video_duration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `video_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total_rate` int(11) NOT NULL DEFAULT 0,
  `rate_avg` float(11,1) NOT NULL DEFAULT 0.0,
  `totel_viewer` int(11) NOT NULL DEFAULT 0,
  `featured` int(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_video`
--

INSERT INTO `tbl_video` (`id`, `cat_id`, `video_type`, `video_title`, `video_url`, `video_id`, `video_thumbnail`, `video_duration`, `video_description`, `total_rate`, `rate_avg`, `totel_viewer`, `featured`, `status`) VALUES
(1, 2, 'youtube', 'Chup chup ke movie comedy scenes | Rajpal yadav chup chupke', 'https://www.youtube.com/watch?v=NtzftGb0EcM', 'NtzftGb0EcM', 'https://img.youtube.com/vi/NtzftGb0EcM/sddefault.jpg', '-', '<p>Chup chup ke movie comedy scenes</p>\r\n\r\n<p>| Rajpal yadav chup chupkeChup chup ke movie comedy scenes | Rajpal yadav chup chupkeChup chup ke movie comedy scenes</p>\r\n\r\n<p>| Rajpal yadav chup chupkeChup chup ke movie comedy scenes | Rajpal yadav chup chupke.</p>', 0, 0.0, 178, 1, 1),
(13, 4, 'youtube', 'Half Girlfriend Official Trailer', 'https://www.youtube.com/watch?v=KmlBnmyelHI', 'KmlBnmyelHI', 'https://img.youtube.com/vi/KmlBnmyelHI/sddefault.jpg', '-', '<p>Balaji Motion Pictures presents &lsquo;Half Girlfriend &ndash; Dost se Zyada, Girlfriend se kam&rsquo;, an adaptation of Chetan Bhagat&#39;s best selling novel &lsquo;Half Girlfriend&rsquo;. Directed by Mohit Suri, the intense love story sets out to explore the &lsquo;grey area&rsquo; in relationships today; the in-between space, between two people.<br />\r\n<br />\r\nStarring Arjun Kapoor, as Madhav Jha &amp; Shraddha Kapoor as Riya Somani, the film is set against the backdrop of three distinct worlds of Delhi, Patna &amp; New York.<br />\r\nMadhav wanted a relationship. Riya didn&#39;t. So, she decided to be his &lsquo;Half Girlfriend&rsquo;.<br />\r\nMore than a friend, les than a girlfriend,</p>', 0, 0.0, 349, 0, 1),
(20, 5, 'youtube', 'IPL 2018 : CSK crush hyderabad and qualifier for Final', 'https://www.youtube.com/watch?v=c7mWC6CN7kY', 'c7mWC6CN7kY', 'https://img.youtube.com/vi/c7mWC6CN7kY/sddefault.jpg', '-', '<p>That background music is so annoying yaar, please stop the background music was only for the world cup which was amazing but now its it has become annoying and you bloody news people if you people don&#39;t have any news we just start showing cricket Dhoom Dhadaka and all﻿</p>', 0, 0.0, 59, 1, 1),
(23, 3, 'youtube', 'X-men: Dark Phoenix', 'https://www.youtube.com/watch?v=azvR__GRQic', 'azvR__GRQic', 'https://img.youtube.com/vi/azvR__GRQic/sddefault.jpg', '-', '<p>In DARK PHOENIX, the X-MEN face their most formidable and powerful foe: one of their own, Jean Grey. During a rescue mission in space, Jean is nearly killed when she is hit by a mysterious cosmic force. Once she returns home, this force not only makes her infinitely more powerful, but far more unstable. Wrestling with this entity inside her, Jean unleashes her powers in ways she can neither comprehend nor contain.&nbsp;</p>\r\n\r\n<p>Coming soon to a theater near you.</p>', 0, 0.0, 103, 1, 1),
(31, 1, 'youtube', 'Shiv Bhola', 'https://www.youtube.com/watch?v=I1LxYeEjKOc', 'I1LxYeEjKOc', 'https://img.youtube.com/vi/I1LxYeEjKOc/sddefault.jpg', '-', '<p>KD Digital Present</p>\r\n\r\n<p>&ldquo;Shiv Bhola&rdquo;</p>\r\n\r\n<p>Singer :- Kinjal Dave</p>\r\n\r\n<p>Starring :- Jay Wadhwani</p>\r\n\r\n<p>Lyrics :- Rajan Rayka,Dhaval Motan</p>\r\n\r\n<p>Music :- Jitu Prajapati</p>', 0, 0.0, 432, 0, 1),
(39, 1, 'youtube', 'demo', 'https://www.youtube.com/watch?v=5ZZitB_FFE8', '5ZZitB_FFE8', 'https://img.youtube.com/vi/5ZZitB_FFE8/sddefault.jpg', '-', '<p>watch this video</p>\r\n\r\n<p>Basic details</p>\r\n\r\n<p>Number of bedrooms - 2</p>\r\n\r\n<p>Total area - 980 square feet.</p>\r\n\r\n<p>Location - Kerala - near Tirur</p>\r\n\r\n<p>Cost - 15 lakh (construction only)</p>', 0, 0.0, 12, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_active_log`
--
ALTER TABLE `tbl_active_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_home_banner`
--
ALTER TABLE `tbl_home_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_smtp_settings`
--
ALTER TABLE `tbl_smtp_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_video`
--
ALTER TABLE `tbl_video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_active_log`
--
ALTER TABLE `tbl_active_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_home_banner`
--
ALTER TABLE `tbl_home_banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_smtp_settings`
--
ALTER TABLE `tbl_smtp_settings`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_video`
--
ALTER TABLE `tbl_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;