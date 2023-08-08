<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Image;
use Alert;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'blood_group' =>'required',
            'nid_number'=>'required|numeric|unique:users',
            'phone'=>'required',
            'dob'=> 'required|date',
            'gender'=>'required',
            'division'=>'required',






        ]);
        $default_role = 3;
        $requestData = $request->all();

        if ($request->hasFile('profile_image') && $request->hasFile('nid_image')) {

            $profile_image = $request->file('profile_image');
            $nid_image = $request->file('nid_image');


            $nid_image_Name = time() . '.' . $nid_image->getClientOriginalExtension();
            $profile_image_Name = time() . '.' . $profile_image->getClientOriginalExtension();
            Image::make($request->file('profile_image'))
            ->resize(300, 200)
            ->save(storage_path() . '/app/public/users/profile/' . $profile_image_Name);

            Image::make($request->file('nid_image'))
                ->resize(300, 200)
                ->save(storage_path() . '/app/public/users/nid/' . $nid_image_Name);
            $requestData['profile_image'] = $profile_image_Name;
            $requestData['nid_image'] = $nid_image_Name;
        }



    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'blood_group'=> $request->blood_group,
        'role_id' => $default_role,
        'nid_number' => $request->nid_number,
        'total_donated'=> 0,

    ]);
    $user->profile()->create([
        'phone' => $request->phone,
        'phone2' =>$request->phone2,
        'father'=> $request->father,
        'mother'=> $request->mother,
        'dob'=> $request->dob,
        'gender'=> $request->gender,
        'division'=> $request->division,
        'district'=> $request->district,


    ]);
    // if ($user) {
    //     Alert::success('Submitted', 'Your donor signup request is waiting for approval');
    //     return back();
    // }


    Auth::login($user);
    return redirect()->route('login');
    try {
        $donor_id = Auth::id();

        //donated
        DB::table('blood_request_user')->where('user_id', $donor_id)->where('blood_request_id', $id)->update(
            ['status' => 2]
        );
        BloodRequest::find($id)->update(
            ['status' => 3],
            ['donor_id' => $donor_id],
            ['completed_at' => Carbon::now()]
        );

        //updating in donor table
        User::find($donor_id)->update(
            [
                'last_donated' => Carbon::now(),
                'total_donated' => DB::raw('total_donated + 1'),
                'status' => 1
            ]
        );
        return redirect()->back()->withMessage('Congrats! You can again donate after 3 months');
    } catch (QueryException $q) {
        return redirect()->back()->withMessage();
    }

    return redirect()->back()->withMessage('Your signup request is submitted! We will mail you soon');
    //   return redirect()->route('verification.notice');
    }
}
