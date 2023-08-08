<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackendController extends Controller
{
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
   
    public function index()
    {   
        
        $donationAvail = Carbon::parse(Carbon::now()->subMonths(3));

        $eventRequests = Event::whereNull('status')->count();
        $signupRequests = User::whereNull('approval_status')->whereNull('rejected_by')->count();

        $availableDonors = User::whereNull('last_donated')->orWhereDate('last_donated', '<=', $donationAvail)
                        ->count();  
        // dd($availableDonors)  ;


        $bloodRequests = BloodRequest::whereNull('approved_by')->whereNull('status')->whereNull('rejected_by')->count();
        $totalDonors = User::count();
          
        // dd($totalDonors);
        $ongoing = Auth::user()->bloodRequests()->wherePivot('status',1)->first();
        $usersBloodRequests = Auth::user()->bloodRequests()->wherePivotNull('status')->count();
        return view('backend/dashboard',compact(
        'signupRequests',
        'eventRequests',
        'usersBloodRequests',
        'ongoing',
        'bloodRequests',
        'totalDonors',
        'availableDonors'
    ));
    }
}
