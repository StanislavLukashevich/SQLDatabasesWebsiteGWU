SET FOREIGN_KEY_CHECKS = 0;

/*************************
* START OF GLOBAL TABLES *
*************************/

-- user schema from REGS
DROP TABLE IF EXISTS users CASCADE;
create table users(
	id int UNIQUE,
	p_level varchar(20) NOT NULL,
	password varchar(20) NOT NULL,
	primary key (id)
);

DROP TABLE IF EXISTS student CASCADE;
create table student(
	u_id int NOT NULL,
	major varchar(20),
	program varchar(3),
    gpa double (2,1),
	formid int,
	advisorid int,
	applied_to_grad int,
	admit_year int,
	primary key (u_id),
	foreign key (u_id) references users(id),
	foreign key (u_id) references personal_info(user_id)
);

DROP TABLE IF EXISTS faculty CASCADE;
CREATE TABLE faculty(
	f_id int NOT NULL,
	dept varchar(4),
	primary key (f_id),
	foreign key (f_id) references users(id),
	foreign key (f_id) references personal_info(user_id)
);

DROP TABLE IF EXISTS personal_info CASCADE;
CREATE TABLE personal_info (
	user_id int primary key,
	fname varchar(20) NOT NULL,
	lname varchar(20) NOT NULL,
	dob date,
	address varchar(50),
	email varchar(25),
	foreign key (user_id) references users(id)
); 

/***********************
* END OF GLOBAL TABLES *
***********************/ 
/**********************
* START OF ADS TABLES *
**********************/

DROP TABLE IF EXISTS formone CASCADE;
CREATE TABLE formone (
	universityid   int,
	department     varchar(8),
  cnumber        int,
	primary key(universityid, department, cnumber),
	foreign key (universityid) references users (id)
);

DROP TABLE IF EXISTS alumni CASCADE;
CREATE TABLE alumni (
  univid     int primary key,
  yeargrad   int,
  program varchar(3),
  foreign key (univid) references users (id)
);

/********************
* END OF ADS TABLES *
********************/

/***********************
* START OF REGS TABLES *
***********************/

DROP TABLE IF EXISTS catalog CASCADE;
CREATE TABLE catalog(
	c_id int AUTO_INCREMENT,
	department varchar(20) NOT NULL,
	c_no int NOT NULL,
	title varchar(30) NOT NULL,
	credits int NOT NULL,
	primary key (c_id)
);

DROP TABLE IF EXISTS schedule CASCADE;
create table schedule(
crn int AUTO_INCREMENT,
course_id int NOT NULL,
section_no int NOT NULL,
semester varchar(20) NOT NULL,
year YEAR NOT NULL,
day char(1) NOT NULL,
start_time TIME NOT NULL,
end_time TIME NOT NULL,
primary key (crn),
foreign key (course_id) references catalog(c_id)
);

DROP TABLE IF EXISTS courses_taken CASCADE;
create table courses_taken(
student_id int NOT NULL,
crn int NOT NULL,
grade varchar(2) NOT NULL,
primary key (student_id, crn),
foreign key (student_id) references student(u_id),
foreign key (crn) references schedule(crn)
);

DROP TABLE IF EXISTS courses_taught CASCADE;
create table courses_taught(
f_id int NOT NULL,
crn int NOT NULL,
primary key (f_id, crn),
foreign key (f_id) references faculty(f_id),
foreign key (crn) references schedule(crn)
);

DROP TABLE IF EXISTS prereqs CASCADE;
create table prereqs(
course_Id int NOT NULL,
prereq1 varchar(20) NOT NULL,
prereq2 varchar(20) DEFAULT NULL,
primary key (course_Id, prereq1),
foreign key (course_Id) references catalog(c_id)
);

/*********************
* END OF REGS TABLES *
*********************/

/*********************
* START OF APPS TABLES *
*********************/
DROP TABLE IF EXISTS decisions CASCADE;
create table decisions (
	decisionID int(1),
	description varchar(140),

	primary key (decisionID)
);

/*application form
* main form has its own table and references to supplements
* Prior Degrees, test scores, and letters are referenced from application
* form */
DROP TABLE IF EXISTS application_form CASCADE;
create table application_form (
	applicationID int(8) AUTO_INCREMENT,
	address1 varchar(32),
	address2 varchar(32),
	city varchar(32),
	state varchar(2),
	zip int(5),
	userID int(8) UNIQUE,
	interest varchar(32),
	term varchar(32), -- this is a year and month
	degree varchar(32),
	submitted int(1) DEFAULT 0,
	decision int(1) DEFAULT 0,
	finalReviewer int(8) DEFAULT NULL,

	primary key (applicationID),
 	foreign key (userID) references users (id),
 	foreign key (finalReviewer) references users (id),
 	foreign key (decision) references decisions (decisionID)
);

