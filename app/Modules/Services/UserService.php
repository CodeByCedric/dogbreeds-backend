<?php


namespace App\Modules\Services;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserService extends Service
{

    /** @var User */
    protected Model $model;

    protected array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6',
    ];

    public function __construct(User $model)
    {
        parent::__construct($model);
    }


    public function addCommentToPost(User $user, $data): ?Model
    {
        $this->validate($data);
        if ($this->hasErrors()) return null;

        return $user->create($data);
    }

}







//namespace App\Modules\Services;
//
//use App\Models\User;
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\Hash;
//
//
//class UserService extends Service
//{
//    protected Model $model;
//
//    protected array $rules = [
//        'name' => 'required|string|max:255',
//        'email' => 'required|string|email|max:255|unique:users',
//        'password' => 'required|string|min:6',
//    ];
//
//    public function __construct(User $model)
//    {
//        parent::__construct($model);
//    }
//
//    public function registerUser($data) {
//        $this->validate($data);
//        if ($this->hasErrors()) return null;
//
//        $data['password'] = Hash::make($data['password']);
//
//
//        return $this->model->create($data);
//    }
//}
