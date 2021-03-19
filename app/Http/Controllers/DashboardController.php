<?php

namespace App\Http\Controllers;

use App\Adapters\FileDatAdapter;
use App\Managers\DatManager;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(DatManager $datManager)
    {
        return view('welcome');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getOutFile(Request $request)
    {

        $this->validate($request, [
            'fileName' => 'required|file_dat_out'
        ]);

        $file = $request->get('fileName');
        return response()->json([
            'ok' => true,
            'obj' => json_decode($this->datManager->getContentDoneFile($file), true)
        ]);
    }

    /**
     * @param Request $request
     * @param DatManager $datManager
     * @return array
     */
    public function upload(Request $request, DatManager $datManager)
    {
        $request->validate([
            'file' => 'required'
        ]);
        $request->file('file')->move(storage_path() . '/data.dat/in/',
            $request->file('file')->getClientOriginalName());

        return response()->json(
            $datManager->analizeSpecificFile('/in/' . $request->file('file')->getClientOriginalName())
        );
    }
}
