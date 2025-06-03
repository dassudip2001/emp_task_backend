<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Http\Requests\StoreOrganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $org = Organization::all();
        return response()->json($org);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganizationRequest $request)
    {
        try {
            $data = $request->validated();
            $org = new Organization();
            $org->name = $request->$data['name'];
            if (isset($data['email'])) {
                $org->email = $data['email'];
            }
            if (isset($data['phone'])) {
                $org->phone = $data['phone'];
            }
            if (isset($data['address'])) {
                $org->address = $data['address'];
            }
            if (isset($data['logo'])) {
                $org->logo = $data['logo'];
            }

            $org->save();
            return response()->json(['message' => 'Organization created successfully'], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        try {
            $org = Organization::find($id);
            if (!$org) {
                return response()->json(['message' => 'Organization not found'], 404);
            }
            return response()->json($org);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizationRequest $request, int $id)
    {

        try {
            $data = $request->validated();
            $org = Organization::find($id);
            if (!$org) {
                return response()->json(['message' => 'Organization not found'], 404);
            }

            $org->name = $data['name'];
            if (isset($data['email'])) {
                $org->email = $data['email'];
            }
            if (isset($data['phone'])) {
                $org->phone = $data['phone'];
            }

            if (isset($data['address'])) {
                $org->address = $data['address'];
            }
            if (isset($data['logo'])) {
                $org->logo = $data['logo'];
            }


            $org->save();
            return response()->json($org);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $org = Organization::find($id);
            $org->delete();
            return response()->json(['message' => 'Organization deleted successfully']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
