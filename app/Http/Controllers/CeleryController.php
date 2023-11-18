<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Google2FA;

class CeleryController extends Controller
{
    public function callback(Request $request) {
        $code = $request->query('code');
        $locale = $request->query('locale');
        $userState = $request->query('userState');
        return redirect(app()->getLocale().'/celery/callback?code='.$code.'&locale='.$locale.'&userSate='.$userState);
    }

    public function webhook(Request $request) {

        Log::info('Request header: {header}', ['header' => json_encode($request->header())]);
        
        $header_email = (request()->header()['php-auth-user'][0]);
        
        // GET EVENT INFO
        $resource = $request->json('resource'); // "EMPLOYEE"
        $employee_id = $request->json('resource_id');
        $employer_id = $request->json('employer_id');
        $event_type = $request->json('event_type'); // "CREATE" | "UPDATE" | "DELETE"
        $triggered_at = $request->json('triggered_at');

        // USER ROLE
        $user_role = App\Models\UserRole::firstWhere('role_code', 'employee');

        $created_by = App\Models\User::where('email', $header_email)->first()->id;
        $company_id = App\Models\User::where('email', $header_email)->first()->company_user->company_id;

        // TOKEN CHECK
        $celery_token_found = App\Models\CeleryToken::first();

        if($celery_token_found) {
            $res = $this->access_token_refresh_token($celery_token_found->refresh_token);
            $access_token = $res? $res["access_token"]: null;
            if($access_token) {

                // GET CONTEXTS
                $response_context = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $access_token
                ])
                    ->get(config('app.celery_api_url').'/contexts');
                
                if ($response_context->successful()) {
                    $data1 = $response_context->json(); 
                    $context = $data1["data"][0];
    
                    // GET A SINGLE EMPLOYEE INFO
                    $response_employee = Http::withHeaders([
                        'Accept' => 'application/json',
                        'X-Celery-Context-Id' => $context['id'],
                        'X-Celery-Employer-Id' => $employer_id,
                        'Authorization' => 'Bearer ' . $access_token
                    ])
                        ->get(config('app.celery_api_url').'/employees/'.$employee_id);
                    
                    if ($response_employee->successful()) {
                        $data2 = $response_employee->json(); 
                        $e = $data2["data"];
                        
                        if($event_type == "CREATE") {
                            $celery_user = App\Models\User::where('celery_id', $employee_id)->first();
                            if (!$celery_user) {
                                $status = 'active';
                                $password = getRandomString(8);
                                
                                $new["user_role_id"] = $user_role->id;
                                $new['created_by'] = $created_by;
                                $new['celery_id'] = $e['id'];
                                $new['first_name'] = $e['first_name'];
                                $new['last_name'] = $e['surname'];
                                $new['email'] = $e["contact"]['email']?: "";
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
                                $new['performance_email_sent'] = 0;
                
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
                        } else if($event_type == "UPDATE") {
                            $celery_user = App\Models\User::where('celery_id', $employee_id)->first();
                            if($celery_user) {
                                $celery_user['first_name'] = $e['first_name'];
                                $celery_user['last_name'] = $e['surname'];
                                $celery_user['email'] = $e["contact"]['email']?: "";
                                // $celery_user['telephone'] = $e['contact']['phone'];
                                $celery_user['function'] = $e['position'];
                                $celery_user->save();
                            }
                        } else if($event_type == "DELETE"){ 
                            $celery_user = App\Models\User::where('celery_id', $employee_id)->first();
                            if($celery_user) {
                                $celery_user->delete();
                            }
                        }
                      
                        return ["msg" => "Employee Info Changed."];
                    }
                }
            }
        }

        $celery_webhook_found = App\Models\CeleryWebhook::where("company_id", $company_id)->first();
        
        if($celery_webhook_found) {
            $celery_webhook_found->msg = "Employee Info Changed.".$triggered_at; 
            $celery_webhook_found->save();
        } else {
            App\Models\CeleryWebhook::create(["msg" => "Employee Info Changed.".$triggered_at, "company_id" => $company_id]);
        }
        return ["msg" => "No Update."];
    }

    public function index(Request $request) {
        $page_title = __('form.label.celery');
        $code = $request->query('code');
        $company_id = Auth::user()->company_user->company_id;
        $celery_token_found = App\Models\CeleryToken::where('company_id', $company_id)->first();
        if($celery_token_found) {
            $res = $this->access_token_refresh_token($celery_token_found->refresh_token);
            $access_token = $res? $res["access_token"]: null;
            if(!$access_token) return redirect(app()->getLocale().'/users/import');
        } else {
            $res = $this->access_token_with_code($code);
            $access_token = $res? $res["access_token"]: null;
            if(!$access_token) return redirect(app()->getLocale().'/users/import');
        }
        return view("celery.index", compact('page_title', 'access_token'));
    }

    private function access_token_refresh_token($refresh_token) {
        $response = Http::asForm() 
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic ' . base64_encode(config('app.celery_client_id') . ":" . config('app.celery_secret'))
            ])
            ->post(config('app.celery_login_url').'/oauth2/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refresh_token,
                'redirect_uri'=> url('/celery/callback')
            ]);

        if ($response->successful()) {
            $data = $response->json();
            $company_id = Auth::user()->company_user->company_id;
            $celery_token_found = App\Models\CeleryToken::where('company_id', $company_id)->first();
            $data['company_id'] = $company_id;
            if($celery_token_found) {
                $celery_token_found->access_token = $data['access_token'];
                $celery_token_found->refresh_token = $data['refresh_token'];
                $celery_token_found->save();
            } else {
                App\Models\CeleryToken::create($data);
            }
            return $data;
        } else {
            // $response->status();
            return null;
        }
    }


    private function access_token_with_code($code) {
        $response = Http::asForm() 
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
            $company_id = Auth::user()->company_user->company_id;
            $celery_token_found = App\Models\CeleryToken::where('company_id', $company_id)->first();
            $data['company_id'] = $company_id;
            if($celery_token_found) {
                $celery_token_found->access_token = $data['access_token'];
                $celery_token_found->refresh_token = $data['refresh_token'];
                $celery_token_found->save();
            } else {
                App\Models\CeleryToken::create($data);
            }
            return $data;
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
            ->get(config('app.celery_api_url').'/employers');
        
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

        $created_by = Auth::id();
        $company_id = Auth::user()->company_user->company_id;
        
        foreach($celery_employees as $e) {
            $celery_user = App\Models\User::where('celery_id', $e['id'])->first();
            if ($celery_user) {
                // Update
                $celery_user['first_name'] = $e['first_name'];
                $celery_user['last_name'] = $e['surname'];
                $celery_user['email'] = $e["contact"]['email']?: "";
                // $celery_user['telephone'] = $e['contact']['phone'];
                $celery_user['function'] = $e['position'];
                $celery_user->save();
            }else{
                // Insert
                
                $status = 'active';
                $password = getRandomString(8);

                $new["user_role_id"] = $user_role->id;
                $new['created_by'] = $created_by;
                $new['celery_id'] = $e['id'];
                $new['first_name'] = $e['first_name'];
                $new['last_name'] = $e['surname'];
                $new['email'] = $e["contact"]['email']?: "";
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
                $new['performance_email_sent'] = 0;

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
        $celery_webhook_found = App\Models\CeleryWebhook::where("company_id", $company_id)->first();
        
        if($celery_webhook_found) {
            $celery_webhook_found->delete();
        }
        
        return json_encode(["success"=> true]);
    }
}
