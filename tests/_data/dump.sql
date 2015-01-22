# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.21)
# Database: hris
# Generation Time: 2014-11-25 22:48:41 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table cities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cities`;

CREATE TABLE `cities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `province_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;

INSERT INTO `cities` (`id`, `province_id`, `name`)
VALUES
	(1,1,'Bangued'),
	(2,1,'Boliney'),
	(3,1,'Bucay'),
	(4,1,'Bucloc'),
	(5,1,'Daguioman'),
	(6,1,'Danglas'),
	(7,1,'Dolores'),
	(8,1,'La Paz'),
	(9,1,'Lacub'),
	(10,1,'Lagangilang'),
	(11,1,'Lagayan'),
	(12,1,'Langiden'),
	(13,1,'Licuan-Baay'),
	(14,1,'Luba'),
	(15,1,'Malibcong'),
	(16,1,'Manabo'),
	(17,1,'Peñarrubia'),
	(18,1,'Pidigan'),
	(19,1,'Pilar'),
	(20,1,'Sallapadan'),
	(21,1,'San Isidro'),
	(22,1,'San Juan'),
	(23,1,'San Quintin'),
	(24,1,'Tayum'),
	(25,1,'Tineg'),
	(26,1,'Tubo'),
	(27,1,'Villaviciosa'),
	(28,2,'Butuan City'),
	(29,2,'Cabadbaran City'),
	(30,2,'Buenavista'),
	(31,2,'Carmen'),
	(32,2,'Jabonga'),
	(33,2,'Kitcharao'),
	(34,2,'Las Nieves'),
	(35,2,'Magallanes'),
	(36,2,'Nasipit'),
	(37,2,'Remedios T. Romualdez'),
	(38,2,'Santiago'),
	(39,2,'Tubay'),
	(40,3,'Bayugan City'),
	(41,3,'Bunawan'),
	(42,3,'Esperanza'),
	(43,3,'La Paz'),
	(44,3,'Loreto'),
	(45,3,'Prosperidad'),
	(46,3,'Rosario'),
	(47,3,'San Francisco'),
	(48,3,'San Luis'),
	(49,3,'Santa Josefa'),
	(50,3,'Sibagat'),
	(51,3,'Talacogon'),
	(52,3,'Trento'),
	(53,3,'Veruela'),
	(54,4,'Altavas'),
	(55,4,'Balete'),
	(56,4,'Banga'),
	(57,4,'Batan'),
	(58,4,'Buruanga'),
	(59,4,'Ibajay'),
	(60,4,'Kalibo'),
	(61,4,'Lezo'),
	(62,4,'Libacao'),
	(63,4,'Madalag'),
	(64,4,'Makato'),
	(65,4,'Malay'),
	(66,4,'Malinao'),
	(67,4,'Nabas'),
	(68,4,'New Washington'),
	(69,4,'Numancia'),
	(70,4,'Tangalan'),
	(71,5,'Legazpi City'),
	(72,5,'Ligao City'),
	(73,5,'Tabaco City'),
	(74,5,'Bacacay'),
	(75,5,'Camalig'),
	(76,5,'Daraga'),
	(77,5,'Guinobatan'),
	(78,5,'Jovellar'),
	(79,5,'Libon'),
	(80,5,'Malilipot'),
	(81,5,'Malinao'),
	(82,5,'Manito'),
	(83,5,'Oas'),
	(84,5,'Pio Duran'),
	(85,5,'Polangui'),
	(86,5,'Rapu-Rapu'),
	(87,5,'Santo Domingo'),
	(88,5,'Tiwi'),
	(89,6,'Anini-y'),
	(90,6,'Barbaza'),
	(91,6,'Belison'),
	(92,6,'Bugasong'),
	(93,6,'Caluya'),
	(94,6,'Culasi'),
	(95,6,'Hamtic'),
	(96,6,'Laua-an'),
	(97,6,'Libertad'),
	(98,6,'Pandan'),
	(99,6,'Patnongon'),
	(100,6,'San Jose'),
	(101,6,'San Remigio'),
	(102,6,'Sebaste'),
	(103,6,'Sibalom'),
	(104,6,'Tibiao'),
	(105,6,'Tobias Fornier'),
	(106,6,'Valderrama'),
	(107,7,'Calanasan'),
	(108,7,'Conner'),
	(109,7,'Flora'),
	(110,7,'Kabugao'),
	(111,7,'Luna'),
	(112,7,'Pudtol'),
	(113,7,'Santa Marcela'),
	(114,8,'Baler'),
	(115,8,'Casiguran'),
	(116,8,'Dilasag'),
	(117,8,'Dinalungan'),
	(118,8,'Dingalan'),
	(119,8,'Dipaculao'),
	(120,8,'Maria Aurora'),
	(121,8,'San Luis'),
	(122,9,'Isabela City'),
	(123,9,'Lamitan City'),
	(124,9,'Akbar'),
	(125,9,'Al-Barka'),
	(126,9,'Hadji Mohammad Ajul'),
	(127,9,'Hadji Muhtamad'),
	(128,9,'Lantawan'),
	(129,9,'Maluso'),
	(130,9,'Sumisip'),
	(131,9,'Tabuan-Lasa'),
	(132,9,'Tipo-Tipo'),
	(133,9,'Tuburan'),
	(134,9,'Ungkaya Pukan'),
	(135,10,'Balanga City'),
	(136,10,'Abucay'),
	(137,10,'Bagac'),
	(138,10,'Dinalupihan'),
	(139,10,'Hermosa'),
	(140,10,'Limay'),
	(141,10,'Mariveles'),
	(142,10,'Morong'),
	(143,10,'Orani'),
	(144,10,'Orion'),
	(145,10,'Pilar'),
	(146,10,'Samal'),
	(147,11,'Basco'),
	(148,11,'Itbayat'),
	(149,11,'Ivana'),
	(150,11,'Mahatao'),
	(151,11,'Sabtang'),
	(152,11,'Uyugan'),
	(153,12,'Batangas City'),
	(154,12,'Lipa City'),
	(155,12,'Tanauan City'),
	(156,12,'Agoncillo'),
	(157,12,'Alitagtag'),
	(158,12,'Balayan'),
	(159,12,'Balete'),
	(160,12,'Bauan'),
	(161,12,'Calaca'),
	(162,12,'Calatagan'),
	(163,12,'Cuenca'),
	(164,12,'Ibaan'),
	(165,12,'Laurel'),
	(166,12,'Lemery'),
	(167,12,'Lian'),
	(168,12,'Lobo'),
	(169,12,'Mabini'),
	(170,12,'Malvar'),
	(171,12,'Mataas na Kahoy'),
	(172,12,'Nasugbu'),
	(173,12,'Padre Garcia'),
	(174,12,'Rosario'),
	(175,12,'San Jose'),
	(176,12,'San Juan'),
	(177,12,'San Luis'),
	(178,12,'San Nicolas'),
	(179,12,'San Pascual'),
	(180,12,'Santa Teresita'),
	(181,12,'Santo Tomas'),
	(182,12,'Taal'),
	(183,12,'Talisay'),
	(184,12,'Taysan'),
	(185,12,'Tingloy'),
	(186,12,'Tuy'),
	(187,13,'Baguio City'),
	(188,13,'Atok'),
	(189,13,'Bakun'),
	(190,13,'Bokod'),
	(191,13,'Buguias'),
	(192,13,'Itogon'),
	(193,13,'Kabayan'),
	(194,13,'Kapangan'),
	(195,13,'Kibungan'),
	(196,13,'La Trinidad'),
	(197,13,'Mankayan'),
	(198,13,'Sablan'),
	(199,13,'Tuba'),
	(200,13,'Tublay'),
	(201,14,'Almeria'),
	(202,14,'Biliran'),
	(203,14,'Cabucgayan'),
	(204,14,'Caibiran'),
	(205,14,'Culaba'),
	(206,14,'Kawayan'),
	(207,14,'Maripipi'),
	(208,14,'Naval'),
	(209,15,'Tagbilaran City'),
	(210,15,'Alburquerque'),
	(211,15,'Alicia'),
	(212,15,'Anda'),
	(213,15,'Antequera'),
	(214,15,'Baclayon'),
	(215,15,'Balilihan'),
	(216,15,'Batuan'),
	(217,15,'Bien Unido'),
	(218,15,'Bilar'),
	(219,15,'Buenavista'),
	(220,15,'Calape'),
	(221,15,'Candijay'),
	(222,15,'Carmen'),
	(223,15,'Catigbian'),
	(224,15,'Clarin'),
	(225,15,'Corella'),
	(226,15,'Cortes'),
	(227,15,'Dagohoy'),
	(228,15,'Danao'),
	(229,15,'Dauis'),
	(230,15,'Dimiao'),
	(231,15,'Duero'),
	(232,15,'Garcia Hernandez'),
	(233,15,'Guindulman'),
	(234,15,'Inabanga'),
	(235,15,'Jagna'),
	(236,15,'Jetafe'),
	(237,15,'Lila'),
	(238,15,'Loay'),
	(239,15,'Loboc'),
	(240,15,'Loon'),
	(241,15,'Mabini'),
	(242,15,'Maribojoc'),
	(243,15,'Panglao'),
	(244,15,'Pilar'),
	(245,15,'Pres. Carlos P. Garcia'),
	(246,15,'Sagbayan'),
	(247,15,'San Isidro'),
	(248,15,'San Miguel'),
	(249,15,'Sevilla'),
	(250,15,'Sierra Bullones'),
	(251,15,'Sikatuna'),
	(252,15,'Talibon'),
	(253,15,'Trinidad'),
	(254,15,'Tubigon'),
	(255,15,'Ubay'),
	(256,15,'Valencia'),
	(257,16,'Malaybalay City'),
	(258,16,'Valencia City'),
	(259,16,'Baungon'),
	(260,16,'Cabanglasan'),
	(261,16,'Damulog'),
	(262,16,'Dangcagan'),
	(263,16,'Don Carlos'),
	(264,16,'Impasug-Ong'),
	(265,16,'Kadingilan'),
	(266,16,'Kalilangan'),
	(267,16,'Kibawe'),
	(268,16,'Kitaotao'),
	(269,16,'Lantapan'),
	(270,16,'Libona'),
	(271,16,'Malitbog'),
	(272,16,'Manolo Fortich'),
	(273,16,'Maramag'),
	(274,16,'Pangantucan'),
	(275,16,'Quezon'),
	(276,16,'San Fernando'),
	(277,16,'Sumilao'),
	(278,16,'Talakag'),
	(279,17,'Malolos City'),
	(280,17,'Meycauayan City'),
	(281,17,'San Jose del Monte City'),
	(282,17,'Angat'),
	(283,17,'Balagtas'),
	(284,17,'Baliuag'),
	(285,17,'Bocaue'),
	(286,17,'Bulacan'),
	(287,17,'Bustos'),
	(288,17,'Calumpit'),
	(289,17,'Doña Remedios Trinidad'),
	(290,17,'Guiguinto'),
	(291,17,'Hagonoy'),
	(292,17,'Marilao'),
	(293,17,'Norzagaray'),
	(294,17,'Obando'),
	(295,17,'Pandi'),
	(296,17,'Paombong'),
	(297,17,'Plaridel'),
	(298,17,'Pulilan'),
	(299,17,'San Ildefonso'),
	(300,17,'San Miguel'),
	(301,17,'San Rafael'),
	(302,17,'Santa Maria'),
	(303,18,'Tuguegarao City'),
	(304,18,'Abulug'),
	(305,18,'Alcala'),
	(306,18,'Allacapan'),
	(307,18,'Amulung'),
	(308,18,'Aparri'),
	(309,18,'Baggao'),
	(310,18,'Ballesteros'),
	(311,18,'Buguey'),
	(312,18,'Calayan'),
	(313,18,'Camalaniugan'),
	(314,18,'Claveria'),
	(315,18,'Enrile'),
	(316,18,'Gattaran'),
	(317,18,'Gonzaga'),
	(318,18,'Iguig'),
	(319,18,'Lal-Lo'),
	(320,18,'Lasam'),
	(321,18,'Pamplona'),
	(322,18,'Peñablanca'),
	(323,18,'Piat'),
	(324,18,'Rizal'),
	(325,18,'Sanchez-Mira'),
	(326,18,'Santa Ana'),
	(327,18,'Santa Praxedes'),
	(328,18,'Santa Teresita'),
	(329,18,'Santo Niño'),
	(330,18,'Solana'),
	(331,18,'Tuao'),
	(332,19,'Basud'),
	(333,19,'Capalonga'),
	(334,19,'Daet'),
	(335,19,'Jose Panganiban'),
	(336,19,'Labo'),
	(337,19,'Mercedes'),
	(338,19,'Paracale'),
	(339,19,'San Lorenzo Ruiz'),
	(340,19,'San Vicente'),
	(341,19,'Santa Elena'),
	(342,19,'Talisay'),
	(343,19,'Vinzons'),
	(344,20,'Iriga City'),
	(345,20,'Naga City'),
	(346,20,'Baao'),
	(347,20,'Balatan'),
	(348,20,'Bato'),
	(349,20,'Bombon'),
	(350,20,'Buhi'),
	(351,20,'Bula'),
	(352,20,'Cabusao'),
	(353,20,'Calabanga'),
	(354,20,'Camaligan'),
	(355,20,'Canaman'),
	(356,20,'Caramoan'),
	(357,20,'Del Gallego'),
	(358,20,'Gainza'),
	(359,20,'Garchitorena'),
	(360,20,'Goa'),
	(361,20,'Lagonoy'),
	(362,20,'Libmanan'),
	(363,20,'Lupi'),
	(364,20,'Magarao'),
	(365,20,'Milaor'),
	(366,20,'Minalabac'),
	(367,20,'Nabua'),
	(368,20,'Ocampo'),
	(369,20,'Pamplona'),
	(370,20,'Pasacao'),
	(371,20,'Pili'),
	(372,20,'Presentacion'),
	(373,20,'Ragay'),
	(374,20,'Sagñay'),
	(375,20,'San Fernando'),
	(376,20,'San Jose'),
	(377,20,'Sipocot'),
	(378,20,'Siruma'),
	(379,20,'Tigaon'),
	(380,20,'Tinambac'),
	(381,21,'Catarman'),
	(382,21,'Guinsiliban'),
	(383,21,'Mahinog'),
	(384,21,'Mambajao'),
	(385,21,'Sagay'),
	(386,22,'Roxas City'),
	(387,22,'Cuartero'),
	(388,22,'Dao'),
	(389,22,'Dumalag'),
	(390,22,'Dumarao'),
	(391,22,'Ivisan'),
	(392,22,'Jamindan'),
	(393,22,'Ma-ayon'),
	(394,22,'Mambusao'),
	(395,22,'Panay'),
	(396,22,'Panitan'),
	(397,22,'Pilar'),
	(398,22,'Pontevedra'),
	(399,22,'President Roxas'),
	(400,22,'Sapi-an'),
	(401,22,'Sigma'),
	(402,22,'Tapaz'),
	(403,23,'Bagamanoc'),
	(404,23,'Baras'),
	(405,23,'Bato'),
	(406,23,'Caramoran'),
	(407,23,'Gigmoto'),
	(408,23,'Pandan'),
	(409,23,'Panganiban'),
	(410,23,'San Andres'),
	(411,23,'San Miguel'),
	(412,23,'Viga'),
	(413,23,'Virac'),
	(414,24,'Cavite City'),
	(415,24,'Dasmariñas City'),
	(416,24,'Tagaytay City'),
	(417,24,'Trece Martires City'),
	(418,24,'Alfonso'),
	(419,24,'Amadeo'),
	(420,24,'Bacoor'),
	(421,24,'Carmona'),
	(422,24,'Gen. Mariano Alvarez'),
	(423,24,'Gen. Emilio Aguinaldo'),
	(424,24,'Gen. Trias'),
	(425,24,'Imus'),
	(426,24,'Indang'),
	(427,24,'Kawit'),
	(428,24,'Magallanes'),
	(429,24,'Maragondon'),
	(430,24,'Mendez'),
	(431,24,'Naic'),
	(432,24,'Noveleta'),
	(433,24,'Rosario'),
	(434,24,'Silang'),
	(435,24,'Tanza'),
	(436,24,'Ternate'),
	(437,25,'Bogo City'),
	(438,25,'Carcar City'),
	(439,25,'Cebu City'),
	(440,25,'Danao City'),
	(441,25,'Lapu-Lapu City'),
	(442,25,'Mandaue City'),
	(443,25,'Naga City'),
	(444,25,'Talisay City'),
	(445,25,'Toledo City'),
	(446,25,'Alcantara'),
	(447,25,'Alcoy'),
	(448,25,'Alegria'),
	(449,25,'Aloguinsan'),
	(450,25,'Argao'),
	(451,25,'Asturias'),
	(452,25,'Badian'),
	(453,25,'Balamban'),
	(454,25,'Bantayan'),
	(455,25,'Barili'),
	(456,25,'Boljoon'),
	(457,25,'Borbon'),
	(458,25,'Carmen'),
	(459,25,'Catmon'),
	(460,25,'Compostela'),
	(461,25,'Consolacion'),
	(462,25,'Cordoba'),
	(463,25,'Daanbantayan'),
	(464,25,'Dalaguete'),
	(465,25,'Dumanjug'),
	(466,25,'Ginatilan'),
	(467,25,'Liloan'),
	(468,25,'Madridejos'),
	(469,25,'Malabuyoc'),
	(470,25,'Medellin'),
	(471,25,'Minglanilla'),
	(472,25,'Moalboal'),
	(473,25,'Oslob'),
	(474,25,'Pilar'),
	(475,25,'Pinamungahan'),
	(476,25,'Poro'),
	(477,25,'Ronda'),
	(478,25,'Samboan'),
	(479,25,'San Fernando'),
	(480,25,'San Francisco'),
	(481,25,'San Remigio'),
	(482,25,'Santa Fe'),
	(483,25,'Santander'),
	(484,25,'Sibonga'),
	(485,25,'Sogod'),
	(486,25,'Tabogon'),
	(487,25,'Tabuelan'),
	(488,25,'Tuburan'),
	(489,25,'Tudela'),
	(490,26,'Compostela'),
	(491,26,'Laak'),
	(492,26,'Mabini'),
	(493,26,'Maco'),
	(494,26,'Maragusan'),
	(495,26,'Mawab'),
	(496,26,'Monkayo'),
	(497,26,'Montevista'),
	(498,26,'Nabunturan'),
	(499,26,'New Bataan'),
	(500,26,'Pantukan'),
	(501,27,'Kidapawan City'),
	(502,27,'Alamada'),
	(503,27,'Aleosan'),
	(504,27,'Antipas'),
	(505,27,'Arakan'),
	(506,27,'Banisilan'),
	(507,27,'Carmen'),
	(508,27,'Kabacan'),
	(509,27,'Libungan'),
	(510,27,'M\'Lang'),
	(511,27,'Magpet'),
	(512,27,'Makilala'),
	(513,27,'Matalam'),
	(514,27,'Midsayap'),
	(515,27,'Pigkawayan'),
	(516,27,'Pikit'),
	(517,27,'President Roxas'),
	(518,27,'Tulunan'),
	(519,28,'Panabo City'),
	(520,28,'Island Garden City of Samal'),
	(521,28,'Tagum City'),
	(522,28,'Asuncion'),
	(523,28,'Braulio E. Dujali'),
	(524,28,'Carmen'),
	(525,28,'Kapalong'),
	(526,28,'New Corella'),
	(527,28,'San Isidro'),
	(528,28,'Santo Tomas'),
	(529,28,'Talaingod'),
	(530,29,'Davao City'),
	(531,29,'Digos City'),
	(532,29,'Bansalan'),
	(533,29,'Don Marcelino'),
	(534,29,'Hagonoy'),
	(535,29,'Jose Abad Santos'),
	(536,29,'Kiblawan'),
	(537,29,'Magsaysay'),
	(538,29,'Malalag'),
	(539,29,'Malita'),
	(540,29,'Matanao'),
	(541,29,'Padada'),
	(542,29,'Santa Cruz'),
	(543,29,'Santa Maria'),
	(544,29,'Sarangani'),
	(545,29,'Sulop'),
	(546,30,'Mati City'),
	(547,30,'Baganga'),
	(548,30,'Banaybanay'),
	(549,30,'Boston'),
	(550,30,'Caraga'),
	(551,30,'Cateel'),
	(552,30,'Governor Generoso'),
	(553,30,'Lupon'),
	(554,30,'Manay'),
	(555,30,'San Isidro'),
	(556,30,'Tarragona'),
	(557,31,'Basilisia [Rizal]'),
	(558,31,'Cagdianao'),
	(559,31,'Dinagat'),
	(560,31,'Libjo [Albor]'),
	(561,31,'Loreto'),
	(562,31,'San Jose'),
	(563,32,'Borongan City'),
	(564,32,'Arteche'),
	(565,32,'Balangiga'),
	(566,32,'Balangkayan'),
	(567,32,'Can-avid'),
	(568,32,'Dolores'),
	(569,32,'General MacArthur'),
	(570,32,'Giporlos'),
	(571,32,'Guiuan'),
	(572,32,'Hernani'),
	(573,32,'Jipapad'),
	(574,32,'Lawaan'),
	(575,32,'Llorente'),
	(576,32,'Maslog'),
	(577,32,'Maydolong'),
	(578,32,'Mercedes'),
	(579,32,'Oras'),
	(580,32,'Quinapondan'),
	(581,32,'Salcedo'),
	(582,32,'San Julian'),
	(583,32,'San Policarpo'),
	(584,32,'Sulat'),
	(585,32,'Taft'),
	(586,33,'Buenavista'),
	(587,33,'Jordan'),
	(588,33,'Nueva Valencia'),
	(589,33,'San Lorenzo'),
	(590,33,'Sibunag'),
	(591,34,'Aguinaldo'),
	(592,34,'Alfonso Lista'),
	(593,34,'Asipulo'),
	(594,34,'Banaue'),
	(595,34,'Hingyon'),
	(596,34,'Hungduan'),
	(597,34,'Kiangan'),
	(598,34,'Lagawe'),
	(599,34,'Lamut'),
	(600,34,'Mayoyao'),
	(601,34,'Tinoc'),
	(602,35,'Batac City'),
	(603,35,'Laoag City'),
	(604,35,'Adams'),
	(605,35,'Bacarra'),
	(606,35,'Badoc'),
	(607,35,'Bangui'),
	(608,35,'Banna'),
	(609,35,'Burgos'),
	(610,35,'Carasi'),
	(611,35,'Currimao'),
	(612,35,'Dingras'),
	(613,35,'Dumalneg'),
	(614,35,'Marcos'),
	(615,35,'Nueva Era'),
	(616,35,'Pagudpud'),
	(617,35,'Paoay'),
	(618,35,'Pasuquin'),
	(619,35,'Piddig'),
	(620,35,'Pinili'),
	(621,35,'San Nicolas'),
	(622,35,'Sarrat'),
	(623,35,'Solsona'),
	(624,35,'Vintar'),
	(625,36,'Candon City'),
	(626,36,'Vigan City'),
	(627,36,'Alilem'),
	(628,36,'Banayoyo'),
	(629,36,'Bantay'),
	(630,36,'Burgos'),
	(631,36,'Cabugao'),
	(632,36,'Caoayan'),
	(633,36,'Cervantes'),
	(634,36,'Galimuyod'),
	(635,36,'Gregorio Del Pilar'),
	(636,36,'Lidlidda'),
	(637,36,'Magsingal'),
	(638,36,'Nagbukel'),
	(639,36,'Narvacan'),
	(640,36,'Quirino'),
	(641,36,'Salcedo'),
	(642,36,'San Emilio'),
	(643,36,'San Esteban'),
	(644,36,'San Ildefonso'),
	(645,36,'San Juan'),
	(646,36,'San Vicente'),
	(647,36,'Santa'),
	(648,36,'Santa Catalina'),
	(649,36,'Santa Cruz'),
	(650,36,'Santa Lucia'),
	(651,36,'Santa Maria'),
	(652,36,'Santiago'),
	(653,36,'Santo Domingo'),
	(654,36,'Sigay'),
	(655,36,'Sinait'),
	(656,36,'Sugpon'),
	(657,36,'Suyo'),
	(658,36,'Tagudin'),
	(659,37,'Cauayan City'),
	(660,37,'Santiago City'),
	(661,37,'Alicia'),
	(662,37,'Angadanan'),
	(663,37,'Aurora'),
	(664,37,'Benito Soliven'),
	(665,37,'Burgos'),
	(666,37,'Cabagan'),
	(667,37,'Cabatuan'),
	(668,37,'Cordon'),
	(669,37,'Delfin Albano'),
	(670,37,'Dinapigue'),
	(671,37,'Divilacan'),
	(672,37,'Echague'),
	(673,37,'Gamu'),
	(674,37,'Ilagan'),
	(675,37,'Jones'),
	(676,37,'Luna'),
	(677,37,'Maconacon'),
	(678,37,'Mallig'),
	(679,37,'Naguilian'),
	(680,37,'Palanan'),
	(681,37,'Quezon'),
	(682,37,'Quirino'),
	(683,37,'Ramon'),
	(684,37,'Reina Mercedes'),
	(685,37,'Roxas'),
	(686,37,'San Agustin'),
	(687,37,'San Guillermo'),
	(688,37,'San Isidro'),
	(689,37,'San Manuel'),
	(690,37,'San Mariano'),
	(691,37,'San Mateo'),
	(692,37,'San Pablo'),
	(693,37,'Santa Maria'),
	(694,37,'Santo Tomas'),
	(695,37,'Tumauini'),
	(696,38,'Iloilo City'),
	(697,38,'Passi City'),
	(698,38,'Ajuy'),
	(699,38,'Alimodian'),
	(700,38,'Anilao'),
	(701,38,'Badiangan'),
	(702,38,'Balasan'),
	(703,38,'Banate'),
	(704,38,'Barotac Nuevo'),
	(705,38,'Barotac Viejo'),
	(706,38,'Batad'),
	(707,38,'Bingawan'),
	(708,38,'Cabatuan'),
	(709,38,'Calinog'),
	(710,38,'Carles'),
	(711,38,'Concepcion'),
	(712,38,'Dingle'),
	(713,38,'Dueñas'),
	(714,38,'Dumangas'),
	(715,38,'Estancia'),
	(716,38,'Guimbal'),
	(717,38,'Igbaras'),
	(718,38,'Janiuay'),
	(719,38,'Lambunao'),
	(720,38,'Leganes'),
	(721,38,'Lemery'),
	(722,38,'Leon'),
	(723,38,'Maasin'),
	(724,38,'Miagao'),
	(725,38,'Mina'),
	(726,38,'New Lucena'),
	(727,38,'Oton'),
	(728,38,'Pavia'),
	(729,38,'Pototan'),
	(730,38,'San Dionisio'),
	(731,38,'San Enrique'),
	(732,38,'San Joaquin'),
	(733,38,'San Miguel'),
	(734,38,'San Rafael'),
	(735,38,'Santa Barbara'),
	(736,38,'Sara'),
	(737,38,'Tigbauan'),
	(738,38,'Tubungan'),
	(739,38,'Zarraga'),
	(740,39,'Tabuk City'),
	(741,39,'Balbalan'),
	(742,39,'Lubuagan'),
	(743,39,'Pasil'),
	(744,39,'Pinukpuk'),
	(745,39,'Rizal'),
	(746,39,'Tanudan'),
	(747,39,'Tinglayan'),
	(748,40,'San Fernando City'),
	(749,40,'Agoo'),
	(750,40,'Aringay'),
	(751,40,'Bacnotan'),
	(752,40,'Bagulin'),
	(753,40,'Balaoan'),
	(754,40,'Bangar'),
	(755,40,'Bauang'),
	(756,40,'Burgos'),
	(757,40,'Caba'),
	(758,40,'Luna'),
	(759,40,'Naguilian'),
	(760,40,'Pugo'),
	(761,40,'Rosario'),
	(762,40,'San Gabriel'),
	(763,40,'San Juan'),
	(764,40,'Santo Tomas'),
	(765,40,'Santol'),
	(766,40,'Sudipen'),
	(767,40,'Tubao'),
	(768,41,'Calamba City'),
	(769,41,'San Pablo City'),
	(770,41,'Santa Rosa City'),
	(771,41,'Alaminos'),
	(772,41,'Bay'),
	(773,41,'Biñan'),
	(774,41,'Cabuyao'),
	(775,41,'Calauan'),
	(776,41,'Cavinti'),
	(777,41,'Famy'),
	(778,41,'Kalayaan'),
	(779,41,'Liliw'),
	(780,41,'Los Baños'),
	(781,41,'Luisiana'),
	(782,41,'Lumban'),
	(783,41,'Mabitac'),
	(784,41,'Magdalena'),
	(785,41,'Majayjay'),
	(786,41,'Nagcarlan'),
	(787,41,'Paete'),
	(788,41,'Pagsanjan'),
	(789,41,'Pakil'),
	(790,41,'Pangil'),
	(791,41,'Pila'),
	(792,41,'Rizal'),
	(793,41,'San Pedro'),
	(794,41,'Santa Cruz'),
	(795,41,'Santa Maria'),
	(796,41,'Siniloan'),
	(797,41,'Victoria'),
	(798,42,'Iligan City'),
	(799,42,'Bacolod'),
	(800,42,'Baloi'),
	(801,42,'Baroy'),
	(802,42,'Kapatagan'),
	(803,42,'Kauswagan'),
	(804,42,'Kolambugan'),
	(805,42,'Lala'),
	(806,42,'Linamon'),
	(807,42,'Magsaysay'),
	(808,42,'Maigo'),
	(809,42,'Matungao'),
	(810,42,'Munai'),
	(811,42,'Nunungan'),
	(812,42,'Pantao Ragat'),
	(813,42,'Pantar'),
	(814,42,'Poona Piagapo'),
	(815,42,'Salvador'),
	(816,42,'Sapad'),
	(817,42,'Sultan Naga Dimaporo'),
	(818,42,'Tagoloan'),
	(819,42,'Tangcal'),
	(820,42,'Tubod'),
	(821,43,'Marawi City'),
	(822,43,'Bacolod-Kalawi'),
	(823,43,'Balabagan'),
	(824,43,'Balindong'),
	(825,43,'Bayang'),
	(826,43,'Binidayan'),
	(827,43,'Buadiposo-Buntong'),
	(828,43,'Bubong'),
	(829,43,'Bumbaran'),
	(830,43,'Butig'),
	(831,43,'Calanogas'),
	(832,43,'Ditsaan-Ramain'),
	(833,43,'Ganassi'),
	(834,43,'Kapai'),
	(835,43,'Kapatagan'),
	(836,43,'Lumba-Bayabao'),
	(837,43,'Lumbaca-Unayan'),
	(838,43,'Lumbatan'),
	(839,43,'Lumbayanague'),
	(840,43,'Madalum'),
	(841,43,'Madamba'),
	(842,43,'Maguing'),
	(843,43,'Malabang'),
	(844,43,'Marantao'),
	(845,43,'Marogong'),
	(846,43,'Masiu'),
	(847,43,'Mulondo'),
	(848,43,'Pagayawan'),
	(849,43,'Piagapo'),
	(850,43,'Poona Bayabao'),
	(851,43,'Pualas'),
	(852,43,'Saguiaran'),
	(853,43,'Sultan Dumalondong'),
	(854,43,'Picong'),
	(855,43,'Tagoloan II'),
	(856,43,'Tamparan'),
	(857,43,'Taraka'),
	(858,43,'Tubaran'),
	(859,43,'Tugaya'),
	(860,43,'Wao'),
	(861,44,'Baybay City'),
	(862,44,'Ormoc City'),
	(863,44,'Tacloban City'),
	(864,44,'Abuyog'),
	(865,44,'Alangalang'),
	(866,44,'Albuera'),
	(867,44,'Babatngon'),
	(868,44,'Barugo'),
	(869,44,'Bato'),
	(870,44,'Burauen'),
	(871,44,'Calubian'),
	(872,44,'Capoocan'),
	(873,44,'Carigara'),
	(874,44,'Dagami'),
	(875,44,'Dulag'),
	(876,44,'Hilongos'),
	(877,44,'Hindang'),
	(878,44,'Inopacan'),
	(879,44,'Isabel'),
	(880,44,'Jaro'),
	(881,44,'Javier'),
	(882,44,'Julita'),
	(883,44,'Kananga'),
	(884,44,'La Paz'),
	(885,44,'Leyte'),
	(886,44,'Macarthur'),
	(887,44,'Mahaplag'),
	(888,44,'Matag-ob'),
	(889,44,'Matalom'),
	(890,44,'Mayorga'),
	(891,44,'Merida'),
	(892,44,'Palo'),
	(893,44,'Palompon'),
	(894,44,'Pastrana'),
	(895,44,'San Isidro'),
	(896,44,'San Miguel'),
	(897,44,'Santa Fe'),
	(898,44,'Tabango'),
	(899,44,'Tabontabon'),
	(900,44,'Tanauan'),
	(901,44,'Tolosa'),
	(902,44,'Tunga'),
	(903,44,'Villaba'),
	(904,45,'Cotabato City'),
	(905,45,'Ampatuan'),
	(906,45,'Barira'),
	(907,45,'Buldon'),
	(908,45,'Buluan'),
	(909,45,'Datu Abdullah Sangki'),
	(910,45,'Datu Anggal Midtimbang'),
	(911,45,'Datu Blah T. Sinsuat'),
	(912,45,'Datu Hoffer Ampatuan'),
	(913,45,'Datu Montawal'),
	(914,45,'Datu Odin Sinsuat'),
	(915,45,'Datu Paglas'),
	(916,45,'Datu Piang'),
	(917,45,'Datu Salibo'),
	(918,45,'Datu Saudi-Ampatuan'),
	(919,45,'Datu Unsay'),
	(920,45,'Gen. S. K. Pendatun'),
	(921,45,'Guindulungan'),
	(922,45,'Kabuntalan'),
	(923,45,'Mamasapano'),
	(924,45,'Mangudadatu'),
	(925,45,'Matanog'),
	(926,45,'Northern Kabuntalan'),
	(927,45,'Pagalungan'),
	(928,45,'Paglat'),
	(929,45,'Pandag'),
	(930,45,'Parang'),
	(931,45,'Rajah Buayan'),
	(932,45,'Shariff Aguak'),
	(933,45,'Shariff Saydona Mustapha'),
	(934,45,'South Upi'),
	(935,45,'Sultan Kudarat'),
	(936,45,'Sultan Mastura'),
	(937,45,'Sultan sa Barongis'),
	(938,45,'Talayan'),
	(939,45,'Talitay'),
	(940,45,'Upi'),
	(941,46,'Boac'),
	(942,46,'Buenavista'),
	(943,46,'Gasan'),
	(944,46,'Mogpog'),
	(945,46,'Santa Cruz'),
	(946,46,'Torrijos'),
	(947,47,'Masbate City'),
	(948,47,'Aroroy'),
	(949,47,'Baleno'),
	(950,47,'Balud'),
	(951,47,'Batuan'),
	(952,47,'Cataingan'),
	(953,47,'Cawayan'),
	(954,47,'Claveria'),
	(955,47,'Dimasalang'),
	(956,47,'Esperanza'),
	(957,47,'Mandaon'),
	(958,47,'Milagros'),
	(959,47,'Mobo'),
	(960,47,'Monreal'),
	(961,47,'Palanas'),
	(962,47,'Pio V. Corpuz'),
	(963,47,'Placer'),
	(964,47,'San Fernando'),
	(965,47,'San Jacinto'),
	(966,47,'San Pascual'),
	(967,47,'Uson'),
	(968,48,'Caloocan City'),
	(969,48,'Las Piñas City'),
	(970,48,'Makati City'),
	(971,48,'Malabon City'),
	(972,48,'Mandaluyong City'),
	(973,48,'Manila City'),
	(974,48,'Marikina City'),
	(975,48,'Muntinlupa City'),
	(976,48,'Navotas City'),
	(977,48,'Parañaque City'),
	(978,48,'Pasay City'),
	(979,48,'Pasig City'),
	(980,48,'Quezon City'),
	(981,48,'San Juan City'),
	(982,48,'Taguig City'),
	(983,48,'Valenzuela City'),
	(984,48,'Pateros'),
	(985,49,'Oroquieta City'),
	(986,49,'Ozamiz City'),
	(987,49,'Tangub City'),
	(988,49,'Aloran'),
	(989,49,'Baliangao'),
	(990,49,'Bonifacio'),
	(991,49,'Calamba'),
	(992,49,'Clarin'),
	(993,49,'Concepcion'),
	(994,49,'Don Victoriano Chiongbian'),
	(995,49,'Jimenez'),
	(996,49,'Lopez Jaena'),
	(997,49,'Panaon'),
	(998,49,'Plaridel'),
	(999,49,'Sapang Dalaga'),
	(1000,49,'Sinacaban');

