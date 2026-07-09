<?php

namespace Modules\IAM\Database\Seeders\User;

use Illuminate\Database\Seeder;
use Modules\Core\Models\City;
use Modules\Core\Models\Country;
use Modules\Core\Models\District;
use Modules\IAM\Models\User;
use Modules\IAM\Models\UserAddress;

class UserAddressSeeder extends Seeder
{
    public function run(): void
    {
        $countryId = Country::query()->where('iso2', 'EG')->value('id')
            ?? Country::query()->value('id');

        $cityId = City::query()->value('id');
        $districtId = District::query()->value('id');

        $addresses = [
            [
                'mobile' => '+201000000001',
                'street' => '10 Admin Street',
                'latitude' => 30.0444200,
                'longitude' => 31.2357120,
                'is_default' => true,
            ],
            [
                'mobile' => '+201000000002',
                'street' => '20 User Avenue',
                'latitude' => 30.0500000,
                'longitude' => 31.2400000,
                'is_default' => true,
            ],
        ];

        foreach ($addresses as $address) {
            $userId = User::query()->where('mobile', $address['mobile'])->value('id');

            if ($userId === null) {
                continue;
            }

            UserAddress::updateOrCreate(
                ['user_id' => $userId, 'street' => $address['street']],
                [
                    'country_id' => $countryId,
                    'city_id' => $cityId,
                    'district_id' => $districtId,
                    'latitude' => $address['latitude'],
                    'longitude' => $address['longitude'],
                    'is_default' => $address['is_default'],
                ],
            );
        }
    }
}
