<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Column;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  Get the columns from the included .json file
        $columns = json_decode(file_get_contents(
            database_path('json/cards.json')
        ));

        //  Loop through all the columns
        foreach ($columns as $column) {
            //  Create a service
            $service = Column::create([
                'title' => $column->title,
            ]);

            //  Create cards
            foreach ($column->cards as $card) {
                $area = $service->cards()->create([
                    'title' => $card->title,
                    'description' => $card->description,
                ]);
            }
        }
    }
}
