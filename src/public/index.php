<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../config/bootstrap.php';

use Src\Application\UseCase\RegisterUserUseCase;
use Src\Domain\Exception\InvalidEmailException;
use Src\Domain\Exception\InvalidNameException;
use Src\Domain\Exception\InvalidPasswordException;
use Src\Domain\Exception\InvalidUuidException;
use Src\Domain\Exception\WeakPasswordException;
use Src\Infrastructure\EventDispatcher;
use Src\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use Src\Presentation\Controller\RegisterUserController;
use Src\Presentation\Exception\EmailAlreadyInUseException;
use Src\Presentation\Exception\UserAlreadyExistsException;

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($requestMethod === 'GET' && $requestUri === '/') {
    require __DIR__.'/welcome.html';
    exit;
}

if ($requestMethod === 'POST' && $requestUri === '/register') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (! $data || ! isset($data['id'], $data['name'], $data['email'], $data['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    $userRepository = new DoctrineUserRepository($entityManager);
    $eventDispatcher = new EventDispatcher;
    $registerUserUseCase = new RegisterUserUseCase($userRepository, $eventDispatcher);
    $controller = new RegisterUserController($registerUserUseCase);

    try {
        $response = $controller->register($data);
        echo json_encode($response);
    } catch (UserAlreadyExistsException|EmailAlreadyInUseException $e) {
        http_response_code(409);
        echo json_encode(['error' => $e->getMessage()]);
    } catch (InvalidUuidException|InvalidNameException|InvalidEmailException|InvalidPasswordException|WeakPasswordException $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'An unexpected error occurred']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}
