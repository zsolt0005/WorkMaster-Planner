<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class UserRoleSeeder extends Seeder
{
    use WithoutModelEvents;

    private static array $userToRolesMap = [
        'diCaprio' => ['HR manager', 'Employee'],
        'johnny_depp' => ['Employee'],
        'john.smith42' => ['HR manager', 'Employee'],
        'emily.johnson33' => ['HR manager', 'Employee'],
        'michael.williams77' => ['HR manager', 'Employee'],
        'olivia.brown64' => ['HR manager', 'Employee'],
        'daniel.jones15' => ['HR manager', 'Employee'],
        'sophia.garcia91' => ['HR manager', 'Employee'],
        'ethan.miller28' => ['HR manager', 'Employee'],
        'isabella.davis47' => ['HR manager', 'Employee'],
        'jacob.rodriguez36' => ['HR manager', 'Employee'],
        'mia.martinez82' => ['HR manager', 'Employee'],
        'noah.wilson55' => ['Employee'],
        'amelia.anderson73' => ['Employee'],
        'liam.thomas88' => ['Employee'],
        'charlotte.taylor14' => ['Employee'],
        'matthew.moore22' => ['Employee'],
        'harper.jackson67' => ['Employee'],
        'samuel.martin31' => ['Employee'],
        'victoria.lee90' => ['Employee'],
        'ethan.perez44' => ['Employee'],
        'mia.thompson76' => ['Employee'],
        'jacob.white29' => ['Employee'],
        'emma.harris52' => ['Employee'],
        'benjamin.sanchez68' => ['Employee'],
        'ella.clark35' => ['Employee'],
        'lucas.ramirez49' => ['Employee'],
        'olivia.lewis20' => ['Employee'],
        'samuel.robinson81' => ['Employee'],
        'harper.lee59' => ['Employee'],
        'lucas.thompson98' => ['Employee'],
        'amelia.white11' => ['Employee'],
        'ethan.martin77' => ['Employee'],
        'mia.rodriguez32' => ['Employee'],
        'jacob.johnson64' => ['Employee'],
        'isabella.smith29' => ['Employee'],
        'liam.miller88' => ['Employee'],
        'victoria.brown45' => ['Employee'],
        'benjamin.jones93' => ['Employee'],
        'ella.garcia56' => ['Employee'],
        'samuel.williams71' => ['Employee'],
        'harper.martinez23' => ['Employee'],
        'olivia.hernandez36' => ['Employee'],
        'lucas.lopez12' => ['Employee'],
        'amelia.gonzalez59' => ['Employee'],
        'ethan.wilson85' => ['Employee'],
        'mia.anderson40' => ['Employee'],
        'jacob.thomas57' => ['Employee'],
        'isabella.taylor63' => ['Employee'],
        'liam.moore50' => ['Employee'],
        'victoria.jackson28' => ['Employee'],
    ];

    public function run(): void
    {
        foreach (self::$userToRolesMap as $user => $roles) {
            foreach ($roles as $role) {
                DB::table('user_role')->insertOrIgnore([
                    'user_id' => DB::table('users')->where('username', $user)->first()->id,
                    'role_id' => DB::table('roles')->where('role_name', $role)->first()->id,
                ]);
            }
        }
    }
}
