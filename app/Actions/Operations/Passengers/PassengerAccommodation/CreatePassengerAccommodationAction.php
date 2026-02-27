<?php

namespace App\Actions\Operations\Passengers\PassengerAccommodation;

use App\Actions\Action;
use App\Actions\Marketing\Rate\AccommodationRates\CreateAccommodationRatesAction;
use App\Models\Operations\PassengerAccommodation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class CreatePassengerAccommodationAction extends Action
{
    protected CreateAccommodationRatesAction $createAccommodationRatesAction;

    public function __construct(CreateAccommodationRatesAction $createAccommodationRatesAction)
    {
        $this->createAccommodationRatesAction = $createAccommodationRatesAction;
    }

    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'accommodation_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return DB::transaction(function () use ($data) {

            $accommodation = PassengerAccommodation::create([
                'accommodation_name' => $data['accommodation_name'],
            ]);

            $this->createAccommodationRatesAction->execute($accommodation);

            return $this->success([
                'passengerAccommodation' => $accommodation,
            ], 'Passenger Accommodation and rates created successfully', 201);
        });
    }
}