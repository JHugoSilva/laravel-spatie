<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TryCatch;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        //return response()->json(['status' => true, 'result' => UserResource::collection($users), 'message' => 'Get Data Success']);
        return $this->sendResponse($users, "Get Data Success");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $request->validated();

        $imageName = null;

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $imageName = time() . '.' . $request->file('photo')->extension();
            $request->file('photo')->storeAs('users', $imageName, 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
            'address' => $request->address,
            'photo_profile' => $imageName,
        ]);

        //return response()->json(['status' => true, 'result' =>new UserResource($user), 'message' => 'User created!']);

        return $this->sendResponse(new UserResource($user), 'Save Data Success');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //return response()->json(['status' => true, 'result' =>new UserResource($user), 'message' => 'Get Data Success']);
        return $this->sendResponse(new UserResource($user), 'Show User Success');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserRequest $request, User $user)
    {
        // $request->validate([
        //     'name' => 'required|min:3',
        //     'email' => 'required|unique:users,email,'.$user->id,
        // ]);
        $request->validated();
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
        $user->update();
        return $this->sendResponse(new UserResource($user), 'Update Data Success');
       // return response()->json(['status' => true, 'result' =>new UserResource($user), 'message' => 'User updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->deleteOrFail();
            return response()->noContent();
        } catch (Exception $e) {
            return $this->sendError('Error Delete', $e->getMessage(), 500);
        }
    }
}