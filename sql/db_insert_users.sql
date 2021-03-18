/******************************
 * p_level definitions *
 ******************************
0=admin
1=graduate secretary
2=chair
3=applicant
4=student
5=alumni
6=instructor
7=faculty review
8=faculty advisor
******************************/

SET FOREIGN_KEY_CHECKS = 0;

/******************************
 * Inserting ADMIN, GS, CHAIR *
 ******************************/

-- Admin
INSERT INTO users (id, p_level, password) VALUES (10000000, "0", "admin");
INSERT INTO personal_info (user_id, fname, lname) VALUES (10000000, "", "");

-- GS
INSERT INTO users (id, p_level, password) VALUES (10000001, "1", "gs");
INSERT INTO personal_info (user_id, fname, lname) VALUES (10000001, "", "");

-- Chair
INSERT INTO users (id, p_level, password) VALUES (10000002, "2", "chair");
INSERT INTO personal_info (user_id, fname, lname) VALUES (10000002, "Robert", "Pless");

/************************
 * Inserting APPLICANTS *
 ************************/

-- John Lennon
INSERT INTO users (id, p_level, password) VALUES (15555555, "3", "JohnLennon"
);
INSERT INTO personal_info (user_id, fname, lname) VALUES (15555555, "John", "Lennon");

-- Ringo Starr
INSERT INTO users (id, p_level, password) VALUES (16666666, "3", "RingoStarr");
INSERT INTO personal_info (user_id, fname, lname) VALUES (16666666, "Ringo", "Starr");

-- Louis Armstrong
INSERT INTO users (id, p_level, password) VALUES (00001234, "3", "LouisArmstrong");
INSERT INTO personal_info (user_id, fname, lname) VALUES (00001234, "Louis", "Armstrong");

-- Aretha Franklin
INSERT INTO users (id, p_level, password) VALUES (00001235, "3", "ArethaFranklin");
INSERT INTO personal_info (user_id, fname, lname) VALUES (00001235, "Aretha", "Franklin");

-- Carlos Santana
INSERT INTO users (id, p_level, password) VALUES (00001236, "3", "CarlosSantana");
INSERT INTO personal_info (user_id, fname, lname) VALUES (00001236, "Carlos", "Santana");


/**********************
 * Inserting STUDENTS *
 **********************/

-- Billie Holiday
INSERT INTO users (id, p_level, password) VALUES (88888888, "4", "BillieHoliday");
INSERT INTO personal_info (user_id, fname, lname) VALUES (88888888, "Billie", "Holiday");
INSERT INTO student (u_id, program, advisorid, admit_year) VALUES (88888888, "MS", 12340007, 2018);

INSERT INTO courses_taken (student_id, crn, grade) VALUES 
(88888888, 22, "IP"),
(88888888, 23, "IP");

-- Diana Krall 
INSERT INTO users (id, p_level, password) VALUES (99999999, "4", "DianaKrall");
INSERT INTO personal_info (user_id, fname, lname) VALUES (99999999, "Diana", "Krall");
INSERT INTO student (u_id, program, advisorid, admit_year) VALUES (99999999, "MS", 12340004, 2019);

-- Ella Fitzgerald
INSERT INTO users (id, p_level, password) VALUES (23456789, "4", "EllaFitzgerald");
INSERT INTO personal_info (user_id, fname, lname) VALUES (23456789, "Ella", "Fitzgerald");
INSERT INTO student (u_id, program, advisorid, admit_year) VALUES (23456789, "PhD", 12340002, 2019);

-- Eva Cassidy
INSERT INTO users (id, p_level, password) VALUES (87654321, "4", "EvaCassidy");
INSERT INTO personal_info (user_id, fname, lname) VALUES (87654321, "Eva", "Cassidy");
INSERT INTO student (u_id, program, advisorid, admit_year) VALUES (87654321, "MS", 12340006, 2017);

INSERT INTO courses_taken (student_id, crn, grade) VALUES 
(87654321, 1, "A"),
(87654321, 2, "A"),
(87654321, 3, "A"),
(87654321, 4, "A"),
(87654321, 5, "A"),
(87654321, 14, "A"),
(87654321, 15, "A"),
(87654321, 6, "C"),
(87654321, 8, "C"),
(87654321, 12, "C");

