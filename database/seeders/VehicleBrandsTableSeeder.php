<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operations\VehicleBrand;
use App\Models\Operations\VehicleType;

class VehicleBrandsTableSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'motorcycle' => ["Yamaha","Honda","Suzuki","Kawasaki","Motorstar","Rusi","KTM","Others"],
            'mc400' => ["BMW","Ducati","Harley-Davidson","KTM","Others"],
            'bicycle' => ["Giant","Trek","Specialized","Others"],
            'tricycle' => ["Honda","Yamaha","Suzuki","Others"],
            'lightcar' => ["Toyota","Honda","Hyundai","Ford","Mazda","Nissan","Chevrolet","Others"],
            'van' => ["Toyota","Nissan","Hyundai","Ford","Others"],
            'pickup' => ["Toyota","Ford","Isuzu","Nissan","Others"],
        ];

        foreach ($brands as $typeCode => $typeBrands) {
            $type = VehicleType::where('type_code', $typeCode)->first();
            if (!$type) continue;

            foreach ($typeBrands as $brandLabel) {
                VehicleBrand::firstOrCreate(
                    [
                        'type_id' => $type->type_id,
                        'label' => $brandLabel
                    ]
                );
            }
        }

        $this->command->info('Vehicle brands seeded successfully!');
    }
}
