<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use DataTables;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {        
        if ($request->ajax()) {
            $data = Notification::select('*')->orderBy('id', 'desc')->get();
            return Datatables::of($data)
                ->addColumn('checkbox', '<input type="checkbox" name="enquiry_id[]" value="{{$id}}" />')
                ->addColumn('markas', '<a href="{{route("enquiry-mark",["enquiry"=>$id])}}" class="btn btn-primary btn-circle"><i class="fas fa-marker"></i></a>')
                ->addColumn('delete', '<a href="{{route("enquiry-delete",["id"=>$id])}}" class="btn btn-danger btn-circle"><i class="fas fa-trash"></i></a>')
                ->addColumn('view', '<a href="{{route("enquiry-show",["id"=>$id])}}" class="btn btn-info btn-circle"><i class="fas fa-eye"></i></a>')
                ->rawColumns(['checkbox', 'markas', 'delete', 'view'])
                ->make(true);
        }
        return view('enquiry.list');
    }

    public function mark(Notification $enquiry){
        $enquiry->mark = $enquiry->mark == 0 ? 1 : 0;
        $enquiry->save();
        return redirect()->back();
    }


    public function show(Notification $id){
        
        if($id->mark == 1){
            $id->mark = $id->mark == 0;
            $id->save();
        }
        return view('enquiry.show',['enquiry' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $id)
    {
        $id->delete();
        return redirect()->back(); 
    }


    public function deleteSelected(Request $request)
    {
        $selectedIds = $request->selectedIds;
        Notification::whereIn('id', $selectedIds)->delete();
        return response()->json(['status' => 'success','message' => 'Selected records deleted successfully']);
    }

}