INSERT INTO formone (universityid, department, cnumber) VALUES (87654321, "CSCI", 6221);
INSERT INTO formone (universityid, department, cnumber) VALUES (87654321, "CSCI", 6212);
INSERT INTO formone (universityid, department, cnumber) VALUES (87654321, "CSCI", 6461);
INSERT INTO formone (universityid, department, cnumber) VALUES (87654321, "CSCI", 6232);
INSERT INTO formone (universityid, department, cnumber) VALUES (87654321, "CSCI", 6233);
INSERT INTO formone (universityid, department, cnumber) VALUES (87654321, "CSCI", 6284);
INSERT INTO formone (universityid, department, cnumber) VALUES (87654321, "CSCI", 6286);
INSERT INTO formone (universityid, department, cnumber) VALUES (87654321, "CSCI", 6241);
INSERT INTO formone (universityid, department, cnumber) VALUES (87654321, "CSCI", 6246);
INSERT INTO formone (universityid, department, cnumber) VALUES (87654321, "CSCI", 6262);

-- Jimi Hendrix
INSERT INTO users (id, p_level, password) VALUES (45678901, "4", "JimiHendrix");
INSERT INTO personal_info (user_id, fname, lname) VALUES (45678901, "Jimi", "Hendrix");
INSERT INTO student (u_id, program, advisorid, admit_year) VALUES (45678901, "MS", 12340005, 2017);

INSERT INTO courses_taken (student_id, crn, grade) VALUES 
(45678901, 1, "A"),
(45678901, 2, "A"),
(45678901, 3, "A"),
(45678901, 4, "A"),
(45678901, 5, "A"),
(45678901, 6, "A"),
(45678901, 14, "A"),
(45678901, 15, "A"),
(45678901, 17, "B"),
(45678901, 18, "B"),
(45678901, 19, "B");

-- Paul McCartney
INSERT INTO users (id, p_level, password) VALUES (55555555, "4", "PaulMcCartney");
INSERT INTO personal_info (user_id, fname, lname) VALUES (55555555, "Paul", "McCartney");
INSERT INTO student (u_id, program, advisorid, admit_year) VALUES (55555555, "MS", 12340002, 2017);

INSERT INTO courses_taken (student_id, crn, grade) VALUES 
(55555555, 1, "A"),
(55555555, 2, "A"),
(55555555, 3, "A"),
(55555555, 4, "A"),
(55555555, 5, "A"),
(55555555, 6, "B"),
(55555555, 7, "B"),
(55555555, 8, "B"),
(55555555, 12, "B"),
(55555555, 13, "B");

INSERT INTO formone (universityid, department, cnumber) VALUES (55555555, "CSCI", 6221);
INSERT INTO formone (universityid, department, cnumber) VALUES (55555555, "CSCI", 6212);
INSERT INTO formone (universityid, department, cnumber) VALUES (55555555, "CSCI", 6461);
INSERT INTO formone (universityid, department, cnumber) VALUES (55555555, "CSCI", 6232);
INSERT INTO formone (universityid, department, cnumber) VALUES (55555555, "CSCI", 6233);
INSERT INTO formone (universityid, department, cnumber) VALUES (55555555, "CSCI", 6283);
INSERT INTO formone (universityid, department, cnumber) VALUES (55555555, "CSCI", 6242);
INSERT INTO formone (universityid, department, cnumber) VALUES (55555555, "CSCI", 6241);
INSERT INTO formone (universityid, department, cnumber) VALUES (55555555, "CSCI", 6246);
INSERT INTO formone (universityid, department, cnumber) VALUES (55555555, "CSCI", 6262);

-- George Harrison
INSERT INTO users (id, p_level, password) VALUES (66666666, "4", "GeorgeHarrison");
INSERT INTO personal_info (user_id, fname, lname) VALUES (66666666, "George", "Harrison");
INSERT INTO student (u_id, program, advisorid, admit_year) VALUES (66666666, "MS", 12340005, 2016);