/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table countries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `countries`;

CREATE TABLE `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;

INSERT INTO `countries` (`id`, `name`)
VALUES
	(1,'Afghanistan'),
	(2,'Akrotiri'),
	(3,'Albania'),
	(4,'Algeria'),
	(5,'American Samoa'),
	(6,'Andorra'),
	(7,'Angola'),
	(8,'Anguilla'),
	(9,'Antarctica'),
	(10,'Antigua and Barbuda'),
	(11,'Argentina'),
	(12,'Armenia'),
	(13,'Aruba'),
	(14,'Ashmore and Cartier Islands'),
	(15,'Australia'),
	(16,'Austria'),
	(17,'Azerbaijan'),
	(18,'Bahamas, The'),
	(19,'Bahrain'),
	(20,'Bangladesh'),
	(21,'Barbados'),
	(22,'Bassas da India'),
	(23,'Belarus'),
	(24,'Belgium'),
	(25,'Belize'),
	(26,'Benin'),
	(27,'Bermuda'),
	(28,'Bhutan'),
	(29,'Bolivia'),
	(30,'Bosnia and Herzegovina'),
	(31,'Botswana'),
	(32,'Bouvet Island'),
	(33,'Brazil'),
	(34,'British Indian Ocean Territory'),
	(35,'British Virgin Islands'),
	(36,'Brunei'),
	(37,'Bulgaria'),
	(38,'Burkina Faso'),
	(39,'Burma'),
	(40,'Burundi'),
	(41,'Cambodia'),
	(42,'Cameroon'),
	(43,'Canada'),
	(44,'Cape Verde'),
	(45,'Cayman Islands'),
	(46,'Central African Republic'),
	(47,'Chad'),
	(48,'Chile'),
	(49,'China'),
	(50,'Christmas Island'),
	(51,'Clipperton Island'),
	(52,'Cocos (Keeling) Islands'),
	(53,'Colombia'),
	(54,'Comoros'),
	(55,'Congo, Democratic Republic of the'),
	(56,'Congo, Republic of the'),
	(57,'Cook Islands'),
	(58,'Coral Sea Islands'),
	(59,'Costa Rica'),
	(60,'Cote d\'Ivoire'),
	(61,'Croatia'),
	(62,'Cuba'),
	(63,'Cyprus'),
	(64,'Czech Republic'),
	(65,'Denmark'),
	(66,'Dhekelia'),
	(67,'Djibouti'),
	(68,'Dominica'),
	(69,'Dominican Republic'),
	(70,'Ecuador'),
	(71,'Egypt'),
	(72,'El Salvador'),
	(73,'Equatorial Guinea'),
	(74,'Eritrea'),
	(75,'Estonia'),
	(76,'Ethiopia'),
	(77,'Europa Island'),
	(78,'Falkland Islands (Islas Malvinas)'),
	(79,'Faroe Islands'),
	(80,'Fiji'),
	(81,'Finland'),
	(82,'France'),
	(83,'French Guiana'),
	(84,'French Polynesia'),
	(85,'French Southern and Antarctic Lands'),
	(86,'Gabon'),
	(87,'Gambia, The'),
	(88,'Gaza Strip'),
	(89,'Georgia'),
	(90,'Germany'),
	(91,'Ghana'),
	(92,'Gibraltar'),
	(93,'Glorioso Islands'),
	(94,'Greece'),
	(95,'Greenland'),
	(96,'Grenada'),
	(97,'Guadeloupe'),
	(98,'Guam'),
	(99,'Guatemala'),
	(100,'Guernsey'),
	(101,'Guinea'),
	(102,'Guinea-Bissau'),
	(103,'Guyana'),
	(104,'Haiti'),
	(105,'Heard Island and McDonald Islands'),
	(106,'Holy See (Vatican City)'),
	(107,'Honduras'),
	(108,'Hong Kong'),
	(109,'Hungary'),
	(110,'Iceland'),
	(111,'India'),
	(112,'Indonesia'),
	(113,'Iran'),
	(114,'Iraq'),
	(115,'Ireland'),
	(116,'Isle of Man'),
	(117,'Israel'),
	(118,'Italy'),
	(119,'Jamaica'),
	(120,'Jan Mayen'),
	(121,'Japan'),
	(122,'Jersey'),
	(123,'Jordan'),
	(124,'Juan de Nova Island'),
	(125,'Kazakhstan'),
	(126,'Kenya'),
	(127,'Kiribati'),
	(128,'Korea, North'),
	(129,'Korea, South'),
	(130,'Kuwait'),
	(131,'Kyrgyzstan'),
	(132,'Laos'),
	(133,'Latvia'),
	(134,'Lebanon'),
	(135,'Lesotho'),
	(136,'Liberia'),
	(137,'Libya'),
	(138,'Liechtenstein'),
	(139,'Lithuania'),
	(140,'Luxembourg'),
	(141,'Macau'),
	(142,'Macedonia'),
	(143,'Madagascar'),
	(144,'Malawi'),
	(145,'Malaysia'),
	(146,'Maldives'),
	(147,'Mali'),
	(148,'Malta'),
	(149,'Marshall Islands'),
	(150,'Martinique'),
	(151,'Mauritania'),
	(152,'Mauritius'),
	(153,'Mayotte'),
	(154,'Mexico'),
	(155,'Micronesia, Federated States of'),
	(156,'Moldova'),
	(157,'Monaco'),
	(158,'Mongolia'),
	(159,'Montserrat'),
	(160,'Morocco'),
	(161,'Mozambique'),
	(162,'Namibia'),
	(163,'Nauru'),
	(164,'Navassa Island'),
	(165,'Nepal'),
	(166,'Netherlands'),
	(167,'Netherlands Antilles'),
	(168,'New Caledonia'),
	(169,'New Zealand'),
	(170,'Nicaragua'),
	(171,'Niger'),
	(172,'Nigeria'),
	(173,'Niue'),
	(174,'Norfolk Island'),
	(175,'Northern Mariana Islands'),
	(176,'Norway'),
	(177,'Oman'),
	(178,'Pakistan'),
	(179,'Palau'),
	(180,'Panama'),
	(181,'Papua New Guinea'),
	(182,'Paracel Islands'),
	(183,'Paraguay'),
	(184,'Peru'),
	(185,'Philippines'),
	(186,'Pitcairn Islands'),
	(187,'Poland'),
	(188,'Portugal'),
	(189,'Puerto Rico'),
	(190,'Qatar'),
	(191,'Reunion'),
	(192,'Romania'),
	(193,'Russia'),
	(194,'Rwanda'),
	(195,'Saint Helena'),
	(196,'Saint Kitts and Nevis'),
	(197,'Saint Lucia'),
	(198,'Saint Pierre and Miquelon'),
	(199,'Saint Vincent and the Grenadines'),
	(200,'Samoa'),
	(201,'San Marino'),
	(202,'Sao Tome and Principe'),
	(203,'Saudi Arabia'),
	(204,'Senegal'),
	(205,'Serbia and Montenegro'),
	(206,'Seychelles'),
	(207,'Sierra Leone'),
	(208,'Singapore'),
	(209,'Slovakia'),
	(210,'Slovenia'),
	(211,'Solomon Islands'),
	(212,'Somalia'),
	(213,'South Africa'),
	(214,'South Georgia and the South Sandwich Islands'),
	(215,'Spain'),
	(216,'Spratly Islands'),
	(217,'Sri Lanka'),
	(218,'Sudan'),
	(219,'Suriname'),
	(220,'Svalbard'),
	(221,'Swaziland'),
	(222,'Sweden'),
	(223,'Switzerland'),
	(224,'Syria'),
	(225,'Taiwan'),
	(226,'Tajikistan'),
	(227,'Tanzania'),
	(228,'Thailand'),
	(229,'Timor-Leste'),
	(230,'Togo'),
	(231,'Tokelau'),
	(232,'Tonga'),
	(233,'Trinidad and Tobago'),
	(234,'Tromelin Island'),
	(235,'Tunisia'),
	(236,'Turkey'),
	(237,'Turkmenistan'),
	(238,'Turks and Caicos Islands'),
	(239,'Tuvalu'),
	(240,'Uganda'),
	(241,'Ukraine'),
	(242,'United Arab Emirates'),
	(243,'United Kingdom'),
	(244,'United States'),
	(245,'Uruguay'),
	(246,'Uzbekistan'),
	(247,'Vanuatu'),
	(248,'Venezuela'),
	(249,'Vietnam'),
	(250,'Virgin Islands'),
	(251,'Wake Island'),
	(252,'Wallis and Futuna'),
	(253,'West Bank'),
	(254,'Western Sahara'),
	(255,'Yemen'),
	(256,'Zambia'),
	(257,'Zimbabwe');

/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table departments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;

INSERT INTO `departments` (`id`, `name`)
VALUES
	(1,'Administration'),
	(2,'Human Resource'),
	(3,'Development'),
	(4,'Call Center'),
	(5,'Customer Service');

/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dependents
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dependents`;

