<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Affiche le formulaire de connexion
    public function showLogin()
    {
        return view('login');
    }

    // Traitement de la connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Identifiants invalides.')->withInput();
    }

    // Affiche le formulaire d'inscription
    public function showRegister()
    {
        return view('register');
    }

    // Traitement de l'inscription
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
            'role' => ['required', 'in:student,teacher,company'],
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
        ]);
        Auth::login($user);
        // Création du profil selon le rôle
        if ($user->role === 'student') {
            DB::table('students')->insert([
                'user_id' => $user->id,
                'major' => 'Informatique',
                'year' => '2025',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($user->role === 'teacher') {
            DB::table('teachers')->insert([
                'user_id' => $user->id,
                'department' => 'Informatique',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($user->role === 'company') {
            DB::table('companies')->insert([
                'user_id' => $user->id,
                'name' => $user->name,
                'sector' => 'Services',
                'address' => 'Adresse inconnue',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return redirect()->route('dashboard');
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // Dashboard selon le rôle
    public function dashboard()
    {
        $role = Auth::user()->role;
        if ($role === 'student') {
            return redirect()->route('dashboard.student');
        } elseif ($role === 'teacher') {
            return redirect()->route('dashboard.teacher');
        } elseif ($role === 'company') {
            return redirect()->route('dashboard.company');
        }
        abort(403);
    }
}

