<?php

namespace App\Modules\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;


class AuthService
{

    private function validateRegistrationData(array $data): void
    {
        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
            //todo make custom exception?
        }
    }

    private function validateLoginData(array $data): void
    {
        $validator = Validator::make($data, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
            //todo make custom exception?
        }
    }

    public function register(array $data): array
    {
        $this->validateRegistrationData($data);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = Auth::login($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Attempts to log the user in and returns a JWT token.
     * @param array $data
     * @return string
     * @throws InvalidArgumentException
     */
    public function login(array $data): string
    {

        $this->validateLoginData($data);

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];

        $token = Auth::attempt($credentials);

        if (!$token) {
            throw new InvalidArgumentException();
        } else {
            return $token;
        }
    }
}
