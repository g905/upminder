<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\City;
use App\Models\Company;
use App\Models\CompanyCategory;
use App\Models\Country;
use App\Models\Language;
use App\Models\Mentor;
use App\Models\MentorCategory;

class DashboardController extends Controller {
	
    public function __construct() {
        $this->middleware('auth');
    }

	public function delete($type, $id) {
		
		if ($type == 'company') {
			$rec = Company::find($id);
		}
		elseif ($type == 'company_category') {
			$rec = CompanyCategory::find($id);
		}
		elseif ($type == 'mentor') {
			$rec = Mentor::find($id);
		}
		elseif ($type == 'mentor_category') {
			$rec = MentorCategory::find($id);
		}
		elseif ($type == 'country') {
			$rec = Country::find($id);
		}
		elseif ($type == 'city') {
			$rec = City::find($id);
		}
		elseif ($type == 'language') {
			$rec = Language::find($id);
		}
		
		if (!$rec) {
			return redirect()->back()->with('error', 'Не найдено!');
		}
		
		$rec->delete();
		
		return redirect()->back()->with('success', 'Удалено!');
		
	}

    public function index() {
		
        return view('admin/dashboard');
		
    }
	
}
