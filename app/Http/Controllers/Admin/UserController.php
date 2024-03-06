<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Models\Country;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'level:1']);
    }

    public function index () {
        $countries = Country::all();
        return view('admin.user.profile', compact('countries'));
    }

    public function update (UpdateProfileRequest $request) {
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
