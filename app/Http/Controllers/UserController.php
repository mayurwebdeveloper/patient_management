<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = Role::get();
        if ($request->ajax()) {
            $data = User::select('*')->orderBy('id', 'desc')->get();
            return Datatables::of($data)
                ->addColumn('checkbox', '<input type="checkbox" name="user_id[]" value="{{$id}}" />')
                ->addColumn('edit', '<button onclick="editUser({{$id}})" class="edit-btn btn btn-info btn-circle"><i class="fas fa-edit"></i></button>')
                ->addColumn('delete', '<a href="{{route("user-delete",["id"=>$id])}}" class="btn btn-danger btn-circle"><i class="fas fa-trash"></i></a>')
                ->rawColumns(['checkbox', 'edit', 'delete'])
                ->make(true);
        }
        return view('user.list',['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'id'=>'required',
                'name'=>'required',
                'email'=>'required',
                'status'=>'required',
                'status'=>'required',
                'roles'=>'required',
            ]
        );

        //new record
        if($request->id == "0")
            $user=new User();
        else
            $user=User::findOrFail($request->id);

        $user->name=$request['name'];
        $user->email=$request['email'];
        if($request['password']){
            $user->password=$request['password'];
        }
        $user->status=$request['status'];
        $user->save();

        $user->syncRoles($request->roles);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $user=User::findOrFail($id);
            $user_roles = $user->roles->pluck('name','name')->all();

            $responseData = [
                'user' => $user,
                'user_roles' => $user_roles
            ];

            return response()->json($responseData, 200); // Return a JSON response with a 200 status code
        } catch (\Exception $e) {
            // Handle exceptions, for example, if the bus route is not found
            $errorMessage = 'User not found.';
            return response()->json(['error' => $errorMessage], 404); // Return a JSON response with a 404 status code
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $id)
    {
        $id->delete();
        return redirect()->back(); 
    }


    public function deleteSelected(Request $request)
    {
        $selectedIds = $request->selectedIds;
        User::whereIn('id', $selectedIds)->delete();
        return response()->json(['status' => 'error','message' => 'Selected records deleted successfully']);
    }
}
