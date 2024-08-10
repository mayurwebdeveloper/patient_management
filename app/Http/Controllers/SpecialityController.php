<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;


class SpecialityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Speciality::select('*')->orderBy('id', 'desc')->get();
            return Datatables::of($data)
                ->addColumn('checkbox', '<input type="checkbox" name="speciality_id[]" value="{{$id}}" />')
                ->addColumn('edit', '<button onclick="editSpeciality({{$id}})" class="edit-btn btn btn-info btn-circle"><i class="fas fa-edit"></i></button>')
                ->addColumn('delete', '<a href="{{route("speciality-delete",["id"=>$id])}}" class="btn btn-danger btn-circle"><i class="fas fa-trash"></i></a>')
                ->rawColumns(['checkbox', 'edit', 'delete'])
                ->make(true);
        }
        return view('speciality.list');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'id'=>'required',
                'title'=>'required|max:100',
                'status'=>'required'
            ]
        );

        DB::beginTransaction();

        try {
            //new record
            if($request->id == "0")
                $speciality=new Speciality();
            else
                $speciality=Speciality::findOrFail($request->id);

            $speciality->title=$request['title'];
            
            $speciality->status=$request['status'];


            if($speciality->save())
            {
                DB::commit();
            } else {
                throw new \Exception('Failed to save record');
            }

        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $speciality=Speciality::findOrFail($id);

            $responseData = [
                'speciality' => $speciality
            ];

            return response()->json($responseData, 200); // Return a JSON response with a 200 status code
        } catch (\Exception $e) {
            $errorMessage = 'Speciality not found.';
            return response()->json(['error' => $errorMessage], 404); // Return a JSON response with a 404 status code
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Speciality $id)
    {
        $id->delete();
        return redirect()->back(); 
    }


    public function deleteSelected(Request $request)
    {
        $selectedIds = $request->selectedIds;
        Speciality::whereIn('id', $selectedIds)->delete();
        return response()->json(['status' => 'success','message' => 'Selected records deleted successfully']);
    }
}
