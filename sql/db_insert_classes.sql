/***********************************
 * Insert classes into the catalog *
 **********************************/
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6221, 'SW Paradigms', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6461, 'Computer Architecture', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6212, 'Algorithms', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6220, 'Machine Learning', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6232, 'Networks 1', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6233, 'Networks 2', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6241, 'Database 1', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6242, 'Database 2', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6246, 'Compilers', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6260, 'Multimedia', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6251, 'Cloud Computing', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6254, 'SW Engineering', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6262, 'Graphics 1', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6283, 'Security 1', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6284, 'Cryptography', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6286, 'Network Security', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6325, 'Algorithms 2', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6339, 'Embedded Systems', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6384, 'Cryptography 2', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('ECE', 6241, 'Communication Theory', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('ECE', 6242, 'Information Theory', 2);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('MATH', 6210, 'Logic', 2);

/************************************
 * Insert classes into the schedule *
 ***********************************/
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (1, 1, 'Fall', 2019, 'M', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (2, 1, 'Fall', 2019, 'T', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (3, 1, 'Fall', 2019, 'W', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (5, 1, 'Fall', 2019, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (6, 1, 'Fall', 2019, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (7, 1, 'Fall', 2019, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (8, 1, 'Fall', 2019, 'R', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (9, 1, 'Fall', 2019, 'T', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (11, 1, 'Fall', 2019, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (12, 1, 'Fall', 2019, 'M', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (10, 1, 'Fall', 2019, 'R', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (13, 1, 'Fall', 2019, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (14, 1, 'Fall', 2019, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (15, 1, 'Fall', 2019, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (16, 1, 'Fall', 2019, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (19, 1, 'Fall', 2019, 'W', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (20, 1, 'Fall', 2019, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (21, 1, 'Fall', 2019, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (22, 1, 'Fall', 2019, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (18, 1, 'Fall', 2019, 'R', '16:00', '18:30');


INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (1, 1, 'Spring', 2020, 'M', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (2, 1, 'Spring', 2020, 'T', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (3, 1, 'Spring', 2020, 'W', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (5, 1, 'Spring', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (6, 1, 'Spring', 2020, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (7, 1, 'Spring', 2020, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (8, 1, 'Spring', 2020, 'R', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (9, 1, 'Spring', 2020, 'T', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (11, 1, 'Spring', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (12, 1, 'Spring', 2020, 'M', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (10, 1, 'Spring', 2020, 'R', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (13, 1, 'Spring', 2020, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (14, 1, 'Spring', 2020, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (15, 1, 'Spring', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (16, 1, 'Spring', 2020, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (19, 1, 'Spring', 2020, 'W', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (20, 1, 'Spring', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (21, 1, 'Spring', 2020, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (22, 1, 'Spring', 2020, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (18, 1, 'Spring', 2020, 'R', '16:00', '18:30');

INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (1, 1, 'Fall', 2020, 'M', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (2, 1, 'Fall', 2020, 'T', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (3, 1, 'Fall', 2020, 'W', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (5, 1, 'Fall', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (6, 1, 'Fall', 2020, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (7, 1, 'Fall', 2020, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (8, 1, 'Fall', 2020, 'R', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (9, 1, 'Fall', 2020, 'T', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (11, 1, 'Fall', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (12, 1, 'Fall', 2020, 'M', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (10, 1, 'Fall', 2020, 'R', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (13, 1, 'Fall', 2020, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (14, 1, 'Fall', 2020, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (15, 1, 'Fall', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (16, 1, 'Fall', 2020, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (19, 1, 'Fall', 2020, 'W', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (20, 1, 'Fall', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (21, 1, 'Fall', 2020, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (22, 1, 'Fall', 2020, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (18, 1, 'Fall', 2020, 'R', '16:00', '18:30');

/**********************
 * Insert the prereqs *
 *********************/
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (6, 'CSCI 6232', NULL);
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (8, 'CSCI 6241', NULL);
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (9, 'CSCI 6461', 'CSCI 6212');
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (11, 'CSCI 6241', NULL);
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (12, 'CSCI 6221', NULL);
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (14, 'CSCI 6212', NULL);
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (15, 'CSCI 6212', NULL);
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (16, 'CSCI 6283', 'CSCI 6232');
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (17, 'CSCI 6212', NULL);
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (18, 'CSCI 6461','CSCI 6212');
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (19, 'CSCI 6284', NULL);
