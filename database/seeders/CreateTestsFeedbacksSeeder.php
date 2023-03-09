<?php
namespace Database\Seeders;
use App\Models\Feedback;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class CreateTestsFeedbacksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i< 500; $i++) {
            $feedback= Feedback::create([
                'title' => $i.'qwerty',
                'detail' => $i.'detail',
                'filename' => $i.'.png',
                'user_id'=> '1'
            ]);
        }
    }
}
