<?php

namespace App\Http\Controllers;

use App\Models\DailyUpdate;
use App\Http\Requests\StoreDailyUpdateRequest;
use App\Http\Requests\UpdateDailyUpdateRequest;

class DailyUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dailyUpdates = auth()->user()->hasRole('admin')
            ? DailyUpdate::orderBy('date', 'desc')->get()
            : DailyUpdate::where('userId', auth()->user()->id)
            ->orderBy('date', 'desc')
            ->get();
        return response()->json($dailyUpdates);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDailyUpdateRequest $request)
    {
        try {
            $data = $request->validated();
            $dailyUpdate = new DailyUpdate();
            $dailyUpdate->date = $data['date'];
            $dailyUpdate->task_title = $data['task_title'];
            $dailyUpdate->summary = $data['summary'];
            if (isset($data['hoursSpent'])) {
                $dailyUpdate->hoursSpent = $data['hoursSpent'];
            }
            $dailyUpdate->userId = auth()->user()->id;
            $dailyUpdate->save();
            return response()->json($dailyUpdate);
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id, DailyUpdate $dailyUpdate)
    {
        try {
            $dailyUpdate = DailyUpdate::where('userId', auth()->user()->id)
                ->find($id);
            if (!$dailyUpdate) {
                return response()->json(['message' => 'Daily Update not found'], 404);
            }

            return response()->json($dailyUpdate);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDailyUpdateRequest $request, int $id)
    {
        try {
            $data = $request->validated();
            $dailyUpdate = DailyUpdate::find($id);
            if (!$dailyUpdate) {
                return response()->json(['message' => 'Daily Update not found'], 404);
            }

            $dailyUpdate->date = $data['date'];
            $dailyUpdate->task_title = $data['task_title'];
            $dailyUpdate->summary = $data['summary'];
            $dailyUpdate->hoursSpent = $data['hoursSpent'];
            $dailyUpdate->userId = auth()->user()->id;
            $dailyUpdate->save();

            return response()->json($dailyUpdate);
        } catch (\Throwable $th) {
            throw $th;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $dailyUpdate = DailyUpdate::where('userId', auth()->user()->id)
            ->find($id);
        $dailyUpdate->delete();
        return response()->json(['message' => 'Daily Update deleted successfully']);
    }
}
