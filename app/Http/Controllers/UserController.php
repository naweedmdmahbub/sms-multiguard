<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Events\SendVerificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendVerificationCodeMail;
use App\Events\EmailVerificationCodeEvent;

class UserController extends Controller
{
    // public function __construct()
    // {
    //    $this->middleware('auth');
    // }

    public function index()
    {
        // dd('hi index');
        $users = User::all();
        foreach($users as $user){
            $user->role = $user->getRoleNames()[0];
        }
        // dd(Auth::check(), auth());

        // Return the users as a response
        return response()->json($users);
    }

    public function store(UserRequest $request)
    {
        // dd(config('app.url'));
        try {
            $userData = $request->only('name', 'email');

            DB::beginTransaction();
            $userData['invitation_token'] = random_int(100000, 999999);
            $userData['password'] = Hash::make('123456');
            $userData['role'] = 'user';
            $user = User::create($userData);
            // event(new SendVerificationCode($user->email, $user->invitation_token));
            // dd('store', $request->all(), $userData);
            DB::commit();
            SendVerificationCode::dispatch($user['email'], $user['invitation_token']);
            return $user;
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json( new \Illuminate\Support\MessageBag(['catch_exception'=>$ex->getMessage()]), 403);
        }
    }


    public function edit($id)
    {
        // dd('hi index');
        $user = User::find($id);

        // Return the customers as a response
        return response()->json($user);
    }


    public function update(UserRequest $request, $id)
    {
        try {
            $userData = $request->only('name', 'email');
            $user = User::find($id);
            DB::beginTransaction();
            $user->update($userData);
            DB::commit();
            return $user;
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json( new \Illuminate\Support\MessageBag(['catch_exception'=>$ex->getMessage()]), 403);
        }
    }

    public function delete($id)
    {
        try {
            $user = User::find($id);
            DB::beginTransaction();
            $user->delete();
            DB::commit();

            $users = User::all();
            return response()->json($users);
        } catch (Exception $ex) {
            DB::rollBack();
            return 'Delete Failed';
        }
    }

    public function confirm_registration(Request $request)
    {
        // dd($request->all(), request(), 'hi');
        $user = User::where('email', $request->email)
                    ->where('invitation_token', $request->code)
                    ->first();
        return view('register.register', compact('user'));
        // $request->get('invitee');
    }

    public function update_registration(Request $request)
    {
        $user = User::where('email', $request->email)
                    ->where('invitation_token', $request->invitation_token)
                    ->first();
                    // dd($request->all(), $user);

        $user->password = Hash::make($request->password);
        $user->markEmailAsVerified();
        $user->save();
        return redirect()->route('login');
    }


    public function logged_in_user(Request $request)
    {
        $logged_in_user = Auth::user();
        return response()->json($logged_in_user);
    }

}
