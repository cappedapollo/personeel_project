<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Google2FA;

class CeleryController extends Controller
{
    //
    public function index(Request $request) {
        $page_title = __('form.label.celery');
        $code = $request->query('code');
        $access_token = $this->access_token("$code");
        if(!$access_token) return redirect(app()->getLocale().'/users/import');
        return view("celery.index", compact('page_title', 'access_token'));
    }

    private function access_token($code) {
        $response = Http::asForm()  // Specify the form URL-encoded format
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic ' . base64_encode(config('app.celery_client_id') . ":" . config('app.celery_secret'))
            ])
            ->post(config('app.celery_login_url').'/oauth2/token', [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri'=> url('/celery/callback')
            ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data["access_token"];
        } else {
            // $response->status();
            return null;
        }
    }

    public function contexts(Request $request) {

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->access_token
        ])
            ->get(config('app.celery_api_url').'/contexts');
        
        if ($response->successful()) {
            $data = $response->json(); 
            return $data["data"];
        } else {
            // $response->status();
            return null;
        }
    }
    
    public function employers(Request $request) {
    
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Celery-Context-Id' => $request->context_id,
            'Authorization' => 'Bearer ' . $request->access_token
        ])
            ->get(config('app.celery_api_url').'/employers?status=active');
        
        if ($response->successful()) {
            $data = $response->json(); 
            return $data["data"];
        } else {
            // $response->status();
            return null;
        }
    }

    public function employees(Request $request) {
    
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Celery-Context-Id' => $request->context_id,
            'X-Celery-Employer-Id' => $request->employer_id,
            'Authorization' => 'Bearer ' . $request->access_token
        ])
            ->get(config('app.celery_api_url').'/employees?status=active');
        
        if ($response->successful()) {
            $data = $response->json(); 
            return $data["data"];
        } else {
            // $response->status();
            return null;
        }
    }

    public function save_employees(Request $request) {
        $celery_employees = $request->json("employees");
        $user_role = App\Models\UserRole::firstWhere('role_code', 'employee');

        foreach($celery_employees as $e) {
            $celery_user = App\Models\User::where('celery_id', $e['id'])->first();
            if ($celery_user) {
                // Update
                $celery_user['first_name'] = $e['first_name'];
                $celery_user['last_name'] = $e['surname'];
                $celery_user['country_code'] = null;
                // $celery_user['telephone'] = $e['contact']['phone'];
                $celery_user['function'] = $e['position'];
                $celery_user->save();
            }else{
                // Insert
                $created_by = Auth::id();
                $company_id = Auth::user()->company_user->company_id;
                $status = 'active';
                $password = getRandomString(8);

                $new["user_role_id"] = $user_role->id;
                $new['created_by'] = $created_by;
                $new['celery_id'] = $e['id'];
                $new['first_name'] = $e['first_name'];
                $new['last_name'] = $e['surname'];
                $new['email'] = $e["id"].'@celery.com';
                $new['password'] = Hash::make($password);
                $new['country_code'] = null;
                // $new['telephone'] = $e['contact']['phone'];
                $new['function'] = $e['position'];
                $new['status'] = $status;
                $new['email_verified'] = 'yes';
                $new['token'] = null;
                $new['first_login'] = 0;
                $new['gfa_authenticated'] = 0;
                $new["google2fa_secret"] = Google2FA::generateSecretKey();
                $new['gfa_setup'] = 0;
                $new['performance_email_sent'] = 1;

                if($inserted_data = App\Models\User::create($new)) {
                    # add company user data
                    $cu_data['company_id'] = $company_id;
                    $cu_data['user_id'] = $inserted_data->id;
                    App\Models\CompanyUser::create($cu_data);
                    
                    # send temporary password
                    if ($status == 'active' && $user_role->id != $new['user_role_id']) {
                        $mail_data = ['email'=>$inserted_data->email, 'password'=>$password];
                        Mail::send('emails.'.app()->getLocale().'.user_registered', compact('mail_data'), function($message) use ($mail_data) {
                            $message->to($mail_data['email'])->subject(__('email.subject.user_registered'));
                        });
                    }
                }
            }
        }

        return json_encode(["success"=> true]);
    }
}
