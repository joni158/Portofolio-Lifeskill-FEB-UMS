/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50617
Source Host           : 127.0.0.1:3306
Source Database       : skpi

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-12-22 08:49:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for options
-- ----------------------------
DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(50) NOT NULL,
  `option_value` longtext NOT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of options
-- ----------------------------
INSERT INTO `options` VALUES ('1', 'sitename', 'Life Skill');
INSERT INTO `options` VALUES ('2', 'sitedescription', '');
INSERT INTO `options` VALUES ('3', 'phone', '');
INSERT INTO `options` VALUES ('4', 'mobile', '');
INSERT INTO `options` VALUES ('5', 'bbm', '');
INSERT INTO `options` VALUES ('6', 'whatsapp', '');
INSERT INTO `options` VALUES ('7', 'email', '');
INSERT INTO `options` VALUES ('8', 'lat', '');
INSERT INTO `options` VALUES ('9', 'lng', '');
INSERT INTO `options` VALUES ('10', 'about', '');
INSERT INTO `options` VALUES ('11', 'address', '');
INSERT INTO `options` VALUES ('12', 'npwp', '');
INSERT INTO `options` VALUES ('13', 'siup', '');
INSERT INTO `options` VALUES ('14', 'tdp', '');
INSERT INTO `options` VALUES ('15', 'notaris', '');
INSERT INTO `options` VALUES ('16', 'BCA', '');
INSERT INTO `options` VALUES ('17', 'BNI', '');
INSERT INTO `options` VALUES ('18', 'BRI', '');
INSERT INTO `options` VALUES ('19', 'logo', '');