INSERT INTO courses_taken (student_id, crn, grade) VALUES 
(66666666, 18, "C"),
(66666666, 1, "B"),
(66666666, 2, "B"),
(66666666, 3, "B"),
(66666666, 4, "B"),
(66666666, 5, "B"),
(66666666, 6, "B"),
(66666666, 7, "B"),
(66666666, 13, "B"),
(66666666, 14, "B");

-- Stevie Nicks
INSERT INTO users (id, p_level, password) VALUES (12345678, "4", "StevieNicks");
INSERT INTO personal_info (user_id, fname, lname, email) VALUES (12345678, "Stevie", "Nicks", "nicks@gwu.edu");
INSERT INTO student (u_id, program, advisorid, admit_year) VALUES (12345678, "PhD", 12340007, 2017);

INSERT INTO courses_taken (student_id, crn, grade) VALUES 
(12345678, 1, "A"),
(12345678, 2, "A"),
(12345678, 3, "A"),
(12345678, 4, "A"),
(12345678, 5, "A"),
(12345678, 6, "B"),
(12345678, 7, "B"),
(12345678, 8, "B"),
(12345678, 12, "B"),
(12345678, 13, "B"),
(12345678, 14, "A"),
(12345678, 15, "A");

INSERT INTO formone (universityid, department, cnumber) VALUES (12345678, "CSCI", 6221);
INSERT INTO formone (universityid, department, cnumber) VALUES (12345678, "CSCI", 6212);
INSERT INTO formone (universityid, department, cnumber) VALUES (12345678, "CSCI", 6461);
INSERT INTO formone (universityid, department, cnumber) VALUES (12345678, "CSCI", 6232);
INSERT INTO formone (universityid, department, cnumber) VALUES (12345678, "CSCI", 6233);
INSERT INTO formone (universityid, department, cnumber) VALUES (12345678, "CSCI", 6284);
INSERT INTO formone (universityid, department, cnumber) VALUES (12345678, "CSCI", 6242);
INSERT INTO formone (universityid, department, cnumber) VALUES (12345678, "CSCI", 6241);
INSERT INTO formone (universityid, department, cnumber) VALUES (12345678, "CSCI", 6246);
INSERT INTO formone (universityid, department, cnumber) VALUES (12345678, "CSCI", 6262);
INSERT INTO formone (universityid, department, cnumber) VALUES (12345678, "CSCI", 6283);


/********************
 * Inserting ALUMNI *
 ********************/

-- Eric Clapton
INSERT INTO users (id, p_level, password) VALUES (77777777, "5", "EricClapton");
INSERT INTO personal_info (user_id, fname, lname, email) VALUES (77777777, "Eric", "Clapton", "clapton@gwu.edu");
INSERT INTO alumni (univid, yeargrad, program) VALUES (77777777, 2014, "MS");

INSERT INTO courses_taken (student_id, crn, grade) VALUES 
(77777777, 1, "B"),
(77777777, 2, "B"),
(77777777, 3, "B"),
(77777777, 5, "B"),
(77777777, 6, "B"),
(77777777, 7, "B"),
(77777777, 8, "B"),
(77777777, 14, "A"),
(77777777, 15, "A"),
(77777777, 16, "A");

-- Kurt Cobain
INSERT INTO users (id, p_level, password) VALUES (34567890, "5", "KurtCobain");
INSERT INTO personal_info (user_id, fname, lname, email) VALUES (34567890, "Kurt", "Cobain", "cobain@gwu.edu");
INSERT INTO alumni (univid, yeargrad, program) VALUES (34567890, 2015, "PhD");

INSERT INTO courses_taken (student_id, crn, grade) VALUES 
(34567890, 1, "A"),
(34567890, 2, "A"),
(34567890, 3, "A"),
(34567890, 5, "A"),
(34567890, 6, "A"),
(34567890, 7, "A"),
(34567890, 14, "A"),
(34567890, 15, "A"),
(34567890, 16, "A"),
(34567890, 8, "B"),
(34567890, 11, "B"),
(34567890, 12, "B");


/*********************
 * Inserting FACULTY *
 *********************/

