<?php

namespace App\Http\Controllers;

use App\Models\Robot;
use Illuminate\Http\Request;
use App\Http\Traits\Response;
use App\Http\Resources\RobotResource;
use App\Http\Requests\CreateRobotRequest;
use App\Http\Resources\RobotCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RobotController extends Controller
{
    use Response;

    /**
     * Create a new robot
     *
     * @return Json
     */
    public function create(CreateRobotRequest $request)
    {
        //check if currently authenticated manager has a robot with the same name as incoming robot
        if (!is_null(Robot::where(["manager_id" => auth()->user()->id, "name" => $request->input("name")])->first())) {
            return $this->sendError("Robot with the same name already exists");
        }

        $robot = Robot::create([
            "name" => $request->input("name"),
            "powermove" => $request->input("powermove"),
            "experience" => $request->input("experience"),
            "outOfOrder" => $request->input("outOfOrder"),
            "avatar" => $request->input("avatar"),
            "manager_id" => auth()->user()->id
        ]);

        return $this->sendResponse("Robot created successfully", [
            "robot" => new RobotResource($robot)
        ], 201);
    }

    /**
     * Get single robot
     *
     * @return Json
     */
    public function getSingleRobot($id)
    {
        try {
            $robot = Robot::where(["manager_id" => auth()->user()->id, "id" => $id])->firstOrFail();
            return $this->sendResponse("Robot fetched successfully", [
                "robot" => new RobotResource($robot)
            ]);
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Robot not found", [], 404);
        }
    }

    /**
     * Get all robots
     *
     * @return Json
     */
    public function getAllRobots()
    {
        $robots = Robot::where("manager_id", auth()->user()->id)->get();

        if (!$robots->count()) {
            return $this->sendResponse("Robots not found", [], 404);
        }
        return $this->sendResponse(
            "Robot fetched successfully",
            new RobotCollection($robots)
        );
    }
}
