-- phpMyAdmin SQL Dump
-- version 3.4.4
-- http://www.phpmyadmin.net
--
-- Host: gophp.cs.dixie.edu
-- Generation Time: Apr 09, 2013 at 01:47 PM
-- Server version: 5.5.17
-- PHP Version: 5.3.2-1ubuntu4.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `app_gophp`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `person_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`person_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`person_id`, `name`, `comment`) VALUES
(23, '', ''),
(24, 'asdfasd', 'erqwerqwerwe'),
(7, 'darth vader', 'Luke, I am your father.'),
(8, 'darth vader', 'Luke, I am your father.'),
(10, 'darth vader', 'Luke, I am your father.'),
(11, 'darth vader', 'Luke, I am your father.'),
(12, 'darth vader', 'Luke, I am your father.'),
(17, 'darth vader', 'Luke, I am your father.'),
(20, 'joe', 'hello'),
(21, 'hi', 'this is fun'),
(22, 'hi', 'this is fun');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `courseID` varchar(6) NOT NULL,
  `courseName` varchar(30) DEFAULT NULL,
  `maxEnrollment` int(2) DEFAULT NULL,
  PRIMARY KEY (`courseID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseID`, `courseName`, `maxEnrollment`) VALUES
('cs3500', 'application development', 20);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`member_id`, `fname`, `tel`, `email`) VALUES
(1, 'fred', '673-1088', 'francom@dixie.edu'),
(3, 'fred', '673-1088', 'francom@dixie.edu'),
(4, 'fred', '673-1088', 'francom@dixie.edu'),
(5, 'steve-o', '673-1088', 'francom@dixie.edu'),
(11, 'tommy boy', '234-234-2344', 'a@b.com'),
(7, 'fred', '673-1088', 'fred@dixie.edu'),
(8, 'fred', '673-1088', 'francom@dixie.edu');

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE IF NOT EXISTS `instructor` (
  `instructorID` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  PRIMARY KEY (`instructorID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`instructorID`, `firstName`, `lastName`) VALUES
(1, 'Joe', 'Francom'),
(2, 'Bart', 'Stander'),
(3, 'Curtis', 'Larsen'),
(4, 'Lemon', 'Snickets'),
(5, 'Russ', 'Ross');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `locationID` int(11) NOT NULL AUTO_INCREMENT,
  `Location` varchar(10) NOT NULL,
  PRIMARY KEY (`locationID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`locationID`, `Location`) VALUES
(1, 'hazy 119'),
(2, 'hazy 120'),
(3, 'hazy 204'),
(4, 'MCD 111'),
(5, 'Jen 207');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`) VALUES
('joe', 'joG.hyWgzWwzg');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `php_console_input`
--

CREATE TABLE IF NOT EXISTS `php_console_input` (
  `input_id` int(11) NOT NULL AUTO_INCREMENT,
  `value1` varchar(20) NOT NULL,
  `value2` varchar(20) NOT NULL,
  `value3` varchar(20) NOT NULL,
  `value4` varchar(20) NOT NULL,
  PRIMARY KEY (`input_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `php_console_person`
--

CREATE TABLE IF NOT EXISTS `php_console_person` (
  `username` varchar(20) NOT NULL DEFAULT '',
  `fname` varchar(20) DEFAULT NULL,
  `lname` varchar(30) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`username`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `php_console_person`
--

INSERT INTO `php_console_person` (`username`, `fname`, `lname`, `role_id`) VALUES
('akinnaman', 'Andrew', 'Kinnaman', 1),
('astevens', 'Amber', 'Stevens', 1),
('cdixon1', 'Clayton', 'Dixon', 1),
('cho', 'Chanseng', 'Ho', 1),
('d0189187', 'Katie', 'Gish', 1),
('dgrange', 'Dustin', 'Grange', 1),
('elewis', 'Eric', 'Lewis', 1),
('jfrancom', 'Joe', 'Francom', 2),
('joe', 'joe', 'joe', 1),
('jwalker1', 'Joshua', 'Walker', 1),
('kwastlund', 'Kraig', 'Wastlund', 1),
('rbracken', 'Riley', 'Bracken', 1),
('rcooke', 'Roseann', 'Cooke', 1),
('rrodriguez', 'Rene', 'Rodriguez', 1),
('tmyrup', 'Tyler', 'Myrup', 1);

-- --------------------------------------------------------

--
-- Table structure for table `php_console_person_question`
--

CREATE TABLE IF NOT EXISTS `php_console_person_question` (
  `student_id` varchar(20) NOT NULL DEFAULT '',
  `question_id` int(11) NOT NULL,
  `num_attempts` int(11) NOT NULL DEFAULT '0',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `correct` tinyint(1) NOT NULL DEFAULT '0',
  `code` text NOT NULL,
  PRIMARY KEY (`student_id`,`question_id`),
  KEY `question_id` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `php_console_person_question`
--

INSERT INTO `php_console_person_question` (`student_id`, `question_id`, `num_attempts`, `last_modified`, `correct`, `code`) VALUES
('akinnaman', 4, 3, '2012-08-29 20:08:37', 1, 'echo "Hello World";'),
('akinnaman', 32, 1, '2012-08-29 20:12:43', 1, 'echo ''hello wor'';'),
('akinnaman', 35, 1, '2012-08-29 20:13:06', 1, 'echo ''673'';'),
('astevens', 4, 2, '2012-08-29 20:09:09', 1, '\necho "Hello World";\n'),
('astevens', 32, 1, '2012-08-29 20:10:26', 1, 'echo ''hello wor'';'),
('astevens', 35, 1, '2012-08-29 20:10:58', 1, 'echo ''673'';'),
('cdixon1', 4, 4, '2012-08-29 20:08:16', 1, 'echo "Hello World";'),
('cdixon1', 32, 1, '2012-08-29 20:09:34', 1, 'echo "hello wor";'),
('cdixon1', 35, 4, '2012-08-29 20:09:52', 1, 'echo "673";'),
('cdixon1', 39, 2, '2012-08-29 20:12:07', 0, 'for ($i=1; $i<101; $i++)\r\n    {\r\n      echo "$i<br/>";\r\n    }'),
('cho', 4, 1, '2012-08-29 20:08:06', 1, 'echo "Hello World";'),
('cho', 32, 2, '2012-08-29 20:09:43', 1, 'echo "hello wor";'),
('cho', 35, 2, '2012-08-29 20:08:41', 1, 'echo 673;'),
('cho', 75, 12, '2012-08-29 20:11:32', 0, '$i = 0\nwhile($i <= 100)\n{\n    $i += 1;\n    echo $i;\n}'),
('d0189187', 4, 2, '2012-08-29 20:08:25', 1, 'echo "Hello World";'),
('d0189187', 32, 1, '2012-08-29 20:09:31', 1, 'echo "hello wor";'),
('d0189187', 35, 1, '2012-08-29 20:09:57', 1, '$num1 = 673;\necho $num1;'),
('d0189187', 39, 6, '2012-08-29 20:11:30', 0, '$num = 1;\nwhile($num < 101)\n{\n    echo $num . "</br>";\n    $num = $num + 1;\n}'),
('dgrange', 4, 1, '2012-08-29 20:08:36', 1, 'echo "Hello World";'),
('dgrange', 32, 1, '2012-08-29 20:10:45', 1, 'echo ''hello wor'';'),
('elewis', 4, 1, '2012-08-29 20:08:19', 1, 'echo "Hello World";'),
('elewis', 32, 1, '2012-08-29 20:10:37', 1, 'echo ''hello wor'';'),
('elewis', 35, 1, '2012-08-29 20:11:27', 1, 'echo 673;'),
('jfrancom', 1, 2, '2012-08-23 16:56:10', 0, 'echo ''nothing entered'';'),
('jfrancom', 4, 6, '2012-08-29 20:08:37', 1, 'echo "Hello World";\n'),
('jfrancom', 5, 2, '2012-09-04 17:53:18', 0, 'function s($a,$b){\n    return $a+1;\n}'),
('jfrancom', 6, 1, '2012-08-28 00:43:41', 0, 'echo ''nothing entered'';'),
('jfrancom', 32, 1, '2012-08-29 20:10:25', 1, 'echo ''hello wor'';'),
('jfrancom', 35, 6, '2012-08-28 21:50:01', 1, 'echo 673;'),
('jfrancom', 36, 1, '2012-08-28 21:47:43', 1, '$_SESSION[''names'']=array(1=>''tom'', 2=>''fred'', 3=>''steve'');'),
('jfrancom', 37, 2, '2012-08-23 18:07:29', 1, 'function a()\n{\n    return date("l h:i");\n}'),
('jfrancom', 38, 2, '2012-08-23 18:09:28', 1, '$_SESSION[''curdate''] = date("M d, h:i");'),
('jfrancom', 39, 5, '2012-08-29 22:09:30', 1, 'for ($i=1; $i<101; $i++)\n    {\n      echo "$i<br>";\n    }'),
('jfrancom', 75, 6, '2012-08-23 17:56:40', 1, 'for($i=1;$i<100;$i++){\n    if($i%2==1)\n    {\n        echo $i.''<br>'';\n    }\n}'),
('jwalker1', 4, 4, '2012-08-29 22:30:07', 1, 'echo "Hello World";'),
('jwalker1', 75, 5, '2012-08-29 22:34:38', 0, 'for($i = 1;$i <= 100;$i += 2)\n{\n    echo $i . "<br \\>";\n}'),
('jwalker1', 76, 5, '2012-08-29 22:39:12', 0, 'for($i = 0; $i < 100; $i++)\n{\n    echo "hi<br \\>";\n}'),
('kwastlund', 4, 1, '2012-08-29 20:08:23', 1, 'echo "Hello World";'),
('kwastlund', 32, 2, '2012-08-29 20:10:30', 1, ' echo "hello wor";'),
('kwastlund', 35, 1, '2012-08-29 20:11:24', 1, 'echo "673";'),
('rbracken', 4, 4, '2012-08-29 20:08:23', 1, 'echo "Hello World";'),
('rbracken', 32, 1, '2012-08-29 20:11:25', 1, 'echo ''hello wor'';'),
('rbracken', 35, 1, '2012-08-29 20:11:42', 1, 'echo ''673'';'),
('rcooke', 4, 1, '2012-08-29 20:08:11', 1, 'echo "Hello World";\n'),
('rcooke', 32, 1, '2012-08-29 20:10:52', 1, 'echo "hello wor";'),
('rcooke', 35, 1, '2012-08-29 20:11:34', 1, 'echo "673";'),
('rrodriguez', 1, 1, '2012-08-29 20:08:11', 0, '$test = steve;\necho $test'),
('rrodriguez', 4, 4, '2012-08-29 20:09:28', 1, 'echo "Hello World";'),
('rrodriguez', 32, 2, '2012-08-29 20:10:49', 1, 'echo "hello wor";'),
('rrodriguez', 35, 1, '2012-08-29 20:11:28', 1, 'echo ''673'';'),
('tmyrup', 1, 2, '2012-08-29 20:12:06', 0, '$test = "steve"l;'),
('tmyrup', 4, 3, '2012-08-29 20:08:36', 1, 'echo "Hello World";'),
('tmyrup', 32, 1, '2012-08-29 20:09:40', 1, 'echo "hello wor";'),
('tmyrup', 35, 2, '2012-08-29 20:09:58', 1, 'echo "673";');

-- --------------------------------------------------------

--
-- Table structure for table `php_console_questions`
--

CREATE TABLE IF NOT EXISTS `php_console_questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_type` int(11) NOT NULL,
  `question_name` varchar(20) DEFAULT NULL,
  `question_text` text NOT NULL,
  `question_solution` text NOT NULL,
  PRIMARY KEY (`question_id`),
  KEY `question_type` (`question_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

--
-- Dumping data for table `php_console_questions`
--

INSERT INTO `php_console_questions` (`question_id`, `question_type`, `question_name`, `question_text`, `question_solution`) VALUES
(1, 1, 'session_1', 'Create a session variable named ''test'' that contains the value ''steve''.', '$_SESSION["test"] = "steve";'),
(3, 2, 'question_2', 'Create a query that retrieves all fields and records from a table called ''student''.  Assign to a variable like\r\n\r\n$sql = ''YOUR STATEMENT HERE'';', '$sql = "SELECT * FROM student";'),
(4, 3, 'question_3', 'Output the following:\r\n\r\nHello World', 'echo ''Hello World'';'),
(5, 4, 'question_4', 'Create a function that receives two variables and returns the sum of them.', 'function addit($a,$b){\r\n    return $a+$b;\r\n}'),
(6, 2, 'student insert', 'Insert into student table a record. Preface with $sql = "YOUR STATEMENT";', '$sql = "INSERT into student (firstName, lastName, address, city, state, zip, phone, email, age, sex) VALUES (''temp'', ''temp'', ''123 nada'', ''some city'', ''UT'', 78999, ''1234567890'',''joe@bla.com'', 22, ''m'')";'),
(32, 3, 'output_2', 'Output ''hello wor'' to the screen.', 'echo ''hello wor'';'),
(33, 4, 'function_3', 'Create a function that receives 3 variables and returns the sum of them.', 'function a($b, $c, $d){\n    return $b + $c + $d;\n}'),
(35, 3, 'num1', 'Output the following number to the screen:\n\n673', 'echo 673;'),
(36, 1, 'num1', 'Create a session variable named ''names'' with the following contents as an array.\n\nKey   Value\n---   -----\n1     tom\n2     fred\n3     steve', '$_SESSION[''names''] = array(1=>''tom'', 2=>''fred'', 3=>''steve'');'),
(37, 4, 'date', 'Write a function that receives nothing and returns the current time as returned by the date function in the following format:\n\nMonday 07:23\n\n', 'function getDate(){\r\n    return date("l h:i");\r\n}'),
(38, 1, 'session_date', 'Set a session variable named ''curdate'' using the date function with the following format:\n\nAug 22, 08:53', '$_SESSION[''curdate'']= date("M d, h:i");'),
(39, 3, 'many_numbers', 'Echo to the screen the numbers from 1 to 100 each on it''s own line (use a br tag). (A loop makes this easy).', 'for($i=1;$i<=100; $i++)\r\n{\r\n    echo $i."<br>";\r\n};'),
(40, 4, 'function_hello', 'Return the string "Hello World" from a function.', 'function sayHi(){\n    return "Hello World";\n}'),
(41, 4, 'function_myip', 'Return your current ip address from a function. Hint: use a $_SERVER variable.', 'function myIP(){\n    return $_SERVER[''REMOTE_ADDR''];\n};'),
(42, 4, 'function_host', 'Return the contents of the ''Host:'' header from the current request, if there is one. (Use a function)(Hint: see $_SERVER variables)', 'function myHost(){\n    return $_SERVER[''HTTP_HOST''];\n};'),
(75, 3, 'odd_numbers', 'Print out the odd numbers from 1-100 each separated by a ''br'' tag.', 'for($i=1;$i<100;$i+=2){\n   echo "$i<br>";\n};'),
(76, 3, 'loop_text', 'Echo out ''hi<br />'' 100 times.', 'for($i=0;$i<100;$i++){\necho ''hi<br />'';\n}');

-- --------------------------------------------------------

--
-- Table structure for table `php_console_question_input`
--

CREATE TABLE IF NOT EXISTS `php_console_question_input` (
  `question_id` int(11) NOT NULL,
  `input_id` int(11) NOT NULL,
  PRIMARY KEY (`question_id`,`input_id`),
  KEY `input_id` (`input_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `php_console_question_type`
--

CREATE TABLE IF NOT EXISTS `php_console_question_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_val` varchar(20) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `php_console_question_type`
--

INSERT INTO `php_console_question_type` (`type_id`, `type_val`) VALUES
(1, 'session'),
(2, 'database'),
(3, 'output'),
(4, 'function');

-- --------------------------------------------------------

--
-- Table structure for table `php_console_roles`
--

CREATE TABLE IF NOT EXISTS `php_console_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_desc` varchar(20) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `php_console_roles`
--

INSERT INTO `php_console_roles` (`role_id`, `role_desc`) VALUES
(1, 'student'),
(2, 'administrator');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `body` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `created`, `modified`) VALUES
(1, 'The title', 'This is the post body.', '2012-02-28 08:03:05', NULL),
(2, 'A title once again', 'And the post body follows.', '2012-02-28 08:03:05', NULL),
(3, 'Title strikes back', 'This is really exciting! Not.', '2012-02-28 08:03:06', NULL),
(4, 'new pst 1', 'coolness', '2012-02-28 08:35:48', '2012-02-28 08:35:48');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE IF NOT EXISTS `registration` (
  `studentID` int(11) NOT NULL DEFAULT '0',
  `sectionID` int(4) NOT NULL,
  `letterGrade` char(2) DEFAULT 'A+',
  PRIMARY KEY (`studentID`,`sectionID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`studentID`, `sectionID`, `letterGrade`) VALUES
(1, 1, 'A+'),
(1, 3, 'A+'),
(2, 2, 'A+'),
(2, 1, 'A+'),
(2, 3, 'A+');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE IF NOT EXISTS `section` (
  `sectionID` int(4) NOT NULL AUTO_INCREMENT,
  `sectionNum` int(3) NOT NULL DEFAULT '0',
  `courseID` varchar(6) NOT NULL,
  `instructorID` int(3) DEFAULT NULL,
  `locationID` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`sectionID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`sectionID`, `sectionNum`, `courseID`, `instructorID`, `locationID`) VALUES
(1, 1, 'it2400', 1, '2'),
(2, 1, 'cs1400', 1, '2'),
(3, 2, 'it2400', 1, '2'),
(4, 1, 'it4200', 1, '2');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `student_id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=118 ;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `name`, `email`) VALUES
(1, 'sally', 's@lly.com'),
(2, 'billy', 'billy@billy.com'),
(3, 'steve', 'steve@zoo.com'),
(4, 'archie', 'c00kym0nster@foobar.com'),
(5, 'beelzebub', 'luke@hades.com'),
(6, 'asdf', 'bb@c.om'),
(7, 'asdf', 'bb@c.om'),
(8, 'asdf', 'bb@c.om'),
(9, 'asdf', 'bb@c.om'),
(10, 'asdf', 'bb@c.om'),
(11, 'asdf', 'bb@c.om'),
(12, 'asdf', 'bb@c.om'),
(13, 'asdf', 'bb@c.om'),
(14, 'asdf', 'bb@c.om'),
(15, 'asdf', 'bb@c.om'),
(16, 'asdf', 'bb@c.om'),
(17, 'asdf', 'bb@c.om'),
(18, 'asdf', 'bb@c.om'),
(19, 'asdf', 'bb@c.om'),
(20, 'asdf', 'bb@c.om'),
(21, 'asdf', 'bb@c.om'),
(22, 'asdf', 'bb@c.om'),
(23, 'asdf', 'bb@c.om'),
(24, 'asdf', 'bb@c.om'),
(25, 'asdf', 'bb@c.om'),
(26, 'asdf', 'bb@c.om'),
(27, 'asdf', 'bb@c.om'),
(28, 'asdf', 'bb@c.om'),
(29, 'asdf', 'bb@c.om'),
(30, 'asdf', 'bb@c.om'),
(31, 'asdf', 'bb@c.om'),
(32, 'asdf', 'bb@c.om'),
(33, 'asdf', 'bb@c.om'),
(34, 'asdf', 'bb@c.om'),
(35, 'asdf', 'bb@c.om'),
(36, 'asdf', 'bb@c.om'),
(37, 'asdf', 'bb@c.om'),
(38, 'asdf', 'bb@c.om'),
(39, 'asdf', 'bb@c.om'),
(40, 'asdf', 'bb@c.om'),
(41, 'asdf', 'bb@c.om'),
(42, 'asdf', 'bb@c.om'),
(43, 'asdf', 'bb@c.om'),
(44, 'asdf', 'bb@c.om'),
(45, 'asdf', 'bb@c.om'),
(46, 'asdf', 'bb@c.om'),
(47, 'asdf', 'bb@c.om'),
(48, 'asdf', 'bb@c.om'),
(49, 'asdf', 'bb@c.om'),
(50, 'asdf', 'bb@c.om'),
(51, 'asdf', 'bb@c.om'),
(52, 'asdf', 'bb@c.om'),
(53, 'Reykjavik Tokavich', 'reykjavik@icemail.com'),
(54, 'asdf', 'bb@c.om'),
(55, 'asdf', 'bb@c.om'),
(56, 'asdf', 'bb@c.om'),
(57, 'asdf', 'bb@c.om'),
(58, 'asdf', 'bb@c.om'),
(59, 'asdf', 'bb@c.om'),
(60, 'asdf', 'bb@c.om'),
(61, 'asdf', 'bb@c.om'),
(62, 'asdf', 'bb@c.om'),
(63, 'fred', 'fred@email.com'),
(64, 'asdf', 'bb@c.om'),
(65, 'asdf', 'bb@c.om'),
(66, 'Stephen', 'whatevs@gmail.com'),
(67, 'asdf', 'bb@c.om'),
(68, 'asdf', 'bb@c.om'),
(69, 'asdf', 'bb@c.om'),
(70, 'asdf', 'bb@c.om'),
(71, 'asdf', 'bb@c.om'),
(72, 'asdf', 'bb@c.om'),
(73, 'Eric', 'es@email.com'),
(74, 'asdf', 'bb@c.om'),
(75, 'asdf', 'bb@c.om'),
(76, 'asdf', 'bb@c.om'),
(77, 'asdf', 'bb@c.om'),
(78, 'Kynzie', 'mekynzie.jensen@gmail.com'),
(79, 'asdf', 'bb@c.om'),
(80, 'Scott', 'scott@gmail.com'),
(81, 'asdf', 'bb@c.om'),
(82, 'asdf', 'bb@c.om'),
(83, 'asdf', 'bb@c.om'),
(84, 'Brandon', 'nygard@dixie.edu'),
(85, 'asdf', 'bb@c.om'),
(86, 'asdf', 'bb@c.om'),
(87, 'asdf', 'bb@c.om'),
(88, 'asdf', 'bb@c.om'),
(89, 'asdf', 'bb@c.om'),
(90, 'asdf', 'bb@c.om'),
(91, 'Kynzie', 'mekynzie.jensen@gmail.com'),
(92, 'asdf', 'bb@c.om'),
(93, 'trent', 'trentonipson@gmail.com'),
(94, 'asdf', 'bb@c.om'),
(95, 'Scott', 'scott@gmail.com'),
(96, 'asdf', 'bb@c.om'),
(97, 'Scott', 'scott@gmail.com'),
(98, 'asdf', 'bb@c.om'),
(99, 'trent', 'trentonipson@gmail.com'),
(100, 'asdf', 'bb@c.om'),
(101, 'asdf', 'bb@c.om'),
(102, 'asdf', 'bb@c.om'),
(103, 'asdf', 'bb@c.om'),
(104, 'asdf', 'bb@c.om'),
(105, 'asdf', 'bb@c.om'),
(106, 'preston', 'pwag42@gmail.com'),
(107, 'asdf', 'bb@c.om'),
(108, 'asdf', 'bb@c.om'),
(109, 'asdf', 'bb@c.om'),
(110, 'joe', 'joe@joe.com'),
(111, 'asdf', 'bb@c.om'),
(112, 'asdf', 'bb@c.om'),
(113, 'Scott', 'scott@gmail.com'),
(114, 'asdf', 'bb@c.om'),
(115, 'asdf', 'bb@c.om'),
(116, 'Eric Beilmann', 'ebeilmann@dixie.edu'),
(117, 'asdf', 'bb@c.om');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_question`
--

CREATE TABLE IF NOT EXISTS `tbl_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(100) DEFAULT NULL,
  `answer` varchar(30) DEFAULT NULL,
  `used` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `tbl_question`
--

INSERT INTO `tbl_question` (`id`, `question`, `answer`, `used`) VALUES
(1, 'In which 1942 Humphrey Bogart film was the song ''As Time Goes By''?', 'Casablanca', 1),
(2, 'Who commanded the Eighth Army from 1942-1944?', 'Field-Marshal Montgomery', 1),
(3, 'Which ''Unsinkable'' German battleship was sunk in the Atlantic by British Ships?', 'Bismark', 1),
(4, 'Whose book ''The Power and the Glory'' was first punished in 1940?', 'Graham Greene', 0),
(5, 'Which non-food commodity was rationed in Britain from June 2nd 1941?', 'Clothing', 0),
(6, 'What type of structures were Moehne and Edar destroyed by the Allies in 1941?', 'Dams', 0),
(7, 'At which great battle were the Germans defeated by the Russians on September 6th 1942?', 'Battle of Stalingrad', 0),
(8, 'On August 6th 1945, the first atom bomb was dropped where?', 'Hiroshima', 0),
(9, 'On board which US ship did General MacArthur accept the surrender of Japan in 1945?', 'USS Missouri', 0),
(10, 'Which British colony did Japan capture on Chritmas Day 1942?', 'Hong Kong', 0),
(11, 'What name was given to the young men conscripted to work in Britain''s mine s to help the war effort?', 'Bevin Boys', 0),
(12, 'Which of Hitler''s deputies parachuted into Scotland to negotiate peace terms?', 'Rudolph Hess', 0),
(13, 'Which three-term prime minister of Britain died in 1947, aged 80?', 'Stanley Baldwin', 0),
(14, 'Which two nations fought the Battle of Leyte Gulf in 1944?', 'USA & Japan', 0),
(15, 'In which country did the Battle of El Alamein take place?', 'Egypt', 0),
(16, 'Where in September 1942 did Australian forces halt a Japanese land advance in the south-west pacific', 'New Guinea', 0),
(17, 'Which element, later to be used to devestating effect, was discovered in 1940 by G T Seaborg?', 'Plutonium', 0),
(18, 'Which German city was attacked by over 1000 allied bombers on May 30th 1942?', 'Cologne', 0),
(19, 'Richard Murdoch and Kenneth Horne were the stars of which popular 1940''s radio show?', 'Much binding in the Marsh', 0),
(20, 'Which German city was devestated on February 15th 1945 by an attack of 796 Lancaster bombers?', 'Dresden', 0),
(21, 'What World War II attack began with the signal ''Climb Mount Niitaka''?', 'Pearl Harbour', 0),
(22, 'Which historic event took place on June 6th 1944?', 'D-Day Landings', 0),
(23, 'Which major European city was recaptured by the Allies on August 24th-25th 1944?', 'Paris', 0),
(24, 'Which European country declared war on both the Allies and Germany during WWII?', 'Italy', 0),
(25, 'Who betrayed Norway to the Nazi''s?', 'Quisling', 0),
(26, 'Which new bridge was opened over the river Thames, in London, in 1945?', 'Waterloo Bridge', 0),
(27, 'Where were Omaha, Juno and Gold beaches?', 'Normandy', 0),
(28, 'Which military alliance was formed in 1949 by Western Nations?', 'Nato', 0),
(29, 'Which country signed a ten year pact in 1940 with the European axis powers of Italy and Germany?', 'Japan', 0),
(30, 'Which country did the allies invade in ''Operation Avalanche''?', 'Italy', 0),
(31, 'Which country defeated Finland after a 3-month war, in March 1940?', 'Russia', 0),
(32, 'Which German composer, whose works include ''Der Rosenkavalier'' died aged 85 in 1949?', 'Richard Strauss', 0),
(33, 'Which dramatic action of World War II took place between May 27th & June 4th 1940?', 'Evacuation of Dunkirk', 0),
(34, 'On Which country did Britain delare war on December 8th 1941?', 'Japan', 0),
(35, 'What honour was bestowed upon the island of Malta in 1942 to honour the bravery of its inhabitants?', 'George Cross', 0),
(36, 'Which city was the capital of free China during World War II?', 'Chunking', 0),
(37, 'Which Russian born composer died in Beverley Hills, California aged 69?', 'Rachmaninov', 0),
(38, 'Which classic film starring Orson Welles was released in 1941?', 'Citizen Kane', 0),
(39, 'Which religion did the Japanese ''abolish'' in 1945?', 'Shintoism', 0),
(40, 'What is the principal language if the Caribbean?', 'English', 0),
(41, 'Which Caribbean country won the most medals for boxing in the 1992 Olympic games?', 'Cuba', 0),
(42, 'Which Caribbean island group contains St Lucia, St Vincent & Martinique?', 'The Winward Islands', 0),
(43, 'Which religious cult is linked with reggae music?', 'Rastafarianism', 0),
(44, 'Complete this famous song lyric:', 'hey, we''re going toÃ¢â‚¬Â¦Ã¢â‚', 0),
(45, 'What is the maximum length a banana can grow?', 'One foot (30cm)', 0),
(46, 'What is the capital of Jamaica?', 'Kingston', 0),
(47, 'Which Cuban leader led his country in Communism?', 'Fidel Castro', 0),
(48, 'The Ping Pong and Second Pan are types of what?', 'Steel Drum', 0),
(49, 'What colour are pineapple flowers?', 'Purple', 0),
(50, 'Which is the largest Caribbean Island? ', 'Cuba', 0),
(51, 'What is the principal motif of the Jamaican flag?', 'A Yellow Cross', 0),
(52, 'What is the meaning of the abbreviation CARICOM?', 'Caribbean Community', 0),
(53, 'What is the name of Bob Marley''s wife?', 'Rita', 0),
(54, 'Who discovered the West Indies in 1942?', 'Christopher Columbus', 0),
(55, 'Name a Caribbean Island beginning with P?', 'Puerto Rico', 0),
(56, 'Which great West Indian batsmen played cricket for Somerset in the 1980''s?', 'Joel Garner & Viv Richards', 0),
(57, 'Which country owns the Cayman Islands?', 'Great Britain', 0),
(58, 'Which country did Columbus think Cuba was when he discovered it?', 'India', 0),
(59, 'Which Cuban cigars are the most highly prized in the world?', 'Havana', 0),
(60, 'How did most of the Jamaican inhabitants arrive there origionally?', 'On slave boats', 0),
(61, 'What is rum distilled from?', 'Molasses (sugar cane)', 0),
(62, 'What film starring Tom Cruise was set in the Caribbean?', 'Cocktail', 0),
(63, 'In which group of islands is Ireland Island?', 'Bermuda', 0),
(64, 'Which driving force behind Comic Relief had his roots in the Caribbean?', 'Lenny Henry', 0),
(65, 'What is Jamaica''s major cash crop?', 'Sugar', 0),
(66, 'Who were the original inhabitants of Jamaica?', 'The Arawaks', 0),
(67, 'What religion is practiced subversively in Haiti?', 'Voodoo', 0),
(68, 'What conclusive proof was found by Soviet scientists exploring the Bermuda Triangle?', 'None', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `email`) VALUES
(1, 'test1', 'pass1', 'test1@example.com'),
(2, 'test2', 'pass2', 'test2@example.com'),
(3, 'test3', 'pass3', 'test3@example.com'),
(4, 'test4', 'pass4', 'test4@example.com'),
(5, 'test5', 'pass5', 'test5@example.com'),
(6, 'test6', 'pass6', 'test6@example.com'),
(7, 'test7', 'pass7', 'test7@example.com'),
(8, 'test8', 'pass8', 'test8@example.com'),
(9, 'test9', 'pass9', 'test9@example.com'),
(10, 'test10', 'pass10', 'test10@example.com'),
(11, 'test11', 'pass11', 'test11@example.com'),
(12, 'test12', 'pass12', 'test12@example.com'),
(13, 'test13', 'pass13', 'test13@example.com'),
(14, 'test14', 'pass14', 'test14@example.com'),
(15, 'test15', 'pass15', 'test15@example.com'),
(16, 'test16', 'pass16', 'test16@example.com'),
(17, 'test17', 'pass17', 'test17@example.com'),
(18, 'test18', 'pass18', 'test18@example.com'),
(19, 'test19', 'pass19', 'test19@example.com'),
(20, 'test20', 'pass20', 'test20@example.com'),
(21, 'test21', 'pass21', 'test21@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE IF NOT EXISTS `temp` (
  `testnum` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temp`
--

INSERT INTO `temp` (`testnum`) VALUES
(1234),
(67890);

-- --------------------------------------------------------

--
-- Table structure for table `tst`
--

CREATE TABLE IF NOT EXISTS `tst` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `t` double(7,4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tst`
--

INSERT INTO `tst` (`id`, `t`) VALUES
(1, 1.6345),
(2, 6.2345),
(3, 999.9999);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `php_console_person`
--
ALTER TABLE `php_console_person`
  ADD CONSTRAINT `php_console_person_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `php_console_roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `php_console_person_question`
--
ALTER TABLE `php_console_person_question`
  ADD CONSTRAINT `php_console_person_question_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `php_console_questions` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `php_console_person_question_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `php_console_person` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `php_console_questions`
--
ALTER TABLE `php_console_questions`
  ADD CONSTRAINT `php_console_questions_ibfk_1` FOREIGN KEY (`question_type`) REFERENCES `php_console_question_type` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `php_console_question_input`
--
ALTER TABLE `php_console_question_input`
  ADD CONSTRAINT `php_console_question_input_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `php_console_questions` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `php_console_question_input_ibfk_2` FOREIGN KEY (`input_id`) REFERENCES `php_console_input` (`input_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
