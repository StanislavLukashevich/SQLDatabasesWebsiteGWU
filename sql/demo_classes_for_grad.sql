SET @id = 99999999;

REPLACE INTO courses_taken (student_id, crn, grade) VALUES
-- CSCI 6221, B+
(@id, 21, "B+"),
-- CSCI 6232, A
(@id, 24, "A"),
-- CSCI 6233, A
(@id, 25, "A"),
-- CSCI 6241, A-
(@id, 26, "A-"),
-- CSCI 6242, A
(@id, 27, "A"),
-- CSCI 6283, B
(@id, 33, "B"),
-- CSCI 6284, B-
(@id, 34, "B-"),
-- CSCI 6286, C
(@id, 35, "C");
