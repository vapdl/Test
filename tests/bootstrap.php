<?php
require_once __DIR__ . '/../src/interfaces/IResultApi.php';
require_once __DIR__ . '/../src/interfaces/ICache.php';
require_once __DIR__ . '/../src/exceptions/ApiException.php';
require_once __DIR__ . '/../src/exceptions/DataBaseException.php';
require_once __DIR__ . '/../src/exceptions/RedisException.php';
require_once __DIR__ . '/../src/providers/ApiLotoConnector.php';
require_once __DIR__ . '/../src/providers/RedisConnector.php';
require_once __DIR__ . '/../src/providers/MySQLConnector.php';
require_once __DIR__ . '/../src/services/ApiMagayoService.php';
require_once __DIR__ . '/../src/services/ApiFakeService.php';
require_once __DIR__ . '/../src/repositories/EuromillionsRepository.php';
require_once __DIR__ . '/../src/models/Euromillions.php';
require_once __DIR__ . '/../vendor/autoload.php';