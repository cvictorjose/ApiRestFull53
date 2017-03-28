<?php

namespace App\Http\Controllers\Auth;
use App\User;
use App\Cart;
use App\Order;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Response;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/login'; //'/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest', ['except' => 'logout']);
    }

    protected function authenticated(Request $request, User $user)
    {
        return redirect()->intended();
    }

    public function doLogin(Request $request)
    {

        // validate the info, create rules for the inputs
        $rules = array(
            'email'    => 'required|email', // make sure the email is an actual email
            'password' => 'required|alphaNum|min:6' // password can only be alphanumeric and has to be greater than 3
            // characters
        );

        // run the validation rules on the inputs from the WPSite
        $validator = Validator::make(Input::all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return $this->createMessageError("Failed validation inputs","403");
        } else {
            // user data for the authentication
            $userdata = array(
                'email'     => Input::get('email'),
                'password'  => Input::get('password')
            );

            // attempt to do the login
            if (Auth::attempt($userdata)) {

                // Creating connected Cart. FIXME: we need a method to clean orphaned carts.
                $cart = new Cart;
                $cart->session_id = Session::getId();
                $cart->save();

                $session_cookie = (isset($_COOKIE['laravel_session'])) ?: '';

                return $this->createMessage(array(
                                "message"         =>  "Login successful",
                                "session_cookie"  =>  $session_cookie,
                                "cart_id"         =>  $cart->id
                                ),
                              "200");
               /* print_r($data = $request->session('laravel_session')->all());
                if ($request->session()->has('_token')) {
                    //echo "has token";
                }else{
                    $new_session=$request->session()->regenerate();
                }*/


                /* $api_token= Auth::user()->api_token;
                  $accessToken = Request::header('Authorization');
                  if(!empty($accessToken)){

                      //$check_token= User::where('api_token', $accessToken)->first();
                      //if ($check_token){
                          //return ['Token'=> $accessToken, 'Status'=> '200'];
                      //return $this->createMessage("Login successful","200");
                      //}else{
                      //return $this->createMessageError("Access token not valid","403");
                      //}


                  }else{
                      //return Request::header('Authorization'); //THE PROBLEM
                      //return Response::json(['error'=>'Not authorized. Access token needed in Header.Authorization'], 403);
                      return $this->createMessageError("Not authorized. Access token needed in Header.Authorization",
                          "403");
                  }*/
            } else {
                // validation not successful, send back to form
                return $this->createMessageError("Login failed","404");
            }
        }
    }

    public function loginStatus()
    {
      if (Auth::check()) {
        $cart = Cart::where('session_id', Session::getId())->first();
        $last_order = Order::where('session_id', Session::getId())->orderBy('id', 'desc')->first();
        $last_order_id = ($last_order) ? $last_order->id : '';
        return $this->createMessage(array(
                "message"         =>  "Logged in",
                "session_id"      =>  Session::getId(),
                "session_cookie"  =>  $_COOKIE['laravel_session'],
                "xsrf_token"      =>  csrf_token(),
                "cart_id"         =>  $cart->id,
                "last_order_id"   =>  $last_order_id,
                ),
              "200");
      }else{
        return $this->createMessage(array(
                "message" =>  "Not logged in",
                ),
              "200");        
      }
    }

    public function logout()
    {
        Auth::logout();
        return $this->createMessage("Logout successful","200");
    }
}
