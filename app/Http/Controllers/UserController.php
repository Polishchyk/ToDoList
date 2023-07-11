<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $user = auth()->user();

        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request)
    {
        $attr = $request->validated();

        $user = auth()->user();
        $user = User::findOrFail($user->id);

        $user->name = $attr['name'];
        $user->save();

        return new UserResource($user);

    }
}
