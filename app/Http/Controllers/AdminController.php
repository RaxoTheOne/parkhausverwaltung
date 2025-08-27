<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Parkhaus;
use App\Models\Ticket;
use App\Models\EinAusfahrt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_parkhaeuser' => Parkhaus::count(),
            'total_tickets' => Ticket::count(),
            'active_tickets' => Ticket::where('status', 'aktiv')->count(),
            'today_entries' => EinAusfahrt::whereDate('created_at', today())->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function parkhausIndex()
    {
        $parkhaeuser = Parkhaus::withCount(['parkplaetze', 'tickets'])->get();
        return view('admin.parkhaus.index', compact('parkhaeuser'));
    }

    public function parkhausShow(Parkhaus $parkhaus)
    {
        $parkhaus->load(['parkplaetze', 'tickets.fahrzeug']);
        return view('admin.parkhaus.show', compact('parkhaus'));
    }

    public function adminIndex()
    {
        $admins = Admin::with('parkhaus')->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function adminCreate()
    {
        $parkhaeuser = Parkhaus::all();
        return view('admin.admins.create', compact('parkhaeuser'));
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:super_admin,parkhaus_admin,mitarbeiter'],
            'parkhaus_id' => ['nullable', 'exists:parkhaeuser,id'],
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'parkhaus_id' => $request->parkhaus_id,
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin erfolgreich erstellt!');
    }
}
