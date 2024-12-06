<?php

namespace App\Http\Controllers\admin;

use Gate;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        abort_if(Gate::denies('page_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        // use to yajra datatable
        if ($request->ajax()) {
            $data = Page::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('banner_image', function ($row) {
                    $banner_image= $row->getFirstMediaUrl('banner_image');
                    if ($banner_image) {
                        return "<img src='$banner_image' alt='Banner Image' style='width: 70px; height: 70px;'>";
                    } else {
                        return 'No Banner_image image';
                    }
                })
                ->addColumn('status', function ($row) {
                   return $row->status == 1 ? 'Enable' : 'Disable';
                })
                ->addColumn('action', function ($row) {
                    $editBtn = '<a class="dropdown-item" href="' . route('page.edit', $row->id) . '">
                                    <i class="fas fa-edit"></i> Edit
                                </a>';
                    $deleteBtn = '<form action="'. route('page.destroy', $row->id) .'" method="POST" style="display:inline;">
                        '. csrf_field() .'
                        '. method_field("DELETE") .'
                        <button type="submit" class="dropdown-item" onclick="return confirm(\'Are you sure you want to delete this Page?\');">
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
                
                
                ->rawColumns(['action','banner_image'])
                ->make(true);
        }


        return view('admin.pages.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('page_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        abort_if(Gate::denies('page_store'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $request->validate([
            'title'                   => 'required|min:3|max:30',
            'heading'                 => 'required|min:3|max:50',
            'description'             => 'required|min:1',
            'ordering'                => 'required',
            'status'                  => 'required',
            'show_in_menu'            => 'required',
            'show_in_footer'          => 'required',
            'meta_tag'                => 'required',
            'meta_title'              => 'required',
            'meta_description'        => 'required',
            'banner_image'            => 'required|image', 
        ], [
            'title.required'          => 'The title field is required.',
            'title.min'               => 'The title must be at least 3 characters.',
            'title.max'               => 'The title may not be greater than 10 characters.',
            'heading.required'        => 'The heading field is required.',
            'heading.min'             => 'The heading must be at least 3 characters.',
            'heading.max'             => 'The heading may not be greater than 50 characters.',
            'description.required'    => 'The description field is required.',
            'description.min'         => 'The description must be at least 1 character.',
            'ordering.required'       => 'The ordering field is required.',
            'status.required'         => 'The status field is required.',
            'banner_image.required'   => 'The banner_image field is required.',
            'banner_image.image'      => 'The file must be an image.',
        ]);

        // this is to work title to url_key lowerCase and widhout space -----
        $title = $request->title;
        $url_keylo=strtolower($title);
        $url_key=preg_replace('/[^a-zA-Z0-9-]+/', '-', $url_keylo);

        // this data store in database
        $page=Page::create([
            'title'            => $request->title,
            'heading'          => $request->heading,
            'description'      => $request->description,
            'ordering'         => $request->ordering,
            'url_key'          => $url_key,
            'status'           => $request->status,
            'show_in_menu'     => $request->show_in_menu,
            'show_in_footer'   => $request->show_in_footer,
            'meta_tag'         => $request->meta_tag,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description
        ]);

        // use to media lib. and uplode a image for pages
        if ($request->hasFile('banner_image') && $request->file('banner_image')->isValid()) 
        {
            $page->addMediaFromRequest('banner_image')->toMediaCollection('banner_image');
        }

        return \redirect()->route('page.index')->with('success','page add successfull');        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // abort_if(Gate::denies('page_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('page_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');

        // only id is == this  id first data show in form  
       $page=Page::where('id',$id)->first();

       return view('admin.pages.edit',compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        abort_if(Gate::denies('page_update'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $request->validate([
            'title'                  =>  'required|min:3|max:30',
            'heading'                =>  'required|min:3|max:50',
            'description'            =>  'required|min:1',
            'ordering'               =>  'required',
            'status'                 =>  'required',
            'show_in_menu'           =>  'required',
            'show_in_footer'         =>  'required',
            'meta_tag'               =>  'required',
            'meta_title'             =>  'required',
            'meta_description'       =>  'required',
            'banner_image'           =>  'image', 
        ], [
            'title.required'         => 'The title field is required.',
            'title.min'              => 'The title must be at least 3 characters.',
            'title.max'              => 'The title may not be greater than 10 characters.',
            'heading.required'       => 'The heading field is required.',
            'heading.min'            => 'The heading must be at least 3 characters.',
            'heading.max'            => 'The heading may not be greater than 50 characters.',
            'description.required'   => 'The description field is required.',
            'description.min'        => 'The description must be at least 1 character.',
            'ordering.required'      => 'The ordering field is required.',
            'status.required'        => 'The status field is required.',
            'banner_image.image'     => 'The file must be an image.',

        ]);

        $title = $request->title;
        $url_key=strtolower($title);
        $url_key=preg_replace('/[^a-zA-Z0-9-]+/', '-', $url_key);

        $page=[
            'title'             => $request->title,
            'heading'           => $request->heading,
            'description'       => $request->description,
            'ordering'          => $request->ordering,
            'url_key'           => $url_key,
            'status'            => $request->status,
            'show_in_menu'      => $request->show_in_menu,
            'show_in_footer'    => $request->show_in_footer,
            'meta_tag'          => $request->meta_tag,
            'meta_title'        => $request->meta_title,
            'meta_description'  => $request->meta_description
        ];
        Page::where('id',$id)->update($page);
        $pageId=Page::find($id);

        // if banner_image is come to form so update else not update 

        if ($request->banner_image) 
        {
            if ($request->hasFile('banner_image') && $request->file('banner_image')->isValid()) 
            {
                 $pageId->clearMediaCollection('banner_image');
                 $pageId->addMediaFromRequest('banner_image')->toMediaCollection('banner_image');
            }
        }

         return \redirect()->route('page.index')->with('success','page edit successfull');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('page_delete'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        
        Page::where('id',$id)->delete();
        return \redirect()->route('page.index')->with('success','page Delete successfull');

    }
}