-- ----------------------------
-- Table structure for s_table0
-- ----------------------------
DROP TABLE IF EXISTS `s_table0`;
CREATE TABLE `s_table0` (
  `uid` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of s_table0
-- ----------------------------
INSERT INTO `s_table0` VALUES ('1', 'admin', '0822fc4535f875bfcb80ffd3e6a9d778', 'superadmin', '1');
INSERT INTO `s_table0` VALUES ('31', 'F200134006', '37507dc73c25fe2c71437a17682c6218', 'mahasiswa', '25');
INSERT INTO `s_table0` VALUES ('32', 'F200134007', 'bd57434b3aab98e5a88898ff7f0ca17f', 'mahasiswa', '26');
INSERT INTO `s_table0` VALUES ('33', 'F200134008', '50bafb28e441713e8b5ff177506451a8', 'mahasiswa', '27');
INSERT INTO `s_table0` VALUES ('34', 'E1001', '7e4cc451e5d07bd0f0c8b4b76a9fa8f6', 'kaprodi', '22');
INSERT INTO `s_table0` VALUES ('35', 'E1002', '418da9adbb49d62eb85fb4fbf38d77ad', 'kaprodi', '23');
INSERT INTO `s_table0` VALUES ('36', 'E1003', 'b4bf6cd9732ebcb98c1e6650f88d332f', 'kaprodi', '24');
INSERT INTO `s_table0` VALUES ('37', 'D2001', 'f2a14e11cea688de452c4bde8fd69226', 'pembimbing', '25');
INSERT INTO `s_table0` VALUES ('38', 'D2002', 'f118b308503a58bfa7b12a80b7d20bd2', 'pembimbing', '26');
INSERT INTO `s_table0` VALUES ('39', 'D2003', '03027e337c7fde48c7fe69d3d55ddbc6', 'pembimbing', '27');

-- ----------------------------
-- Table structure for s_table1
-- ----------------------------
DROP TABLE IF EXISTS `s_table1`;
CREATE TABLE `s_table1` (
  `id_fakultas` varchar(10) NOT NULL,
  `nama_fakultas` varchar(100) NOT NULL,
  PRIMARY KEY (`id_fakultas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of s_table1
-- ----------------------------
INSERT INTO `s_table1` VALUES ('FEB', 'Fakultas Ekonomi dan Bisnis');

-- ----------------------------
-- Table structure for s_table2
-- ----------------------------
DROP TABLE IF EXISTS `s_table2`;
CREATE TABLE `s_table2` (
  `uid_jurusan` varchar(10) NOT NULL,
  `nama_jurusan` varchar(100) NOT NULL,
  `uid_fakultas` varchar(10) NOT NULL,
  PRIMARY KEY (`uid_jurusan`),
  KEY `uid_fakultas` (`uid_fakultas`),
  CONSTRAINT `s_table2_ibfk_1` FOREIGN KEY (`uid_fakultas`) REFERENCES `s_table1` (`id_fakultas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of s_table2
-- ----------------------------
INSERT INTO `s_table2` VALUES ('D100', 'Manajemen', 'FEB');
INSERT INTO `s_table2` VALUES ('D200', 'Akuntansi', 'FEB');
INSERT INTO `s_table2` VALUES ('D300', 'Ilmu Ekonomi dan Studi Pembangunan', 'FEB');

-- ----------------------------
-- Table structure for s_table3
-- ----------------------------
DROP TABLE IF EXISTS `s_table3`;
CREATE TABLE `s_table3` (
  `uid_dosen` bigint(20) NOT NULL AUTO_INCREMENT,
  `nidn` varchar(20) NOT NULL,
  `nama_dosen` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `id_jurusan` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`uid_dosen`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of s_table3
-- ----------------------------
INSERT INTO `s_table3` VALUES ('23', 'E1002', 'Muhammad Fahmi', 'muh.fahmi@gmail.com', '08223193233', 'E1002', '418da9adbb49d62eb85fb4fbf38d77ad', 'kaprodi', 'D100');
INSERT INTO `s_table3` VALUES ('24', 'E1003', 'Muhlisin', 'muhlisin@gmail.com', '08123921393', 'E1003', 'b4bf6cd9732ebcb98c1e6650f88d332f', 'kaprodi', 'D300');
INSERT INTO `s_table3` VALUES ('25', 'D2001', 'Syilvia Jannah', 'syilvia@gmail.com', '08122412392', 'D2001', 'f2a14e11cea688de452c4bde8fd69226', 'pembimbing', 'D200');
INSERT INTO `s_table3` VALUES ('26', 'D2002', 'Dinar Amalia', 'dinar@gmail.com', '08123219392', 'D2002', 'f118b308503a58bfa7b12a80b7d20bd2', 'pembimbing', 'D100');
INSERT INTO `s_table3` VALUES ('22', 'E1001', 'Suparman', 'suparman@gmail.com', '08291283937', 'E1001', '7e4cc451e5d07bd0f0c8b4b76a9fa8f6', 'kaprodi', 'D200');
INSERT INTO `s_table3` VALUES ('27', 'D2003', 'Fahrurozi', 'fahru@gmail.com', '08971293293', 'D2003', '03027e337c7fde48c7fe69d3d55ddbc6', 'pembimbing', 'D300');

-- ----------------------------
-- Table structure for s_table4
-- ----------------------------
DROP TABLE IF EXISTS `s_table4`;
CREATE TABLE `s_table4` (
  `uid_mhs` bigint(20) NOT NULL AUTO_INCREMENT,
  `nim` varchar(20) NOT NULL,
  `nama_mhs` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `angkatan` varchar(20) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `aktif` varchar(50) DEFAULT 'Aktif',
  `id_jurusan` varchar(10) DEFAULT NULL,
  `img` varchar(255) DEFAULT '',
  `alamat` text,
  PRIMARY KEY (`uid_mhs`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of s_table4
-- ----------------------------
INSERT INTO `s_table4` VALUES ('25', 'F200134006', 'Joni', 'joni@gmail.com', '0857993212', 'Sragen', '1994-03-01', '2014', 'F200134006', '37507dc73c25fe2c71437a17682c6218', 'mahasiswa', 'Aktif', 'D100', '', 'Jl. Raya No.21');
INSERT INTO `s_table4` VALUES ('26', 'F200134007', 'Rudi', 'rudi@gmail.com', '0892383948', 'Solo', '1993-04-13', '2013', 'F200134007', 'bd57434b3aab98e5a88898ff7f0ca17f', 'mahasiswa', 'Aktif', 'D200', '', 'Jl. Bunga No.11');
INSERT INTO `s_table4` VALUES ('27', 'F200134008', 'Bayu', 'bayu@gmail.com', '08921370832', 'Sukoharjo', '1995-09-21', '2015', 'F200134008', '50bafb28e441713e8b5ff177506451a8', 'mahasiswa', 'Aktif', 'D300', '', 'Jl. Mawar No.32');

-- ----------------------------
-- Table structure for s_table5
-- ----------------------------
DROP TABLE IF EXISTS `s_table5`;
CREATE TABLE `s_table5` (
  `uid_kelas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`uid_kelas`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of s_table5
-- ----------------------------
INSERT INTO `s_table5` VALUES ('1', 'A');
INSERT INTO `s_table5` VALUES ('2', 'B');
INSERT INTO `s_table5` VALUES ('4', 'C');
INSERT INTO `s_table5` VALUES ('6', 'D');

-- ----------------------------
-- Table structure for s_table6
-- ----------------------------
DROP TABLE IF EXISTS `s_table6`;
CREATE TABLE `s_table6` (
  `uid_rubrik` int(11) NOT NULL AUTO_INCREMENT,
  `kegiatan` varchar(255) NOT NULL,
  `poin` int(3) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT '',
  `bukti` varchar(100) DEFAULT '',
  `softskill` varchar(100) DEFAULT '',
  `parent` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `child` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid_rubrik`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of s_table6
-- ----------------------------
INSERT INTO `s_table6` VALUES ('1', 'Peserta PPA, Masta atau PKPMB  (Wajib Universitas)', '20', 'Kegiatan', 'Sertifikat', 'Intrapersonal Skills', '0', '1', '0');
INSERT INTO `s_table6` VALUES ('2', 'Baitul Arqom (Wajib Universitas)', '20', 'Kegiatan', 'Sertifikat', 'Intrapersonal Skills', '0', '1', '0');
INSERT INTO `s_table6` VALUES ('3', 'Mentoring Studi Islam ', '0', '', '', '', '0', '1', '1');
INSERT INTO `s_table6` VALUES ('4', 'Mentor', '40', 'Semester', 'SK/Sertifikat', 'Communication skills', '3', '2', '0');
INSERT INTO `s_table6` VALUES ('5', 'Peserta', '20', 'Semester', 'SK/Sertifikat', 'Intrapersonal skills', '3', '2', '0');
INSERT INTO `s_table6` VALUES ('6', 'Mentoring Bahasa Inggris ', '0', '', '', '', '0', '1', '1');
INSERT INTO `s_table6` VALUES ('7', 'Tutor', '40', 'Semester', 'SK/Sertifikat', 'Communication skills', '6', '2', '0');
INSERT INTO `s_table6` VALUES ('8', 'Peserta', '20', 'Semester', 'SK/Sertifikat', 'Communication skills', '6', '2', '0');
INSERT INTO `s_table6` VALUES ('9', 'Sekolah kewirausahaan', '30', 'Kegiatan', 'Sertifikat', 'Entrepreneurship skills', '0', '1', '0');
INSERT INTO `s_table6` VALUES ('10', 'Sekolah kebangsaan', '30', 'Kegiatan', 'Sertifikat', 'Leadership skills', '0', '1', '0');
INSERT INTO `s_table6` VALUES ('11', 'Business coaching', '30', 'Kegiatan', 'Sertifikat', 'Entrepreneurship skills', '0', '1', '0');
INSERT INTO `s_table6` VALUES ('12', 'Pelatihan kepemimpinan', '20', 'Kegiatan', 'Sertifikat', 'Leadership skills', '0', '1', '0');
INSERT INTO `s_table6` VALUES ('13', 'Pelatihan problem solving', '20', 'Kegiatan', 'Sertifikat', 'Logical skills', '0', '1', '0');
INSERT INTO `s_table6` VALUES ('14', 'Pelatihan komunikasi', '20', 'Kegiatan', 'Sertifikat', 'Communication skills', '0', '1', '0');
INSERT INTO `s_table6` VALUES ('15', 'Pelatihan kerjasama', '20', 'Kegiatan', 'Sertifikat', 'Team work skills', '0', '1', '0');
INSERT INTO `s_table6` VALUES ('16', 'Penguasaan Bahasa Inggris aktif dan pasif (Wajib Universitas)', '20', 'Kegiatan', 'Sertifikat', 'Public speaking skills', '0', '1', '0');
INSERT INTO `s_table6` VALUES ('17', 'Kepanitiaan sebuah kegiatan ', '0', '', '', '', '0', '1', '1');
INSERT INTO `s_table6` VALUES ('18', 'Tingkat Nasional', '0', '', '', '', '17', '2', '1');
INSERT INTO `s_table6` VALUES ('19', 'Ketua', '30', 'Kegiatan', 'Surat keputusan, Surat Tugas', 'Leadership and commitments skills', '18', '3', '0');
INSERT INTO `s_table6` VALUES ('20', 'Wakil Ketua, Sekretaris, Bendahara', '20', 'Kegiatan', 'Surat keputusan, Surat Tugas', 'Leadership and commitments skills', '18', '3', '0');
INSERT INTO `s_table6` VALUES ('21', 'Anggota Panitia', '10', 'Kegiatan', 'Surat keputusan, Surat Tugas', 'Leadership and commitments skills', '18', '3', '0');
INSERT INTO `s_table6` VALUES ('22', 'Tingkat Unive/Fak/Progdi/Ormawa', '0', '', '', '', '17', '2', '1');
INSERT INTO `s_table6` VALUES ('23', 'Ketua', '25', 'Kegiatan', 'Surat keputusan, Surat Tugas', 'Leadership and commitments skills', '22', '3', '0');
INSERT INTO `s_table6` VALUES ('24', 'Wakil Ketua, Sekretaris, Bendahara', '15', 'Kegiatan', 'Surat keputusan, Surat Tugas', 'Leadership and commitments skills', '22', '3', '0');
INSERT INTO `s_table6` VALUES ('25', 'Anggota Panitia', '5', 'Kegiatan', '\r\n\r\n\r\nSurat keputusan, Surat Tugas\r\n', 'Leadership and commitments skills', '22', '3', '0');
INSERT INTO `s_table6` VALUES ('26', 'Organisasi kemahasiswaan ', '0', '', '', '', '0', '1', '1');
INSERT INTO `s_table6` VALUES ('27', 'Pengurus Harian  Universitas', '0', '', '', '', '26', '2', '1');
INSERT INTO `s_table6` VALUES ('28', 'Ketua ', '40', '  Periode', 'Surat keputusan-Surat Tugas', 'Leadership and commitments skills\r\nTeam work and social skills\r\n', '27', '3', '0');
INSERT INTO `s_table6` VALUES ('29', 'Wakil Ketua, Sekretaris, Bendahara', '30', 'Periode', 'Surat keputusan-Surat Tugas', 'Leadership and commitments skills\r\nTeam work and social skills\r\n', '27', '3', '0');
INSERT INTO `s_table6` VALUES ('30', 'Koordinator/Ketua seksi', '20', 'Periode', 'Surat keputusan-Surat Tugas', 'Leadership and commitments skills\r\nTeam work and social skills\r\n', '27', '3', '0');
INSERT INTO `s_table6` VALUES ('31', 'Anggota', '10', 'Periode', 'Surat keputusan-Surat Tugas\r\n\r\n', 'Leadership and commitments skills\r\nTeam work and social skills\r\n', '27', '3', '0');
INSERT INTO `s_table6` VALUES ('32', 'Pengurus Harian  Fakultas', '0', '', '', '', '26', '2', '1');
INSERT INTO `s_table6` VALUES ('33', 'Ketua', '35', 'Periode', 'Surat keputusan-Surat Tugas', 'Leadership and commitments skills\r\nTeam work and social skills\r\n', '32', '3', '0');
INSERT INTO `s_table6` VALUES ('34', 'Wakil Ketua, Sekretaris, Bendahara', '25', 'Periode', 'Surat keputusan-Surat Tugas\r\n\r\n', 'Leadership and commitments skills\r\nTeam work and social skills\r\n', '32', '3', '0');
INSERT INTO `s_table6` VALUES ('35', 'Koordinator/Ketua seksi', '15', 'Periode', 'Surat keputusan-Surat Tugas', 'Leadership and commitments skills\r\nTeam work and social skills\r\n', '32', '3', '0');
INSERT INTO `s_table6` VALUES ('36', 'Anggota', '5', 'Periode', 'Surat keputusan-Surat Tugas', 'Leadership and commitments skills\r\nTeam work and social skills\r\n', '32', '3', '0');
INSERT INTO `s_table6` VALUES ('37', 'Pengurus Harian  Prodi', '0', '', '', '', '26', '2', '1');
INSERT INTO `s_table6` VALUES ('38', 'Ketua', '25', 'Periode', 'Surat keputusan-Surat Tugas', 'Leadership and commitments skills\r\nTeam work and social skills\r\n', '37', '3', '0');
INSERT INTO `s_table6` VALUES ('39', 'Wakil Ketua, Sekretaris, Bendahara', '15', 'Periode', 'Surat keputusan-Surat Tugas', 'Leadership and commitments skills\r\nTeam work and social skills\r\n', '37', '3', '0');
INSERT INTO `s_table6` VALUES ('40', 'Koordinator/Ketua seksi', '10', 'Periode', 'Surat keputusan-Surat Tugas', 'Leadership and commitments skills\r\nTeam work and social skills\r\n', '37', '3', '0');
INSERT INTO `s_table6` VALUES ('41', 'Anggota', '5', 'Periode', 'Surat keputusan-Surat Tugas\r\n\r\n', 'Leadership and commitments skills\r\nTeam work and social skills\r\n', '37', '3', '0');
INSERT INTO `s_table6` VALUES ('42', 'Peserta seminar, kuliah umum, workshop, lokakarya dan\r\nsejenisnya\r\n', '0', '', '', '', '0', '1', '1');
INSERT INTO `s_table6` VALUES ('43', 'Internasional', '30', 'Kegiatan', 'Sertifikat, surat tugas', 'Accelerated learning and motivation skills', '42', '2', '0');
INSERT INTO `s_table6` VALUES ('44', 'Nasional', '20', 'Kegiatan', 'Sertifikat, surat tugas', 'Accelerated learning and motivation skills', '42', '2', '0');
INSERT INTO `s_table6` VALUES ('45', 'Regional', '10', 'Kegiatan', 'Sertifikat, surat tugas', 'Accelerated learning and motivation skills', '42', '2', '0');
INSERT INTO `s_table6` VALUES ('46', 'Peserta pelatihan, upgrading program, dan sejenisnya', '20', 'Kegiatan', 'Sertifikat', 'Accelerated learning and motivation skills', '0', '1', '0');
INSERT INTO `s_table6` VALUES ('47', 'Mengikuti lomba bidang penalaran : Karya Ilmiah, PKM, Mawapres, PIMNAS, Pertukaran Mahasiswa dan sejenisnya', '0', '', '', '', '0', '1', '1');
INSERT INTO `s_table6` VALUES ('48', 'Internasional', '70', 'Karya', 'Sertifikat', 'Logical and creativity skills', '47', '2', '0');
INSERT INTO `s_table6` VALUES ('49', 'Nasional', '50', 'Karya', 'Sertifikat', 'Logical and creativity skills', '47', '2', '0');
INSERT INTO `s_table6` VALUES ('50', 'Regional', '30', 'Karya', 'Sertifikat', 'Logical and creativity skills', '47', '2', '0');
INSERT INTO `s_table6` VALUES ('51', 'Mengikuti lomba bidang minat bakat : Pecinta Alam, olah raga ,seni budaya dan sejenisnya', '0', '', '', '', '0', '1', '1');
INSERT INTO `s_table6` VALUES ('52', 'Internasional', '45', 'Karya', 'Sertifikat', 'Adversity skill', '51', '2', '0');
INSERT INTO `s_table6` VALUES ('53', 'Nasional', '25', 'Karya', 'Sertifikat', 'Adversity skill', '51', '2', '0');
INSERT INTO `s_table6` VALUES ('54', 'Regional', '15', 'Karya', 'Sertifikat', 'Adversity skill', '51', '2', '0');
INSERT INTO `s_table6` VALUES ('55', 'Membuat karya penelitian yang dipublikasikan di Jurnal ilmiah ', '0', '', '', '', '0', '1', '1');
INSERT INTO `s_table6` VALUES ('56', 'Jurnal internasional ', '75', 'Artikel', 'Copy artikel yang dimuat', 'Logical and creativity skills', '55', '2', '0');
INSERT INTO `s_table6` VALUES ('57', 'Jurnal terakreditasi', '60', 'Artikel', 'Copy artikel yang dimuat', 'Logical and creativity skills ', '55', '2', '0');
INSERT INTO `s_table6` VALUES ('58', 'Jurnal ber-ISSN', '50', 'Artikel', 'Copy artikel yang dimuat', 'Logical and creativity skills ', '55', '2', '0');
INSERT INTO `s_table6` VALUES ('59', 'Pemakalah seminar', '0', '', '', '', '0', '1', '1');
INSERT INTO `s_table6` VALUES ('60', 'Internasional', '60', 'Makalah atau artikel', 'Sertifikat dan artikel, prosiding', 'Logical and presentation skills', '59', '2', '0');
INSERT INTO `s_table6` VALUES ('61', 'Nasional', '50', 'Makalah atau artikel', 'Sertifikat dan artikel, prosiding', '\r\nLogical and presentation skills\r\n', '59', '2', '0');
INSERT INTO `s_table6` VALUES ('62', 'Regional', '40', 'Makalah atau artikel', 'Sertifikat dan artikel, prosiding', 'Logical and presentation skills', '59', '2', '0');
INSERT INTO `s_table6` VALUES ('63', 'Peningkatan Profesionalisme', '0', '', '', '', '0', '1', '1');
INSERT INTO `s_table6` VALUES ('64', 'Menjadi asisten kuliah/praktikum', '40', 'Semester', '\r\nSertifikat, Surat Tugas\r\n', 'Logical and self-marketing skills', '63', '2', '0');
INSERT INTO `s_table6` VALUES ('65', 'Pemateri pelatihan', '30', 'Kegiatan', 'Sertifikat, Surat Tugas', 'Logical and self-marketing skills', '63', '2', '0');
INSERT INTO `s_table6` VALUES ('66', 'Co-Fasilitator ', '20', 'Kegiatan', 'Sertifikat, Surat Tugas', 'Logical and self-marketing skills', '63', '2', '0');
INSERT INTO `s_table6` VALUES ('67', 'Job training dan magang ', '0', '', '', '', '0', '1', '1');
INSERT INTO `s_table6` VALUES ('68', 'Kurang 6 hari', '20', 'Kegiatan', 'Surat keterangan', 'Relationship building and\r\nSelft marketing skill\r\n', '67', '2', '0');
INSERT INTO `s_table6` VALUES ('69', '7 – 12 hari', '30', 'Kegiatan', 'Surat keterangan', 'Relationship building and\r\nSelft marketing skill\r\n', '67', '2', '0');
INSERT INTO `s_table6` VALUES ('70', '13 – 18 hari', '40', 'Kegiatan', 'Surat keterangan', 'Relationship building and\r\nSelft marketing skill\r\n', '67', '2', '0');
INSERT INTO `s_table6` VALUES ('71', '19 – 24 hari', '50', 'Kegiatan', 'Surat keterangan', 'Relationship building and\r\nSelft marketing skill\r\n', '67', '2', '0');
INSERT INTO `s_table6` VALUES ('72', 'Lebih 24 hari', '60', 'Kegiatan', 'Surat keterangan', 'Relationship building and\r\nSelft marketing skill\r\n', '67', '2', '0');
INSERT INTO `s_table6` VALUES ('73', 'Kejuaraan dalam lomba ', '0', '', '', '', '0', '1', '1');
INSERT INTO `s_table6` VALUES ('74', 'Pemenang lomba tingkat internasional', '75', 'Kegiatan', 'Sertifikat', 'Adversity skills', '73', '2', '0');
INSERT INTO `s_table6` VALUES ('75', 'Pemenang lomba tingkat nasional', '60', 'Kegiatan', 'Sertifikat', 'Adversity skills', '73', '2', '0');
INSERT INTO `s_table6` VALUES ('76', 'Pemenang lomba tingkat regional', '50', 'Kegiatan', 'Sertifikat', 'Adversity skills', '73', '2', '0');
INSERT INTO `s_table6` VALUES ('77', 'Pengurus di luar kampus (missal:  Karang Taruna, LSM, Ormas, dll)', '0', '', '', '', '0', '1', '1');
INSERT INTO `s_table6` VALUES ('78', 'Ketua', '20', 'Periode', 'Surat keputusan', 'Relationship building and social skills', '77', '2', '0');
INSERT INTO `s_table6` VALUES ('79', 'Non Ketua', '10', 'Periode', 'Surat keputusan', 'Relationship building and social skills', '77', '2', '0');
INSERT INTO `s_table6` VALUES ('80', 'Menjadi wakil  mengikuti\r\nkegiatan di luar kampus (Jur, Fak,\r\nUniv), misalnya: relawan, karya\r\nsosial, dll\r\n', '20', 'Kegiatan', 'Surat tugas', 'Relationship building and social skills', '0', '1', '0');
INSERT INTO `s_table6` VALUES ('81', 'Membuat karya yang dipublikasikan\r\ndi media masa eksternal\r\n', '0', '', '', '', '0', '1', '1');
INSERT INTO `s_table6` VALUES ('82', 'Nasional', '40', 'Karya', 'Copy publikasi', 'Logical and creativity skills ', '81', '2', '0');
INSERT INTO `s_table6` VALUES ('83', 'Regional', '30', 'Karya', 'Copy publikasi', 'Logical and creativity skills ', '81', '2', '0');
INSERT INTO `s_table6` VALUES ('84', 'Lokal', '20', 'Karya', 'Copy publikasi', 'Logical and creativity skills ', '81', '2', '0');

-- ----------------------------
-- Table structure for s_table7
-- ----------------------------
DROP TABLE IF EXISTS `s_table7`;
CREATE TABLE `s_table7` (
  `uid_kelasajar` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_kelas` int(11) NOT NULL,
  `id_dosen` bigint(20) NOT NULL,
  `id_mhs` bigint(20) NOT NULL,
  `semester` varchar(50) DEFAULT NULL,
  `id_jurusan` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`uid_kelasajar`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of s_table7
-- ----------------------------
INSERT INTO `s_table7` VALUES ('18', '1', '25', '26', '20161', 'D200');

-- ----------------------------
-- Table structure for s_table8
-- ----------------------------
DROP TABLE IF EXISTS `s_table8`;
CREATE TABLE `s_table8` (
  `uid_nilai` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_kelasajar` bigint(20) DEFAULT NULL,
  `id_rubrik` int(11) DEFAULT NULL,
  `keterangan` text,
  `status` int(2) DEFAULT '0',
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`uid_nilai`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of s_table8
-- ----------------------------
INSERT INTO `s_table8` VALUES ('16', '18', '1', 'Masta 2015', '0', '2016-11-22');
DROP TRIGGER IF EXISTS `insert_to_user`;
DELIMITER ;;
CREATE TRIGGER `insert_to_user` AFTER INSERT ON `s_table3` FOR EACH ROW insert into s_table0 (username, password, level, id_user)
values (new.username, new.password, new.level, new.uid_dosen)
;
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `update_to_user`;
DELIMITER ;;
CREATE TRIGGER `update_to_user` AFTER UPDATE ON `s_table3` FOR EACH ROW update s_table0  set username = new.username, password = new.password where id_user = old.uid_dosen and level = old.level
;
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `delete_to_user`;
DELIMITER ;;
CREATE TRIGGER `delete_to_user` AFTER DELETE ON `s_table3` FOR EACH ROW delete from s_table0 where id_user = old.uid_dosen and level = old.level
;
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `insert_to_user2`;
DELIMITER ;;
CREATE TRIGGER `insert_to_user2` AFTER INSERT ON `s_table4` FOR EACH ROW insert into s_table0 (username, password, level, id_user)
values (new.username, new.password, new.level, new.uid_mhs)
;
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `update_to_user2`;
DELIMITER ;;
CREATE TRIGGER `update_to_user2` AFTER UPDATE ON `s_table4` FOR EACH ROW update s_table0  set username = new.username, password = new.password where id_user = old.uid_mhs and level = old.level
;
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `delete_to_user2`;
DELIMITER ;;
CREATE TRIGGER `delete_to_user2` AFTER DELETE ON `s_table4` FOR EACH ROW delete from s_table0 where id_user = old.uid_mhs and level = old.level
;;
DELIMITER ;
