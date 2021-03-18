/* Possible decisions */
INSERT ignore INTO decisions (decisionID, description) VALUES
(0, 'Application incomplete'),
(1, 'Application complete and under review'),
(2, 'Admitted'),
(3, 'Admitted with aid'),
(4, 'Rejected'),
(5, 'Accepted offer of admission, awaiting payment'),
(6, 'Declined offer of admission'),
(7, 'Matriculated');

/* John Lennon - complete but no reviews */
INSERT IGNORE INTO application_form (applicationID, userID, degree, submitted, term, decision) VALUES 
(1, 15555555, "MS", 1, NOW(), 1);
INSERT ignore INTO transcript (applicationID, pathToFile, received) VALUES 
(1, 'fake-transcript.pdf', '2020-01-20');
INSERT ignore INTO rec_letter(letterID, applicationID, writerName, writerTitle, writerEmployer, writerEmail) VALUES
(1, 1, 'Test Recommender', 'Test Title', 'Test Employer', 'test@gmail.com');
INSERT ignore INTO GRE_score(applicationID, totalScore) VALUES (1, 200);

/* Ringo Starr - incomplete, no reviews */
INSERT IGNORE INTO application_form (userID, degree) VALUES (16666666, "MS");

/* Louis Armstrong - completed in 2017 and rejected */
INSERT IGNORE INTO application_form (userID, degree, submitted, term, decision) VALUES
(00001234, 'MS', 1, '2017-08-01', 4);
INSERT ignore INTO GRE_score(applicationID, totalScore) VALUES (3, 120);

/* Aretha Franklin - completed in 2017, admitted, did not accept */
INSERT IGNORE INTO application_form (userID, degree, submitted, term, decision) VALUES
(00001235, 'MS', 1, '2017-01-01', 6);
INSERT ignore INTO GRE_score(applicationID, totalScore) VALUES (4, 340);

/* Carlos Santana - completed in 2017, admitted, did not accept */
INSERT IGNORE INTO application_form (userID, degree, submitted, term, decision) VALUES
(00001236, 'PhD', 1, '2017-01-01', 6);
INSERT ignore INTO GRE_score(applicationID, totalScore) VALUES (5, 300);
