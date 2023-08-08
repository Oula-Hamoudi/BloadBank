<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{

    private function donorAdmin()
    {
        if (Auth::user()->role_id == 3 && Auth::user()->role_id == 2) {
            return true;
        } else {
            return false;
        }
    }
    protected function protect()
    {
        if ($this->donorAdmin()) {
            abort(404);
        };
    }

    public function userList()
    {
        $this->protect();

        $users = User::whereNotNull('approved_by')->get()->all();
        // dd($users);
        return view('backend.admin.index', compact('users'));
    }

    public function makeAdmin($id)
    {
        $this->protect();
        try {
            User::findOrFail($id)->update([
                'role_id' => 2
            ]);
            return redirect()->back()->withMessage('Admin added');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e);
        }
    }
    public function removeAdmin($id)
    {
        $this->protect();
        try {
            User::findOrFail($id)->update([
                'role_id' => 3
            ]);
            return redirect()->back()->withMessage('Admin added');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e);
        }
    }
    public function makeSuperAdmin($id)
    {
        $this->protect();
        try {
            User::findOrFail($id)->update([
                'role_id' => 1
            ]);
            return redirect()->back()->withMessage('SuperAdmin added');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e);
        }
    }
    public function removeSuperAdmin($id)
    {
        $this->protect();
        $superadmin = User::where('role_id', 1)->get()->all();
        if (count($superadmin) <= 1) {
            return redirect()->back()->withErrors('Cant remove super admin. Only one superadmin available. Please add another super admin to remove this one.');
        } else {
            try {
                User::findOrFail($id)->update([
                    'role_id' => 2
                ]);
                return redirect()->back()->withMessage('SuperAdmin added');
            } catch (Exception $e) {
                return redirect()->back()->withErrors($e);
            }
        }
    }
}
