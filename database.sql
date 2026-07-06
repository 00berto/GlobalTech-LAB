-- Creación de la Base de Datos del Laboratorio
CREATE DATABASE IF NOT EXISTS globaltech_db;
USE globaltech_db;

-- 1. Estructura de la tabla de Usuarios (Según Captura 5 del TFG)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    rol VARCHAR(50) NOT NULL,
    puesto VARCHAR(100) NOT NULL
);

-- 2. Estructura de la tabla de Nóminas (Según Capítulos 4.2 y 4.3 del TFG)
CREATE TABLE IF NOT EXISTS nominas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    mes VARCHAR(30) NOT NULL,
    salario_base DECIMAL(10,2) NOT NULL,
    retencion DECIMAL(5,2) NOT NULL,
    archivo_pdf VARCHAR(100) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- 3. Inserción de Datos Limpios para el Escenario de Pruebas (Según Captura 5 del TFG)
INSERT INTO usuarios (id, username, password, nombre, rol, puesto) VALUES
(1, 'carlos.ceo', 'CorpPass2026', 'Carlos Mendoza', 'CEO', 'Director General (CEO)'),
(2, 'asanz', 'SoportePass2026', 'Ana Sanz', 'Soporte', 'Soporte Tecnico IT'),
(3, 'mrossi', '123456', 'Marta Rossi', 'RRHH', 'RRHH'),
(4, 'jmartinez', 'MktPass2026', 'Juan Martinez', 'Marketing', 'Marketing');

-- Inserción de la nómina de Marta Rossi (ID = 3) para la explotación de IDOR/BOLA (Según Captura 5 y 13)
INSERT INTO nominas (id, usuario_id, mes, salario_base, retencion, archivo_pdf) VALUES
(3, 3, 'Junio 2026', 2100.00, 14.50, 'nomina_mrossi_junio.pdf');
