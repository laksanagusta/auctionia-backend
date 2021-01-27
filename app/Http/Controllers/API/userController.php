<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\PasswordValidationRules;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;
use DB;


class userController extends Controller
{
    use PasswordValidationRules;
    
    /**
     * @param Request $request
     * @return mixed
     */
    public function fetch(Request $request)
    {
        return ResponseFormatter::success($request->user(),'Data profile user berhasil diambil');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */

    public function index(){
        $user = Cache::remember('user', 86400, function () {
            return User::paginate(10);
        }); 

        return view('user.index', [
            'user' => $user
        ]);
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            Cache::forget('user');

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ],'User Registered');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ],'Authentication Failed', 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ],'Authentication Failed', 500);
            }

            $user = User::where('email', $request->email)->first();
            if ( ! Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ],'Authenticated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ],'Authentication Failed', 500);
        }
    }

    public function updatePassword(Request $request)
    {
        $user = User::find($request->users_id);
        $user->password = Hash::make($request->password);
        $user->save();

        return ResponseFormatter::success([
            'user' => $user
        ],'Password Updated');
    }

    public function update(Request $request, User $user)
    {

        $user = User::find($request->users_id);
        $user->name = $request->name;

        if($request->picture !== ""){
            Storage::disk('s3')->delete($user->profile_photo_path);
            $data = $request->picture;
            $dataconfirm = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
            $uuidGenerated = Uuid::generate();
            Storage::disk('s3')->put('auctionia-images/'.$uuidGenerated, $dataconfirm);
            $user->profile_photo_path = 'auctionia-images/'.$uuidGenerated;
        }

        $user->save();

        $user = User::find($request->users_id);

        return ResponseFormatter::success([
            'user' => $user
        ],'User Updated');
    }

    public function editPicture(Request $request)
    {
        $data = $request->picture;
        $dataconfirm = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
        $uuidGenerated = Uuid::generate();
        $image_s3_path = Storage::disk('s3')->put('auctionia-images/'.$uuidGenerated, $dataconfirm);
        $affected = DB::table('users')
              ->where('email', $request->email)
              ->update(['profile_photo_path' => 'auctionia-images/'.$uuidGenerated]);
        return ResponseFormatter::success([
            'image_path' => 'auctionia-images/'.$uuidGenerated,

        ],'User Updated');
    }
}

//lumen
//redis
