CREATE TABLE IF NOT EXISTS org(org_id int PRIMARY KEY, org_name varchar(50), org_location varchar(200), phone bigint);
CREATE TABLE IF NOT EXISTS emp(emp_id int PRIMARY KEY, emp_name varchar(50), org_id int, phone bigint, email_id varchar(60), FOREIGN KEY (org_id) REFERENCES org(org_id));


INSERT INTO org (org_id, org_name, org_location, phone) VALUES (1, "Damodar College", "Margao", 9876543210);
INSERT INTO org VALUES (2, "Rosary College", "Margao", 9876543210);
UPDATE org SET org_location="Navelim" WHERE org_id=2;
UPDATE org SET phone=9988776655 WHERE org_id=2;

INSERT INTO emp VALUES (1, "Manoj", 1, 9911882273, "manoj@vvm.edu.in");
INSERT INTO emp VALUES (2, "Ram", 1, 8768765544, "ram@vvm.edu.in");
INSERT INTO emp VALUES (3, "Rohit", 2, 7897896655, "rohit@rosary.ac.in");
INSERT INTO emp VALUES (4, "Mohit", 2, 7897896655, "mohit@rosary.ac.in");

ALTER TABLE org DROP COLUMN phone;
CREATE TABLE IF NOT EXISTS org_phone(id int PRIMARY KEY, org_id int, phone bigint);

INSERT INTO org_phone VALUES (1, 1, 9876543210);
INSERT INTO org_phone VALUES (2, 1, 9988776655);
INSERT INTO org_phone VALUES (3, 2, 8877665544);
INSERT INTO org_phone VALUES (4, 2, 8899887766);

SELECT org_name, phone FROM org, org_phone where org.org_id=org_phone.org_id and org.org_id=1;
SELECT emp_name, org_name FROM emp, org WHERE org.org_id=emp.org_id and emp.emp_id=2;