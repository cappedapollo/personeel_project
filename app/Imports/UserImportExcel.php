<?php

namespace App\Imports;

use App;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mail;

class UserImportExcel implements ToCollection, WithStartRow
{
    private $rows = 0;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $request = request()->all();
        $user_import_id = $request['user_import_id'];
        $company_id = Auth::user()->company_user->company_id;
        
        foreach ($rows as $row) {
            ++$this->rows;
            $password = getRandomString(8);
            $role = trim($row[3]);
            $user_role = App\Models\UserRole::firstWhere('role_code', strtolower($role));
            
            $user_data['user_role_id'] = $user_role->id;
            $user_data['created_by'] = Auth::id();
            $user_data['user_import_id'] = $user_import_id;
            $user_data['first_name'] = trim($row[0]);
            $user_data['last_name'] = trim($row[1]);
            $user_data['email'] = trim($row[2]);
            $user_data['password'] = Hash::make($password);
            $user_data['status'] = 'active';
            $user_data['email_verified'] = 'yes';
            $user_data['function'] = trim($row[4]);
            # add google2fa_secret value
            $google2fa = app('pragmarx.google2fa');
            $user_data["google2fa_secret"] = $google2fa->generateSecretKey();
            
            if($inserted_data = User::create($user_data)) {
                # add company user data
                $cu_data['company_id'] = $company_id;
                $cu_data['user_id'] = $inserted_data->id;
                App\Models\CompanyUser::create($cu_data);
                
                # send temporary password to only manager
                if ($role == 'manager') {
                    $mail_data = ['email'=>$inserted_data->email, 'password'=>$password];
                    Mail::send('emails.'.app()->getLocale().'.user_registered', compact('mail_data'), function($message) use ($mail_data) {
                        $message->to($mail_data['email'])->subject(__('email.subject.user_registered'));
                    });
                }
            }
        }
        
    }
    
    public function startRow(): int
    {
        return 2;
    }
    
    public function getRowCount(): int
    {
        return $this->rows;
    }
}
