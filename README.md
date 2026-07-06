# 🌐 GlobalTech Solutions - Laboratorio Interactivo de Ofensiva y Defensa

Este repositorio contiene la plataforma interna corporativa **GlobalTech Solutions S.L.**, un entorno web interactivo desarrollado *ad hoc* para la simulación avanzada de ataques (Red Team) y despliegue de contramedidas de seguridad perimetral y de código (Blue Team). 

El núcleo didáctico de este laboratorio radica en su **arquitectura dual en tiempo real**, permitiendo alternar dinámicamente toda la infraestructura entre un estado vulnerable y un entorno bastionado (hardening) alineado con las directrices de **OWASP** y **MITRE ATT&CK**[cite: 1].

---

## 🛠️ Arquitectura del Laboratorio: Dos Modos

El entorno cuenta con un "cerebro" centralizado que conmuta el comportamiento de la aplicación mediante variables de sesión lógicas y automatización en el servidor web Apache:

*   🔴 **Offensive Mode (Red Team):** Todas las vulnerabilidades críticas se encuentran activas y expuestas de forma nativa para su explotación controlada (PoC)[cite: 1].
*   🟢 **Defensive Mode (Blue Team):** Se aplican instantáneamente los parches a nivel de código fuente (Security by Design) y controles perimetrales de hardening (reescritura dinámica de reglas en el servidor Apache)[cite: 1].

---

## 🔀 Mapeo de Vulnerabilidades y Mitigaciones (OWASP Top 10)

El laboratorio cubre de forma práctica los siguientes escenarios de explotación y defensa desarrollados en la memoria del proyecto[cite: 1]:

| Módulo / Archivo | 🔴 Vector Ofensivo (Red Team) | 🟢 Mecanismo Defensivo (Blue Team) |
| :--- | :--- | :--- |
| **`login.php`** | **Time-Based Blind SQL Injection** mediante consultas SQL concatenadas tradicionales[cite: 1]. | **Consultas Preparadas Parametrizadas** (`Prepared Statements`) que aíslan los datos de la lógica SQL[cite: 1]. |
| **`documentos.php`** | **Local File Inclusion (LFI)** que permite Path Traversal y exfiltración de credenciales con PHP Wrappers (`php://filter`)[cite: 1]. | **Lista Blanca (Whitelist)** estricta de rutas de recursos accesibles e inmutables[cite: 1]. |
| **`rrhh.php`** | **IDOR / BOLA** en un endpoint híbrido de tipo API REST que expone datos financieros sin autorización[cite: 1]. | **Control de Acceso a Nivel de Objeto** mediante validación estricta de variables de sesión del servidor[cite: 1]. |
| **`soporte.php`** | **Unrestricted File Upload** explotable mediante WebShells ocultas dentro de metadatos EXIF con ExifTool[cite: 1]. | **Validación MIME real**, renombrado seguro por Hashing y **recompresión de píxeles vía librería gráfica GD** para destruir metadatos[cite: 1]. |
| **`diagnostico.php`** | **OS Command Injection** clásico por concatenación directa de parámetros en la consola de Linux[cite: 1]. | **Validación estructural** (`FILTER_VALIDATE_IP`) y sanitización forzosa de argumentos mediante `escapeshellarg()`[cite: 1]. |

---

## 🛡️ Hardening Avanzado Automatizado

Al activar el **Defensive Mode**, el sistema no solo reescribe el comportamiento de PHP, sino que el script central `security.php` genera en tiempo real un archivo `.htaccess` restrictivo en el directorio de subidas (`/uploads`) con las siguientes directivas de denegación:

*   Apagado por completo del motor de ejecución PHP (`php_admin_flag engine off`).
*   Eliminación del gestor de scripts (`RemoveHandler .php`).
*   Desactivación de permisos de ejecución en la carpeta (`Options -ExecCGI`).

Al regresar al **Offensive Mode**, el entorno destruye automáticamente el archivo `.htaccess` para permitir de nuevo las auditorías ofensivas[cite: 1].

---

## 🎓 Contexto Académico

Este laboratorio práctico constituye la base técnica y la infraestructura experimental desplegada en Proxmox ypfSense para el **Trabajo Final de Estudio (TFE)** de la Universidad Internacional de La Rioja (UNIR)[cite: 1]:

*   **Proyecto:** Evaluación de Resiliencia, Hardening y Trazabilidad SIEM (Wazuh) en Entornos Corporativos Web/API[cite: 1].
*   **Autor:** Alberto Zani[cite: 1]
*   **Programa:** Programa Profesional en Ciberseguridad: Ofensiva y Defensa[cite: 1]
*   **Fecha de Presentación:** Julio de 2026[cite: 1]

---
*Nota: Este entorno ha sido diseñado exclusivamente como un laboratorio de pruebas enfocado a la formación académica en desarrollo seguro y auditorías de seguridad informática. Queda prohibido su uso en entornos de producción reales.*
