<?php

namespace App\Actions\Operations\VesselLayout;

use App\Models\Operations\{
    Vessel,
    VesselAccommodation,
    PassengerAccommodation
};
use Illuminate\Support\Facades\DB;

class StoreVesselLayoutAction
{
    public function execute(Vessel $vessel, array $classes)
    {
        DB::transaction(function () use ($vessel, $classes) {

            foreach ($classes as $class) {

                $accommodation = PassengerAccommodation::firstOrCreate([
                    'accommodation_name' => $class['name'],
                ]);

                $va = VesselAccommodation::updateOrCreate(
                    [
                        'vessel_id' => $vessel->id,
                        'accommodation_id' => $accommodation->accommodation_id,
                    ],
                    [
                        'rows' => $class['rows'],
                        'columns' => $class['columns'],
                        'aircon' => $class['aircon'],
                        'wifi' => $class['wifi'],
                    ]
                );

                // overwrite layout safely
                $va->seats()->delete();
                $va->facilityLabels()->delete();

                foreach ($class['seats'] as $seat) {
                    $va->seats()->create($seat);
                }

                foreach ($class['facilityLabels'] ?? [] as $label) {
                    $va->facilityLabels()->create($label);
                }
            }
        });

        return ['message' => 'Vessel layout saved'];
    }
}

