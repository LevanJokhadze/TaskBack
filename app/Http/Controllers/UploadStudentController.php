<?php

namespace App\Http\Controllers;

use App\Models\UploadStudent;
use App\Http\Requests\StoreUploadStudentRequest;
use App\Http\Requests\UpdateUploadStudentRequest;

class UploadStudentController extends Controller
{
    public function upload(StoreUploadStudentRequest $request)
    {
        $name = $request->name;
        $lastName = $request->last_name;
        $serial = $request->serial;

        try {
            $upload = UploadStudent::create([
                'name' => $name,
                'last_name' => $lastName,
                'serial' => $serial,
            ]);

            $response = [
                "message" => "Uploaded",
                "user" => $upload
            ];


            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
