CREATE DATABASE IF NOT EXISTS globaltech_db;
USE globaltech_db;

-- Tabla de empleados y credenciales
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    rol VARCHAR(20) NOT NULL,
    puesto VARCHAR(50),
    email VARCHAR(100)
);

-- Tabla de nominas
CREATE TABLE IF NOT EXISTS nominas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    mes VARCHAR(20),
    salario_base DECIMAL(10,2),
    retencion DECIMAL(5,2),
    archivo_pdf VARCHAR(100),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Insertamos la jerarquia con correos incluidos
INSERT INTO usuarios (username, password, nombre, rol, puesto, email) VALUES 
('carlos.ceo', 'CEO_SecurePass2026!', 'Carlos Mendoza', 'admin', 'Director General (CEO)', 'cmendoza@globaltech.com'),
('asanz', 'temporal2026', 'Ana Sanz', 'empleado', 'Soporte Tecnico IT', 'asanz@globaltech.com'),
('mrossi', '123456', 'Marta Rossi', 'empleado', 'RRHH', 'mrossi@globaltech.com'),
('jmartinez', 'passw0rd', 'Juan Martinez', 'empleado', 'Marketing', 'jmartinez@globaltech.com');

INSERT INTO nominas (usuario_id, mes, salario_base, retencion, archivo_pdf) VALUES 
(1, 'Junio 2026', 8500.00, 24.50, 'nomina_ceo_junio.pdf'),
(2, 'Junio 2026', 1800.00, 12.00, 'nomina_asanz_junio.pdf'),
(3, 'Junio 2026', 2100.00, 14.50, 'nomina_mrossi_junio.pdf'),
(4, 'Junio 2026', 1900.00, 13.75, 'nomina_jmartinez_junio.pdf');
