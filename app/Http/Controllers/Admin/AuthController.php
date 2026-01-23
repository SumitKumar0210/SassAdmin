<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\EmailLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\EmailOtp;
use App\Models\Admin\AdminConfiguration;
use App\Models\Admin\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Services\AdminAuditService;

class AuthController extends Controller
{
   public function index()
   {
      $hotlr = AdminConfiguration::get(['logo', 'name']);
      return view('admin.auth.login', compact('hotlr'));
   }

   public function forget()
   {
      $hotlr = AdminConfiguration::get(['logo', 'name']);
      return view('admin.auth.forgot-password', compact('hotlr'));
   }

   public function forgetpass()
   {
      $hotlr = AdminConfiguration::get(['logo', 'name']);
      return view('admin.auth.forget-password', compact('hotlr'));
   }
   public function authenticate(Request $request)
   {
      // $auth = Auth::attempt(
      //    [
      //       'email' => strtolower($request->email),
      //       'password' => $request->password
      //    ],
      //    true
      // );
      $auth = false;
      $user = User::where('email', strtolower($request->email))->first();

      if ($user && Hash::check($request->password, $user->password)) {
         Auth::guard('super_admin')->login($user, true);
         $auth = true;
      }
      \Log::info('Admin login attempt', [
         'user' => $user
      ]);
      if ($auth) {
         AdminAuditService::log('admin_logged_in', $user);
         $response = response()->json(['success' => true, 'user_id' => auth()->guard('super_admin')->id(), 'user_name' => auth()->guard('super_admin')->user()->name], 200);
      } else {
         $response = response()->json(['error_success' => 'credentials do not matched !'], 200);
      }
      return $response;
   }
   public function sendOtp(Request $request)
   {

      if ($request->ajax()) {
         $validator = Validator::make($request->all(), [
            'email' => 'required|email',
         ]);
         if ($validator->fails()) {
            return response()->json([
               'error_validation' => $validator->errors()->all(),
            ], 200);
         }
      }

      $otp = random_int(100000, 999999);
      $emails = $request->email;
      $user = User::where('email', $emails)->first(['id','email']); // checking email ID found in db.
      $check_email = $user->email ?? '';
      if ($check_email == $emails) {  // checking entered email and db email are same or not.
         $check_emailotp = EmailOtp::where('email', $emails)->get(['email']);
         $check_emailotp = $check_emailotp[0]->email ?? '';
         if ($check_emailotp == '') {
            $emailotp = new EmailOtp();
            $emailotp->email = $emails;
            $emailotp->otp = $otp;
            $emailotp->save(); // save new email id and otp in db.
         } else {
            $update = EmailOtp::where('email', $emails)->update(
               [
                  'otp' => $otp
               ]
            ); // updating otp in db againt email id.
         }
         Mail::send('backend.email.otp', ['otp' => $otp], function ($message) use ($request) {
            $message->to($request->input('email'))->subject('OTP For Password Reset');
         }); //OTP send on mail function
         AdminAuditService::log('otp_sent', $user, ['email' => $user->email]);
         return response()->json(['success' => 'OTP sent successfully']);
      } else {
         $response = response()->json(['errors_success' => 'Email id not found'], 200);
      }
      return $response;
   }
   public function verifyotp(Request $request)
   {
      $user_email = $request->email;
      $user_otp = $request->otp;
      $check_otp = EmailOtp::where('email', $user_email)->get();
      $otp_time = $check_otp[0]->updated_at;
      $mytime = Carbon::now()->toDateTimeString();
      $startTime = Carbon::parse($otp_time);
      $finishTime = Carbon::parse($mytime);
      $otpduration = $finishTime->diffInMinutes($startTime) ?? '';
      $otp = $check_otp[0]->otp ?? '';
      $email = $check_otp[0]->email ?? '';
      if ($user_email == $email && $user_otp == $otp && $otpduration <= 15) {
         AdminAuditService::log('otp_verified', $check_otp[0]);
         $response = response()->json(['success' => 'OTP Verified successfully'], 200);
      } else {
         $response = response()->json(['errors_success' => 'Error in OTP Verification !'], 200);
      }
      return $response;
   }
   public function updatepass(Request $request)
   {
      $user_email = $request->email;
      $pass = $request->pass;
      $cpass = $request->cpass;
      $update = User::where('email', $user_email)->first();
      if ($pass == $cpass) {
         $pass1 = Hash::make($pass);
         $update->update(
            [
               'password' => $pass1,
            ]
         );
         AdminAuditService::log('password_changed', $update);
         $response = response()->json(['success' => 'Password changed successfully'], 200);
      } else {
         $response = response()->json(['errors_success' => 'Error in changing password !'], 200);
      }
      return $response;
   }
   public function magiclink(Request $request)
   {
      if ($request->ajax()) {
         $validator = Validator::make($request->all(), [
            'email' => 'required|email',
         ]);
         if ($validator->fails()) {
            return response()->json([
               'error_validation' => $validator->errors()->all(),
            ], 200);
         }
      }
      $token = Str::random(30);
      $magic_link = url('/m-l', ['token' => $token]);
      $user_email = $request->email;
      $check_email = User::where('email', $user_email)->get(['email']); // checking email ID found in db.
      $check_email = $check_email[0]->email ?? '';
      if ($check_email == $user_email) {  // checking entered email and db email are same or not.
         $check_emaillink = EmailLink::where('email', $user_email)->get(['email']);
         $check_emaillink = $check_emaillink[0]->email ?? '';
         if ($check_emaillink == '') {
            $emaillink = new EmailLink();
            $emaillink->email = $user_email;
            $emaillink->token = $token;
            $emaillink->magic_link = $magic_link;
            $emaillink->save(); // save new email id and otp in db.
         } else {
            EmailLink::where('email', $user_email)->update(
               [
                  'token' => $token,
                  'magic_link' => $magic_link,
                  'status' => "active"
               ]
            ); // updating otp in db againt email id.
         }
         Mail::send('backend.email.magiclink', ['magiclink' => $magic_link], function ($message) use ($request) {
            $message->to($request->input('email'))->subject('Magic Link For Password Reset');
         }); //password reset link send on mail function
         return response()->json(['success' => 'Magic Link sent successfully'], 200);
      } else {
         $response = response()->json(['error_success' => 'Email id not found!']);
      }
      return $response;
   }