CREATE TABLE `dependents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `relationship_id` int(11) NOT NULL,
  `birth_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `dependents` WRITE;
/*!40000 ALTER TABLE `dependents` DISABLE KEYS */;

INSERT INTO `dependents` (`id`, `employee_id`, `first_name`, `middle_name`, `last_name`, `relationship_id`, `birth_date`)
VALUES
	(1,1,'testing','','',1,NULL);

/*!40000 ALTER TABLE `dependents` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table education_levels
# ------------------------------------------------------------

DROP TABLE IF EXISTS `education_levels`;

CREATE TABLE `education_levels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table educations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `educations`;

CREATE TABLE `educations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `education_level_id` int(11) NOT NULL,
  `institute` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `major_specialization` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `gpa_score` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table emergency_contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `emergency_contacts`;

CREATE TABLE `emergency_contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `relationship_id` int(11) NOT NULL,
  `home_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `emergency_contacts` WRITE;
/*!40000 ALTER TABLE `emergency_contacts` DISABLE KEYS */;

INSERT INTO `emergency_contacts` (`id`, `employee_id`, `first_name`, `middle_name`, `last_name`, `relationship_id`, `home_phone`, `mobile_phone`)
VALUES
	(1,1,'test','','',1,'','');

/*!40000 ALTER TABLE `emergency_contacts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table employee_skill
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employee_skill`;

CREATE TABLE `employee_skill` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(10) unsigned NOT NULL,
  `skill_id` int(10) unsigned NOT NULL,
  `years_of_experience` int(11) DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_skill_employee_id_index` (`employee_id`),
  KEY `employee_skill_skill_id_index` (`skill_id`),
  CONSTRAINT `employee_skill_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `employee_skill_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table employees
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `face_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `job_title_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `employment_status_id` int(11) NOT NULL,
  `marital_status_id` int(11) NOT NULL,
  `nationality_id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middle_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suffix_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `address_1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_city_id` int(11) DEFAULT NULL,
  `address_province_id` int(11) DEFAULT NULL,
  `address_country_id` int(11) DEFAULT NULL,
  `address_postal_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `home_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `work_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `other_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_security` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tax_identification` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `philhealth` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hdmf_pagibig` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mid_rtn` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `resign_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_social_security_unique` (`social_security`),
  UNIQUE KEY `employees_tax_identification_unique` (`tax_identification`),
  UNIQUE KEY `employees_philhealth_unique` (`philhealth`),
  UNIQUE KEY `employees_hdmf_pagibig_unique` (`hdmf_pagibig`),
  UNIQUE KEY `employees_mid_rtn_unique` (`mid_rtn`),
  KEY `employees_employee_id_index` (`employee_id`),
  KEY `employees_user_id_index` (`user_id`),
  KEY `employees_job_title_id_index` (`job_title_id`),
  KEY `employees_department_id_index` (`department_id`),
  KEY `employees_employment_status_id_index` (`employment_status_id`),
  KEY `employees_marital_status_id_index` (`marital_status_id`),
  KEY `employees_nationality_id_index` (`nationality_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;

INSERT INTO `employees` (`id`, `employee_id`, `face_id`, `user_id`, `job_title_id`, `department_id`, `employment_status_id`, `marital_status_id`, `nationality_id`, `first_name`, `middle_name`, `last_name`, `suffix_name`, `avatar`, `gender`, `address_1`, `address_2`, `address_city_id`, `address_province_id`, `address_country_id`, `address_postal_code`, `home_phone`, `mobile_phone`, `work_email`, `other_email`, `social_security`, `tax_identification`, `philhealth`, `hdmf_pagibig`, `mid_rtn`, `birth_date`, `remarks`, `hire_date`, `resign_date`)
VALUES
	(1,'GWO-0137',146,1,7,3,2,1,62,'Bertrand','Son','Kintanar',NULL,NULL,'M','Miñoza St., Talamban','',439,25,185,'6000','032 520 2160','0949 704 7136','bertrand@verticalops.com','bertrand.kintanar@gmail.com','07-2480504-4','278-992-354','12-050792495-1','1210 2113 5039','1210 2113 5039','1985-10-31',NULL,'2012-12-17',NULL),
	(2,'GWO-0320',327,2,9,3,3,1,62,'Gabriel',NULL,'Ceniza',NULL,NULL,'M','Canduman','',262,16,185,'6014','','0923 982 7596','','','06-2633437-0','285-044-950','01-050448798-4','9122 3722 4315','9122 3722 4315','1985-03-24',NULL,'2014-05-08',NULL),
	(3,'GWO-0295',303,3,7,3,1,1,62,'Dominic',NULL,'Yordan',NULL,NULL,'M','Pc Hills, Apas, Lahug','',439,25,185,'6000','','0928 309 3989','dominic@verticalops.com','','06-2898624-7','421-696-773','12-051086366-1','9121 6417 8016',NULL,'1986-03-23',NULL,NULL,NULL),
	(4,'GWO-0370',NULL,0,7,3,2,1,62,'Alex','Lovitos','Culango',NULL,NULL,'M','2093 Don Gil Garcia Ext. Capitol Site','',439,25,185,'6000','','0932 519 1588','alex@verticalops.com','','06-2687194-3','062-687-194','','',NULL,'1988-12-18',NULL,NULL,NULL);

/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table employment_statuses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employment_statuses`;

CREATE TABLE `employment_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `employment_statuses` WRITE;
/*!40000 ALTER TABLE `employment_statuses` DISABLE KEYS */;

