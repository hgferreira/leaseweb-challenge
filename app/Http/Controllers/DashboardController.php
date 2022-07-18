<?php

namespace App\Http\Controllers;

use App\Event\CSVUploaded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FileUploadRequest;

class DashboardController extends Controller
{
    public function home(Request $requestuest)
    {
        return view('dashboard');
    }

    public function upload(FileUploadRequest $request)
    {
        if($request->file()) {
           $request->file('serverlist')->storeAs('', config('leaseweb.sl_filename'), 'public');

           event(new CSVUploaded(Storage::path(config('leaseweb.sl_filename'))));

           return back()
            ->with('success','File has been uploaded.')
            ->with('file', 'serverlist.csv');
        }
    }
}
