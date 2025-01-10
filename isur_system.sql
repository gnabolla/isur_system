-- 1) departments
CREATE TABLE `departments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2) users
CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `role` ENUM('faculty','student','admin','registrar') NOT NULL DEFAULT 'faculty',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` ENUM('pending','active','rejected') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3) faculties (references users.id, departments.id)
CREATE TABLE `faculties` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) DEFAULT NULL,
  `department_id` INT(11) NOT NULL,
  `firstname` VARCHAR(100) NOT NULL,
  `middlename` VARCHAR(100) DEFAULT NULL,
  `lastname` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `prefix` VARCHAR(50) DEFAULT NULL,
  `suffix` VARCHAR(50) DEFAULT NULL,
  `position_rank` VARCHAR(100) DEFAULT NULL,
  `employment_status` VARCHAR(50) DEFAULT NULL,
  `birthdate` DATE DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `id_number` VARCHAR(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faculties_user_id_fk` (`user_id`),
  KEY `fk_faculties_department` (`department_id`),
  CONSTRAINT `faculties_user_id_fk` 
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_faculties_department` 
    FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) 
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 4) programs (references departments.id)
CREATE TABLE `programs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `department_id` INT(11) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(50) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_programs_department` (`department_id`),
  CONSTRAINT `fk_programs_department`
    FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 5) curriculum (references programs.id)
CREATE TABLE `curriculum` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `program_id` INT(11) DEFAULT NULL,
  `version_label` VARCHAR(100) NOT NULL,
  `effectivity_sy` VARCHAR(50) DEFAULT NULL,
  `notes` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_curriculum_program` (`program_id`),
  CONSTRAINT `fk_curriculum_program`
    FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 6) subjects (references departments.id, programs.id)
CREATE TABLE `subjects` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(50) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `department_id` INT(11) DEFAULT NULL,
  `program_id` INT(11) DEFAULT NULL,
  `units` DECIMAL(4,1) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_subjects_department` (`department_id`),
  KEY `fk_subjects_program` (`program_id`),
  CONSTRAINT `fk_subjects_department`
    FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`)
    ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_subjects_program`
    FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 7) curriculum_subjects (references curriculum.id, subjects.id)
CREATE TABLE `curriculum_subjects` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `curriculum_id` INT(11) NOT NULL,
  `subject_id` INT(11) NOT NULL,
  `year_level` INT(11) NOT NULL,
  `semester` INT(11) NOT NULL,
  `is_lab` TINYINT(1) DEFAULT 0,
  `prerequisites` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `curriculum_id` (`curriculum_id`),
  KEY `subject_id` (`subject_id`),
  CONSTRAINT `curriculum_subjects_ibfk_1`
    FOREIGN KEY (`curriculum_id`) REFERENCES `curriculum` (`id`),
  CONSTRAINT `curriculum_subjects_ibfk_2`
    FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 8) school_years
CREATE TABLE `school_years` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `start_date` DATE DEFAULT NULL,
  `end_date` DATE DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 9) semesters (references school_years.id)
CREATE TABLE `semesters` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `sy_id` INT(11) NOT NULL,
  `semester_no` INT(11) NOT NULL,
  `label` VARCHAR(50) NOT NULL,
  `start_date` DATE DEFAULT NULL,
  `end_date` DATE DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sy_id` (`sy_id`),
  CONSTRAINT `semesters_ibfk_1`
    FOREIGN KEY (`sy_id`) REFERENCES `school_years` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 10) sections (references programs.id, semesters.id, curriculum.id)
CREATE TABLE `sections` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `program_id` INT(11) NOT NULL,
  `year_level` INT(11) NOT NULL,
  `section` VARCHAR(10) NOT NULL,
  `semester_id` INT(11) NOT NULL,
  `curriculum_id` INT(11) NOT NULL,
  `archived` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_sections_program` (`program_id`),
  KEY `semester_id` (`semester_id`),
  KEY `curriculum_id` (`curriculum_id`),
  CONSTRAINT `fk_sections_program`
    FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sections_ibfk_1`
    FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`),
  CONSTRAINT `sections_ibfk_2`
    FOREIGN KEY (`curriculum_id`) REFERENCES `curriculum` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 11) students (references users.id, sections.id, curriculum.id, programs.id)
CREATE TABLE `students` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) DEFAULT NULL,
  `firstname` VARCHAR(100) NOT NULL,
  `middlename` VARCHAR(100) DEFAULT NULL,
  `lastname` VARCHAR(100) NOT NULL,
  `program_id` INT(11) NOT NULL,
  `year_level` INT(11) DEFAULT NULL,
  `section_id` INT(11) DEFAULT NULL,
  `curriculum_id` INT(11) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `students_user_id_fk` (`user_id`),
  KEY `fk_students_program` (`program_id`),
  KEY `section_id` (`section_id`),
  KEY `curriculum_id` (`curriculum_id`),
  CONSTRAINT `students_user_id_fk`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_students_program`
    FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`)
    ON UPDATE CASCADE,
  CONSTRAINT `students_ibfk_1`
    FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  CONSTRAINT `students_ibfk_2`
    FOREIGN KEY (`curriculum_id`) REFERENCES `curriculum` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 12) enrollments (references students.id, subjects.id, semesters.id)
CREATE TABLE `enrollments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `student_id` INT(11) NOT NULL,
  `subject_id` INT(11) NOT NULL,
  `semester_id` INT(11) NOT NULL,
  `grade` VARCHAR(10) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `subject_id` (`subject_id`),
  KEY `semester_id` (`semester_id`),
  CONSTRAINT `enrollments_ibfk_1`
    FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  CONSTRAINT `enrollments_ibfk_2`
    FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  CONSTRAINT `enrollments_ibfk_3`
    FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 13) rooms
CREATE TABLE `rooms` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `room_type` ENUM('LAB','LECTURE') NOT NULL,
  `capacity` INT(11) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 14) schedules (references faculties.id, subjects.id, sections.id, rooms.id, semesters.id, programs.id)
CREATE TABLE `schedules` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `faculty_id` INT(11) NOT NULL,
  `subject_id` INT(11) NOT NULL,
  `section_id` INT(11) NOT NULL,
  `room_id` INT(11) NOT NULL,
  `semester_id` INT(11) NOT NULL,
  `program_id` INT(11) NOT NULL,
  `department_id` INT(11) NOT NULL,
  `school_year_id` INT(11) NOT NULL,
  `day` ENUM('Mon','Tue','Wed','Thu','Fri') NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `class_type` ENUM('lecture','lab') NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `faculty_id` (`faculty_id`),
  KEY `subject_id` (`subject_id`),
  KEY `section_id` (`section_id`),
  KEY `room_id` (`room_id`),
  KEY `semester_id` (`semester_id`),
  KEY `program_id` (`program_id`),
  CONSTRAINT `schedules_ibfk_1`
    FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`),
  CONSTRAINT `schedules_ibfk_2`
    FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  CONSTRAINT `schedules_ibfk_3`
    FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  CONSTRAINT `schedules_ibfk_4`
    FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  CONSTRAINT `schedules_ibfk_5`
    FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`),
  CONSTRAINT `fk_schedules_program_id`
    FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) 
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- (Optional) COMMIT if wrapped in a transaction
-- COMMIT;
