<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\UpdateProfileRequest;
use App\Models\Country;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function profile () {
        $countries = Country::all();
        $user = auth()->user();
        return view('frontend.user.profile', compact('countries', 'user'));
    }

    public function updateProfile (UpdateProfileRequest $request) {
        try {
            $userId = auth()->id();
            $user = User::findOrFail($userId);
            $data = $request->all();
            $file = $request->avatar;

            if(!empty($file)){
                $data['avatar'] = $file->getClientOriginalName();
            }

            if ($data['password']) {
                $data['password'] = bcrypt($data['password']);
            }else{
                $data['password'] = $user->password;
            }

            if ($user->update($data)) {
                if(!empty($file)){
                    $file->move('upload/user/avatar', $file->getClientOriginalName());
                }
                return redirect()->back()->with('success', __('Update profile success.'));
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors('Update profile error.');
        }
    }
}
