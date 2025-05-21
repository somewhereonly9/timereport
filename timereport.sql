-- =================================================================================
-- 1) Roles, Teams y Usuarios
-- =================================================================================

-- 1.1 Roles (merge de timereport_roles + category)
CREATE TABLE IF NOT EXISTS roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 1.2 Equipos de Trabajo
CREATE TABLE IF NOT EXISTS teams (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_teams_name(name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 1.3 Usuarios (merge de timereport_users + casetraking.users, incluyendo abogados)
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email           VARCHAR(255) NOT NULL,
  password        VARCHAR(255),
  first_name      VARCHAR(100),
  last_name       VARCHAR(100),
  role_id         INT,
  team_id         INT,
  created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  last_updated    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (role_id) REFERENCES roles(id),
  FOREIGN KEY (team_id) REFERENCES teams(id),
  INDEX idx_users_role(role_id),
  INDEX idx_users_team(team_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =================================================================================
-- 2) Compañías y Catálogos Auxiliares
-- =================================================================================

-- 2.1 Tipos de Compañía (equivalente a typeCompany)
CREATE TABLE IF NOT EXISTS type_company (
  id INT AUTO_INCREMENT PRIMARY KEY,
  description VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2.2 Compañías / Clientes (merge de timereport_clients + casetraking.companys)
CREATE TABLE IF NOT EXISTS companies (
  id             INT AUTO_INCREMENT PRIMARY KEY,
  code           VARCHAR(50),
  name           VARCHAR(100),
  rfc            VARCHAR(45),
  address        VARCHAR(255),
  contact_person VARCHAR(100),
  email          VARCHAR(255),
  phone          VARCHAR(20),
  type_id        INT,
  created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  last_updated   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (type_id) REFERENCES type_company(id),
  INDEX idx_companies_type(type_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =================================================================================
-- 3) Catálogos Legales
-- =================================================================================

-- 3.1 Actors
CREATE TABLE IF NOT EXISTS actors (
  idactors         INT AUTO_INCREMENT PRIMARY KEY,
  name             VARCHAR(45),
  telephone_number VARCHAR(45)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3.2 Stages
CREATE TABLE IF NOT EXISTS stages (
  idstages INT AUTO_INCREMENT PRIMARY KEY,
  name     VARCHAR(45),
  valor    INT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3.3 Defendants (renombrada para consistencia)
CREATE TABLE IF NOT EXISTS defendants (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  name       VARCHAR(45),
  position   VARCHAR(45),
  company_id INT NOT NULL,
  FOREIGN KEY (company_id) REFERENCES companies(id),
  INDEX idx_defendants_company(company_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =================================================================================
-- 4) Autoridades (tribunal, junta de conciliación, etc.)
-- =================================================================================

CREATE TABLE IF NOT EXISTS authorities (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  name          VARCHAR(255) NOT NULL,
  description   TEXT,
  municipio     VARCHAR(100),
  estado        VARCHAR(100),
  direccion     VARCHAR(255),
  codigo_postal VARCHAR(20),
  telefono      VARCHAR(20),
  INDEX idx_authorities_name(name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =================================================================================
-- 5) Casos y Proyectos
-- =================================================================================

-- 5.1 Casos (expedientes legales)
CREATE TABLE IF NOT EXISTS cases (
  idCase        INT AUTO_INCREMENT PRIMARY KEY,
  folio         VARCHAR(45) NOT NULL,
  fecha         DATETIME,
  actor         INT,
  lawyer        INT,
  stage         INT,
  defendant     INT,
  company       INT,
  authority_id  INT,
  FOREIGN KEY (actor)      REFERENCES actors(idactors),
  FOREIGN KEY (lawyer)     REFERENCES users(id),
  FOREIGN KEY (stage)      REFERENCES stages(idstages),
  FOREIGN KEY (defendant)  REFERENCES defendants(id),
  FOREIGN KEY (company)    REFERENCES companies(id),
  FOREIGN KEY (authority_id) REFERENCES authorities(id),
  INDEX idx_cases_actor(actor),
  INDEX idx_cases_lawyer(lawyer),
  INDEX idx_cases_stage(stage),
  INDEX idx_cases_defendant(defendant),
  INDEX idx_cases_company(company),
  INDEX idx_cases_authority(authority_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5.2 Proyectos (etapas/partes del caso: amparos, asesorías, audiencias, etc.)
CREATE TABLE IF NOT EXISTS projects (
  id             INT AUTO_INCREMENT PRIMARY KEY,
  code           VARCHAR(50),
  name           VARCHAR(255),
  description    TEXT,
  date           DATE,
  created_by     INT,
  FOREIGN KEY (created_by) REFERENCES users(id),
  INDEX idx_projects_created_by(created_by)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =================================================================================
-- 6) Tareas, Calendario, Horas y Actualizaciones de Caso
-- =================================================================================

-- 6.1 Tareas
CREATE TABLE IF NOT EXISTS tasks (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  project_id   INT NOT NULL,
  company_id   INT,
  name         VARCHAR(255),
  description  TEXT,
  date         DATE,
  assigned_to  INT NOT NULL,
  hours_worked INT NOT NULL,
  minutes_worked INT NOT NULL,
  FOREIGN KEY (project_id)  REFERENCES projects(id),
  FOREIGN KEY (company_id)  REFERENCES companies(id) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (assigned_to) REFERENCES users(id),
  INDEX idx_tasks_project(project_id),
  INDEX idx_tasks_assigned_to(assigned_to)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6.2 Eventos de Calendario
CREATE TABLE IF NOT EXISTS calendar_events (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  user_id      INT,
  event_name   VARCHAR(255),
  event_date   DATE,
  start_time   TIME,
  end_time     TIME,
  description  TEXT,
  FOREIGN KEY (user_id) REFERENCES users(id),
  INDEX idx_calendar_user(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6.3 Registro de Horas Trabajadas
CREATE TABLE IF NOT EXISTS work_hours (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  user_id       INT NOT NULL,
  task_id       INT NOT NULL,
  hours_worked  DECIMAL(5,2),
  work_date     DATE,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (task_id) REFERENCES tasks(id),
  INDEX idx_work_hours_user(user_id),
  INDEX idx_work_hours_task(task_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6.4 Actualizaciones de Caso (manuales y de scraping)
CREATE TABLE IF NOT EXISTS case_updates (
  id                 INT AUTO_INCREMENT PRIMARY KEY,
  case_id            INT NOT NULL,
  update_description TEXT,
  update_date        DATETIME DEFAULT CURRENT_TIMESTAMP,
  created_by         INT,
  is_scraping_update TINYINT(1),
  FOREIGN KEY (case_id)    REFERENCES cases(idCase),
  FOREIGN KEY (created_by) REFERENCES users(id),
  INDEX idx_case_updates_case(case_id),
  INDEX idx_case_updates_created_by(created_by)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;