   public function magicLinkVerify($token)
   {
      $emailtoken = EmailLink::where('token', $token)->get();
      $user_email = $emailtoken[0]->email ?? '';
      $status = $emailtoken[0]->status ?? '';
      $link_time = $emailtoken[0]->updated_at ?? '';
      $mytime = Carbon::now()->toDateTimeString();
      $startTime = Carbon::parse($link_time);
      $finishTime = Carbon::parse($mytime);
      $otpduration = $finishTime->diffInMinutes($startTime) ?? '';
      if ($status == 'active' && $otpduration <= 15) {
         $user = User::where('email', $user_email)->get(['plain_password']);
         $user_pass = $user[0]->plain_password ?? '';
         $request = new Request([
            'email' => $user_email,
            'password' => $user_pass, // Assuming this is the plain text password, otherwise you'll need to handle this differently
         ]);
         $response = $this->authenticate($request); // Call the authenticate method
         $response_data = json_decode($response->getContent(), true); // Decode the JSON response

         // Ensure success key exists before accessing it
         if (isset($response_data['success']) && $response_data['success'] === true) {
            EmailLink::where('token', $token)->update([
               'status' => 'inactive'
            ]); //change status when success login.
            return redirect()->route('backend.dashboard'); //open dashboard when success login with magic link.
         } else {
            return redirect()->route('backend.token_error'); //it run when token is wrong.
         }
      } else {
         return redirect()->route('backend.token_error'); //it run when status is not active and link time is less then 15 min.
      }
   }
   public function tokenError()
   {
      $hotlr = AdminConfiguration::get(['logo', 'name']);
      return view('backend.auth.token_error', compact('hotlr'));
   }
   public function destroy(Request $request)
   {
      AdminAuditService::log('admin_logged_out',Auth::guard('super_admin')->user());
      Auth::guard('super_admin')->logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      return redirect()->route('admin.index');
      //   return view('backend.auth.logout');

   }
}
