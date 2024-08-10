<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use App\Models\Slider;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class SliderController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Slider::select('*')->orderBy('id', 'desc')->get();
                        
            return Datatables::of($data)
                ->addColumn('checkbox', '<input type="checkbox" name="slider_id[]" value="{{$id}}" />')
                ->addColumn('view', '<a href="{{route("view-slider",["id"=>$id])}}" class="btn btn-primary btn-circle"><i class="fas fa-eye"></i></a>')
                ->addColumn('edit', '<a href="{{route("edit-slider-form",["id"=>$id])}}" class="btn btn-info btn-circle"><i class="fas fa-edit"></i></a>')
                ->addColumn('delete', '<a href="{{route("slider-delete",["id"=>$id])}}" class="btn btn-danger btn-circle"><i class="fas fa-trash"></i></a>')
                ->rawColumns(['checkbox', 'view', 'edit', 'delete'])
                ->make(true);
        }
        return view('slider.list');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('slider.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title'=>'required',
                'code'=>'required',
                'status'=>'required',
            ]
        );

        

        $slider=new Slider();
        $slider->title=$request['title'];
        $slider->code=Str::slug($request['code'], '-');
        $slider->status=$request['status'];

        if($slider->save())
        {
            $lastInsertedId = $slider->id;

            // add slides
            $slidePath = 'images/slider/documents';
            
            if (!file_exists($slidePath)) {
                mkdir($slidePath, 0777, true);
            }

            if ($request->hasFile('slides')) {
                $i=0;
                foreach ($request->file('slides') as $slide) {
                    $slide_image_name = time() . mt_rand(1, 2000) . '.' . $slide->extension();
                    $Folder = public_path($slidePath);
                    $slide->move($Folder, $slide_image_name);

                    //insert slides in database
                    $slide = new Slide();
                    $slide->slider_id = $lastInsertedId;   
                    $slide->slide = $slide_image_name;   
                    $slide->title = "";   
                    $slide->type = "I";
                    $slide->save();
                    $i++;
                }
            }

            return redirect()->route('sliders')->with('success','Slider has been added');
        }

        return redirect()->route('sliders')->with('error','something went wrong!!!');
    }



        /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slider=Slider::findOrFail($id);
        $slides = Slide::where("slider_id",$slider->id)->get();
        $slideCount = count($slides);
        $data=compact('slider','slides','slideCount');
        return view('slider.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate(
            [
                'slider_id'=>'required',
                'title'=>'required',
                'code'=>'required',
                'status'=>'required',
            ]
        );


        $slider=Slider::findOrFail($request->slider_id);
        $slider->title=$request['title'];
        $slider->code=Str::slug($request['code'], '-');
        $slider->status=$request['status'];
        
        if($slider->save())
        {
            $lastInsertedId = $slider->id;

             // delete Slides
            Slide::where('slider_id',$lastInsertedId)->delete();

            //insert old slides data
            if($request->old_slides != null)
            {
                $p=0;
                foreach ($request->old_slides as $old_slide) {

                    //insert slides in database
                    $slide = new Slide();
                    $slide->slider_id = $lastInsertedId;   
                    $slide->slide = $old_slide;   
                    $slide->title = "";   
                    $slide->type = "I";
                    $slide->save();
                    $p++;
                }
            }

            // add slides
            $slidePath = 'images/slider/documents';

            if (!file_exists($slidePath)) {
                mkdir($slidePath, 0777, true);
            }
       

            if ($request->hasFile('slides')) {
                $i=0;
                foreach ($request->file('slides') as $slide) {
                    $slide_image_name = time() . mt_rand(1, 2000) . '.' . $slide->extension();
                    $Folder = public_path($slidePath);
                    $slide->move($Folder, $slide_image_name);

                    //insert slides in database
                    $slide = new Slide();
                    $slide->slider_id = $lastInsertedId;   
                    $slide->slide = $slide_image_name;   
                    $slide->title = "";   
                    $slide->type = "I";
                    $slide->save();
                    $i++;
                }
            }

            return redirect()->route('sliders')->with('success','Slider has been updated');
        }

        return redirect()->route('sliders')->with('error','something went wrong!!!');

    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $slider=Slider::findOrFail($id);
        $slides = Slide::where("slider_id",$slider->id)->get();
        $slideCount = count($slides);
        $data=compact('slider','slides','slideCount');
        return view('slider.show')->with($data);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $id)
    {
        $id->sliderSlides()->delete();
        $id->delete();
        return redirect()->back(); 
    }


    public function deleteSelected(Request $request)
    {
        $selectedIds = $request->selectedIds;
        

        // Find the posts by their IDs
        $sliders = Slider::whereIn('id', $selectedIds)->get();

        // Loop through the sliders and delete associated records
        foreach ($sliders as $slider) {
            $slider->sliderSlides()->delete();
        }

        // Delete the sliders
        Slider::whereIn('id', $selectedIds)->delete();

        return response()->json(['status' => 'error','message' => 'Selected records deleted successfully']);
    }


}