<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Mail\SendEmail;
use App\Jobs\SendMailJob;
use Illuminate\Support\Facades\Mail;
use function Laravel\Prompts\password;
use Intervention\Image\Facades\Image;

class LoginRegisterController extends Controller
{
    


    public function __construct()
    {
        $this->middleware('guest')-> except([
            'logout', 'dashboard'
        ]);
    }


    public function register(){
        return view('auth.register');
    }


    public function store (Request $request)
    {
        $request -> validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed',
            'photo' => 'image|nullable|max:1999'
        ]);

        // file upload

        $path = null; // Inisialisasi dengan null
        $pathTumbnail = null; // Inisialisasi dengan null
        $pathSquare = null; // Inisialisasi dengan null

        if($request -> hasFile('photo')){
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameSimpan = $filename.'_'.time().'.'.$extension;

            $path = $request->file('photo')->storeAs('photos', $filenameSimpan);

            // resize ke thumbnail
            $thumbnail = Image::make($request->file('photo')->getRealPath())->resize(150, 150);
            $thumbnailSimpan = time() . '_thumbnail_' . $request->file('photo')->getClientOriginalName(); // penamaan
            $thumbnail->save(public_path() . '/storage/photos/' . $thumbnailSimpan);

            // resize ke square
            $square = Image::make($request->file('photo')->getRealPath())->resize(200, 200);
            $squareSimpan = time() . '_square_' . $request->file('photo')->getClientOriginalName(); // penamaan
            $square->save(public_path() . '/storage/photos/' . $squareSimpan);

            // Simpan path gambar baru ke dalam array data user
            $pathTumbnail = 'photos/' . $thumbnailSimpan;
            $pathSquare = 'photos/' . $squareSimpan;
        } else {
            // kalo gada file foto
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $path,
            'thumbnail' => $pathTumbnail,
            'square' => $pathSquare
        ]);

        $content = [
            'subject'   => $request->name,
            'body'      => $request->email
            ];

        Mail::to($request->email)->send(new SendEmail($content));

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('login')
            ->withSuccess('You have successfully registered & logged in!');
    }

    public function login(){
        return view ('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')
            ->withSuccess('You have successfully logged in');
        }

        return back()->withErrors([
            'email' => 'Yourprovided credentials do not match in our record.',
            ]) -> onlyInput('email');
    }


    public function dashboard(){
        if(Auth::check()){
            return view('auth.dashboard');
        }

        return redirect()->route('login')
        ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
        ->withSuccess('You have logged out successfully');;
    }




}