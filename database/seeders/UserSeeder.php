<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        DB::table('users')->insertOrIgnore([
            'username' => 'admin',
            'full_name' => 'Admin',
            'email' => 'admin@workmasterplanner.com',
            'password' => Hash::make('admin'),
            'is_admin' => true,
            'created_at' => '2024-01-05 14:33:21',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'diCaprio',
            'full_name' => 'Leonardo DiCaprio',
            'email' => 'dicaprio@workmasterplanner.com',
            'password' => Hash::make('dicaprio123'),
            'is_admin' => false,
            'created_at' => '2025-03-19 16:05:48',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'johnny_depp',
            'full_name' => 'Johnny Depp',
            'email' => 'johnydepp@workmasterplanner.com',
            'password' => Hash::make('depp123'),
            'is_admin' => false,
            'created_at' => '2025-08-19 16:05:48',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'noah.wilson55',
            'full_name' => 'Noah Wilson',
            'email' => 'noah.wilson155@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-11-05 12:33:21',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'amelia.anderson73',
            'full_name' => 'Amelia Anderson',
            'email' => 'amelia.anderson473@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-08-19 16:05:48',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'liam.thomas88',
            'full_name' => 'Liam Thomas',
            'email' => 'liam.thomas588@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-03-10 09:12:37',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'charlotte.taylor14',
            'full_name' => 'Charlotte Taylor',
            'email' => 'charlotte.taylor114@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-01-28 20:47:02',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'matthew.moore22',
            'full_name' => 'Matthew Moore',
            'email' => 'matthew.moore322@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-04-06 14:55:11',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'harper.jackson67',
            'full_name' => 'Harper Jackson',
            'email' => 'harper.jackson667@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-05-23 10:21:54',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'samuel.martin31',
            'full_name' => 'Samuel Martin',
            'email' => 'samuel.martin431@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-07-14 18:37:45',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'victoria.lee90',
            'full_name' => 'Victoria Lee',
            'email' => 'victoria.lee490@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-06-02 09:48:12',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'ethan.perez44',
            'full_name' => 'Ethan Perez',
            'email' => 'ethan.perez144@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-02-07 11:29:55',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'mia.thompson76',
            'full_name' => 'Mia Thompson',
            'email' => 'mia.thompson476@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-09-17 15:16:44',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'jacob.white29',
            'full_name' => 'Jacob White',
            'email' => 'jacob.white229@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-12-01 08:42:30',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'emma.harris52',
            'full_name' => 'Emma Harris',
            'email' => 'emma.harris152@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-03-25 17:11:10',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'benjamin.sanchez68',
            'full_name' => 'Benjamin Sanchez',
            'email' => 'benjamin.sanchez368@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-01-15 12:54:23',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'ella.clark35',
            'full_name' => 'Ella Clark',
            'email' => 'ella.clark135@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-06-29 14:22:18',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'lucas.ramirez49',
            'full_name' => 'Lucas Ramirez',
            'email' => 'lucas.ramirez149@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-08-10 09:36:05',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'olivia.lewis20',
            'full_name' => 'Olivia Lewis',
            'email' => 'olivia.lewis120@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-07-25 16:02:39',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'samuel.robinson81',
            'full_name' => 'Samuel Robinson',
            'email' => 'samuel.robinson381@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-11-11 13:44:17',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'harper.lee59',
            'full_name' => 'Harper Lee',
            'email' => 'harper.lee159@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-04-18 10:27:51',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'lucas.thompson98',
            'full_name' => 'Lucas Thompson',
            'email' => 'lucas.thompson198@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-09-05 15:48:33',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'amelia.white11',
            'full_name' => 'Amelia White',
            'email' => 'amelia.white111@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-02-23 09:18:44',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'ethan.martin77',
            'full_name' => 'Ethan Martin',
            'email' => 'ethan.martin377@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-06-14 18:33:12',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'mia.rodriguez32',
            'full_name' => 'Mia Rodriguez',
            'email' => 'mia.rodriguez132@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-03-07 12:11:53',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'jacob.johnson64',
            'full_name' => 'Jacob Johnson',
            'email' => 'jacob.johnson164@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-01-12 14:45:07',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'isabella.smith29',
            'full_name' => 'Isabella Smith',
            'email' => 'isabella.smith129@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-08-30 09:27:21',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'liam.miller88',
            'full_name' => 'Liam Miller',
            'email' => 'liam.miller188@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-10-20 16:05:44',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'victoria.brown45',
            'full_name' => 'Victoria Brown',
            'email' => 'victoria.brown145@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-07-02 11:39:52',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'benjamin.jones93',
            'full_name' => 'Benjamin Jones',
            'email' => 'benjamin.jones493@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-05-28 15:17:33',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'ella.garcia56',
            'full_name' => 'Ella Garcia',
            'email' => 'ella.garcia156@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-11-20 08:50:18',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'samuel.williams71',
            'full_name' => 'Samuel Williams',
            'email' => 'samuel.williams371@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-06-06 13:44:29',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'harper.martinez23',
            'full_name' => 'Harper Martinez',
            'email' => 'harper.martinez123@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-03-31 09:22:55',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'olivia.hernandez36',
            'full_name' => 'Olivia Hernandez',
            'email' => 'olivia.hernandez136@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-12-05 14:16:38',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'lucas.lopez12',
            'full_name' => 'Lucas Lopez',
            'email' => 'lucas.lopez112@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-02-18 10:41:07',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'amelia.gonzalez59',
            'full_name' => 'Amelia Gonzalez',
            'email' => 'amelia.gonzalez159@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-01-08 17:33:26',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'ethan.wilson85',
            'full_name' => 'Ethan Wilson',
            'email' => 'ethan.wilson185@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-09-12 12:28:54',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'mia.anderson40',
            'full_name' => 'Mia Anderson',
            'email' => 'mia.anderson140@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-04-26 09:19:12',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'jacob.thomas57',
            'full_name' => 'Jacob Thomas',
            'email' => 'jacob.thomas157@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-06-12 15:05:47',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'isabella.taylor63',
            'full_name' => 'Isabella Taylor',
            'email' => 'isabella.taylor163@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-03-19 11:44:39',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'liam.moore50',
            'full_name' => 'Liam Moore',
            'email' => 'liam.moore150@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-07-30 08:53:26',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'victoria.jackson28',
            'full_name' => 'Victoria Jackson',
            'email' => 'victoria.jackson128@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-05-09 16:12:48',
        ]);
        DB::table('users')->insertOrIgnore([
            'username' => 'john.smith42',
            'full_name' => 'John Smith',
            'email' => 'john.smith842@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-02-14 10:23:11',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'emily.johnson33',
            'full_name' => 'Emily Johnson',
            'email' => 'emily.johnson553@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-04-03 15:11:44',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'michael.williams77',
            'full_name' => 'Michael Williams',
            'email' => 'michael.williams927@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-01-22 08:55:20',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'olivia.brown64',
            'full_name' => 'Olivia Brown',
            'email' => 'olivia.brown712@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-06-18 19:40:55',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'daniel.jones15',
            'full_name' => 'Daniel Jones',
            'email' => 'daniel.jones134@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-03-29 13:21:10',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'sophia.garcia91',
            'full_name' => 'Sophia Garcia',
            'email' => 'sophia.garcia591@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-05-12 11:20:44',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'ethan.miller28',
            'full_name' => 'Ethan Miller',
            'email' => 'ethan.miller728@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-07-07 09:14:50',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'isabella.davis47',
            'full_name' => 'Isabella Davis',
            'email' => 'isabella.davis147@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-02-28 18:44:18',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'jacob.rodriguez36',
            'full_name' => 'Jacob Rodriguez',
            'email' => 'jacob.rodriguez936@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-10-15 07:22:40',
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'mia.martinez82',
            'full_name' => 'Mia Martinez',
            'email' => 'mia.martinez482@workmasterplanner.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'created_at' => '2025-09-01 14:55:33',
        ]);
    }
}
