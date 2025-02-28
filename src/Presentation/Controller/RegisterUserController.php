<?php

namespace Src\Presentation\Controller;

use Src\Application\DTO\RegisterUserRequest;
use Src\Application\UseCase\RegisterUserUseCase;

class RegisterUserController
{
    private RegisterUserUseCase $useCase;

    public function __construct(RegisterUserUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function register(array $data)
    {
        try {
            $request = new RegisterUserRequest($data['id'], $data['name'], $data['email'], $data['password']);
            $userResponse = $this->useCase->execute($request);

            return [
                'message' => 'User registered successfully.',
                'user' => $userResponse->toArray(),
            ];
        } catch (\Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
