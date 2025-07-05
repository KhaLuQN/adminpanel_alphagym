<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TrainerResource;
use App\Models\TrainerProfile;

class TrainerController extends Controller
{

    public function index()
    {
        $trainers = TrainerProfile::with('member')->latest()->get();

        return TrainerResource::collection($trainers);
    }
}
