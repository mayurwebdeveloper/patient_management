<?php

namespace App\Http\Controllers;

use App\Models\PmJay;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;


class PmJayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PmJay::select('*')->orderBy('id', 'desc')->get();
                        
            return Datatables::of($data)
                ->addColumn('checkbox', '<input type="checkbox" name="pmjay_id[]" value="{{$id}}" />')
                ->addColumn('view', '<a href="{{route("view-pm-jay-resource",["id"=>$id])}}" class="btn btn-primary btn-circle"><i class="fas fa-eye"></i></a>')
                ->addColumn('edit', '<a href="{{route("edit-pm-jay-resource-form",["id"=>$id])}}" class="btn btn-info btn-circle"><i class="fas fa-edit"></i></a>')
                ->addColumn('delete', '<a href="{{route("pm-jay-resource-delete",["id"=>$id])}}" class="btn btn-danger btn-circle"><i class="fas fa-trash"></i></a>')
                ->rawColumns(['checkbox', 'view', 'edit', 'delete'])
                ->make(true);
        }
        return view('pm-jay-resource.list');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pm-jay-resource.create');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        $request->validate([
            'title' => 'required|max:100',
            'description' => 'required',
            'status' => 'required',
            'document_title' => 'max:50',
        ]);


        DB::beginTransaction();

        try {
        
        $resource=new PmJay();
        $resource->status = $request['status'];
        $resource->title = $request['title'];
        $resource->description = $request['description'] ?? "";

        $resource->document_title = $request['document_title'] ?? "";

        if ($request->hasFile('document')) {

            // store pmjay document
            $pmjayBrochurePath = 'images/pmjay/documents';
            if (!file_exists($pmjayBrochurePath)) {
                mkdir($pmjayBrochurePath, 0777, true);
            }

            $document = $request->file('document');
            $document_name = time() . mt_rand(1, 2000) . '.' . $document->extension();
            $Folder = public_path($pmjayBrochurePath);
            $document->move($Folder, $document_name);
            $resource->document = $document_name;
        }

            if($resource->save())
            {
                DB::commit();
                return redirect()->route('pm-jay-resources')->with('success','Record has been added');
            } else {
                throw new \Exception('Failed to save record');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pm-jay-resources')->with('error','something went wrong!!!');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pmjay_resource=PmJay::findOrFail($id);
        $data = compact('pmjay_resource');   
        return view('pm-jay-resource.show')->with($data);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pmjay_resource=PmJay::findOrFail($id);   
        $data = compact('pmjay_resource');   
        return view('pm-jay-resource.edit')->with($data);
    }



        /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'pmjay_id' => 'required',
            'title' => 'required|max:100',
            'description' => 'required',
            'status' => 'required',
            'document_title' => 'max:50',
        ]);


        DB::beginTransaction();

        try {
        
        $resource=PmJay::findOrFail($request->pmjay_id);
        $resource->status = $request['status'];
        $resource->title = $request['title'];
        $resource->description = $request['description'] ?? "";

        $resource->document_title = $request['document_title'] ?? "";

        if ($request->hasFile('document')) {

            // store pmjay document
            $pmjayBrochurePath = 'images/pmjay/documents';
            if (!file_exists($pmjayBrochurePath)) {
                mkdir($pmjayBrochurePath, 0777, true);
            }

            $document = $request->file('document');
            $document_name = time() . mt_rand(1, 2000) . '.' . $document->extension();
            $Folder = public_path($pmjayBrochurePath);
            $document->move($Folder, $document_name);
            $resource->document = $document_name;
        }

            if($resource->save())
            {
                DB::commit();
                return redirect()->route('pm-jay-resources')->with('success','Record has been updated');
            } else {
                throw new \Exception('Failed to save record');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pm-jay-resources')->with('error','something went wrong!!!');
        }

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PmJay $id)
    {
        $id->delete();
        return redirect()->back(); 
    }


    public function deleteSelected(Request $request)
    {
        $selectedIds = $request->selectedIds;

        // Delete PmJay
        PmJay::whereIn('id', $selectedIds)->delete();

        return response()->json(['message' => 'Selected records deleted successfully']);
    }


}
