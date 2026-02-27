<?php

namespace App\Actions\Operations\Passengers\PassengerAccommodation;

use App\Actions\Action;
use App\Models\Operations\PassengerAccommodation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use RuntimeException;


class GetPassengerAccommodationAction extends Action
{
    public function execute(int $accommodationId) 
    {
        try {
            $accommodation = PassengerAccommodation::findOrFail($accommodationId); 

            return $this->success([
                'accommodation' => $accommodation,
            ], 'Accommodation retrieved successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new RuntimeException("Accommodation with ID {$accommodationId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve accommodation.');
        }
    }}