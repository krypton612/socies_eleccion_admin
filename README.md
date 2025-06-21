# ⚠️Nombre del Proyecto (Sistema de Administración de Elecciones)

![Laravel](https://img.shields.io/badge/Laravel-10.x-red)
![FilamentPHP](https://img.shields.io/badge/Filament-3.x-blue)
![PostgreSQL](https://img.shields.io/badge/Database-PostgreSQL-336791)
![Blockchain](https://img.shields.io/badge/Blockchain-Ethereum-green)

## 🧾 Descripción

⚠️Este sistema permite administrar procesos electorales a nivel institucional o gubernamental, integrando tecnologías web modernas con blockchain para asegurar la trazabilidad, transparencia y seguridad de los votos.

Incluye:
- Gestión de votantes y candidatos.
- Votación electrónica respaldada por contratos inteligentes.
- Panel administrativo con FilamentPHP.
- Registro de eventos electorales en Blockchain.

## ⚙️ Tecnologías Utilizadas

- **Laravel 10.x**
- **FilamentPHP 3.x** (panel administrativo)
- **PostgreSQL** (base de datos relacional)
- **Blockchain (Ethereum + Smart Contracts)** con ⚠️Hardhat/Ganache/Geth
- **PHP 8.2+**
- **Composer y NPM**

## 📦 Instalación

### Requisitos Previos

- PHP 8.2+
- Composer
- Node.js y NPM
- PostgreSQL
- Laravel
- ⚠️Clef (si usas firma externa en blockchain)

### Clonar el repositorio

```bash
git clone https://github.com/⚠️usuario/proyecto-elecciones.git
cd proyecto-elecciones
```

### Configurar variables de entorno
```bash
cp .env.example .env
```
Editar el archivo .env con tus credenciales de la base de datos y la cadena de bloques.

### Instalar dependencias
```bash
composer install
npm install
```

### Reemplazar el archivo .env con el archivo .env.example
```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=⚠️nombre_base_datos
DB_USERNAME=⚠️usuario
DB_PASSWORD=⚠️contraseña

BLOCKCHAIN_RPC_URL=http://localhost:8545
BLOCKCHAIN_CONTRACT_ADDRESS=⚠️0xContrato
```