DROP TABLE IF EXISTS transcript CASCADE;
create table transcript (
	applicationID int(8),
	pathToFile varchar(25),
	received DATE,

	primary key (applicationID, pathToFile),
	foreign key (applicationID) references application_form (applicationID)
);


/*application form
* main form has it's own table and references to supplements
* Prior Degrees, test scores, and letters are referenced from application
* form */

DROP TABLE IF EXISTS prior_degrees CASCADE;
create table prior_degrees (
	applicationID int(8),
	institution varchar(25),
	gpa decimal(3, 2),
	major varchar(25),
	gradYear int(4),
	degreeType varchar(10),

	primary key(applicationID, institution, degreeType, gradYear),
	foreign key (applicationID) references application_form (applicationID)
);

DROP TABLE IF EXISTS rec_letter CASCADE;
create table rec_letter (
	letterID int(4) AUTO_INCREMENT,
	applicationID int(8),
	writerName varchar(40),
	writerTitle varchar(100),
	writerEmployer varchar(40),
	writerEmail varchar(40),
	letter varchar(40) DEFAULT NULL,
	received DATE,

	primary key (letterID),
	foreign key (applicationID) references application_form (applicationID),
	unique (applicationID, writerEmail)
);

DROP TABLE IF EXISTS experience CASCADE;
create table experience (
	applicationID int(8),
	employer varchar(25),
	startDate DATE,
	endDate DATE,
	position varchar(25),
	description varchar(100),

	primary key(applicationID, employer, position),
	foreign key (applicationID) references application_form (applicationID)
);

DROP TABLE IF EXISTS GRE_score CASCADE;
create table GRE_score (
	applicationID int(8),
	totalScore int(3),
	examDate DATE,
	verbalScore int(3),
	writtenScore decimal(2, 1),
	quantScore int(3),

	primary key (applicationID, examDate),
	foreign key (applicationID) references application_form (applicationID)
);

DROP TABLE IF EXISTS TOEFL_score CASCADE;
create table TOEFL_score (
	applicationID int(8),
	examDate DATE,
	totalScore int(8),

	primary key (applicationID, examDate),
	foreign key (applicationID) references application_form (applicationID)
);

DROP TABLE IF EXISTS Adv_GRE CASCADE;
create table Adv_GRE (
	applicationID int(8),
	examDate DATE,
	totalScore int(8),
	subject varchar(32),


	primary key (applicationID, examDate),
	foreign key (applicationID) references application_form (applicationID)
);


/*create tables for letter review and review form
* to be filled out by faculty reviewers */
DROP TABLE IF EXISTS letter_rating CASCADE;
create table letter_rating (
	facultyID int(8),
	letterID int(4),
	credible varchar(1),
	generic varchar(1),
	score int(4),

	primary key (facultyID, letterID),
	foreign key (facultyID) references faculty (f_id),
	foreign key (letterID) references rec_letter (letterID)
);

/* seperate table for deficient courses prevents update anomalies
* to add a deficient course for an applicant we would need to seach
* all of the review table */
DROP TABLE IF EXISTS deficient_courses CASCADE;
create table deficient_courses (
	applicationID int(8),
	course_id int(4) NOT NULL,

	primary key (applicationID, course_id),
	foreign key (applicationID) references application_form (applicationID)
);

DROP TABLE IF EXISTS review_form CASCADE;
create table review_form (
	facultyID int(8),
	applicationID int(8),
	letterRating int(4),
	suggested_decision varchar(40),
	reasons varchar(100),
	comments varchar(100),

	primary key (facultyID, applicationID),
	constraint FK_revForm0 foreign key (facultyID) references faculty (f_id) ON UPDATE CASCADE ON DELETE NO ACTION,
	constraint FK_revForm1 foreign key (applicationID) references application_form (applicationID) ON UPDATE CASCADE ON DELETE CASCADE,
	constraint FK_revForm2 foreign key (letterRating) references letter_rating (letterID) ON UPDATE CASCADE ON DELETE NO ACTION
);

DROP TABLE IF EXISTS final_decision CASCADE;
create table final_decision (
	facultyID int(8),
	applicantID int(8),
	decision int(4),
	recommendedAdvisor int(8),

	primary key (facultyID, applicantID),
	foreign key (facultyID) references users (id),
	foreign key (recommendedAdvisor) references faculty (f_id),
	foreign key (applicantID) references users (id)
);

/*********************
* END OF APPS TABLES *
*********************/

SET FOREIGN_KEY_CHECKS = 1;
