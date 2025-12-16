<?php

namespace App\Actions\Operations\VesselLayout;

use App\Models\Operations\{
    Vessel,
    VesselAccommodation,
    PassengerAccommodation
};
use Illuminate\Support\Facades\DB;

class UpdateVesselLayoutAction
{
    public function execute(Vessel $vessel, array $classes)
    {
        DB::transaction(function () use ($vessel, $classes) {

            // Track which accommodations are still valid
            $activeAccommodationIds = [];

            foreach ($classes as $class) {

                // Ensure accommodation exists (Economy, Business)
                $accommodation = PassengerAccommodation::firstOrCreate([
                    'accommodation_name' => $class['name'],
                ]);

                $activeAccommodationIds[] = $accommodation->accommodation_id;

                // Update or create vessel accommodation
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

                // FULL overwrite of layout
                $va->seats()->delete();
                $va->facilityLabels()->delete();

                // Insert seats
                foreach ($class['seats'] as $seat) {
                    $va->seats()->create([
                        'seat_no' => $seat['seat_no'],
                        'row' => $seat['row'],
                        'col' => $seat['col'],
                        'blocked' => $seat['blocked'],
                        'path' => $seat['path'],
                        'facility' => $seat['facility'],
                    ]);
                }

                // Insert facility labels
                foreach ($class['facilityLabels'] ?? [] as $label) {
                    $va->facilityLabels()->create([
                        'name' => $label['name'],
                        'top' => $label['top'],
                        'left' => $label['left'],
                        'width' => $label['width'],
                        'height' => $label['height'],
                    ]);
                }
            }

            // 🔥 Delete classes NOT included in payload
            VesselAccommodation::where('vessel_id', $vessel->id)
                ->whereNotIn('accommodation_id', $activeAccommodationIds)
                ->delete();
        });

        return [
            'message' => 'Vessel layout updated successfully'
        ];
    }
}
