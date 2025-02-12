Requisitos Previos
PHP versión >= 8.1
Composer
MySQL
Git

Pasos para Instalar y Configurar el Proyecto
1. Clonar el Repositorio
Primero, clona el repositorio desde GitHub a tu máquina local

2. Instalar las Dependencias
Una vez que hayas clonado el repositorio, instala las dependencias utilizando Composer:
composer install

3. Configurar las Variables de Entorno
.env.dev

4. Crear la Base de Datos
php bin/console doctrine:database:create

5. Generar y Aplicar las Migraciones
php bin/console make:migration
php bin/console doctrine:migrations:migrate

6. Generar las Claves JWT

mkdir -p config/jwt
php bin/console lexik:jwt:generate-keypair

7. Listo a probar en postman!

Register:
/api/register

{
    "email": "ejemplo15@ejemplo.com",
    "password": "12345678"
}

![image](https://github.com/user-attachments/assets/493438cc-3aa1-492c-8ee4-3c30d524a0b9)

Login:
/api/login
{
    "email": "ejemplo15@ejemplo.com",
    "password": "12345678"
}

![image](https://github.com/user-attachments/assets/83bbb1cd-0568-46b8-8b52-1625346a58cd)

Crear Empleado:
/api/employee/
{
  "firstName": "pepito",
  "lastName": "perez",
  "position": "fullstack",
  "birthDate": "1996-06-13",
  "email": "pepito.perez@prueba.com"
}

![image](https://github.com/user-attachments/assets/289480ea-b975-40a3-a091-02d4134f74b5)

Lista de Empleados:
/api/employee/

![image](https://github.com/user-attachments/assets/1a6e813d-583d-40ee-8bca-5eaa8643ff64)

Editar Empleado:
/api/employee/16
{
  "firstName": "Juan",
  "lastName": "PRUEBA",
  "position": "ADMIN",
  "birthDate": "1996-06-13",
  "email": "xxxxxprueba@prueba.com"
}

![image](https://github.com/user-attachments/assets/462d0216-e258-415c-9ee9-aab63252ebf8)

Eliminar Empleado:
/api/employee/16

![image](https://github.com/user-attachments/assets/fafd52ff-466b-48c5-8dd8-9c83598bd8c7)

