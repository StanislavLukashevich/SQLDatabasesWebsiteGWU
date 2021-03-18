-- Per year and degree...

-- Get the number of applicants 
SELECT 
	application_form.userID, 
	application_form.term, 
	application_form.degree, 
	YEAR(application_form.term) AS year,
	COUNT(DISTINCT userID) AS num_applicants,
	AVG(GRE_score.totalScore) AS avg_gre
FROM application_form
JOIN personal_info ON application_form.userID = personal_info.user_id
LEFT JOIN GRE_score ON application_form.applicationID = GRE_score.applicationID
GROUP BY year, application_form.degree;

-- Get the number of rejects 
SELECT 
	application_form.userID, 
	application_form.term, 
	application_form.degree, 
	YEAR(application_form.term) AS year,
	COUNT(DISTINCT userID) AS num_rejects,
	AVG(GRE_score.totalScore) AS avg_gre
FROM application_form
JOIN personal_info ON application_form.userID = personal_info.user_id
LEFT JOIN GRE_score ON application_form.applicationID = GRE_score.applicationID
WHERE application_form.decision = 4
GROUP BY year, application_form.degree;

-- get the number of acceptances
SELECT 
	application_form.userID, 
	application_form.term, 
	application_form.degree, 
	YEAR(application_form.term) AS year,
	COUNT(DISTINCT userID) AS num_admits,
	AVG(GRE_score.totalScore) AS avg_gre
FROM application_form
JOIN personal_info ON application_form.userID = personal_info.user_id
LEFT JOIN GRE_score ON application_form.applicationID = GRE_score.applicationID
WHERE application_form.decision = 2 OR application_form.decision = 3 OR application_form.decision > 4
GROUP BY year, application_form.degree;