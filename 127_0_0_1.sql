-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2015 at 08:24 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `futurismdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(20) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(20) NOT NULL,
  `admin_sec_question` varchar(50) NOT NULL,
  `admin_sec_answer` varchar(50) NOT NULL,
  `admin_pwd` varchar(20) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_sec_question`, `admin_sec_answer`, `admin_pwd`) VALUES
(1, 'bhumika', 'what', 'what', 'bhumika');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(10) NOT NULL AUTO_INCREMENT,
  `main_cat_id` int(10) NOT NULL,
  `category_name` varchar(20) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `main_cat_id`, `category_name`) VALUES
(1, 1, 'Verbal'),
(2, 1, 'Maths and Quants abi'),
(3, 3, 'QI & DI'),
(4, 3, 'Logical Reasoning');

-- --------------------------------------------------------

--
-- Table structure for table `chatbox`
--

CREATE TABLE IF NOT EXISTS `chatbox` (
  `chatid` int(20) NOT NULL AUTO_INCREMENT,
  `message_content` varchar(500) NOT NULL,
  `from` varchar(20) NOT NULL,
  `to` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `session` int(30) NOT NULL,
  PRIMARY KEY (`chatid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `corect_ans`
--

CREATE TABLE IF NOT EXISTS `corect_ans` (
  `corect_ans_id` int(10) NOT NULL,
  `question_id` int(10) NOT NULL,
  `answer_id` int(10) NOT NULL,
  PRIMARY KEY (`corect_ans_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fis_category`
--

CREATE TABLE IF NOT EXISTS `fis_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `hint_solution`
--

CREATE TABLE IF NOT EXISTS `hint_solution` (
  `hint_solution_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `hint_desc` int(11) NOT NULL,
  `solution_desc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `main_category`
--

CREATE TABLE IF NOT EXISTS `main_category` (
  `main_cat_id` int(10) NOT NULL AUTO_INCREMENT,
  `main_cat_name` varchar(10) NOT NULL,
  PRIMARY KEY (`main_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `main_category`
--

INSERT INTO `main_category` (`main_cat_id`, `main_cat_name`) VALUES
(1, 'CAT'),
(2, 'GRE'),
(3, 'CMAT');

-- --------------------------------------------------------

--
-- Table structure for table `material_category`
--

CREATE TABLE IF NOT EXISTS `material_category` (
  `material_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE IF NOT EXISTS `note` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `note_content` varchar(2000) NOT NULL,
  PRIMARY KEY (`note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `question_id` int(10) NOT NULL,
  `question` varchar(1000) NOT NULL,
  `que_paper_id` int(10) NOT NULL,
  `priority` int(2) NOT NULL,
  `weightage` int(2) NOT NULL,
  `deduction` int(2) NOT NULL,
  `marked` tinyint(1) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question_answer`
--

CREATE TABLE IF NOT EXISTS `question_answer` (
  `question_id` int(10) NOT NULL,
  `answer_id` int(10) NOT NULL,
  `answer` varchar(50) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `question-answer_id` int(10) NOT NULL,
  PRIMARY KEY (`question-answer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question_paper`
--

CREATE TABLE IF NOT EXISTS `question_paper` (
  `que_paper_id` int(10) NOT NULL AUTO_INCREMENT,
  `que_paper_name` varchar(20) NOT NULL,
  `category_id` int(10) NOT NULL,
  `max_time` datetime NOT NULL,
  PRIMARY KEY (`que_paper_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `question_paper`
--

INSERT INTO `question_paper` (`que_paper_id`, `que_paper_name`, `category_id`, `max_time`) VALUES
(1, 'Cat 2011', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `reminder`
--

CREATE TABLE IF NOT EXISTS `reminder` (
  `reminde_id` int(10) NOT NULL AUTO_INCREMENT,
  `reminder_title` varchar(20) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`reminde_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE IF NOT EXISTS `sub_category` (
  `sub_cat_id` int(10) NOT NULL AUTO_INCREMENT,
  `sub_cat_name` varchar(30) NOT NULL,
  `category_id` int(10) NOT NULL,
  PRIMARY KEY (`sub_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`sub_cat_id`, `sub_cat_name`, `category_id`) VALUES
(1, 'Comprehension', 1),
(2, 'Verbal Reasoning', 1),
(3, 'Number System', 2),
(4, 'Geometry', 2);

-- --------------------------------------------------------

--
-- Table structure for table `sudoku`
--

CREATE TABLE IF NOT EXISTS `sudoku` (
  `sudoku_id` int(10) NOT NULL AUTO_INCREMENT,
  `sudoku_category` varchar(20) NOT NULL,
  `sudoku_question` varchar(200) NOT NULL,
  `sudoku_answer` varchar(200) NOT NULL,
  PRIMARY KEY (`sudoku_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sudoku_user`
--

CREATE TABLE IF NOT EXISTS `sudoku_user` (
  `user_id` int(10) NOT NULL,
  `sudoku_id` int(10) NOT NULL,
  `user_answer_sudoku` varchar(200) NOT NULL,
  `correct` tinyint(1) NOT NULL,
  `sudoku_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(25) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_pwd` varchar(20) NOT NULL,
  `user_join_date` datetime NOT NULL,
  `user_last_login_date` datetime NOT NULL,
  `user_sec_que` varchar(50) NOT NULL,
  `user_sec_ans` varchar(35) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_email`, `user_name`, `user_pwd`, `user_join_date`, `user_last_login_date`, `user_sec_que`, `user_sec_ans`) VALUES
(1, 'abc@exm.com', 'bhumi', 'bhumi', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_category`
--

CREATE TABLE IF NOT EXISTS `user_category` (
  `user_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_test`
--

CREATE TABLE IF NOT EXISTS `user_test` (
  `user-test_id` int(10) NOT NULL,
  `que_paper_id` int(10) NOT NULL,
  `question_id` int(10) NOT NULL,
  `user_answer_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `datetime` datetime NOT NULL,
  `duration` int(10) NOT NULL,
  `attempted` tinyint(1) NOT NULL,
  `corect` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `word_up`
--

CREATE TABLE IF NOT EXISTS `word_up` (
  `word_up_id` int(10) NOT NULL AUTO_INCREMENT,
  `word_up_string` varchar(20) NOT NULL,
  `word_up_synonym` varchar(20) NOT NULL,
  `word_up_answer` varchar(20) NOT NULL,
  PRIMARY KEY (`word_up_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `word_up_user`
--

CREATE TABLE IF NOT EXISTS `word_up_user` (
  `user_id` int(10) NOT NULL,
  `word_up_id` int(10) NOT NULL,
  `user_answer_word_up` varchar(20) NOT NULL,
  `correct` tinyint(1) NOT NULL,
  `word_up_user_id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`word_up_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Database: `futurismdb_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `fis_admins`
--

CREATE TABLE IF NOT EXISTS `fis_admins` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(80) NOT NULL,
  `password` varchar(50) NOT NULL,
  `admin_type` char(1) NOT NULL DEFAULT 'A',
  `del_in` int(1) NOT NULL DEFAULT '0',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `fis_admins`
--

INSERT INTO `fis_admins` (`admin_id`, `username`, `password`, `admin_type`, `del_in`, `created_on`) VALUES
(1, 'admin', 'ac34784d360aeb6822f3e17ef2ce8ef5', 'A', 0, '2012-12-06 12:53:40');

-- --------------------------------------------------------

--
-- Table structure for table `fis_album`
--

CREATE TABLE IF NOT EXISTS `fis_album` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_name` varchar(255) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `album_poster` varchar(255) NOT NULL COMMENT 'select from image',
  `is_private` int(11) NOT NULL DEFAULT '0' COMMENT '1 for private and 0 for public',
  `sort_order` int(11) NOT NULL,
  `del_in` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`album_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `fis_album`
--

INSERT INTO `fis_album` (`album_id`, `album_name`, `width`, `height`, `album_poster`, `is_private`, `sort_order`, `del_in`) VALUES
(1, 'dzire', 439, 585, 'uploads/album/img1_1366139639.jpg', 0, 3, 1),
(2, 'akruti', 437, 585, 'uploads/album/img2_1366139657.jpg', 1, 4, 1),
(3, 'barbie', 500, 333, 'uploads/album/img3_1366139665.jpg', 1, 5, 1),
(4, 'atlantis', 432, 648, 'uploads/album/cover1_1368365770.jpg', 1, 2, 1),
(5, 'nancy', 464, 600, 'uploads/album/cover1_1368367701.jpg', 1, 1, 1),
(6, 'Dream Girl', 750, 750, 'uploads/album/dream_girl_1375365529.jpg', 1, 6, 1),
(7, 'LAVASA', 1000, 800, 'uploads/album/cover__1377846448.jpg', 1, 9, 0),
(8, 'aa', 22, 22, 'uploads/album/chat_13821154831.png', 0, 8, 0),
(9, 'aa', 22, 22, 'uploads/album/chat_13821154831.png', 0, 7, 0),
(10, 'qwer', 34, 23, 'uploads/album/admin-logo_1390039832.gif', 0, 10, 0),
(11, 'qwe', 12, 11, 'uploads/album/admin-logo_1390045475.gif', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fis_answers`
--

CREATE TABLE IF NOT EXISTS `fis_answers` (
  `answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `ans_txt` text NOT NULL,
  `is_true` int(11) NOT NULL,
  PRIMARY KEY (`answer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fis_attempt_ans`
--

CREATE TABLE IF NOT EXISTS `fis_attempt_ans` (
  `attempt_ans_id` int(11) NOT NULL AUTO_INCREMENT,
  `attempt_id` int(11) NOT NULL,
  `que_id` int(11) NOT NULL,
  `ans_id` int(11) NOT NULL,
  PRIMARY KEY (`attempt_ans_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `fis_attempt_ans`
--

INSERT INTO `fis_attempt_ans` (`attempt_ans_id`, `attempt_id`, `que_id`, `ans_id`) VALUES
(1, 1, 6, 20),
(2, 1, 7, 26),
(3, 1, 8, 29);

-- --------------------------------------------------------

--
-- Table structure for table `fis_category`
--

CREATE TABLE IF NOT EXISTS `fis_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `fis_category`
--

INSERT INTO `fis_category` (`category_id`, `parent_id`, `cat_name`) VALUES
(1, 0, 'CAT'),
(2, 0, 'GRE'),
(3, 0, 'GMAT'),
(4, 0, 'CMAT'),
(5, 2, 'Verbal'),
(6, 5, 'Symonyms'),
(7, 1, 'Logical Reasoning'),
(8, 1, 'Data Interpretation'),
(9, 1, 'Maths and Quants'),
(10, 9, 'Percentage'),
(11, 9, 'Averages'),
(12, 9, 'Trigonometry'),
(14, 13, 'l2'),
(15, 1, 'Verbal'),
(16, 4, 'QI & DI'),
(17, 4, 'Logical Reasoning'),
(18, 4, 'language Comprehension'),
(19, 4, 'General Awareness'),
(20, 7, 'logical Matching'),
(21, 7, 'clocks'),
(22, 7, 'calenders'),
(23, 7, 'cubes'),
(24, 7, 'Binary logic'),
(25, 7, 'Seating Arrangements'),
(26, 7, 'Blood Relations'),
(27, 7, 'Logical Sequence'),
(28, 7, 'Logical Connections'),
(29, 7, 'assumption'),
(30, 7, 'Premise'),
(31, 7, 'Conclusion'),
(32, 7, 'Linesr & Matrix Arangements'),
(33, 7, 'Number & letter series'),
(34, 7, 'Venn diagrams'),
(35, 8, 'Progression(Series and Sequence)'),
(36, 8, 'Bionomial Theorm'),
(37, 8, 'Surds & Indices'),
(38, 8, 'Inequalities'),
(39, 8, 'Interpretation & analysis of data based on Text'),
(40, 8, 'tables'),
(41, 8, 'graphs'),
(42, 8, 'charts (Column , bar ,pie)'),
(43, 9, 'Number System'),
(44, 9, 'set theory'),
(45, 9, 'Geometry'),
(46, 9, 'Mixtures & Alligations'),
(47, 9, 'LCM & HCF'),
(48, 9, 'Interest (Simple & Compound)'),
(49, 9, 'Probability'),
(50, 9, 'Co-ordinate Geometry'),
(51, 9, 'Speed -Time -Distance'),
(52, 9, 'Permutation Combination'),
(53, 9, 'Quadratic equation'),
(54, 15, 'Reading Comprehension'),
(55, 15, 'Jumbled para'),
(56, 15, 'Verbal Reasoning'),
(57, 15, 'Meaning Usage Match'),
(58, 15, 'Vocabulary Based( Synonym-Antonym )');

-- --------------------------------------------------------

--
-- Table structure for table `fis_discussion`
--

CREATE TABLE IF NOT EXISTS `fis_discussion` (
  `discussion_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `discussion_text` text NOT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`discussion_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fis_discussion`
--

INSERT INTO `fis_discussion` (`discussion_id`, `parent_id`, `cat_id`, `user_id`, `discussion_text`, `created_on`) VALUES
(1, 0, 1, 1, 'test132', '2014-03-27 01:01:06'),
(2, 1, 1, 1, 'test132', '2014-03-27 01:26:20');

-- --------------------------------------------------------

--
-- Table structure for table `fis_discussionreview`
--

CREATE TABLE IF NOT EXISTS `fis_discussionreview` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `discussion_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 for like and 0 for dislike',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `fis_discussionreview`
--

INSERT INTO `fis_discussionreview` (`review_id`, `discussion_id`, `user_id`, `type`, `created_on`) VALUES
(1, 1, 1, 1, '2014-03-26 19:55:00');

-- --------------------------------------------------------

--
-- Table structure for table `fis_images`
--

CREATE TABLE IF NOT EXISTS `fis_images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `del_in` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=179 ;

--
-- Dumping data for table `fis_images`
--

INSERT INTO `fis_images` (`image_id`, `album_id`, `img_path`, `sort_order`, `del_in`) VALUES
(1, 1, '', 1, 1),
(2, 1, 'uploads/image/1_1367339019.jpg', 2, 0),
(3, 1, 'uploads/image/2_1367339028.jpg', 3, 0),
(4, 1, 'uploads/image/3_1367339072.jpg', 4, 0),
(5, 1, 'uploads/image/4_1367339087.jpg', 5, 0),
(6, 1, 'uploads/image/5_1367339107.jpg', 6, 0),
(7, 1, 'uploads/image/6_1367339123.jpg', 7, 0),
(8, 1, 'uploads/image/7_1367339132.jpg', 8, 0),
(9, 1, 'uploads/image/8_1367339150.jpg', 9, 0),
(10, 1, 'uploads/image/9_1367339161.jpg', 10, 0),
(11, 1, 'uploads/image/10_1367339174.jpg', 11, 0),
(12, 1, 'uploads/image/11_1367339183.jpg', 12, 0),
(13, 1, 'uploads/image/12_1367339195.jpg', 13, 0),
(14, 1, 'uploads/image/13_1367339203.jpg', 14, 0),
(15, 1, 'uploads/image/14_1367339219.jpg', 15, 0),
(16, 1, 'uploads/image/15_1367339228.jpg', 16, 0),
(17, 1, 'uploads/image/16_1367339236.jpg', 17, 0),
(18, 1, 'uploads/image/17_1367339249.jpg', 18, 0),
(19, 1, 'uploads/image/18_1367339372.jpg', 19, 0),
(20, 1, 'uploads/image/19_1367339385.jpg', 20, 0),
(21, 1, 'uploads/image/20_1367339411.jpg', 21, 0),
(22, 1, 'uploads/image/21_1367339426.jpg', 22, 0),
(23, 1, 'uploads/image/22_1367339437.jpg', 23, 0),
(24, 1, 'uploads/image/23_1367339445.jpg', 24, 0),
(25, 1, 'uploads/image/24_1367339470.jpg', 25, 0),
(26, 1, 'uploads/image/25_1367339486.jpg', 26, 0),
(27, 1, 'uploads/image/26_1367339503.jpg', 27, 0),
(28, 1, 'uploads/image/27_1367339515.jpg', 28, 0),
(29, 1, 'uploads/image/28_1367339533.jpg', 29, 0),
(30, 1, 'uploads/image/29_1367339542.jpg', 30, 0),
(31, 1, 'uploads/image/30_1367339551.jpg', 31, 0),
(32, 1, 'uploads/image/31_1367339561.jpg', 32, 0),
(33, 1, 'uploads/image/32_1367339568.jpg', 33, 0),
(34, 1, 'uploads/image/33_1367339590.jpg', 34, 0),
(35, 1, 'uploads/image/34_1367339602.jpg', 35, 0),
(36, 1, 'uploads/image/35_1367339629.jpg', 36, 0),
(37, 1, 'uploads/image/36_1367339639.jpg', 37, 0),
(38, 1, 'uploads/image/37_1367339648.jpg', 38, 0),
(39, 1, 'uploads/image/38_1367339657.jpg', 39, 0),
(40, 1, 'uploads/image/39_1367339674.jpg', 40, 0),
(41, 1, 'uploads/image/40_1367339686.jpg', 41, 0),
(42, 1, 'uploads/image/41_1367339701.jpg', 42, 0),
(43, 1, 'uploads/image/42_1367339710.jpg', 43, 0),
(44, 1, 'uploads/image/43_1367339722.jpg', 44, 0),
(45, 1, 'uploads/image/44_1367339734.jpg', 45, 0),
(46, 1, 'uploads/image/45_1367339755.jpg', 46, 0),
(47, 1, 'uploads/image/46_1367339765.jpg', 47, 0),
(48, 1, 'uploads/image/47_1367339774.jpg', 48, 0),
(49, 1, 'uploads/image/48_1367339783.jpg', 49, 0),
(50, 1, 'uploads/image/49_1367339792.jpg', 50, 0),
(51, 1, 'uploads/image/50_1367339802.jpg', 51, 0),
(52, 1, 'uploads/image/51_1367339811.jpg', 52, 0),
(53, 1, 'uploads/image/52_1367339819.jpg', 53, 0),
(54, 2, 'uploads/image/1_1367340030.jpg', 57, 0),
(55, 2, 'uploads/image/2_1367340046.jpg', 58, 0),
(56, 2, 'uploads/image/3_1367340057.jpg', 59, 0),
(57, 2, 'uploads/image/4_1367340065.jpg', 60, 0),
(58, 2, 'uploads/image/5_1367340079.jpg', 61, 0),
(59, 2, 'uploads/image/6_1367340091.jpg', 62, 0),
(60, 2, 'uploads/image/7_1367340098.jpg', 63, 0),
(61, 2, 'uploads/image/8_1367340130.jpg', 64, 0),
(62, 2, 'uploads/image/9_1367340141.jpg', 65, 0),
(63, 2, 'uploads/image/10_1367340151.jpg', 66, 0),
(64, 2, 'uploads/image/11_1367340163.jpg', 67, 0),
(65, 2, 'uploads/image/12_1367340184.jpg', 68, 0),
(66, 2, 'uploads/image/13_1367340193.jpg', 69, 0),
(67, 2, 'uploads/image/14_1367340210.jpg', 70, 0),
(68, 2, 'uploads/image/15_1367340219.jpg', 71, 0),
(69, 2, 'uploads/image/16_1367340233.jpg', 72, 0),
(70, 2, 'uploads/image/17_1367340254.jpg', 73, 0),
(71, 2, 'uploads/image/18_1367340263.jpg', 74, 0),
(72, 2, 'uploads/image/19_1367340272.jpg', 75, 0),
(73, 2, 'uploads/image/20_1367340290.jpg', 76, 0),
(74, 2, 'uploads/image/21_1367340328.jpg', 77, 0),
(75, 2, 'uploads/image/22_1367340342.jpg', 78, 0),
(76, 1, 'uploads/image/23_1367340530.jpg', 76, 1),
(77, 4, 'uploads/image/cover1_1368365947.jpg', 77, 0),
(78, 4, 'uploads/image/1_1368366074.jpg', 78, 0),
(79, 4, 'uploads/image/2_1368366103.jpg', 79, 0),
(80, 4, 'uploads/image/3_1368366146.jpg', 80, 0),
(81, 4, 'uploads/image/4_1368366162.jpg', 81, 0),
(82, 4, 'uploads/image/5_1368366198.jpg', 82, 0),
(83, 4, 'uploads/image/6_1368366226.jpg', 83, 0),
(84, 4, 'uploads/image/7_1368366250.jpg', 84, 0),
(85, 4, 'uploads/image/8_1368366265.jpg', 85, 0),
(86, 4, 'uploads/image/9_1368366298.jpg', 86, 0),
(87, 4, 'uploads/image/10_1368366342.jpg', 87, 0),
(88, 4, 'uploads/image/11_1368366363.jpg', 88, 0),
(89, 4, 'uploads/image/12_1368366379.jpg', 89, 0),
(90, 4, 'uploads/image/13_1368366399.jpg', 90, 0),
(91, 4, 'uploads/image/cover2_1368366419.jpg', 94, 0),
(92, 4, 'uploads/image/14_1368366479.jpg', 91, 0),
(93, 4, 'uploads/image/15_1368366494.jpg', 92, 0),
(94, 4, 'uploads/image/16_1368366511.jpg', 93, 0),
(95, 5, 'uploads/image/cover1_1368367765.jpg', 95, 0),
(96, 5, 'uploads/image/1_1368368211.jpg', 96, 0),
(97, 5, 'uploads/image/2_1368368281.jpg', 97, 0),
(98, 5, 'uploads/image/3_1368368374.jpg', 98, 0),
(99, 5, 'uploads/image/4_1368368393.jpg', 99, 0),
(100, 5, 'uploads/image/6_1368368420.jpg', 101, 0),
(101, 5, 'uploads/image/7_1368368443.jpg', 102, 0),
(102, 5, 'uploads/image/8_1368368464.jpg', 103, 0),
(103, 5, 'uploads/image/9_1368368534.jpg', 104, 0),
(104, 5, 'uploads/image/10_1368368553.jpg', 105, 0),
(105, 5, 'uploads/image/11_1368368570.jpg', 106, 0),
(106, 5, 'uploads/image/12_1368368590.jpg', 107, 0),
(107, 5, 'uploads/image/13_1368368704.jpg', 108, 0),
(108, 5, 'uploads/image/14_1368368725.jpg', 109, 0),
(109, 5, 'uploads/image/15_1368368742.jpg', 110, 0),
(110, 5, 'uploads/image/16_1368368763.jpg', 111, 0),
(111, 5, 'uploads/image/17_1368368785.jpg', 112, 0),
(112, 5, 'uploads/image/18_1368368802.jpg', 113, 0),
(113, 5, 'uploads/image/19_1368368820.jpg', 114, 0),
(114, 5, 'uploads/image/20_1368368840.jpg', 115, 0),
(115, 5, 'uploads/image/21_1368368865.jpg', 116, 0),
(116, 5, 'uploads/image/22_1368368978.jpg', 117, 0),
(117, 5, 'uploads/image/23_1368369000.jpg', 118, 0),
(118, 5, 'uploads/image/24_1368369017.jpg', 119, 0),
(119, 5, 'uploads/image/cover2_1368369036.jpg', 120, 0),
(120, 5, 'uploads/image/5_1368369161.jpg', 100, 0),
(121, 2, 'uploads/image/23_1368379030.jpg', 79, 0),
(122, 2, 'uploads/image/24_1368379046.jpg', 80, 0),
(123, 2, 'uploads/image/25_1368379077.jpg', 81, 0),
(124, 2, 'uploads/image/26_1368379099.jpg', 82, 0),
(125, 2, 'uploads/image/27_1368379119.jpg', 83, 0),
(126, 2, 'uploads/image/28_1368379153.jpg', 84, 0),
(127, 2, 'uploads/image/29_1368379163.jpg', 85, 0),
(128, 2, 'uploads/image/30_1368379172.jpg', 86, 0),
(129, 2, 'uploads/image/31_1368379181.jpg', 87, 0),
(130, 2, 'uploads/image/32_1368379194.jpg', 88, 0),
(131, 2, 'uploads/image/33_1368379214.jpg', 89, 0),
(132, 2, 'uploads/image/34_1368379227.jpg', 90, 0),
(133, 2, 'uploads/image/35_1368379242.jpg', 91, 0),
(134, 2, 'uploads/image/36_1368379254.jpg', 92, 0),
(135, 2, 'uploads/image/cover1_1368379272.jpg', 54, 0),
(136, 2, 'uploads/image/cover2_1368379319.jpg', 97, 0),
(137, 2, 'uploads/image/inside1_1368379331.jpg', 55, 0),
(138, 2, 'uploads/image/inside2_1368379344.jpg', 56, 0),
(139, 2, 'uploads/image/last1_1368379507.jpg', 93, 0),
(140, 2, 'uploads/image/last2_1368379519.jpg', 94, 0),
(141, 2, 'uploads/image/last3_1368379530.jpg', 95, 0),
(142, 2, 'uploads/image/last4_1368379557.jpg', 96, 0),
(143, 3, 'uploads/image/01_1368379903.jpg', 143, 0),
(144, 3, 'uploads/image/01-A_1368379917.jpg', 144, 0),
(145, 3, 'uploads/image/02_1368379925.jpg', 145, 0),
(146, 3, 'uploads/image/02-A_1368379934.jpg', 146, 0),
(147, 3, 'uploads/image/03_1368379943.jpg', 147, 0),
(148, 3, 'uploads/image/03-A_1368379965.jpg', 148, 0),
(149, 3, 'uploads/image/04_1368379972.jpg', 149, 0),
(150, 3, 'uploads/image/04-A_1368379984.jpg', 150, 0),
(151, 3, 'uploads/image/05_1368379998.jpg', 151, 0),
(152, 3, 'uploads/image/05-A_1368380009.jpg', 152, 0),
(153, 3, 'uploads/image/06_1368380018.jpg', 153, 0),
(154, 3, 'uploads/image/06-A_1368380034.jpg', 154, 0),
(155, 3, 'uploads/image/07_1368380043.jpg', 155, 0),
(156, 3, 'uploads/image/08-A_1368380056.jpg', 158, 0),
(157, 3, 'uploads/image/07-A_1368380139.jpg', 156, 0),
(158, 3, 'uploads/image/08_1368380162.jpg', 157, 0),
(159, 3, 'uploads/image/09_1368380190.jpg', 159, 0),
(160, 3, 'uploads/image/09-A_1368380200.jpg', 160, 0),
(161, 6, 'uploads/image/1_1375365548.jpg', 161, 0),
(162, 6, 'uploads/image/2_1375365567.jpg', 162, 0),
(163, 8, 'uploads/image/2001_AB_1377846847.jpg', 163, 0),
(164, 7, 'uploads/image/2002_AB_1377846958.jpg', 164, 0),
(165, 7, 'uploads/image/2003_AB_1377846976.jpg', 165, 0),
(166, 7, 'uploads/image/2004_AB_1377847026.jpg', 166, 0),
(167, 7, 'uploads/image/2005_A_1377847040.jpg', 167, 0),
(168, 7, 'uploads/image/2005_B_1377847130.jpg', 168, 0),
(169, 7, 'uploads/image/2006_A_1377847144.jpg', 169, 0),
(170, 7, 'uploads/image/2006_B_1377847155.jpg', 170, 0),
(171, 7, 'uploads/image/2007_A_1377847166.jpg', 171, 0),
(172, 7, 'uploads/image/2007_B_1377847306.jpg', 172, 0),
(173, 7, 'uploads/image/2008_A_1377847327.jpg', 173, 0),
(174, 7, 'uploads/image/2008_B_1377847339.jpg', 174, 0),
(175, 7, 'uploads/image/2009_A_1377847353.jpg', 175, 0),
(176, 7, 'uploads/image/2009_B_1377847365.jpg', 176, 0),
(177, 9, '', 177, 0),
(178, 7, 'uploads/image/admin-logo_1389959851.gif', 178, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fis_material_cat`
--

CREATE TABLE IF NOT EXISTS `fis_material_cat` (
  `material_cat_id` int(11) NOT NULL DEFAULT '0',
  `material_cat_name` varchar(255) NOT NULL,
  `material_cat_poster` varchar(255) NOT NULL COMMENT 'select from image',
  `sort_order` int(11) NOT NULL,
  `del_in` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fis_material_cat`
--

INSERT INTO `fis_material_cat` (`material_cat_id`, `material_cat_name`, `material_cat_poster`, `sort_order`, `del_in`) VALUES
(1, 'dzire', 'uploads/album/img1_1366139639.jpg', 3, 1),
(2, 'akruti', 'uploads/album/img2_1366139657.jpg', 4, 1),
(3, 'barbie', 'uploads/album/img3_1366139665.jpg', 5, 1),
(4, 'atlantis', 'uploads/album/cover1_1368365770.jpg', 2, 1),
(5, 'nancy', 'uploads/album/cover1_1368367701.jpg', 1, 1),
(6, 'Dream Girl', 'uploads/album/dream_girl_1375365529.jpg', 6, 1),
(7, 'LAVASA', 'uploads/album/cover__1377846448.jpg', 9, 0),
(8, 'aa', 'uploads/album/chat_13821154831.png', 8, 0),
(9, 'aa', 'uploads/album/chat_13821154831.png', 7, 0),
(10, 'qwer', 'uploads/album/admin-logo_1390039832.gif', 10, 0),
(11, 'qwe', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fis_materials`
--

CREATE TABLE IF NOT EXISTS `fis_materials` (
  `material_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_category` int(11) NOT NULL,
  `m_title` varchar(255) NOT NULL,
  `m_desc` text NOT NULL,
  `m_images` varchar(255) NOT NULL,
  `m_document` varchar(255) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`material_id`),
  KEY `m_category` (`m_category`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `fis_news`
--

CREATE TABLE IF NOT EXISTS `fis_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(255) NOT NULL,
  `news_img` varchar(255) NOT NULL,
  `news_text` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fis_news`
--

INSERT INTO `fis_news` (`news_id`, `news_title`, `news_img`, `news_text`, `created_on`) VALUES
(1, 'test', 'uploads/materials/images/db_info_1396290657.png', 'test', '2014-03-31 18:31:00'),
(2, 'test1', 'uploads/materials/images/images_(3)_1396290689.jpg', 'test2', '2014-03-31 18:31:31');

-- --------------------------------------------------------

--
-- Table structure for table `fis_questions`
--

CREATE TABLE IF NOT EXISTS `fis_questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `question_txt` text NOT NULL,
  `question_img` varchar(255) NOT NULL,
  `solution` text NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `fis_questions`
--

INSERT INTO `fis_questions` (`question_id`, `cat_id`, `question_txt`, `question_img`, `solution`) VALUES
(4, 56, '<p>Vincent has a paper route. Each morning, he delivers 37 newspapers to customers in his neighborhood. It takes Vincent 50 minutes to deliver all the papers. If Vincent is sick or has other plans, his friend Thomas, who lives on the same street, will sometimes deliver the papers for him.</p>', 'uploads/question/images/Hands_Doing_Blue_CVC_Puzzle_Logo_1396771467.jpg', ''),
(5, 56, '<p>The Pacific yew is an evergreen tree that grows in the Pacific Northwest. The Pacific yew has a fleshy, poisonous fruit. Recently, taxol, a substance found in the bark of the Pacific yew, was discovered to be a promising new anticancer drug.</p>', '', ''),
(6, 43, 'Look at this series: 2, 1, (1/2), (1/4), ... What number should come next?', '', ''),
(7, 39, '<div style="text-align: left;">Tim''s commute never bothered him because there were always seats available on the train and he was able to spend his 40 minutes comfortably reading the newspaper or catching up on paperwork. Ever since the train schedule changed, the train has been extremely crowded, and by the time the doors open at his station, there isn''t a seat to be found.</div>', '', ''),
(8, 29, '<p><b>Statement: </b> "You are hereby appointed as a programmer with a probation period of one year and your performance will be reviewed at the end of the period for confirmation." - A line in an appointment letter.</p>\r\n<p><b>Assumptions:</b></p>\r\n<ol class="lr-ol-upper-roman">\r\n<li>The performance of an individual generally is not known at the time of appointment offer.</li>\r\n<li>Generally an individual tries to prove his worth in the probation period.</li>\r\n</ol>', '', ''),
(9, 6, '<p>This is GRE question</p>\r\n<p></p>', '', ''),
(10, 20, 'test', '', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `fis_student`
--

CREATE TABLE IF NOT EXISTS `fis_student` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fb_id` varchar(100) NOT NULL,
  `secure_key` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fis_student`
--

INSERT INTO `fis_student` (`student_id`, `fname`, `lname`, `email`, `password`, `fb_id`, `secure_key`, `is_active`, `created_on`) VALUES
(2, 'test', 'test', 'test@test.aaa', '47bce5c74f589f4867dbd57e9ca9f808', '', '', 0, '2013-11-24 15:40:15');

-- --------------------------------------------------------

--
-- Table structure for table `fis_test`
--

CREATE TABLE IF NOT EXISTS `fis_test` (
  `test_id` int(11) NOT NULL AUTO_INCREMENT,
  `test_cat_id` int(11) NOT NULL,
  `test_name` varchar(10) NOT NULL,
  `test_timer` int(11) NOT NULL,
  `test_que_ids` text,
  `test_point_if_ans_true` varchar(11) NOT NULL DEFAULT '1',
  `test_point_if_ans_false` varchar(11) NOT NULL,
  `test_release_on` datetime NOT NULL,
  PRIMARY KEY (`test_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `fis_test`
--

INSERT INTO `fis_test` (`test_id`, `test_cat_id`, `test_name`, `test_timer`, `test_que_ids`, `test_point_if_ans_true`, `test_point_if_ans_false`, `test_release_on`) VALUES
(8, 1, 'cat TEST', 5, '4,5', '2', '0.25', '2014-04-06 07:46:00'),
(9, 1, 'cat TEST2', 0, '6,7,8', '2', '0.25', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `fis_user_attempt`
--

CREATE TABLE IF NOT EXISTS `fis_user_attempt` (
  `user_attempt_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `attempt_count` int(11) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_attempt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `fis_user_attempt`
--

INSERT INTO `fis_user_attempt` (`user_attempt_id`, `user_id`, `test_id`, `attempt_count`, `created_on`) VALUES
(1, 2, 9, 6, '2014-04-06 08:18:29');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
