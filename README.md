# 🍽️ Prezo - Escandallos y Ventas

Este proyecto es una solución para la prueba técnica de Prezo.es. Consiste en un sistema para gestionar escandallos (recetas con coste) y simular ventas con cálculos de márgenes, totales e ingresos por día.

---

## 🧱 Requisitos

- PHP >= 8.0
- Composer
- Laravel >= 10
- SQLite (no es necesario instalarlo, viene incluido con PHP)

---

## ⚙️ Instalación

1. Cloná el repositorio:

```bash
git clone https://github.com/miusuario/prezo-escandallos.git
cd prezo-escandallos

2. Instalá las dependencias:

composer install

3. Configurá las variables de entorno:

cp .env.example .env

4. Configurá SQLite en el .env:

DB_CONNECTION=sqlite
DB_DATABASE=./database/database.sqlite


5. Creá la base de datos vacía:

touch database/database.sqlite


6. Ejecutá las migraciones y seeders:

php artisan migrate --seed


Una vez instalado, podés ejecutar el comando principal:

php artisan prezo:summary

Este comando mostrará:



Tabla de escandallos: coste, precio, margen y cantidad vendida

Receta con mayor y menor coste

Receta con mayor y menor margen

Volumen de ventas por día

Día con mayor y menor ventas

Márgenes individuales por receta

Ejemplo de salida en consola

📋 Recetas
+------------------------+----------------+--------------+-------------+-----------+------------------+
| Receta                 | Costo Unitario | Precio Venta | Margen (%)  | Vendidos  | Total Ventas ($) |
+------------------------+----------------+--------------+-------------+-----------+------------------+
| Nachos con guacamole   | 5.51           | 10           | 44.90       | 23        | 230              |
| Ron Cola               | 2.50           | 8            | 68.75       | 15        | 120              |
+------------------------+----------------+--------------+-------------+-----------+------------------+

📊 Receta con mayor coste: Nachos con guacamole, 5.51  
📉 Receta con menor coste: Ron Cola, 2.5  
💰 Receta con mayor margen: Ron Cola, 68.75%  
📉 Receta con menor margen: Nachos con guacamole, 44.9%  

📆 Volumen de ventas por día:
+------------+------------------------+-------------------+
| Fecha      | Total Unidades         | Total Ingresos ($)|
+------------+------------------------+-------------------+
| 2024-07-02 | 25                     | 240               |
| 2024-07-03 | 13                     | 110               |
+------------+------------------------+-------------------+

📈 Día con mayor ventas: 2024-07-02, 240  
📉 Día con menor ventas: 2024-07-03, 110  
