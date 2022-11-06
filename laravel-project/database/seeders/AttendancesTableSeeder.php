<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attendance;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 2,
            'data' => 'abc'
        ];
        Attendance::create($param);
        $param = [
            'user_id' => 3,
            'data' => 'abc'
        ];
        Attendance::create($param);
        $param = [
            'user_id' => 4,
            'data' => 'abc'
        ];
        Attendance::create($param);
        $param = [
            'user_id' => 5,
            'data' => 'abc'
        ];
        Attendance::create($param);
        $param = [
            'user_id' => 6,
            'data' => 'abc'
        ];
        Attendance::create($param);
        $param = [
            'user_id' => 7,
            'data' => 'abc'
        ];
        Attendance::create($param);
        $param = [
            'user_id' => 8,
            'data' => 'abc'
        ];
        Attendance::create($param);
        $param = [
            'user_id' => 9,
            'data' => 'abc'
        ];
        Attendance::create($param);
        $param = [
            'user_id' => 10,
            'data' => 'abc'
        ];
        Attendance::create($param);
    }
}