INSERT INTO `employment_statuses` (`id`, `name`, `class`)
VALUES
	(1,'Probationary','label-danger'),
	(2,'Regular','label-success'),
	(3,'Homebase','label-warning');

/*!40000 ALTER TABLE `employment_statuses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `groups_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;

INSERT INTO `groups` (`id`, `name`, `permissions`, `created_at`, `updated_at`)
VALUES
	(1,'administrator','{\n    \"dashboard.view\": 1,\n    \"profile.view\": 1,\n    \"profile.personal-details.update\" : 1,\n    \"profile.personal-details.view\" : 1,\n    \"profile.contact-details.update\" : 1,\n    \"profile.contact-details.view\" : 1,\n    \"profile.emergency-contacts.create\" : 1,\n    \"profile.emergency-contacts.delete\" : 1,\n    \"profile.emergency-contacts.view\" : 1,\n    \"profile.emergency-contacts.update\" : 1,\n    \"profile.dependents.create\" : 1,\n    \"profile.dependents.delete\" : 1,\n    \"profile.dependents.view\" : 1,\n    \"profile.dependents.update\" : 1,\n    \"profile.job.view\": 1,\n    \"profile.job.update\": 1,\n    \"profile.qualifications.view\" : 1,\n    \"profile.qualifications.work-experiences.create\" : 1,\n    \"profile.qualifications.work-experiences.delete\" : 1,\n    \"profile.qualifications.work-experiences.view\" : 1,\n    \"profile.qualifications.work-experiences.update\" : 1,\n    \"profile.qualifications.educations.create\" : 1,\n    \"profile.qualifications.educations.delete\" : 1,\n    \"profile.qualifications.educations.view\" : 1,\n    \"profile.qualifications.educations.update\" : 1,\n    \"profile.qualifications.skills.create\" : 1,\n    \"profile.qualifications.skills.delete\" : 1,\n    \"profile.qualifications.skills.view\" : 1,\n    \"profile.qualifications.skills.update\" : 1,\n    \"profile.qualifications.languages.create\" : 1,\n    \"profile.qualifications.languages.delete\" : 1,\n    \"profile.qualifications.languages.view\" : 1,\n    \"profile.qualifications.languages.update\" : 1,\n    \"profile.permission.view\": 1,\n    \"performance.view\" : 1,\n    \"performance.my-tracker.view\" : 1,\n    \"performance.employee-tracker.view\" : 1,\n    \"performance.configuration.view\" : 1,\n    \"performance.configuration.trackers.view\" : 1,\n    \"pim.view\": 1,\n    \"pim.employee-list.view\": 1,\n    \"pim.personal-details.update\" : 1,\n    \"pim.personal-details.view\" : 1,\n    \"pim.contact-details.update\" : 1,\n    \"pim.contact-details.view\" : 1,\n    \"pim.emergency-contacts.create\" : 1,\n    \"pim.emergency-contacts.delete\" : 1,\n    \"pim.emergency-contacts.view\" : 1,\n    \"pim.emergency-contacts.update\" : 1,\n    \"pim.dependents.create\" : 1,\n    \"pim.dependents.delete\" : 1,\n    \"pim.dependents.view\" : 1,\n    \"pim.dependents.update\" : 1,\n    \"pim.job.view\": 1,\n    \"pim.job.update\": 1,\n    \"pim.qualifications.view\" : 1,\n    \"pim.qualifications.work-experiences.create\" : 1,\n    \"pim.qualifications.work-experiences.delete\" : 1,\n    \"pim.qualifications.work-experiences.view\" : 1,\n    \"pim.qualifications.work-experiences.update\" : 1,\n    \"pim.qualifications.educations.create\" : 1,\n    \"pim.qualifications.educations.delete\" : 1,\n    \"pim.qualifications.educations.view\" : 1,\n    \"pim.qualifications.educations.update\" : 1,\n    \"pim.qualifications.skills.create\" : 1,\n    \"pim.qualifications.skills.delete\" : 1,\n    \"pim.qualifications.skills.view\" : 1,\n    \"pim.qualifications.skills.update\" : 1,\n    \"pim.qualifications.languages.create\" : 1,\n    \"pim.qualifications.languages.delete\" : 1,\n    \"pim.qualifications.languages.view\" : 1,\n    \"pim.qualifications.languages.update\" : 1,\n    \"pim.configuration.view\": 1,\n    \"pim.configuration.termination-reasons.create\": 1,\n    \"pim.configuration.termination-reasons.delete\": 1,\n    \"pim.configuration.termination-reasons.view\": 1,\n    \"pim.configuration.termination-reasons.update\": 1,\n    \"admin.view\": 1,\n    \"admin.user-management.view\": 1,\n    \"admin.job.view\": 1,\n    \"admin.job.titles.create\": 1,\n    \"admin.job.titles.delete\": 1,\n    \"admin.job.titles.view\": 1,\n    \"admin.job.titles.update\": 1,\n    \"admin.job.pay-grades.view\": 1,\n    \"admin.job.employment-status.create\": 1,\n    \"admin.job.employment-status.delete\": 1,\n    \"admin.job.employment-status.view\": 1,\n    \"admin.job.employment-status.update\": 1,\n    \"admin.job.categories.view\": 1,\n    \"admin.job.work-shifts.view\": 1,\n    \"admin.qualifications.view\": 1,\n    \"admin.qualifications.skills.create\": 1,\n    \"admin.qualifications.skills.delete\": 1,\n    \"admin.qualifications.skills.view\": 1,\n    \"admin.qualifications.skills.update\": 1,\n    \"admin.qualifications.educations.create\": 1,\n    \"admin.qualifications.educations.delete\": 1,\n    \"admin.qualifications.educations.view\": 1,\n    \"admin.qualifications.educations.update\": 1\n}','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,'ess','{\n    \"dashboard.view\": 1,\n    \"profile.view\": 1,\n    \"profile.personal-details.update\" : 1,\n    \"profile.personal-details.view\" : 1,\n    \"profile.contact-details.update\" : 1,\n    \"profile.contact-details.view\" : 1,\n    \"profile.emergency-contacts.create\" : 1,\n    \"profile.emergency-contacts.delete\" : 1,\n    \"profile.emergency-contacts.view\" : 1,\n    \"profile.emergency-contacts.update\" : 1,\n    \"profile.dependents.create\" : 1,\n    \"profile.dependents.delete\" : 1,\n    \"profile.dependents.view\" : 1,\n    \"profile.dependents.update\" : 1,\n    \"profile.qualifications.view\" : 1,\n    \"profile.qualifications.work-experiences.create\" : 1,\n    \"profile.qualifications.work-experiences.delete\" : 1,\n    \"profile.qualifications.work-experiences.view\" : 1,\n    \"profile.qualifications.work-experiences.update\" : 1,\n    \"profile.qualifications.educations.create\" : 1,\n    \"profile.qualifications.educations.delete\" : 1,\n    \"profile.qualifications.educations.view\" : 1,\n    \"profile.qualifications.educations.update\" : 1,\n    \"profile.qualifications.skills.create\" : 1,\n    \"profile.qualifications.skills.delete\" : 1,\n    \"profile.qualifications.skills.view\" : 1,\n    \"profile.qualifications.skills.update\" : 1,\n    \"profile.qualifications.languages.create\" : 1,\n    \"profile.qualifications.languages.delete\" : 1,\n    \"profile.qualifications.languages.view\" : 1,\n    \"profile.qualifications.languages.update\" : 1\n}','0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table job_titles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `job_titles`;

CREATE TABLE `job_titles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `job_titles` WRITE;
/*!40000 ALTER TABLE `job_titles` DISABLE KEYS */;

