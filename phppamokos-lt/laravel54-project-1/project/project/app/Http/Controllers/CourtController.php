<?php
namespace App\Http\Controllers;

use App\Court;

class CourtController extends Controller {

	public function getCourt($court_id)
	{
		$court = Court::find($court_id);
		return view('court', compact('court'));
	}


}
