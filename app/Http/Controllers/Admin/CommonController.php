<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    protected $entity;
    protected $customFields;

    public function __construct($entity, array $customFields = [])
    {
        $this->entity = $entity; // Pass the entity type dynamically (region, sub_region, inventory)
        $this->customFields = $customFields; // Pass any custom fields dynamically
    }

    public function index()
    {
        $items = DB::table($this->entity)->get();
        return view('admin.common.index', [
            'items' => $items,
            'entity' => $this->entity,
            'customFields' => $this->customFields,
        ]);
    }

    public function create()
    {
        return view('admin.common.create', [
            'entity' => $this->entity,
            'customFields' => $this->customFields,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->only(array_merge(['name', 'status'], $this->customFields));
        $data['created_at'] = now();
        $data['updated_at'] = now();

        DB::table($this->entity)->insert($data);

        return redirect()->route('admin.entity.index', ['entity' => $this->entity])
            ->with('success', ucfirst($this->entity) . ' created successfully.');
    }

    public function edit($id)
    {
        $item = DB::table($this->entity)->find($id);
        return view('admin.common.edit', [
            'item' => $item,
            'entity' => $this->entity,
            'customFields' => $this->customFields,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(array_merge(['name', 'status'], $this->customFields));
        $data['updated_at'] = now();

        DB::table($this->entity)->where('id', $id)->update($data);

        return redirect()->route('admin.entity.index', ['entity' => $this->entity])
            ->with('success', ucfirst($this->entity) . ' updated successfully.');
    }
}