INSERT INTO `job_titles` (`id`, `name`, `description`)
VALUES
	(1,'Operations Manager',''),
	(2,'Project Manager',''),
	(3,'HR Officer',''),
	(4,'Admin Staff',''),
	(5,'Team Leader',''),
	(6,'Call Center Agent',''),
	(7,'Sr Web Developer',''),
	(8,'Jr Web Developer',''),
	(9,'Sr Web Designer',''),
	(10,'Jr Web Designer',''),
	(11,'System Admin','');

/*!40000 ALTER TABLE `job_titles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table marital_statuses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `marital_statuses`;

CREATE TABLE `marital_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `marital_statuses` WRITE;
/*!40000 ALTER TABLE `marital_statuses` DISABLE KEYS */;

INSERT INTO `marital_statuses` (`id`, `name`)
VALUES
	(1,'Single'),
	(2,'Married'),
	(3,'Other');

/*!40000 ALTER TABLE `marital_statuses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2012_12_06_225921_migration_cartalyst_sentry_install_users',1),
	('2012_12_06_225929_migration_cartalyst_sentry_install_groups',1),
	('2012_12_06_225945_migration_cartalyst_sentry_install_users_groups_pivot',1),
	('2012_12_06_225988_migration_cartalyst_sentry_install_throttle',1),
	('2014_10_22_005820_create_employees_table',2),
	('2014_10_22_012114_create_titles_table',2),
	('2014_10_22_012228_create_departments_table',2),
	('2014_10_22_012335_create_employment_statuses_table',2),
	('2014_10_22_053904_create_marital_status_table',2),
	('2014_10_22_082537_create_nationalities_table',2),
	('2014_10_22_232347_create_navlinks_table',2),
	('2014_10_24_013659_create_countries_tables',2),
	('2014_10_24_015216_create_provinces_tables',2),
	('2014_10_24_015229_create_cities_tables',2),
	('2014_10_24_143731_create_relationships_table',2),
	('2014_10_24_143753_create_emergency_contacts_table',2),
	('2014_10_24_220637_create_dependents_table',2),
	('2014_10_27_015713_create_education_levels_table',2),
	('2014_10_27_015748_create_educations_table',2),
	('2014_10_27_021146_create_work_experiences_table',2),
	('2014_10_27_044305_create_skills_table',2),
	('2014_10_27_045310_create_pivot_employee_skill_table',2),
	('2014_10_28_203049_create_termination_reasons',2);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table nationalities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nationalities`;

CREATE TABLE `nationalities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `nationalities` WRITE;
/*!40000 ALTER TABLE `nationalities` DISABLE KEYS */;

