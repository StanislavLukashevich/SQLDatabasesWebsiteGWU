SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS suser CASCADE;
CREATE TABLE suser (
  utype      varchar(10),
  uid        int auto_increment,
  uemail     varchar(30),
  passwd       varchar(30),
  primary key(uid)
  );

DROP TABLE IF EXISTS student CASCADE;
CREATE TABLE student (
  unid        int auto_increment,
  program     varchar(5),
  gpa         double(2,1),
  formid      int,
  advisorid   int,
  applied_to_grad  int,
  primary key (unid)
);


DROP TABLE IF EXISTS course CASCADE;
CREATE TABLE course (
 courseid      varchar(8),
 title         varchar(30),
 credits       int,
 prereqone     int,
 prereqtwo     int,
 primary key (courseid)
);


DROP TABLE IF EXISTS alumni CASCADE;
CREATE TABLE alumni (
  univid     int primary key,
  yeargrad   int
);


DROP TABLE IF EXISTS transcript CASCADE;
CREATE TABLE transcript (
  univerid   int,
  crseid     varchar(8),
  semester   varchar(10),
  yeartaken  int,
  grade      varchar(2),
  chours     int,
  primary key (univerid, crseid)
);

DROP TABLE IF EXISTS personalinfo CASCADE;
CREATE TABLE personalinfo (
  universid int primary key,
  ftname  varchar(20),
  ltname  varchar(20),
  dob     date,
  address varchar(50),
  cell    bigint
);

DROP TABLE IF EXISTS formone CASCADE;
CREATE TABLE formone (
  universityid   int,
  cid            varchar(8),
  primary key(universityid, cid)
);

DROP TABLE IF EXISTS faculty CASCADE;
CREATE TABLE faculty (
  facultyid   int,
  primary key(facultyid)
);


ALTER TABLE suser
ADD foreign key (uid) references student(unid);
ALTER TABLE suser
ADD foreign key (uid) references alumni(univid);
ALTER TABLE suser
ADD foreign key (uid) references personalinfo(universid);
ALTER TABLE alumni
ADD foreign key (univid) references personalinfo(universid);
ALTER TABLE student
ADD foreign key (unid) references transcript(univerid);
ALTER TABLE student
ADD foreign key (unid) references formone(universityid);
ALTER TABLE transcript
ADD foreign key (crseid) references course(courseid);




INSERT INTO suser VALUES ( 'student', 1, 'stlukashevich@gwu.edu', 'stan' );
INSERT INTO suser VALUES ( 'student', 55555555, 'mccartney@gwu.edu', 'mccartney' );
INSERT INTO suser VALUES ( 'student', 66666666, 'harrison@gwu.edu', 'harrison' );
INSERT INTO suser VALUES ( 'alumni', 77777777, 'eric@gwu.edu', 'eric' );
INSERT INTO suser VALUES ( 'advisor', 88888888, 'narahari@gwu.edu', 'narahari' );
INSERT INTO suser VALUES ( 'advisor', 99999999, 'parmer@gwu.edu', 'parmer' );
INSERT INTO suser VALUES ( 'gs', 2, 'jakejh@gwu.edu', 'jake' );
INSERT INTO suser VALUES ( 'admin', 12884853, 'jake@gwu.edu', 'jakeadmin' );

INSERT INTO student VALUES ( 1, 'PHD', 3.6, null, 88888888, 0);
INSERT INTO student VALUES ( 55555555, 'MS', 3.5, null, 88888888, 0);
INSERT INTO student VALUES ( 66666666, 'MS', 2.9, null, 99999999, 0);

INSERT INTO faculty VALUES ( 88888888);
INSERT INTO faculty VALUES ( 99999999);

