<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::when($request->search, function($query)use($request){
            $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email','like', '%'.$request->search.'%');
        })->paginate(2)->appends(['search' => $request->search]);
        return view('users.user', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create User";
        $roles = Role::all();
        return view('users.formUser', compact('title', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);

        $imageName = null;

        // if ($request->photo) {
        //     $imageName = time().'.'.$request->file('photo')->extension();
        //     $request->photo->move(public_path('images'), $imageName);
        // }

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $imageName = time() . '.' . $request->file('photo')->extension();
            $request->file('photo')->storeAs('users', $imageName, 'public');


            // $request->photo = $imageName;
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'photo_profile' => $imageName
        ]);

        $user->assignRole($request->roles);

        return redirect()->back()->with('success', 'User created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.userShow', [
            'id' => $user->name
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $title = "Edit User";
        $roles = Role::all();

        $dataRoles = $user->roles->pluck('name')->toArray();
        return view('users.editUser',  [
            'user' => $user,
            'roles' => $roles,
            'title' => $title,
            'dataRoles' => $dataRoles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|unique:users,email,'.$user->id,
        ]);

        $imageName = null;

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $imageName = time() . '.' . $request->file('photo')->extension();
            $request->file('photo')->storeAs('users', $imageName, 'public');

            $path = storage_path('app/public/users/' . $user->icon);

            if (File::exists($path)) {
                File::delete($path);
            }

            $user->photo_profile = $imageName;
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password != "") {
            $user->password = Hash::make($request->password);
        }

        $user->address = $request->address;
        // dd($request->roles);
        $user->update();
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->deleteOrFail();
            $path = public_path('images/'.$user->photo_profile);

            if (File::exists($path)) {
                File::delete($path);
            }

            return redirect()->back()->with('success', 'User deleted!');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
