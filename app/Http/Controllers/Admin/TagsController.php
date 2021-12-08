<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Tag;
use App\Http\Requests\TagRequest;
//use JsValidator;


class TagsController extends BaseController
{

    /**
     *
     * @return type
     */
    public function index()
    {
        return view('admin.tag.index', []);
    }

    /**
     *
     * @param Request $request
     */
    public function getFilteredAjax(Request $request)
    {
        $outputData = array();

        $start       = 0;
        $limit       = 10;
        $search_text = "";

        if (isset($request->iDisplayStart) && $request->iDisplayStart != "" && is_numeric($request->iDisplayStart)) {
            $start = $request->iDisplayStart;
        }
        if (isset($request->iDisplayLength) && $request->iDisplayLength != "" && is_numeric($request->iDisplayStart)) {
            $limit = $request->iDisplayLength;
        }
        if (isset($request->sSearch) && $request->sSearch != "") {
            $search_text = $request->sSearch;
        }

        $tagsCount = Tag
            ::getByTitle($search_text)
            ->count();

        $outputData['iTotalRecords']        = $tagsCount;
        $outputData['iTotalDisplayRecords'] = $tagsCount;

        $tags = Tag
            ::getByTitle($search_text)
            ->orderBy('tags.id', 'desc')
            ->offset($start)->limit($limit)
            ->get()
            ->map(function ($tagItem) {
                $tagItem->created_at_formatted = getFormattedDateTime($tagItem->created_at);
                $tagItem->active_label         = Tag::getTagStatusLabel($tagItem->active);
                $tagItem->edit_url             = route("tags.edit", $tagItem->id);
                return $tagItem;
            });

//        \Log::info(varDump($tags, ' -1 getFilteredAjax $tags::'));

        $outputData['aaData'] = $tags;
        return json_encode($outputData, true);
    }

    public function edit($id)
    {
        $tagData = Tag::find($id);
        if (empty($tagData)) {
            return redirect()->route('tag.list')->with('error', 'Tag not found !');
        }

//        \Log::info(varDump($tagData, ' -1 getFilteredAjax $tagData::'));

        return view('admin.tag.edit', [
            'tagData'   => $tagData,
            'is_insert' => false
        ]);
    } // public function edit($id)

    public function update(TagRequest $request)
    {
        $id      = $request->id;
        $tagData = Tag::find($id);
        if (empty($tagData)) {
            return redirect()->route('tags.index')->with('error', 'Tag not found !');
        }
        \Log::info(  varDump($request->active, ' -1 $request->active::') );

        $tagData->title      = $request->title;
        $tagData->active     = $request->active ? true : false;
        $tagData->updated_at = Carbon::now(config('app.timezone'));
        if ($tagData->save()) {
            return redirect()->route('tags.index')->with('success', 'Tag updated successfully');
        } else {
            return back()->with('error', 'Tag not updated, please try again')->withInput($request->all());
        }
    } // public function update(TagRequest $request)

    public function create()
    {
        return view('admin.tag.edit', [
            'tagData'   => null,
            'is_insert' => true
        ]);
    }

    public function store(TagRequest $request)
    {
        $tag             = new Tag;
        $tag->title      = $request->title;
        $tag->active     = $request->active ? true : false;
//        $tag->slug       = strtolower($request->slug);
        if ($tag->save()) {
            return redirect()->route('tags.index')->with('success', 'Tag added successfully');
        } else {
            return back()->with('error', 'Tag  not added, please try again')->withInput($request->all());
        }
    } // public function store(TagRequest $request)


    public function destroy(Request $request)
    {
        $id  = $request->id;
        $tag = Tag::find($id);

        if ($tag->delete()) {
            return response()->json(['msg' => 'Tag deleted successfully', 'code' => 1]);
        } else {
            return response()->json(['msg' => 'Tag not deleted, please try again', 'code' => 0]);
        }
    } // public function destroy(Request $request)


}
