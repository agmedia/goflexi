<?php

namespace App\Http\Controllers\Back\Catalog;

use App\Helpers\Helper;
use App\Models\Back\Catalog\Page;
use App\Models\Back\Catalog\Product;
use App\Models\Back\Catalog\Widget;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Page::query();

        if ($request->has('search')) {
            $query->where('from_city', 'LIKE', '%' . $request->input('search') . '%');
        }

        $pages = $query->orderByDesc('created_at')
                         ->paginate(config('settings.pagination.back'))->appends($request->query());

        return view('back.catalog.page.index', compact('pages'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $groups = Page::query()->pluck('group')->unique();

        return view('back.catalog.page.edit', compact('groups'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = new Page();
        $stored = $page->validateRequest($request)->store();

        if ($stored) {
            return redirect()->route('page.edit', ['page' => $stored])->with(['success' => 'Stranica je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Desila se greška sa snimanjem stranice.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $groups = Page::query()->pluck('group')->unique();

        return view('back.catalog.page.edit', compact('page', 'groups'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $updated = $page->validateRequest($request)->edit();

        if ($updated) {
            return redirect()->back()->with(['success' => 'Stranica je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Desila se greška sa snimanjem stranice.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->has('id') && $request->input('id')) {
            try {
                Page::query()->where('id', $request->input('id'))->delete();
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }

            return response()->json(['success' => 200]);
        }

        return response()->json(['error' => 300]);
    }


    /**
     * @param Page $page
     */
    private function flush(Page $page): void
    {
        Cache::forget('page.' . $page->id);
    }

}