INSERT INTO `nationalities` (`id`, `name`)
VALUES
	(1,'Afghan'),
	(2,'Albanian'),
	(3,'Algerian'),
	(4,'American'),
	(5,'Andorran'),
	(6,'Angolan'),
	(7,'Antiguans'),
	(8,'Argentinean'),
	(9,'Armenian'),
	(10,'Australian'),
	(11,'Austrian'),
	(12,'Azerbaijani'),
	(13,'Bahamian'),
	(14,'Bahraini'),
	(15,'Bangladeshi'),
	(16,'Barbadian'),
	(17,'Barbudans'),
	(18,'Batswana'),
	(19,'Belarusian'),
	(20,'Belgian'),
	(21,'Belizean'),
	(22,'Beninese'),
	(23,'Bhutanese'),
	(24,'Bolivian'),
	(25,'Bosnian'),
	(26,'Brazilian'),
	(27,'British'),
	(28,'Bruneian'),
	(29,'Bulgarian'),
	(30,'Burkinabe'),
	(31,'Burmese'),
	(32,'Burundian'),
	(33,'Cambodian'),
	(34,'Cameroonian'),
	(35,'Canadian'),
	(36,'Cape Verdean'),
	(37,'Central African'),
	(38,'Chadian'),
	(39,'Chilean'),
	(40,'Chinese'),
	(41,'Colombian'),
	(42,'Comoran'),
	(43,'Congolese'),
	(44,'Costa Rican'),
	(45,'Croatian'),
	(46,'Cuban'),
	(47,'Cypriot'),
	(48,'Czech'),
	(49,'Danish'),
	(50,'Djibouti'),
	(51,'Dominican'),
	(52,'Dutch'),
	(53,'East Timorese'),
	(54,'Ecuadorean'),
	(55,'Egyptian'),
	(56,'Emirian'),
	(57,'Equatorial Guinean'),
	(58,'Eritrean'),
	(59,'Estonian'),
	(60,'Ethiopian'),
	(61,'Fijian'),
	(62,'Filipino'),
	(63,'Finnish'),
	(64,'French'),
	(65,'Gabonese'),
	(66,'Gambian'),
	(67,'Georgian'),
	(68,'German'),
	(69,'Ghanaian'),
	(70,'Greek'),
	(71,'Grenadian'),
	(72,'Guatemalan'),
	(73,'Guinea-Bissauan'),
	(74,'Guinean'),
	(75,'Guyanese'),
	(76,'Haitian'),
	(77,'Herzegovinian'),
	(78,'Honduran'),
	(79,'Hungarian'),
	(80,'I-Kiribati'),
	(81,'Icelander'),
	(82,'Indian'),
	(83,'Indonesian'),
	(84,'Iranian'),
	(85,'Iraqi'),
	(86,'Irish'),
	(87,'Israeli'),
	(88,'Italian'),
	(89,'Ivorian'),
	(90,'Jamaican'),
	(91,'Japanese'),
	(92,'Jordanian'),
	(93,'Kazakhstani'),
	(94,'Kenyan'),
	(95,'Kittian and Nevisian'),
	(96,'Kuwaiti'),
	(97,'Kyrgyz'),
	(98,'Laotian'),
	(99,'Latvian'),
	(100,'Lebanese'),
	(101,'Liberian'),
	(102,'Libyan'),
	(103,'Liechtensteiner'),
	(104,'Lithuanian'),
	(105,'Luxembourger'),
	(106,'Macedonian'),
	(107,'Malagasy'),
	(108,'Malawian'),
	(109,'Malaysian'),
	(110,'Maldivan'),
	(111,'Malian'),
	(112,'Maltese'),
	(113,'Marshallese'),
	(114,'Mauritanian'),
	(115,'Mauritian'),
	(116,'Mexican'),
	(117,'Micronesian'),
	(118,'Moldovan'),
	(119,'Monacan'),
	(120,'Mongolian'),
	(121,'Moroccan'),
	(122,'Mosotho'),
	(123,'Motswana'),
	(124,'Mozambican'),
	(125,'Namibian'),
	(126,'Nauruan'),
	(127,'Nepalese'),
	(128,'New Zealander'),
	(129,'Nicaraguan'),
	(130,'Nigerian'),
	(131,'Nigerien'),
	(132,'North Korean'),
	(133,'Northern Irish'),
	(134,'Norwegian'),
	(135,'Omani'),
	(136,'Pakistani'),
	(137,'Palauan'),
	(138,'Panamanian'),
	(139,'Papua New Guinean'),
	(140,'Paraguayan'),
	(141,'Peruvian'),
	(142,'Polish'),
	(143,'Portuguese'),
	(144,'Qatari'),
	(145,'Romanian'),
	(146,'Russian'),
	(147,'Rwandan'),
	(148,'Saint Lucian'),
	(149,'Salvadoran'),
	(150,'Samoan'),
	(151,'San Marinese'),
	(152,'Sao Tomean'),
	(153,'Saudi'),
	(154,'Scottish'),
	(155,'Senegalese'),
	(156,'Serbian'),
	(157,'Seychellois'),
	(158,'Sierra Leonean'),
	(159,'Singaporean'),
	(160,'Slovakian'),
	(161,'Slovenian'),
	(162,'Solomon Islander'),
	(163,'Somali'),
	(164,'South African'),
	(165,'South Korean'),
	(166,'Spanish'),
	(167,'Sri Lankan'),
	(168,'Sudanese'),
	(169,'Surinamer'),
	(170,'Swazi'),
	(171,'Swedish'),
	(172,'Swiss'),
	(173,'Syrian'),
	(174,'Taiwanese'),
	(175,'Tajik'),
	(176,'Tanzanian'),
	(177,'Thai'),
	(178,'Togolese'),
	(179,'Tongan'),
	(180,'Trinidadian or Tobagonian'),
	(181,'Tunisian'),
	(182,'Turkish'),
	(183,'Tuvaluan'),
	(184,'Ugandan'),
	(185,'Ukrainian'),
	(186,'Uruguayan'),
	(187,'Uzbekistani'),
	(188,'Venezuelan'),
	(189,'Vietnamese'),
	(190,'Welsh'),
	(191,'Yemenite'),
	(192,'Zambian'),
	(193,'Zimbabwean');

