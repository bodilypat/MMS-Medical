SET SQL_MODE ="NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE 'admin'(
    'id' int(11) NOT NULL,
    'username' varchar(255) NOT NULL,
    'password' varchar(255) NOT NULL,
    'updationDate' varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE appointment (
    'id' int(11) NOT NULL,
    'doctorSpecial' int(11) DEFAULT NULL,
    'doctorId' int(11) DEFAULT NULL,
    'userId' int(11) DEFAULT NULL,
    'consultFees' int(11) DEFAULT NULL,
    'appointDate' varchar(255) DEFAULT NULL,
    'appointTime' varchar(255) DEFAULT NULL,
    'postDate' timestamp NULL DEFAULT current_timestamp(),
    'userStatus' int(11) DEFAULT NULL,
    'doctorStatus' int(11) DEFAULT NULL,
    'updateDate' timestamp NULL DEFAULT NULL NO UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE 'doctors'(
    'id' int(11) NOT NULL,
    'special' varchar(255) DEFAULT NULL,
    'doctorName' varchar(255) DEFAULT NULL,
    'address' longtext DEFAULT NULL,
    'doctorFees' varchar(255) DEFAULT NULL,
    'contactno' bigint(11) DEFAULT NULL,
    'doctorEmail' varchar(255) DEFAULT NULL,
    'password' varchar(255) DEFAULT NULL,
    'createDate' timestamp NULL DEFAULT current_timestamp(),
    'updateDate' timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
)

CREATE TABLE 'doctorlog' (
    'id' int(11) NOT NULL,
    'userId' int(11) DEFAULT NULL,
    'username' varchar(255) DEFAULT NULL,
    'userip' binary(16) DEFAULT NULL,
    'loginTime' timestamp NULL DEFAULT current_timestamp();
    'logout' varchar(255) DEFAULT NULL,
    'status' int(11) DEFAULT NULL,
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE 'medicalhistory'(
    'id' int(10) NOT NULL,
    'patientID' int(10) DEFAULT NULL,
    'bloodPressure' varchar(200) DEFAULT NULL,
    'bloodSuger' varchar(200) NOT NULL,
    'weight' varchar(100) DEFAULT NULL,
    'temperature' varchar(200) DEFAULT NULL,
    'medicalPres' mediumtext DEFAULT NULL,
    'creatDate' timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp();
)ENGINE=Inno DEFAULT CHARSET=latin1;

CREATE TABLE 'tblpage'(
    'ID' int(10) NOT NULL,
    'pageType' varchar(200) DEFAULT NULL,
    'pageTitle' varchar(200) DEFAULT NULL,
    'pageDescription' mediumtext DEFAULT NULL,
    'email' varchar(120) DEFAULT NULL,
    'mobile' bigint(10) DEFAULT NULL,
    'updateDate' timestamp NULL DEFAULT current_timestamp(),
    'openningTime' varchar(255) DEFAULT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE 'doctorSpecialized'(
    'id' int(11) NOT NULL,
    'specialized' varchar(255) DEFAULT NULL,
    'createDate' timestamp NULL DEFAULT current_timestamp(),
    'updateDate' timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE 'contactus'(
    'id' int(11) NOT NULL,
    'email' varchar(255) DEFAULT NULL,
    'contactno' varchar(255) DEFAULT NULL,
    'message' mediumtext DEFAULT NULL,
    'postDate' timestamp NULL DEFAULT current_timestamp(),
    'adminRemark' mediumtext DEFAULT NULL,
    'lastupdateDate' timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
    'isRead' int(11) DEFAULT NULL,
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE 'patients'(
    'ID' int(10) NOT NULL,
    'docId' int(10) DEFAULT NULL,
    'patientName' varchar(200) DEFAULT NULL,
    'patientContno' bigint(10) DEFAULT NULL,
    'patientEmail' varchar(200) DEFAULT NULL,
    'patientGender' varchar(50) DEFAULT NULL,
    'patientAddress' mediumtext DEFAULT NULL,
    'patientAge' int(10) DEFAULT NULL,
    'patientMedhis' mediumtext DEFAULT NULL,
    'createDate' timestamp NULL DEFAULT current_timestamp(),
    'updateDate' timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE 'userlog'(
    'id' int(11) NOT FULL,
    'userId' int(11) DEFAULT NULL,
    'username' varchar(255) DEFAULT NULL,
    'userip' binary(16) DEFAULT NULL,
    'loginTime' timestamp NULL DEFAULT current_timestamp(),
    'logout' varchar(255) DEFAULT NULL,
    'status' int(11) DEFAULT NULL
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE 'users'(
    'id' int(11) NOT NULL,
    'fullName' varchar(255) DEFAULT NULL,
    'address' longtext DEFAULT NULL,
    'city' varchar(255) DEFAULT NULL,
    'gender' varchar(255) DEFAULT NULL,
    'email' varchar(255) DEFAULT NULL,
    'password' varchar(255) DEFAULT NULL,
    'regisDate' timestamp NULL DEFAULT current_timestamp(),
    'updateDate' timestamp NULL DEFAULT NULL UPDATE current_timestamp();
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

