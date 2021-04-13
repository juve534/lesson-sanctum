<?php

declare(strict_types=1);

namespace App\Http\Actions\Authenticates;

use App\Http\Requests\CreateTokenRequest;
use App\Models\User;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateTokenAction extends BaseController
{
    private User $user;
    private ResponseFactory $responseFactory;

    public function __construct(User $user, ResponseFactory $responseFactory)
    {
        $this->user = $user;
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(CreateTokenRequest $request)
    {
        try {
            $user = $this->user::findOrFail($request->id);
            $token = $user->createToken($user->name);
        } catch (ModelNotFoundException $e) {
            return $this->responseFactory->json(
                [
                    'error' => [
                        'type'    => 'not_found',
                        'message' => '見つかりません',
                    ],
                ], 404)
                ->header('Content-Type', 'application/json');
        }

        return ['token' => $token->plainTextToken];
    }
}
