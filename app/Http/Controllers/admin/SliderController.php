<?php

namespace App\Http\Controllers\admin;

use Gate;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;


class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('slider_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        if ($request->ajax()) {
            $data = Slider::select('*');
            // dd($data);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $image= $row->getFirstMediaUrl('image');
                    if ($image) {
                        return "<img src='$image' alt='User Image' style='width: 70px; height: 70px;'>";
                    } else {
                        return 'No user image';
                    }
                })
                ->addColumn('status', function ($row) {
                   return $row->status == 1 ? 'Enable' : 'Disable';
                })
                ->addColumn('action', function ($row) {
                    $editBtn = '<a class="dropdown-item" href="' . route('slider.edit', $row->id) . '">
                                    <i class="fas fa-edit"></i> Edit
                                </a>';
                    $deleteBtn = '<form action="'. route('slider.destroy', $row->id) .'" method="POST" style="display:inline;">
                        '. csrf_field() .'
                        '. method_field("DELETE") .'
                        <button type="submit" class="dropdown-item" onclick="return confirm(\'Are you sure you want to delete this Slider?\');">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </form>';

                    $dropdown = '<div class="btn-group">
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-sliders-h"></i>
                    </button>
                    <div class="dropdown-menu">

                        ' . $editBtn . '
                        <div class="dropdown-divider"></div>
                        ' . $deleteBtn . '
                    </div>
                </div>';
    
                    return $dropdown;
                })
                
                
                ->rawColumns(['action','image'])
                ->make(true);
        }
        return view('admin.sliders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('slider_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('slider_store'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        // dd($request->all());
        $request->validate([
            'title'                => 'required|min:3|max:20',
            'ordering'             => 'required',
            'status'               => 'required'
        ],[
            'title.required'       => 'The title field is mandatory.',
            'title.min'            => 'The title must be at least 3 characters long.',
            'title.max'            => 'The title cannot exceed 20 characters.',
            'ordering.required'    => 'The ordering field is mandatory.',
            'status.required'      => 'The status field is mandatory.'
        ]);

        $slider=Slider::create([
            'title'       => $request->title,
            'ordering'    => $request->ordering,
            'status'      => $request->status
        ]);  
        // upload image      
        if ($request->hasFile('image') && $request->file('image')->isValid()) 
        {
            $slider->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return \redirect()->route('slider.index')->with('success','slider add successfully');   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // abort_if(Gate::denies('user_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('slider_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');

        $slider=Slider::where('id',$id)->first();
        return view('admin.sliders.edit',compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('slider_update'),Response::HTTP_FORBIDDEN,'403 Forbidden');

        $request->validate([
            'title'               => 'required|min:3|max:20',
            'ordering'            => 'required',
            'status'              => 'required'
        ], [
            'title.required'      => 'The title field is mandatory.',
            'title.min'           => 'The title must be at least 3 characters long.',
            'title.max'           => 'The title cannot exceed 20 characters.',
            'ordering.required'   => 'The ordering field is mandatory.',
            'status.required'     => 'The status field is mandatory.'
        ]);
        $update=[
            'title'              => $request->title,
            'ordering'           => $request->ordering,
            'status'             => $request->status
        ];

        $updateData=Slider::where('id',$id)->update($update);

        $imgId=Slider::find($id);

        if ($request->image) {
           if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $imgId->clearMediaCollection('image');
                $imgId->addMediaFromRequest('image')->toMediaCollection('image');
           }
        }
        return \redirect()->route('slider.index')->with('success','slider edit successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('slider_delete'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        // delete slider
        Slider::where('id',$id)->delete();
        return \redirect()->route('slider.index')->with('success','slider delete successfully');
    }
}