/*!40000 ALTER TABLE `nationalities` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table navlinks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `navlinks`;

CREATE TABLE `navlinks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `href` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permission` int(11) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `navlinks` WRITE;
/*!40000 ALTER TABLE `navlinks` DISABLE KEYS */;

INSERT INTO `navlinks` (`id`, `name`, `href`, `icon`, `permission`, `parent_id`, `created_at`, `updated_at`)
VALUES
	(1,'Dashboard','dashboard','fa-th-large',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,'Profile','profile','fa-user',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(3,'Personal Details','profile/personal-details','fa-file-text-o ',3,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(4,'Contact Details','profile/contact-details','fa-phone-square',3,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(5,'Emergency Contacts','profile/emergency-contacts','fa-plus-square ',15,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(6,'Dependents','profile/dependents','fa-child',15,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(7,'Job','profile/job','fa-briefcase',3,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(8,'Salary','profile/salary','fa-money',3,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(9,'Qualifications','profile/qualifications','fa-bookmark',1,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(10,'Performance','performance','fa-bar-chart-o',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(11,'My Trackers','performance/my-tracker','fa-comments-o',7,10,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(12,'Employee Trackers','performance/employee-tracker','fa-comments',7,10,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(13,'PIM','pim','fa-cogs',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(14,'Employee List','pim/employee-list','fa-list-ul',15,13,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(15,'Administrator','admin','fa-group',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(16,'User Management','admin/user-management','fa-suitcase',15,15,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(17,'Job','admin/job','fa-list-ol',1,15,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(18,'Job Titles','admin/job/titles','fa-certificate',15,17,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(19,'Pay Grades','admin/job/pay-grades','fa-bullseye',15,17,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(20,'Employment Status','admin/job/employment-status','fa-info-circle',15,17,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(21,'Job Categories','admin/job/categories','fa-sitemap',15,17,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(22,'Work Shifts','admin/job/work-shifts','fa-clock-o ',15,17,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(23,'Qualifications','admin/qualifications','fa-check-square-o',1,15,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(24,'Skills','admin/qualifications/skills','fa-wrench ',15,23,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(25,'Education','admin/qualifications/educations','fa-graduation-cap',15,23,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(26,'Configuration','pim/configuration','fa-cog',1,13,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(27,'Termination Reasons','pim/configuration/termination-reasons','fa-exclamation-triangle',15,26,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(28,'Configuration','performance/configuration','fa-cog',1,10,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(29,'Trackers','performance/configuration/trackers','fa-tasks',15,28,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(30,'Work Experience','profile/qualifications/work-experiences','',15,9,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(31,'Education','profile/qualifications/educations','',15,9,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(32,'Skills','profile/qualifications/skills','',15,9,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(33,'Personal Details','pim/personal-details','',3,14,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(34,'Contact Details','pim/contact-details','',3,14,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(35,'Emergency Contacts','pim/emergency-contacts','fa-plus-square ',15,14,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(36,'Dependents','pim/dependents','fa-child',15,14,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(37,'Job','pim/job','fa-briefcase',3,14,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(38,'Salary','pim/salary','fa-money',3,14,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(39,'Qualifications','pim/qualifications','fa-bookmark',1,14,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(40,'Work Experience','pim/qualifications/work-experiences','fa-bookmark',15,39,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `navlinks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table provinces
# ------------------------------------------------------------

DROP TABLE IF EXISTS `provinces`;

CREATE TABLE `provinces` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `provinces` WRITE;
/*!40000 ALTER TABLE `provinces` DISABLE KEYS */;

INSERT INTO `provinces` (`id`, `country_id`, `name`)
VALUES
	(1,185,'Abra'),
	(2,185,'Agusan del Norte'),
	(3,185,'Agusan del Sur'),
	(4,185,'Aklan'),
	(5,185,'Albay'),
	(6,185,'Antique'),
	(7,185,'Apayao'),
	(8,185,'Aurora'),
	(9,185,'Basilan'),
	(10,185,'Bataan'),
	(11,185,'Batanes'),
	(12,185,'Batangas'),
	(13,185,'Benguet'),
	(14,185,'Biliran'),
	(15,185,'Bohol'),
	(16,185,'Bukidnon'),
	(17,185,'Bulacan'),
	(18,185,'Cagayan'),
	(19,185,'Camarines Norte'),
	(20,185,'Camarines Sur'),
	(21,185,'Camiguin'),
	(22,185,'Capiz'),
	(23,185,'Catanduanes'),
	(24,185,'Cavite'),
	(25,185,'Cebu'),
	(26,185,'Compostela Valley'),
	(27,185,'Cotabato'),
	(28,185,'Davao del Norte'),
	(29,185,'Davao del Sur'),
	(30,185,'Davao Oriental'),
	(31,185,'Dinagat Islands'),
	(32,185,'Eastern Samar'),
	(33,185,'Guimaras'),
	(34,185,'Ifugao'),
	(35,185,'Ilocos Norte'),
	(36,185,'Ilocos Sur'),
	(37,185,'Isabela'),
	(38,185,'Iloilo'),
	(39,185,'Kalinga'),
	(40,185,'La Union'),
	(41,185,'Laguna'),
	(42,185,'Lanao del Norte'),
	(43,185,'Lanao del Sur'),
	(44,185,'Leyte'),
	(45,185,'Maguindanao'),
	(46,185,'Marinduque'),
	(47,185,'Masbate'),
	(48,185,'Metro Manila'),
	(49,185,'Misamis Occidental'),
	(50,185,'Misamis Oriental'),
	(51,185,'Mountain Province'),
	(52,185,'Negros Occidental'),
	(53,185,'Negros Oriental'),
	(54,185,'Northern Samar'),
	(55,185,'Nueva Ecija'),
	(56,185,'Nueva Vizcaya'),
	(57,185,'Occidental Mindoro'),
	(58,185,'Oriental Mindoro'),
	(59,185,'Palawan'),
	(60,185,'Pampanga'),
	(61,185,'Pangasinan'),
	(62,185,'Quezon'),
	(63,185,'Quirino'),
	(64,185,'Rizal'),
	(65,185,'Romblon'),
	(66,185,'Samar'),
	(67,185,'Sarangani'),
	(68,185,'Siquijor'),
	(69,185,'Sorsogon'),
	(70,185,'South Cotabato'),
	(71,185,'Southern Leyte'),
	(72,185,'Sultan Kudarat'),
	(73,185,'Sulu'),
	(74,185,'Surigao del Norte'),
	(75,185,'Surigao del Sur'),
	(76,185,'Tarlac'),
	(77,185,'Tawi-Tawi'),
	(78,185,'Zambales'),
	(79,185,'Zamboanga del Norte'),
	(80,185,'Zamboanga del Sur'),
	(81,185,'Zamboanga Sibugay');

/*!40000 ALTER TABLE `provinces` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table relationships
# ------------------------------------------------------------

DROP TABLE IF EXISTS `relationships`;

CREATE TABLE `relationships` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `relationships` WRITE;
/*!40000 ALTER TABLE `relationships` DISABLE KEYS */;

INSERT INTO `relationships` (`id`, `name`)
VALUES
	(1,'Father'),
	(2,'Mother'),
	(3,'Brother'),
	(4,'Sister'),
	(5,'Spouse'),
	(6,'Child'),
	(7,'Grandfather'),
	(8,'Grandmother'),
	(10,'Other');

/*!40000 ALTER TABLE `relationships` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table skills
# ------------------------------------------------------------

DROP TABLE IF EXISTS `skills`;

CREATE TABLE `skills` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table termination_reasons
# ------------------------------------------------------------

DROP TABLE IF EXISTS `termination_reasons`;

CREATE TABLE `termination_reasons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `termination_reasons` WRITE;
/*!40000 ALTER TABLE `termination_reasons` DISABLE KEYS */;

INSERT INTO `termination_reasons` (`id`, `name`)
VALUES
	(1,'Contract Not Renewed'),
	(2,'Deceased'),
	(3,'Dismissed'),
	(4,'Laid-off'),
	(5,'Other'),
	(6,'Physically Disabled/Compensated'),
	(7,'Resigned'),
	(8,'Resigned - Company Requested'),
	(9,'Resigned - Self Proposed'),
	(10,'Retired');

/*!40000 ALTER TABLE `termination_reasons` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table throttle
# ------------------------------------------------------------

DROP TABLE IF EXISTS `throttle`;

CREATE TABLE `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `suspended` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `suspended_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `throttle` WRITE;
/*!40000 ALTER TABLE `throttle` DISABLE KEYS */;

INSERT INTO `throttle` (`id`, `user_id`, `ip_address`, `attempts`, `suspended`, `banned`, `last_attempt_at`, `suspended_at`, `banned_at`)
VALUES
	(1,1,NULL,0,0,0,NULL,NULL,NULL);

/*!40000 ALTER TABLE `throttle` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `persist_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_activation_code_index` (`activation_code`),
  KEY `users_reset_password_code_index` (`reset_password_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `password`, `permissions`, `activated`, `activation_code`, `activated_at`, `last_login`, `persist_code`, `reset_password_code`, `first_name`, `last_name`, `created_at`, `updated_at`)
VALUES
	(1,'bertrand@verticalops.com','$2y$10$Vh3K2Xax44ujFamFGHleeOFKVxUlChIxj3zVIxxPhVCaV.jjiUtAO',NULL,1,NULL,NULL,'2014-11-25 13:40:46','$2y$10$qFNgXLT7UpVYSRdkhUFEy..FagTPq8VUalHQ9nWTifxqFkGaYMBnK',NULL,NULL,NULL,'2014-10-21 22:56:12','2014-11-25 13:40:46'),
	(2,'gabriel@verticalops.com','$2y$10$iAXXiB9efnCFWhbObMGDAO.abGeqYSY3BVvXmg1qWdKzumNd2BSFO',NULL,1,NULL,NULL,'2014-10-31 02:05:22','$2y$10$86DzwaIpkTvaMC5aWSVS8eZiTkv0XqRB6LAOZNm9NY9MSZLbaky7i',NULL,NULL,NULL,'2014-10-21 22:56:12','2014-10-31 02:05:22');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_groups`;

CREATE TABLE `users_groups` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;

INSERT INTO `users_groups` (`user_id`, `group_id`)
VALUES
	(1,1),
	(2,2);

/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table work_experiences
# ------------------------------------------------------------

DROP TABLE IF EXISTS `work_experiences`;

CREATE TABLE `work_experiences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `job_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