-- Bhagi Narahari
INSERT INTO users (id, p_level, password) VALUES (12340002, "678", "BhagiNarahari");
INSERT INTO personal_info (user_id, fname, lname) VALUES (12340002, "Bhagi", "Narahari");
INSERT INTO faculty (f_id, dept) VALUES (12340002, "CSCI");

INSERT INTO courses_taught (f_id, crn) VALUES 
-- F19
(12340002, 1),
(12340002, 2),
(12340002, 9),
(12340002, 10),
(12340002, 11),

-- S20
(12340002, 21),
(12340002, 22),
(12340002, 29),
(12340002, 30),
(12340002, 31),

-- F20
(12340002, 41),
(12340002, 42),
(12340002, 49),
(12340002, 50),
(12340002, 51);

-- Hyeong-Ah Choi
INSERT INTO users (id, p_level, password) VALUES (12340003, "6", "Hyeong-AhChoi");
INSERT INTO personal_info (user_id, fname, lname) VALUES (12340003, "Hyeong-Ah", "Choi");
INSERT INTO faculty (f_id, dept) VALUES (12340003, "CSCI");

INSERT INTO courses_taught (f_id, crn) VALUES
-- F19
(12340003, 3),
(12340003, 4),
(12340003, 5),
(12340003, 12),
(12340003, 13),

-- S20
(12340003, 23),
(12340003, 24),
(12340003, 25),
(12340003, 32),
(12340003, 33),

-- F20
(12340003, 43),
(12340003, 44),
(12340003, 45),
(12340003, 52),
(12340003, 53);

-- Gabe Parmer
INSERT INTO users (id, p_level, password) VALUES (12340004, "8", "GabeParmer");
INSERT INTO personal_info (user_id, fname, lname) VALUES (12340004, "Gabe", "Parmer");
INSERT INTO faculty (f_id, dept) VALUES (12340004, "CSCI");

-- Tim Wood
INSERT INTO users (id, p_level, password) VALUES (12340005, "67", "TimWood");
INSERT INTO personal_info (user_id, fname, lname) VALUES (12340005, "Tim", "Wood");
INSERT INTO faculty (f_id, dept) VALUES (12340005, "CSCI");

INSERT INTO courses_taught (f_id, crn) VALUES 
-- F19
(12340005, 6),
(12340005, 8),
(12340005, 14),
(12340005, 15),
(12340005, 16),

-- S20
(12340005, 26),
(12340005, 28),
(12340005, 34),
(12340005, 35),
(12340005, 36),

-- F20
(12340005, 46),
(12340005, 48),
(12340005, 54),
(12340005, 55),
(12340005, 56);

-- Shelly Heller
INSERT INTO users (id, p_level, password) VALUES (12340006, "7", "ShellyHeller");
INSERT INTO personal_info (user_id, fname, lname) VALUES (12340006, "Shelly", "Heller");
INSERT INTO faculty (f_id, dept) VALUES (12340006, "CSCI");

-- Sarah Morin
INSERT INTO users (id, p_level, password) VALUES (12340007, "8", "SarahMorin");
INSERT INTO personal_info (user_id, fname, lname) VALUES (12340007, "Sarah", "Morin");
INSERT INTO faculty (f_id, dept) VALUES (12340007, "CSCI");

-- Kevin Deems
INSERT INTO users (id, p_level, password) VALUES (12340008, "6", "KevinDeems");
INSERT INTO personal_info (user_id, fname, lname) VALUES (12340008, "Kevin", "Deems");
INSERT INTO faculty (f_id, dept) VALUES (12340008, "CSCI");

INSERT INTO courses_taught (f_id, crn) VALUES 
-- F19
(12340008, 7),
(12340008, 17),
(12340008, 18),
(12340008, 19),
(12340008, 20),

-- S20
(12340008, 27),
(12340008, 37),
(12340008, 38),
(12340008, 39),
(12340008, 40),

-- F20
(12340008, 47),
(12340008, 57),
(12340008, 58),
(12340008, 59),
(12340008, 60);

SET FOREIGN_KEY_CHECKS = 1;
