<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin.searvice.view', ['only' => ['index']]);
        $this->middleware('permission:admin.searvice.create', ['only' => ['create','store']]);
        $this->middleware('permission:admin.searvice.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin.searvice.delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $services = Service::all();
        return view('admin.serviceai.index', compact('services'));
    }

    public function create()
    {
        return view('admin.serviceai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $input = $request->all();
        $input['status'] = isset($request->status)  ? 1 : 0;
        $data = Service::create($input);
        $data->save();
        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function edit($id)
    {
         $data = Service::findOrFail($id);
        return view('admin.serviceai.edit', compact('data'));
    }

    public function update(Request $request,$id)
    {
        $data = Service::findOrFail($request->id);
        $data['name'] = strip_tags($request->name);
        $data['status'] = isset($request->status)  ? 1 : 0;
        $data->save();
        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully');
    }
}

