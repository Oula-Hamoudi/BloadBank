<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Http\Requests\StoreBloodRequestRequest;
use App\Http\Requests\UpdateBloodRequestRequest;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;

class BloodRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     
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


    public function pending()
    {
        $this->protect();
        $bloodRequests = BloodRequest::whereNull('approved_by')->whereNull('status')->whereNull('not_donated_reason')->whereNull('rejected_by')->latest()->get();
        return view('backend/blood/not-approved', compact('bloodRequests'));
    }


    public function approve($id)
    {
        $this->protect();
        $bloodRequest = BloodRequest::findOrFail($id);
        // $bloodRequest['approved_by'] = auth()->user()->id;
        $done = $bloodRequest->update([
            'approved_by' => Auth::id()
        ]);
        // sending mail to seekers;
        if ($done) {
            $data = [
                'request_no' => $bloodRequest['request_no'],
                'patient_name' => $bloodRequest['patient_name'],
                'blood_group' => $bloodRequest['blood_group'],
                'hospital_name' => $bloodRequest['hospital_name'],
                'contact_name' => $bloodRequest['contact_name'],
            ];
            $user['to'] = $bloodRequest['email'];
            Mail::send('mail.request-approve', $data, function ($messages) use ($user) {
                $messages->to($user['to']);
                $messages->subject('Your Request has been Approved');
            });
        }

        return redirect()->back()->withMessage('Successfully Approved! To assign donor please visit approved blood requests');
    }


    public function reject(Request $request)
    {
        $this->protect();
        $request->validate(
            [
                'reject_reason' => ['required']
            ]
        );
        if ($request->reject_reason || $request->reject_reason2) {
            if($request->reject_reason2){
                $request->reject_reason = $request->reject_reason2;
            }            
            $bloodRequest = BloodRequest::findOrFail($request->id);
            // $bloodRequest['approved_by'] = auth()->user()->id;
            $done = $bloodRequest->update([
                'rejected_by' => Auth::id(),
                'reject_reason' => $request->reject_reason
            ]);

            //sending mail
            if ($done) {
                $data = [
                    'request_no' => $bloodRequest['request_no'],
                    'patient_name' => $bloodRequest['patient_name'],
                    'blood_group' => $bloodRequest['blood_group'],
                    'hospital_name' => $bloodRequest['hospital_name'],
                    'contact_name' => $bloodRequest['contact_name'],
                ];
                $user['to'] = $bloodRequest['email'];
                Mail::send('mail.request-reject', $data, function ($messages) use ($user) {
                    $messages->to($user['to']);
                    $messages->subject('Your Request has been Rejected');
                });
            }
            return redirect()->back()->withMessage('Rejected!');
        } else {
            return redirect()->back()->withErrors('NO REASON SPECIFIED!PLEASE MARK A REASON TO REJECT');
        }
    }


    public function allRequests()
    {
        $this->protect();
        $bloodRequests = BloodRequest::whereNotNull('approved_by')->latest()->get();
        return view('backend/blood/all', compact('bloodRequests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function assignIndex(BloodRequest $bloodRequest)
    {
        $this->protect();
        
        $donationAvail = Carbon::parse(Carbon::now()->subMonths(3));

        $blood_group = $bloodRequest['blood_group'];
        // dd($blood_group);

        $donors = User::where([
            ['blood_group', $blood_group],
            ['last_donated', '<=', $donationAvail],
        ])
            ->orWhere([
                ['blood_group', $blood_group],
                ['rejected_by', null],
                ['last_donated', null]
            ])
            ->whereNull('status')
            ->latest()
            ->get();



        return view('backend.blood.assign-index', compact('donors', 'bloodRequest'));
    }


    public function assignDonor(Request $request, BloodRequest $bloodRequest)
    {
        $this->protect();
        // dd($request);
        // $bloodRequest->donor()->attach( $request->donor_ids);
        $bloodRequest->donors()->attach($request->donor_ids);
        $done = $bloodRequest->update([
            'status' => 1
        ]);

        //sending mail to donors
        if ($done) {
            $donors = User::where('id', $request->donor_ids)->get();
            foreach ($donors as $donor) {
                $data = [
                    'donor_name' => $donor['name'],
                ];
                Mail::send('mail.request-donor', $data, function ($messages) use ($donor) {
                    $messages->to($donor['email']);
                    $messages->subject('DONOR:You have new blood requests');
                });
            };

            // sending mail to seekers
            $data = [
                'request_no' => $bloodRequest['request_no'],
                'contact_name' => $bloodRequest['contact_name'],
            ];
            Mail::send('mail.request-assigned', $data, function ($messages) use ($bloodRequest) {
                $messages->to($bloodRequest['email']);
                $messages->subject('Your request is assigned to donors');
            });
        }



        return redirect()->route('blood-request-all')->withMessage('Successfully Assigned!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBloodRequestRequest  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     * 
     *
     * @param  \App\Models\BloodRequest  $bloodRequest
     * @return \Illuminate\Http\Response
     */
    public function show(BloodRequest $bloodRequest)
    {
        $this->protect();
        
        return view('backend/blood/view', compact('bloodRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BloodRequest  $bloodRequest
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->protect();
        $request = BloodRequest::findOrFail($id)->first();
        // dd($request->require_date);
        return view('backend.blood.edit',compact('request'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBloodRequestRequest  $request
     * @param  \App\Models\BloodRequest  $bloodRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BloodRequest $bloodRequest)
    {
        $this->protect();

        try{
              $request->validate(
                [
                    'patient_name'=>'required|min:5|max:255',
                    'blood_unit'=> 'required|integer' ,
                    'hospital_name'=> 'required|min:5|max:255' ,
                    'division'=> 'required' ,
                    'district'=> 'required' ,
                    'thana'=> 'required' ,
                    'postOffice'=> 'required' ,
                    'postCode'=> 'required' ,
                    'require_date'=> 'required|date' ,
                    'contact_name'=> 'required|min:5|max:255' ,
                    'email'=> 'required|email' ,
                    'phone'=> 'required' ,
                    'reason'=> 'required|min:5|max:255' ,
                ]
            );
         
            $bloodRequest->update([
                'patient_name'=> $request->patient_name,
                'blood_unit'=>  $request->blood_unit,
                'hospital_name'=>  $request->hospital_name,
                'division'=>  $request->division,
                'district'=>  $request->district,
                'thana'=>  $request->thana,
                'postOffice'=>  $request->postOffice,
                'postCode'=>  $request->postCode,
                'require_date'=>  $request->require_date,
                'contact_name'=>  $request->contact_name,
                'email'=>  $request->email,
                'phone'=>  $request->phone,
                'reason'=>  $request->reason,
            ]);
            return redirect()->back()->withMessage('Success');

        }catch(Exception $e){
            return redirect()->back()->withErrors($e);
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BloodRequest  $bloodRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(BloodRequest $bloodRequest)
    {
        $this->protect();
        //
    }
}
