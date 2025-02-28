# Prueba Técnica Docfav

## Descripción

Este proyecto es una aplicación desarrollada en PHP sin frameworks, utilizando **Doctrine** para la gestión de base de datos. Sigue los principios de **Domain-Driven Design (DDD)** y **Clean Architecture**, con una separación clara entre dominio, aplicación e infraestructura.

Incluye:

- Entidades bien estructuradas con **Value Objects**.
- **Interfaces de repositorio** para la persistencia de datos.
- **Caso de uso** desacoplado del controlador.
- **Eventos de dominio** y sus respectivos manejadores.
- **Pruebas unitarias y de integración** con PHPUnit.
- **Configuración con Docker** para facilitar la ejecución.

---

## Tecnologías utilizadas

- PHP 8+
- Doctrine ORM
- MySQL
- Docker & Docker Compose
- PHPUnit
- Makefile (para automatizar tareas)

---

## Requisitos previos

Asegúrate de tener instalado:

- **Docker** y **Docker Compose**
- **Make** (opcional, pero recomendado)

---

## Instalación y ejecución

1. **Clonar el repositorio**
   ```sh
   git clone https://github.com/manuelMedinaVega/docfav-test.git
   cd docfav-test

2. **Levantar los contenedores con Docker**
   ```sh
   make up

3. **Instalar las dependencias**
   ```sh
   make composer-install

4. **Configurar la base de datos**
   ```sh
   make schema-create

5. **Verificar que la aplicación está corriendo**

   Accede a http://localhost/, deberías ver una página de bienvenida.

---

## Pruebas

Este proyecto incluye **pruebas unitarias y de integración** usando PHPUnit.

### Ejecutar todas las pruebas
```sh
make test
```

---

## Endpoints disponibles

### 1. Obtener página de bienvenida
```http
GET /
```

### 2. Registrar un usuario
```http
POST /register
```
#### Cuerpo de la solicitud (JSON)
```json
{
  "id": "6073cafe-41c1-35a7-8952-6662f451cc24",
  "name": "John Doe",
  "email": "john@example.com",
  "password": "SecurePass123@"
}
```
#### Respuestas posibles
- **201 Created** → Usuario registrado correctamente.
- **400 Bad Request** → Datos inválidos.
- **409 Conflict** → El usuario ya existe.
- **500 Internal Server Error** → Error inesperado.

---

## Comandos útiles con Makefile

| Comando             | Descripción |
|---------------------|-------------|
| `make up`          | Levanta los contenedores con Docker |
| `make down`        | Detiene y elimina los contenedores |
| `make composer-install`     | Instala las dependencias con Composer |
| `make schema-create`     | Crea es esquema de la base de datos |
| `make test`        | Ejecuta todas las pruebas |

---

## Despliegue

Para detener la aplicación:
```sh
make down
```
Para reconstruir los contenedores (si hay cambios en el código):
```sh
make restart
```

---

## Autor

Desarrollado por **Manuel Medina**.  
Si tienes preguntas, contáctame en **[manuel.mv1191@gmail.com]**.

---

