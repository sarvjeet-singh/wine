<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;

class CommonController extends Controller
{
    protected $entity;
    protected $customFields;

    public function __construct($entity = null, array $customFields = [])
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

    public function getStates(Request $request)
    {
        $countryId = $request->get('country_id');
        if ($request->has('type') && $request->get('type') == 'name') {
            $countryId = Country::where('name', $countryId)->first()->id;
        }

        if (!$countryId) {
            return response()->json(['success' => false, 'message' => 'Country ID is required']);
        }

        $states = getStates($countryId);

        return response()->json([
            'success' => true,
            'states' => $states
        ]);
    }
}
