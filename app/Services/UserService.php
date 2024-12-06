<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\helpers\SendResponse;
use App\Services\ImageService;
class UserService
{
    protected $imageService;
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    /**
     * Create a new class instance.
     */

    public function registerUser($request)
    {
        $validate = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
        ], [], [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'image' => 'Image',
        ]);

        if ($validate->fails()) {
            return SendResponse::sendResponse(422, 'Register validation error', $validate->errors());
        }


        $userImage = $this->imageService->uploadImage($request);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $userImage,
            'password' => Hash::make($request->password),


        ]);

        $data['token'] = $user->createToken('api')->plainTextToken;
        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['image'] = $userImage;
        return SendResponse::sendResponse(201, 'Register successfully', $data);
    }
    public function loginUser(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required'],

        ], [], [
            'email' => 'Email',
            'password' => 'Password',
        ]);

        if ($validate->fails()) {
            return SendResponse::sendResponse(422, 'Login validation error', $validate->errors());
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $data['token'] = $user->createToken('api')->plainTextToken;
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $data['image'] = $user->image;
            return SendResponse::sendResponse(200, 'Login successfully', $data);
        } else {
            return SendResponse::sendResponse(401, 'Login Faild', );

        }

    }
    public function logoutUser(Request $request)
    { {
            $request->user()->currentAccessToken()->delete();
            return SendResponse::sendResponse(200, 'Logout successfully', []);
        }
    }
}
