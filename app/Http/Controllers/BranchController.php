<?php

namespace HDSSolutions\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Laravel\DataTables\BranchDataTable as DataTable;
use HDSSolutions\Laravel\Http\Request;
use HDSSolutions\Laravel\Models\Branch as Resource;
use HDSSolutions\Laravel\Models\City;
use HDSSolutions\Laravel\Models\Region;
use HDSSolutions\Laravel\Models\Scopes\CompanyScope;

class BranchController extends Controller {

    public function __construct() {
        // check resource Policy
        $this->authorizeResource(Resource::class, 'resource');
    }

    public function index(Request $request, DataTable $dataTable) {
        // check only-form flag
        if ($request->has('only-form'))
            // redirect to popup callback
            return view('backend::components.popup-callback', [ 'resource' => new Resource ]);

        // load resources
        if ($request->ajax()) return $dataTable->ajax();

        // return view with dataTable
        return $dataTable->render('backend::branches.index', [
            // check if we are scoped to a company
            'count' => backend()->companyScoped() ?
                // load resource scoped count
                Resource::count() :
                // load resource count without scope
                Resource::withoutGlobalScope(new CompanyScope)->count(),
            // ask to select company
            'show_company_selector' => !backend()->companyScoped(),
        ]);
    }

    public function create(Request $request) {
        // force company selection
        if (!backend()->companyScoped()) return view('backend::layouts.master', [ 'force_company_selector' => true ]);

        // load companies
        $companies = backend()->companies();
        // load Regions
        $regions = Region::with([
            'cities',
        ])->get()->transform(fn($region) => $region
            // override loaded cities, add relation to parent manually
            ->setRelation('cities', $region->cities->transform(fn($city) => $city
                // set City.region relation manually to avoid more queries
                ->setRelation('region', $region)
            ))
        );

        // show create form
        return view('backend::branches.create', compact('regions', 'companies'));
    }

    public function store(Request $request) {
        // create resource
        $resource = new Resource;

        // set region from city
        $request->merge([ 'region_id' => City::find($request->city_id)->region_id ?? null ]);

        // fill resource with request data
        $resource->fill( $request->input() );

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // check return type
        return $request->has('only-form') ?
            // redirect to popup callback
            view('backend::components.popup-callback', compact('resource')) :
            // redirect to resources list
            redirect()->route('backend.branches');
    }

    public function show(Request $request, Resource $resource) {
        // redirect to list
        return redirect()->route('backend.branches');
    }

    public function edit(Request $request, int $resource) {
        // load resource manually
        $resource = backend()->companyScoped() ?
            // load resource keeping company scope
            Resource::findOrFail($resource) :
            // remove company scope since we are on global scope
            Resource::withoutGlobalScope(new CompanyScope)->findOrFail($resource);

        // load companies
        $companies = backend()->companies();
        // load Regions
        $regions = Region::with([
            'cities',
        ])->get()->transform(fn($region) => $region
            // override loaded cities, add relation to parent manually
            ->setRelation('cities', $region->cities->transform(fn($city) => $city
                // set City.region relation manually to avoid more queries
                ->setRelation('region', $region)
            ))
        );

        // show edit form
        return view('backend::branches.edit', compact('resource', 'regions', 'companies'));
    }

    public function update(Request $request, int $resource) {
        // load resource manually
        $resource = backend()->companyScoped() ?
            // load resource keeping company scope
            Resource::findOrFail($resource) :
            // remove company scope since we are on global scope
            Resource::withoutGlobalScope(new CompanyScope)->findOrFail($resource);

        // fill resource with request data
        $resource->fill( $request->input() );

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.branches');
    }

    public function destroy(Request $request, int $resource) {
        // load resource manually
        $resource = backend()->companyScoped() ?
            // load resource keeping company scope
            Resource::findOrFail($resource) :
            // remove company scope since we are on global scope
            Resource::withoutGlobalScope(new CompanyScope)->findOrFail($resource);

        // delete resource
        if (!$resource->delete())
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.branches');
    }

}
