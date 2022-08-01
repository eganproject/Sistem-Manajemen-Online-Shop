<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Exception;
use App\Models\Employe;

class CobaReactController extends Controller
{
    public function index()
    {

        return view('dashboard.cobareact.index');
    }
    public function getEmployeList()
    {
        try {
            $employes = Employe::orderBy('id', 'DESC')->get();
            return response()->json($employes);
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    // Get individual Employe Detail
    public function getEmployeDetail(Request $request)
    {
        try {
            $employeData = Employe::findOrFail($request->get('employeId'));
            return response()->json($employeData);
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    public function updateEmployeData(Request $request)
    {
        try {
            $employeId = $request->get('employeId');
            $employeName = $request->get('employeName');
            $employeSalary = $request->get('employeSalary');
            Employe::where('id', $employeId)->update(['employe_name' => $employeName, 'salary' => $employeSalary]);
            return response()->json([
                'employe_name' => $employeName, 'salary' => $employeSalary
            ]);
        } catch (Exception $e) {
            Log::error($e);
        }
    }
    public function destroyEmployeData(Employe $employe)
    {
        try {
            $employe->delete();
        } catch (Exception $e) {
            Log::error($e);
        }
    }
    public function storeEmployeData(Request $request)
    {
        try {
            $employeName = $request->get('employeName');
            $employeSalary = $request->get('employeSalary');
            Employe::create(['employe_name' => $employeName, 'salary' => $employeSalary]);
            return response()->json([
                'employe_name' => $employeName, 'salary' => $employeSalary
            ]);
        } catch (Exception $e) {
            Log::error($e);
        }
    }
}
