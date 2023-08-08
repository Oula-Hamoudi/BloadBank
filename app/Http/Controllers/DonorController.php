<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Event;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use FFI\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Return_;
use Image;
use File;

class DonorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     //protecting datas
     private function donor()
     {
         $role_id = 3;
         if (Auth::user()->role_id == $role_id) {
             return true;
         } else {
             return false;
         }
     }
     protected function protect()
     {
         if ($this->donor()) {
             abort(404);
         };
     }

    public function changePassword()
    {

        return view();
    }
    public function profile()
    {
        $user =  Auth::user();
        return view("backend.donor.profile", compact("user"));
    }
   

    public function list()
    {
        $this->protect();
        $donors = User::whereNotNull(
            [
                'approved_by',
                'approval_status',
                'email_verified_at'
            ]
        )->whereNull('rejected_by')->latest()->get();

        return view('backend.donors-list', compact('donors'));
    }

    public function pendingDonorsRequest()
    {
        $this->protect();
        $pendingDonorsRequests = User::whereNull('approval_status')->whereNull('rejected_by')->get();
        return view('backend.donor-requests', compact('pendingDonorsRequests'));
    }
    public function acceptDonors($id)
    {
        $this->protect();
        try {
            $done = User::find($id)->update(
                [
                    'approval_status' => 1,
                    'approved_by' => Auth::id()
                ]
            );
            //sending mail to donors
            $donor = User::findOrFail('id', $id)->first();
            $data = [
                'donor_name' => $donor->name,
            ];
            Mail::send('mail.donor-accept', $data, function ($messages) use ($donor) {
                $messages->to($donor->email);
                $messages->subject('Donor reqeust has been approved');
            });

            return redirect()->back()->withMessage('Successfully Approved!');
        } catch (QueryException $q) {
            return redirect()->back();
        }
    }
    public function rejectDonors(Request $request)
    {
        $this->protect();
        $request->validate(
            [
                'reject_reason' => ['required']
            ]
        );

        if ($request->reason || $request->reason2) {
            try {
                if ($request->reason2) {
                    $request->reason = $request->reason2;
                }

                User::findOrFail($request->id)->update(
                    [
                        'rejected_by' => Auth::id(),
                        'reject_reason' => $request->reason,
                    ]
                );
                $donor = User::where('id', $request->id)->get();
                //mail to donor
                $data = [
                    'donor_name' => $donor->name,
                    'reason' => $request->reason,
                ];
                Mail::send('mail.donor-reject', $data, function ($messages) use ($donor) {
                    $messages->to($donor->email);
                    $messages->subject('Donor reqeust has been rejected');
                });

                return redirect()->back()->withMessage('Successfully Declined!');
            } catch (QueryException $q) {
                return redirect()->back()->withErrors('Something Went Wrong!');
            }
        } else {
            return redirect()->back()->withErrors('NO REASON SPECIFIED!PLEASE MARK A REASON TO DECLINE');
        }
    }


    public function index()
    {
        $pendingRequests = Auth::user()->bloodRequests()
            ->where(function ($q) {
                $q->where('blood_request_user.status', '>', 0)
                    ->orWhere('blood_request_user.status', null);
            })
            ->get();
        $reasons = DB::table('notdonatedreasons')->get();

        return view('backend.donor.pending-blood-requests', compact('pendingRequests','reasons'));
    }

    public function accept($id)
    {
        //blood:: status 1 = taken
        //blood:: status 2 = Donated
        //blood:: status 0 = Not donated 
        // status 0 is declined
        // status 1 is accepted
        // status2 is donated
        // status 3 is deactived
        $donor_id = Auth::id();
        //accepted
        DB::table('blood_request_user')->where('user_id', $donor_id)->where('blood_request_id', $id)->update(
            ['status' => 1]
        );


        //updating request status
        BloodRequest::find($id)->update([
            'status' => 2
        ]);

        //updating donor status
        DB::table('users')->where('id', $donor_id)->update(
            ['status' => 1]
        );

        //others are declined
        $others = DB::table('blood_request_user')
            ->where('user_id', $donor_id)
            ->whereNull('status')->get();
        if ($others) {
            foreach ($others as $other) {
                DB::table('blood_request_user')->where('user_id', $donor_id)->whereNull('status')->update(
                    ['status' => 0]
                );
            }
        }
        //request is removed from others
        $requests = DB::table('blood_request_user')
            ->where('user_id', $donor_id)
            ->whereNull('status')->get();
        if ($requests) {
            foreach ($requests as $request) {
                DB::table('blood_request_user')->where('blood_request_id', $id)->whereNull('status')->delete();
            }
        }

        $donor = User::Where('id', $donor_id)->get()->first();
        $request = BloodRequest::where('id', $id)->get()->first();
        $age = Carbon::parse($donor->profile->dob)->diff(Carbon::now())->y;
        $data = [
            'donor_name' => $donor->name,
            'donor_email' => $donor->email,
            'donor_age' => $age,
            'donor_number' => $donor->profile->phone,
            'donor_gender' => $donor->profile->gender,
            'request_no' => $request->request_no,
            'contact_name' => $request->contact_name,
        ];
        Mail::send('mail.request-donor-accept', $data, function ($messages) use ($request) {
            $messages->to($request->email);
            $messages->subject('Donor accepted your blood seeking request');
        });
        return redirect()->back()->withMessage('Blood request accepted!');
    }



    public function donated($id)
    {
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
    }



    public function notDonated(Request $request , $id)
    {
        // validating inputs 
        $request->validate([
            'not_donated_reason' =>'required'
        ]);
        
 
        //handling requests to mark not donated

        if($request->not_donated_reason == 1){
            $reason = DB::table('notdonatedreasons')->where('id',$request->not_donated_reason)->get();
            $donor_id = Auth::id();
            DB::table('blood_request_user')->where('blood_request_id', $id)->delete();
            BloodRequest::where('id',$id)->update(
                [
                    'not_donated_reason' => $reason->name
                ]
            );
            Auth::user()->update(
                [
                    'status' => null,
                ]
            );
        }
        elseif($request->not_donated_reason == 2){
           
            $reason = DB::table('notdonatedreasons')->where('id',$request->not_donated_reason)->get();
            $donor_id = Auth::id();
            DB::table('blood_request_user')->where('blood_request_id', $id)->delete();
            BloodRequest::where('id',$id)->update(
                [
                    'not_donated_reason' => $reason->name
                ]
            );
            Auth::user()->update(
                [
                    'status' => null,
                ]
            );
        }
        elseif($request->not_donated_reason == 3){
            $this->proccess();
        }
        elseif($request->not_donated_reason == 4){
            $this->proccess();
        }
        else{
            return redirect()->back()->withErrors('Something went wrong');
        }
        return redirect()->back()->withMessage('Marked as not donated');
    }




    private function proccess(){
        $donor_id = Auth::id();
        
        DB::table('blood_request_user')->where('user_id', $donor_id)->where('blood_request_id', $id)->update(
            ['status' => 0]
        );
        Auth::user()->update(
            [
                'status' => null,
            ]
        );
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     
    public function donationStore(Request $request)
    {
        try {


            $request->validate([
                'total_donated' => 'required|numeric',
                'last_donated' => 'required|date'
            ]);

            $user = Auth::id();
            User::findOrFail($user)->update(
                [
                    'total_donated' => $request->total_donated,
                    'last_donated' => $request->last_donated
                ]
            );
            return redirect()->back()->withMessage('Successfully Updated!');
        } catch (QueryException $q) {
            return redirect()->back()->withInputs()->withErrors('Something went wrong');
        }
    }


    public function makeActive()
    {
        if(Auth::user()->status == 3)
        {
            $user = Auth::id();
            User::where('id',$user)->update([
                'status' => Null
            ]);
            return redirect()->back()->withMessage("Donation status is now active");
        };
        if(Auth::user()->status == Null)
        {
            $user = Auth::id();
            User::where('id',$user)->update([
                'status' => 3
            ]);
            return redirect()->back()->withMessage("Donation status Deactived");
        };

        
    }

   
    public function makeDeactive()
    {
        $user = Auth::id();
        User::find($user)->update([
            'status' => 3
        ]);
        return redirect()->back()->withMessage("Donation status is deactived");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $oldEmail = Auth::user()->email;
            $newEmail = $request->email;
            $emailValidationRule = 'required|string|email|max:255|unique:users';
            if ($oldEmail == $newEmail) {
                $emailValidationRule = 'required|string|email|max:255';
            }
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => $emailValidationRule,
                'gender' => 'required',
                'division' => 'required',
                'district' => 'required',
                'thana' => 'required',
                'postOffice' => 'required',
                'postCode' => 'required|numeric',
                'phone' => 'required',
                'profile_image' => 'mimes:jpg,png|min:5|max:2048'
            ]);
            $user = Auth::id();
            if ($request->hasFile('profile_image')) {
                //finding old image 
                $oldImageName = Auth::user()->profile->profile_image;
                //deleting old image 
                $oldImage = storage_path() . '/app/public/users/profile/' . $oldImageName;
                if (File::exists($oldImage)) {
                    unlink($oldImage);
                }
                // deleted the old image

                //triming old image name;
                $trimOldImageName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $oldImageName);
                $profile_image = $request->file('profile_image');
                // saving through old image name and new image extention
                $profile_image_Name = $trimOldImageName . '.' . $profile_image->getClientOriginalExtension();
                Image::make($request->file('profile_image'))
                    ->resize(300, 200)
                    ->save(storage_path() . '/app/public/users/profile/' . $profile_image_Name);
                Auth::user()->profile->update([
                    'profile_image' => $profile_image_Name
                ]);
            }
            User::findOrFail(Auth::id())->update(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                ]
            );
            Auth::user()->profile->update(
                [
                    'father'=> $request->father,
                    'mother' => $request->mother,
                    'gender' => $request->gender,
                    'division' => $request->division,
                    'district' => $request->district,
                    'thana' => $request->thana,
                    'postOffice' => $request->postOffice,
                    'postCode' => $request->postCode,
                    'phone' => $request->phone
                    
                ]
            );

            return redirect()->back()->withMessage('Successfully Updated');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors('Something Went Wrong');
        }
    }

    public function donationHistory(){
        // dd(Auth::id());
        $histories = BloodRequest::where('donor_id',Auth::id())->get()->all();
        return view('backend.donor.history',compact('histories'));
    }
    public function eventHistory(){
        // dd(Auth::id());
        $histories = Event::where('uploaded_by',Auth::id())->get()->all();
        return view('backend.donor.events',compact('histories'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
