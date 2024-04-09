<?php

namespace App\Http\Controllers\Back\Catalog;

use App\Helpers\Helper;
use App\Helpers\ProductHelper;
use App\Models\Back\Catalog\Product;
use App\Models\Back\Catalog\Widget;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('from_city', 'LIKE', '%' . $request->input('search') . '%');
        }

        $products = $query->orderByDesc('created_at')
                         ->paginate(config('settings.pagination.back'))->appends($request->query());

        return view('back.catalog.product.index', compact('products'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('back.catalog.product.edit');
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
        $product = new Product();
        $stored = $product->validateRequest($request)->store();

        if ($stored) {
            return redirect()->route('product.edit', ['product' => $stored])->with(['success' => 'Proizvod je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Desila se greška sa snimanjem proizvoda.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('back.catalog.product.edit', compact('product'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $updated = $product->validateRequest($request)->edit();

        if ($updated) {
            return redirect()->route('product.edit', ['product' => $updated])->with(['success' => 'Proizvod je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Desila se greška sa snimanjem proizvoda.']);
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
                Product::query()->where('id', $request->input('id'))->delete();
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }

            return response()->json(['success' => 200]);
        }

        return response()->json(['error' => 300]);
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeList(Request $request)
    {
        $from = now();
        $to = now()->addDays(7);
        $existing = Product::query()->orderBy('start_time')->first();

        if ($existing) {
            $from = Carbon::make($existing->start_time);
            $to = Carbon::make($existing->start_time)->addDays(7);
        }

        $days = CarbonPeriod::create($from, $to);

        foreach ($days as $day) {
            if ($day->isMonday() || $day->isWednesday() || $day->isFriday()) {
                // import Zagreb-Split
                ProductHelper::create_ZGSP_listing($day);
            }

            if ($day->isMonday() || $day->isWednesday() || $day->isFriday()) {
                // import Zagreb-Rijeka
                ProductHelper::create_ZGRI_listing($day);
            }
        }

        return redirect()->route('products')->with(['success' => 'Lista proizvoda je uspješno snimljena!']);
    }


    /**
     * @param Product $product
     *
     * @return void
     */
    private function flush(Product $product): void
    {
        Cache::forget('prod.' . $product->id);
    }

}
