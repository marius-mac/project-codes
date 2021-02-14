<?php
namespace App\Http\Controllers;

use App\City;
use App\Http\Requests\CreateCityRequest;

class AdminCitiesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('admin.cities.list', array('cities' => City::all()));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('admin.cities.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateCityRequest $request)
	{
		$city = new City;
		$city->title = $request->input('title');
		$city->save();
		return redirect('admin/miestai');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return view('admin.cities.edit', array('city' => City::find($id)));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(CreateCityRequest $request, $id)
	{
		$city = City::find($id);
		$city->title = $request->input('title');
		$city->save();
		return redirect('admin/miestai');
  	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		City::find($id)->delete();
		return redirect('admin/miestai');	
  	}


}