INSERT INTO course VALUES ( 'CSCI6221', 'SW Paradigms', 3, null, null);
INSERT INTO course VALUES ( 'CSCI6461', 'Computer Architecture', 3, null, null);
INSERT INTO course VALUES ( 'CSCI6212', 'Algorithms', 3, null, null);
INSERT INTO course VALUES ( 'CSCI6220', 'Machine Learning', 3, null, null);
INSERT INTO course VALUES ( 'CSCI6232', 'Networks 1', 3, null, null);
INSERT INTO course VALUES ( 'CSCI6233', 'Networks 2', 3, 6232, null);
INSERT INTO course VALUES ( 'CSCI6241', 'Database 1', 3, null, null);
INSERT INTO course VALUES ( 'CSCI6242', 'Database 2', 3, 6241, null);
INSERT INTO course VALUES ( 'CSCI6246', 'Compilers', 3, 6461, 6212);
INSERT INTO course VALUES ( 'CSCI6260', 'Multimedia', 3, null, null);
INSERT INTO course VALUES ( 'CSCI6251', 'Cloud Computing', 3, 6461, null);
INSERT INTO course VALUES ( 'CSCI6254', 'SW Engineering', 3, 6221, null);
INSERT INTO course VALUES ( 'CSCI6262', 'Graphics 1', 3, null, null);
INSERT INTO course VALUES ( 'CSCI6283', 'Security 1', 3, 6212, null);
INSERT INTO course VALUES ( 'CSCI6284', 'Cryptography', 3, 6212, null);
INSERT INTO course VALUES ( 'CSCI6286', 'Network Security', 3, 6283, 6232);
INSERT INTO course VALUES ( 'CSCI6325', 'Algorithms 2', 3, 6212, null);
INSERT INTO course VALUES ( 'CSCI6339', 'Embedded Systems', 3, 6461, 6212);
INSERT INTO course VALUES ( 'CSCI6384', 'Cryptography 2', 3, 6284, null);
INSERT INTO course VALUES ( 'ECE6241',  'Communication Theory', 3, null, null);
INSERT INTO course VALUES ( 'ECE6242',  'Information Theory', 2, null, null);
INSERT INTO course VALUES ( 'MATH6210', 'Logic', 2, null, null);

INSERT INTO alumni VALUES ( 77777777, 2014);

INSERT INTO transcript VALUES (1, 'CSCI6221', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6461', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6212', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6220', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6232', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6233', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6241', 'Fall', 2014, 'B', 3);
INSERT INTO transcript VALUES (1, 'CSCI6242', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6251', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6254', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6262', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'ECE6241',  'Fall', 2019, 'A', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6221', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6212', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6461', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6232', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6223', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6241', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6246', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6262', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6283', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6242', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'ECE6242',  'Fall', 2014, 'C', 2);
INSERT INTO transcript VALUES (66666666, 'CSCI6221', 'Fall', 2014, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'CSCI6461', 'Fall', 2014, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'CSCI6212', 'Fall', 2014, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'CSCI6232', 'Fall', 2014, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'CSCI6233', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'CSCI6241', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'CSCI6242', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'CSCI6283', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'CSCI6284', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6221', 'Fall', 2013, 'B', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6212', 'Fall', 2013, 'B', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6461', 'Fall', 2013, 'B', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6232', 'Fall', 2013, 'B', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6233', 'Fall', 2013, 'B', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6241', 'Spring', 2014, 'A', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6242', 'Spring', 2014, 'A', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6283', 'Spring', 2014, 'A', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6284', 'Spring', 2014, 'A', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6286', 'Spring', 2014, 'A', 3);

INSERT INTO personalinfo VALUES (1, 'Stanislav', 'Lukashevich', '1998-12-12', 'Arlington, VA, 22206', 7036094317);
INSERT INTO personalinfo VALUES (55555555, 'Paul', 'McCartney', '1999-04-04', 'Atlanta, GA, 22666', 2024892713);
INSERT INTO personalinfo VALUES (66666666, 'George', 'Harrison', '1999-02-02', 'Boston, MA, 22777', 2024892714);
INSERT INTO personalinfo VALUES (77777777, 'Eric', 'Clapton', '1996-02-02', 'Washington, DC, 22236', 2024892715);
INSERT INTO personalinfo VALUES (88888888, 'Bhagirath', 'Narahari', '1966-12-12', 'Washington, DC, 22236', 2024892716);
INSERT INTO personalinfo VALUES (99999999, 'Eric', 'Clapton', '1981-02-02', 'Washington, DC, 22236', 2024892717);
INSERT INTO personalinfo VALUES (2, 'Jake', 'Harris', '1999-01-01', 'Atlanta, GA, 44436', 2024892718);


SET FOREIGN_KEY_CHECKS = 1;
