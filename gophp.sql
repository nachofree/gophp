-- phpMyAdmin SQL Dump
-- version 3.4.4
-- http://www.phpmyadmin.net
--
-- Host: gophp.cs.dixie.edu
-- Generation Time: Apr 09, 2013 at 01:44 PM
-- Server version: 5.5.17
-- PHP Version: 5.3.2-1ubuntu4.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `temp`
--

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
('username', 'first', 'last', 1);

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
('username', 1, 2, '2012-08-29 20:12:06', 0, '$test = "steve"l;'),
('username', 4, 3, '2012-08-29 20:08:36', 1, 'echo "Hello World";'),
('username', 32, 1, '2012-08-29 20:09:40', 1, 'echo "hello wor";'),
('username', 35, 2, '2012-08-29 20:09:58', 1, 'echo "673";');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Dumping data for table `php_console_questions`
--

INSERT INTO `php_console_questions` (`question_id`, `question_type`, `question_name`, `question_text`, `question_solution`) VALUES
(1, 1, 'session_1', 'Create a session variable named ''test'' that contains the value ''steve''.', '$_SESSION["test"] = "steve";'),
(3, 2, 'question_2', 'Create a query that retrieves all fields and records from a table called ''students''.  Assign to a variable like\r\n\r\n$sql = ''YOUR STATEMENT HERE'';', '$sql = "SELECT * FROM students";'),
(4, 3, 'question_3', 'Output the following:\r\n\r\nHello World', 'echo ''Hello World'';'),
(5, 4, 'question_4', 'Create a function that receives two variables and returns the sum of them.', 'function addit($a,$b){\r\n    return $a+$b;\r\n}'),
(6, 2, 'student insert', 'Insert into students table a record. Preface with $sql = "YOUR STATEMENT";', '$sql = "INSERT INTO students VALUES (NULL, ''asdf'', ''bb@c.om'')";'),
(32, 3, 'output_2', 'Output ''hello wor'' to the screen.', 'echo ''hello wor'';'),
(33, 4, 'function_3', 'Create a function that receives 3 variables and returns the sum of them.', 'function a($b, $c, $d){\n    return $b + $c + $d;\n}'),
(35, 3, 'num1', 'Output the following number to the screen:\n\n673', 'echo 673;'),
(36, 1, 'num1', 'Create a session variable named ''names'' with the following contents as an array.\n\nKey   Value\n---   -----\n1     tom\n2     fred\n3     steve', '$_SESSION[''names''] = array(1=>''tom'', 2=>''fred'', 3=>''steve'');'),
(37, 4, 'date', 'Write a function that receives nothing and returns the current time as returned by the date function in the following format:\n\nMonday 07:23\n\n', 'function getDate(){\r\n    return date("l h:i");\r\n}'),
(38, 1, 'session_date', 'Set a session variable named ''curdate'' using the date function with the following format:\n\nAug 22, 08:53', '$_SESSION[''curdate'']= date("M d, h:i");'),
(39, 3, 'many_numbers', 'Echo to the screen the numbers from 1 to 100 each on it''s own line (use a br tag). (A loop makes this easy).', 'for($i=1;$i<=100; $i++)\r\n{\r\n    echo $i."<br />";\r\n};'),
(40, 4, 'function_hello', 'Return the string "Hello World" from a function.', 'function sayHi(){\n    return "Hello World";\n}'),
(41, 4, 'function_myip', 'Return your current ip address from a function. Hint: use a $_SERVER variable.', 'function myIP(){\n    return $_SERVER[''REMOTE_ADDR''];\n};'),
(42, 4, 'function_host', 'Return the contents of the ''Host:'' header from the current request, if there is one. (Use a function)(Hint: see $_SERVER variables)', 'function myHost(){\n    return $_SERVER[''HTTP_HOST''];\n};'),
(75, 3, 'odd_numbers', 'Print out the odd numbers from 1-100 each separated by a ''br'' tag.', 'for($i=1;$i<100;$i+=2){\n   echo "$i<br>";\n};'),
(76, 3, 'loop_text', 'Echo out "hi&lt;br /&gt;" 100 times.', 'for($i=0;$i<100;$i++){\necho ''hi<br />'';\n}'),
(77, 1, 'concat', 'Create a session variable called ''simple'' that contains the value of your port number that you are using to connect to the gophp server. (Hint: Look for a $_SERVER variable that reports this)', '$_SESSION[''simple'']=$_SERVER[''REMOTE_PORT''];'),
(78, 1, 'large array', 'Create a session variable called ''large'' that contains an array that has the numbers between 0-1000 in it.', '$arr = array();\nfor($i=0; $i<=1000; $i++)\n{\n    $arr[]=$i;\n}\n$_SESSION[''large'']=$arr;');

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
