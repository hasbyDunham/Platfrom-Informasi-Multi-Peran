<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // Menampilkan form registrasi untuk user biasa
    public function showUserRegistrationForm()
    {
        return view('auth.register_user');
    }

    // Menangani proses registrasi user
    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // $user =
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // $user->assignRole('user'); // Beri peran user biasa

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    // Menampilkan form registrasi untuk penulis
    public function showWriterRegistrationForm()
    {
        $categories = Categorie::all();
        return view('auth.register_writer', compact('categories'));
    }

    // Menangani proses registrasi writer
    public function registerWriter(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id', // Validasi kategori harus ada di database
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // dd($request->all());

        $user->assignRole('Writer'); // Beri peran writer

        // Ambil kategori yang valid
        // $validCategories = Categorie::whereIn('id', $request->categories)->pluck('id')->toArray();

        // Cek apakah kategori valid atau tidak
        // \Log::info('Kategori yang dipilih:', $request->categories);
        // \Log::info('Kategori yang valid:', $validCategories);

        // $user->categories()->sync($validCategories); // Simpan kategori yang dipilih

        $categoryIds = array_map('intval', $request->categories);
        $existingCategories = Categorie::whereIn('id', $categoryIds)->pluck('id')->toArray();

        // dd([
        //     'categories_requested' => $categoryIds, // ID kategori yang dikirim user
        //     'existing_categories' => $existingCategories, // ID kategori yang benar-benar ada di database
        //     'user_id' => $user->id, // ID user yang sedang dibuat
        // ]);

        // $categoryIds = Categorie::whereIn('id', array_map('intval', $request->categories))
        //     ->pluck('id')
        //     ->toArray();

        $user->categories()->sync($categoryIds);
        // foreach ($categoryIds as $categoryId) {
        //     $user->categories()->attach($categoryId);
        // }

        return redirect()->route('login')->with('success', 'Registrasi sebagai penulis berhasil, silakan login.');
    }

    protected function registered(\illuminate\Http\Request $request, $user)
    {
        // logout the user after registration
        $this->guard()->logout();

        // redirect to the login page
        return redirect($this->redirectPath())->with('status', 'Registration successful');
    }
}
