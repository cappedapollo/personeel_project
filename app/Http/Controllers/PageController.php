<?php
namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Mail;
use Google2FA;

class PageController extends Controller
{
    public function gfa_register(Request $request)
    {
        $page_title = 'Google Authenticator';
        $user = Auth::user();
        $secret = $user->google2fa_secret;
        
        # Generate the QR image. This is the image the user will scan with their app
        # to set up two factor authentication
        $QR_Image = Google2FA::getQRCodeInline(
            config('app.name'),
            $user->email,
            $secret
        );
    
        return view('google2fa.register', compact('page_title', 'QR_Image', 'secret'));
    }
    
    public function verify(Request $request)
    {
        $page_title = 'OTP Login';
        return view('google2fa.index', compact('page_title'));
    }
    
    public function gfa_authenticate(Request $request) {
        $data['gfa_authenticated'] = 1;
        $data['gfa_setup'] = 0;
        App\Models\User::where('id', Auth::id())->update($data);
        $user = App\Models\User::find(Auth::id());
        #Auth::setUser($user);
        $request->session()->regenerate();
        
        $redirect = '/';
        if ($user->first_login == 1) {
            $redirect = app()->getLocale().'/profile';
        }
        return redirect($redirect);
    }
    
    public function gfa_generate_link(Request $request)
    {
        $user = Auth::user();
        $token = strtotime("now");
        $_user = Crypt::encryptString($user->id.' '.$user->email);
    
        # send mail to register 2fa
        $data = ['name'=>$user->full_name, 'register_url'=>config("app.url").app()->getLocale().'/gfa_setup/'.$token.'/'.$_user];
        Mail::send('emails.'.app()->getLocale().'.gfa_setup', compact('user', 'data'), function($message) use ($user) {
            $message->to($user->email)->subject(__('email.subject.gfa_setup'));
        });
    
        # update user data
        $user->token = $token;
        $user->gfa_setup = 1;
        $user->gfa_authenticated = 0;
        $user->google2fa_secret = Google2FA::generateSecretKey();
        $user->save();

        # clear all session
        Google2FA::logout();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login')->with('success', __('messages.gfa_setup_link_send'));
    }
    
    public function gfa_setup(Request $request)
    {
        $token = $request->segment(3);
        $_user = Crypt::decryptString($request->segment(4));
        $_user_arr = explode(' ', $_user);
        $user_id = $_user_arr[0];
        $user_email = $_user_arr[1];
    
        $user = App\Models\User::find($user_id);
        if ($user) {
            $start_datetime = new \DateTime(date('Y-m-d H:i:s', $token));
            $end_datetime = new \DateTime("now");
            $date_diff = $start_datetime->diff($end_datetime);
             
            $_hours = $_minutes = $_seconds = 0;
            $hours = $date_diff->h;
            $minutes = $date_diff->i;
            $seconds = $date_diff->s;
            $hours = $hours + ($date_diff->days * 24);
             
            $_seconds += $hours * 3600;
            $_seconds += $minutes * 60;
            $_seconds += $seconds;
             
            $_hours = floor($_seconds / 3600);
            $_seconds -= $_hours * 3600;
            $_minutes  = floor($_seconds / 60);
            $_seconds -= $_minutes * 60;
             
            if($_hours >= 1) {
                return redirect('login')->with('error', __('messages.link_expired'));
            }else{
                $user->token = '';
                if($user->save()) {
                    Auth::login($user);
                    return redirect(app()->getLocale().'/gfa_register');
                }
            }
        }else{
            return redirect('login')->with('error', __('messages.invalid_link'));
        }
    }
}
