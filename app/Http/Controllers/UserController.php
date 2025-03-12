<?php
namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role.permissions'])->where('id', '!=', auth()->id())->get();
        $roles = Role::where('status', 1)->get();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'user_role' => 'required|exists:roles,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->user_role,
        ]);

        $this->storeUserDetails($user->id, $request);

        return response()->json(['success' => true, 'message' => 'User added successfully.']);
    }
    
    private function storeUserDetails($userId,Request $request)
    {
        $imagePath=null;
        if($request->hasFile('image'))
        {
            $imagePath=$request->file('image')->store('profile_images','public');
        }
          UserDetail::create([
             'user_id'=>$userId,
             'specialization' => json_encode($request->specialization),
             'education' => json_encode($request->education),
             'image' => $imagePath, 
             'phone' => $request->phone,
             'experience' => $request->experience,
             'joining_date' => $request->joining_date,
             'address' => $request->address,
             'bio' => $request->bio,
             'status' => 'active', // Default status
             'gender' => $request->gender,
             'dob' => $request->dob,
             'blood_group' => $request->blood_group,
          ]);
    }

    

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'role_id' => $request->role
        ]);

        return response()->json(['message' => 'User updated successfully!']);
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'status' => 'success',
                'message' => "User Deleted",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting user!'
            ], 500);
        }
    }
}
