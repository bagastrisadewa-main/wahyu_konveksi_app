<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $keyword = $request->input('name');

        $query = DB::table('users')
            ->when($keyword, function ($q) use ($keyword) {
                $q->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('name', 'like', "%$keyword%")
                             ->orWhere('email', 'like', "%$keyword%");
                });
            })
            ->orderBy('id', 'desc');

        $users = $query->paginate($perPage);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('pages.users.partials.table', compact('users'))->render()
            ]);
        }

        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('pages.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone'    => 'nullable|string|max:20',
            'roles'    => 'required|in:admin,karyawan',
            'photo'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data['password'] = Hash::make($data['password']);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('users', $filename, 'public');
            $data['photo'] = $filename;
        }

        $user = User::create($data);

        ActivityLog::create([
            'user_id'    => auth()->id(),
            'description'=> 'Menambahkan user: ' . $user->name,
            'action'     => 'create',
            'module'     => 'user',
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'phone'    => 'nullable|string|max:20',
            'roles'    => 'required|in:admin,karyawan',
            'password' => 'nullable|min:6',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo && \Storage::disk('public')->exists('users/' . $user->photo)) {
                \Storage::disk('public')->delete('users/' . $user->photo);
            }

            $filename = time() . '.' . $request->photo->getClientOriginalExtension();
            $request->photo->storeAs('users', $filename, 'public');
            $data['photo'] = $filename;
        }

        $user->update($data);

        ActivityLog::create([
            'user_id'    => auth()->id(),
            'description'=> 'Memperbarui user: ' . $user->name,
            'action'     => 'update',
            'module'     => 'user',
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        ActivityLog::create([
            'user_id'    => auth()->id(),
            'description'=> 'Menghapus user: ' . $user->name,
            'action'     => 'delete',
            'module'     => 'user',
        ]);

        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('pages.profile.show', compact('user'));
    }

    public function editProfile()
    {
        $user = auth()->user();
        return view('pages.profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'photo' => 'nullable|image|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists('users/' . $user->photo)) {
                Storage::disk('public')->delete('users/' . $user->photo);
            }
            $path = $request->file('photo')->store('users', 'public');
            $user->photo = basename($path);
        }

        $user->save();

        ActivityLog::create([
            'user_id'    => $user->id,
            'description'=> 'Memperbarui profil diri',
            'action'     => 'update',
            'module'     => 'profile',
        ]);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui');
    }

public function activities()
{
    $user = auth()->user();

    // Pakai model ActivityLog agar created_at otomatis jadi objek Carbon
    $logs = ActivityLog::where('user_id', $user->id)
        ->latest()
        ->limit(100)
        ->get();

    return view('pages.profile.activities', compact('logs'));
}
}
