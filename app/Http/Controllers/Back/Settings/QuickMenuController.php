<?php

namespace App\Http\Controllers\Back\Settings;

use App\Http\Controllers\Controller;
use App\Models\Back\Settings\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class QuickMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
    
        return redirect()->back()->with('success', 'Cache Cleared succesfully!');
    }


    /**
     * Maintenance Mode CHANGE.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function maintenanceMode(Request $request)
    {
        if (app()->maintenanceMode()->active()) {
            Artisan::call('up');
        } else {
            Artisan::call('down');
        }

        return response()->json(['success' => 'Application is now in maintenance mode.']);
    }
    
    
    /**
     * Maintenance Mode ON.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function maintenanceModeON()
    {
        Artisan::call('down');
        
        return redirect()->back()->with('success', 'Application is now in maintenance mode.');
    }
    
    
    /**
     * Maintenance Mode OFF.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function maintenanceModeOFF()
    {
        Artisan::call('up');
        
        return redirect()->back()->with('success', 'Application is now live.');
    }


    public function setTemplateMode(Request $request)
    {
        if ($request->has('mode')) {
            $set = Settings::reset('app', 'mode', $request->input('mode'), false);

            if ($set) {
                Cache::forget('app' . 'mode');

                return response()->json(['success' => 'Tema je uspješno promjenjena...']);
            }
        }

        return response()->json(['error' => 'Whoops.!! Pokušajte ponovo ili kontaktirajte administratora!']);
    }
    
}
