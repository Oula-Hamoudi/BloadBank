<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
       $user = User::create(
            [
                'name' => 'BDMS',
                'email' => 'superadmin@bdms.com',
                'password' => Hash::make('12345678'),
                'nid_number' => '810120031',
                'blood_group'=> 'A+',
                'role_id' => '1',
                'email_verified_at' => $time,
                'status' => 3,
                'approval_status' => 1 ,
                'approved_by' => 1,
                'created_at'=> $time,
                'updated_at'=> $time,
                'total_donated'=> 0,
            ]
        );
        $user->profile()->create([
            'phone' => '1712912',
            'dob'=> $time,
            'gender'=> 'Male',
            'division'=> 'N/A',
            'district'=> 'N/A',
            'thana'=> 'N/A',
            'postOffice'=> 'N/A',
            'postCode' => '111',
            'profile_image' => 'user.jpg',
            'nid_image' => 'nid.jpg',
        ]); 
    }
}
