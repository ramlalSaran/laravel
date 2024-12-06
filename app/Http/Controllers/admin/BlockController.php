<?php

namespace App\Http\Controllers\admin;
use App\Models\Block;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Gate;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('block_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        if ($request->ajax()) {
            $data = Block::select('*');
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('banner_image', function ($row) {
                $banner_image= $row->getFirstMediaUrl('banner_image');
                if ($banner_image) 
                {
                    return "<img src='$banner_image' alt='Banner Image' style='width: 70px; height: 70px;'>";
                } else {
                    return 'No Banner_image image';
                }
            })
            
            ->addColumn('status', function ($row) {
            return $row->status == 1 ? 'Enable' : 'Disable';
            })

            ->addColumn('action', function ($row) {
                $editBtn='';
                if (auth()->user()->can('block_edit')) {

                 $editBtn = '<a class="dropdown-item" href="' . route('block.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a>';
                }
                $deleteBtn = '';
                if (auth()->user()->can('block_delete')) {
                    $deleteBtn = '<form action="'. route('block.destroy', $row->id) .'" method="POST" style="display:inline;">
                        '. csrf_field() .'
                        '. method_field("DELETE") .'
                        <button type="submit" class="dropdown-item" onclick="return confirm(\'Are you sure you want to delete this block?\');">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </form>';
                }

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
        
        
            ->rawColumns(['action','banner_image'])
            ->make(true);
        }
        return view('admin.blocks.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('block_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        return view('admin.blocks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        abort_if(Gate::denies('block_store'),Response::HTTP_FORBIDDEN,'403 Forbidden');
       $validate= $request->validate([
            'title'                     => 'required|min:3|max:10',
            'heading'                   => 'required|min:3|max:50',
            'description'               => 'required|min:1|max:500',
            'ordering'                  => 'required|integer', // Ensure ordering is an integer
            'status'                    => 'required|in:1,2', // Ensure status is either 1 or 2
            'banner_image'              => 'required|image|max:3072', 
            ], [
            'title.required'            => 'The title field is required.',
            'title.min'                 => 'The title must be at least 3 characters.',
            'title.max'                 => 'The title may not be greater than 10 characters.',
            'heading.required'          => 'The heading field is required.',
            'heading.min'               => 'The heading must be at least 3 characters.',
            'heading.max'               => 'The heading may not be greater than 50 characters.',
            'description.required'      => 'The description field is required.',
            'description.min'           => 'The description must be at least 1 character.',
            'description.max'           => 'The description may not be greater than 500 characters.',
            'ordering.required'         => 'The ordering field is required.',
            'ordering.integer'          => 'The ordering must be an integer.',
            'status.required'           => 'The status field is required.',
            'status.in'                 => 'The selected status is invalid.',
            'banner_image.required'     => 'The banner image field is required.',
            'banner_image.image'        => 'The file must be an image.',
            'banner_image.max'          => 'The image may not be greater than 3 MB.',
        ]);
        
        $heading = $request->heading;
        $idnt = strtolower($heading);
        $identifier = preg_replace('/[^a-zA-Z0-9-]+/', '-', $idnt);
        
        $block = Block::create([
            'identifier'      => $identifier,
            'title'           => $validate['title'],
            'heading'         => $request->heading,
            'description'     => $validate['description'],
            'ordering'        => $request->ordering,
            'status'          => $request->status
        ]);
        
        if ($request->hasFile('banner_image') && $request->file('banner_image')->isValid()) 
        {
            $block->addMediaFromRequest('banner_image')->toMediaCollection('banner_image');
        }
                
        return \redirect()->route('block.index')->with('success','Block add successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // abort_if(Gate::denies('block_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('block_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');

        $block = Block::where('id',$id)->first();
        return view('admin.blocks.edit',compact('block'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('block_update'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $request->validate([
            'title'                 => 'required|min:3|max:10',
            'heading'               => 'required|min:3|max:50',
            'description'           => 'required|min:1|max:500',
            'ordering'              => 'required',
            'status'                => 'required',
            'banner_image'          => 'image|max:3072', 
        ], [
            'title.required'        => 'The title field is required.',
            'title.min'             => 'The title must be at least 3 characters.',
            'title.max'             => 'The title may not be greater than 10 characters.',
            'heading.required'      => 'The heading field is required.',
            'heading.min'           => 'The heading must be at least 3 characters.',
            'heading.max'           => 'The heading may not be greater than 50 characters.',
            'description.required'  => 'The description field is required.',
            'description.min'       => 'The description must be at least 1 character.',
            'description.max'       => 'The description may not be greater than 500 characters.',
            'ordering.required'     => 'The ordering field is required.',
            'status.required'       => 'The status field is required.',
            'banner_image.image'    => 'The file must be an image.',
            'banner_image.max'      => 'The image may not be greater than 3 MB.',
        ]);

        $title = $request->heading;
        $idnt  = strtolower($title);
        $identifier = preg_replace('/[^a-zA-Z0-9-]+/', '-', $idnt);

        $blockUpdate=[
            'title'           => $request->title,
            'heading'         => $request->heading,
            'description'     => $request->description,
            'identifier'      => $identifier,
            'ordering'        => $request->ordering,
            'status'          => $request->status,
        ];
        Block::where('id',$id)->update($blockUpdate);
        $BlockId = Block::find($id);

        if ($request->banner_image) 
        {
            if ($request->hasFile('banner_image') && $request->file('banner_image')->isValid()) 
            {
                $BlockId->clearMediaCollection('banner_image');
                $BlockId->addMediaFromRequest('banner_image')->toMediaCollection('banner_image');
            }
            
        }
        return \redirect()->route('block.index')->with('success','Block edit successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('block_delete'),Response::HTTP_FORBIDDEN,'403 Forbidden');

        Block::where('id',$id)->delete();
        return \redirect()->route('block.index')->with('success','Block delete successfully');
    }
}