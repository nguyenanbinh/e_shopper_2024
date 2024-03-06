<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCountryRequest;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'level:1']);
    }

    public function index()
    {
        $countries = Country::all();

        return view('admin.country.index', compact('countries'));
    }

    public function create()
    {

        return view('admin.country.create');
    }

    public function store(StoreCountryRequest $request)
    {
        $data = $request->all();
        $newCountry = Country::create($data);

        if ($newCountry) {
            return redirect()->route('admin.countries.index');
        } else {
            return redirect()->back();
        }
    }

    public function destroy(string $id)
    {
        $country = Country::find($id);
        $deleteCountry = $country->delete();

        if ($deleteCountry) {
            return redirect()->route('admin.countries.index');
        } else {
            return redirect()->back();
        }
    }
}
