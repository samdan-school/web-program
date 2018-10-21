DROP DATABASE IF EXISTS student_app_04;

CREATE DATABASE IF NOT EXISTS student_app_04;
USE student_app_04;

-- Creating table student, program, course, course_enrollment 
CREATE TABLE student (
    student_id VARCHAR(4),
    last_name VARCHAR(20),
    first_name VARCHAR(20),
    sex VARCHAR(1),
    dob DATE,
    fk_program_id VARCHAR(4),    
   
    CONSTRAINT student_pk
    	PRIMARY KEY (student_id)
);

CREATE TABLE program (
    program_id VARCHAR(4),
    program_name VARCHAR(40),
    -- doe = date of establishment
    doe DATE,

    CONSTRAINT program_pk
    	PRIMARY KEY (program_id)
);

CREATE TABLE course (
    course_id VARCHAR(4),
    course_name VARCHAR(30),
    credit TINYINT,
   
    CONSTRAINT course_pk
    	PRIMARY KEY (course_id)
);

CREATE TABLE course_enrollment (
    student_id VARCHAR(4),
    course_id VARCHAR(4),
   
    CONSTRAINT course_enrollment_pk
    	PRIMARY KEY (student_id, course_id)
);

CREATE TABLE staff (
	staff_id VARCHAR(4),
    last_name VARCHAR(20),
    first_name VARCHAR(20),
    position CHAR(30),
	-- Data of working - ajild orson udur
    dow DATE,
   
    CONSTRAINT staff_pk
    	PRIMARY KEY (staff_id)
);

CREATE TABLE users (
	user_id VARCHAR(4),
	password VARCHAR(255),
   
    CONSTRAINT user_pk
    	PRIMARY KEY (user_id)
);

-- inserting values into programs
INSERT INTO program VALUES
('pcs1', 'Computer Science', '2000-01-15'),
('pph2', 'Physics', '2005-04-01'),
('pmt3', 'Mathematics Engineering', '1998-02-27');

-- inserting values into student
INSERT INTO student VALUES
('sab1', 'Petr', 'Ferrar', 'M', '1997-10-11/', 'pcs1'),
('sab2', 'Zorn', 'Herta', 'F', '2000-11-14/', 'pcs1'),
('sab3', 'Perl', 'Ardyth', 'F', '1998-3-21/', 'pph2'),
('sab4', 'Brett', 'Elora', 'F', '1998-1-25/', 'pph2'),
('sab5', 'Nicko', 'Babbie', 'M', '1999-5-16', 'pmt3');

-- inserting values into course
INSERT INTO course VALUES
('ccs0', 'Intro to Computer Science', 2),
('ccs1', 'Advanced Algorithm', 3),
('cmt1', 'Math 1b', 3),
('cph1', 'Engineering Physics', 3);

-- inserting values into course_enrollment
INSERT INTO course_enrollment VALUES
('sab1', 'ccs0'),
('sab1', 'ccs1'),
('sab1', 'cmt1'),
('sab2', 'ccs0'),
('sab2', 'ccs1'),
('sab3', 'ccs0'),
('sab3', 'cmt1'),
('sab3', 'cph1'),
('sab4', 'cmt1'),
('sab4', 'cph1'),
('sab5', 'ccs0'),
('sab5', 'ccs1'),
('sab5', 'cmt1'),
('sab5', 'cph1');

-- inserting values into staff
INSERT INTO staff VALUES
('aab1', 'Zen', 'Mituki', 'M', '1990-01-01'),
('acd2', 'Tomita', 'Fumiko', 'F', '1992-09-26'),
('aef3', 'Akira', 'Daichi', 'M', '1989-11-19');

-- Alter table to insert FKs
ALTER TABLE student
	ADD CONSTRAINT fk_student_program
	FOREIGN KEY (fk_program_id) REFERENCES program(program_id)
	ON UPDATE CASCADE
	ON DELETE CASCADE;
    
ALTER TABLE course_enrollment
	ADD CONSTRAINT fk_course_enrollment_student
	FOREIGN KEY (student_id) REFERENCES student(student_id)
	ON UPDATE CASCADE
	ON DELETE CASCADE;
    
ALTER TABLE course_enrollment
	ADD CONSTRAINT fk_course_enrollment_course
	FOREIGN KEY (course_id) REFERENCES course(course_id)
	ON UPDATE CASCADE
	ON DELETE CASCADE;