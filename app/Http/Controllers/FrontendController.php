<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Server;
use App\Models\Location;
use App\Models\StorageType;


class FrontendController extends Controller
{

    // list of server to show on the frontend
    public $serverList = null;

    public function home(Request $request)
    {
        // store requests in session between calls        
        $request->flash();

        $storageMin = Server::orderBy('storage_size', 'ASC')->limit(1)->pluck('storage_size');
        $storageMax = Server::orderBy('storage_size', 'DESC')->limit(1)->pluck('storage_size');

        return view('welcome', [
            'storageMin' => !empty($storageMin) && is_array($storageMin) ? $storageMin[0] : 0,
            'storageMax' => !empty($storageMax) && is_array($storageMax) ? $storageMax[0] : 0,
            'rams' => Server::orderBy('ram_size', 'ASC')->distinct('ram_size')->get(['ram_size']),
            'locations' => Location::orderBy('location', 'ASC')->distinct('location')->get(),
            'storageTypes' => StorageType::orderBy('type', 'ASC')->get(),
            'serverList' => $this->serverList,
        ]);
    }

    public function search(Request $request)
    {
        

        $query = Server::select('servers.*', 'locations.location', 'locations.location_code', 'storage_types.type')
                        ->leftJoin('locations', 'servers.location_id', '=', 'locations.id')
                        ->leftJoin('storage_types', 'servers.storage_type_id', '=', 'storage_types.id');

        if ($request->has('storage_min') && $request->get('storage_min') > 0) {
            $query->where('storage_size', '>=', $request->get('storage_min'));
        }

        if ($request->has('storage_max') && $request->get('storage_max') > 0) {
            $query->where('storage_size', '<=', $request->get('storage_max'));
        }

        if ($request->has('storage_type_id') && $request->get('storage_type_id') > 0) {
            $query->where('storage_type_id', $request->get('storage_type_id'));
        }

        if ($request->has('location_id') && $request->get('location_id') > 0) {
            $query->where('location_id', $request->get('location_id'));
        }

        if ($request->has('ram') && is_array($request->get('ram'))) {
            $query->whereIn('ram_size', $request->get('ram'));
        }

        $this->serverList = $query->get();

        return $this->home($request);
    }
}
