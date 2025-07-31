<?php

namespace App\Services;

use App\Models\Member;
use App\Models\TrainerProfile;
use Illuminate\Support\Facades\Storage;

class TrainerService
{
    public function getTrainersForIndex()
    {
        return TrainerProfile::with('member')->latest()->paginate(10);
    }

    public function getMembersForCreate()
    {
        return Member::whereDoesntHave('trainerProfile')->get();
    }

    public function createTrainer(array $validatedData): TrainerProfile
    {
        if (isset($validatedData['photo'])) {
            $validatedData['photo_url'] = $validatedData['photo']->store('trainers', 'public');
            unset($validatedData['photo']);
        }

        return TrainerProfile::create($validatedData);
    }

    public function updateTrainer(TrainerProfile $trainerProfile, array $validatedData): TrainerProfile
    {
        if (isset($validatedData['photo'])) {
            // Xóa ảnh cũ nếu có
            if ($trainerProfile->photo_url) {
                Storage::disk('public')->delete($trainerProfile->photo_url);
            }
            $validatedData['photo_url'] = $validatedData['photo']->store('trainers', 'public');
            unset($validatedData['photo']);
        }

        $trainerProfile->update($validatedData);

        return $trainerProfile;
    }

    public function deleteTrainer(TrainerProfile $trainerProfile): void
    {
        if ($trainerProfile->photo_url) {
            Storage::disk('public')->delete($trainerProfile->photo_url);
        }
        $trainerProfile->delete();
    }
}
