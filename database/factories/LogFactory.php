<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 23.09.2023
 * Time: 10:21
 */

namespace Database\Factories;

use App\Models\Log;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LogFactory extends Factory
{
    protected $model = Log::class;

    public function definition(): array
    {
        return [
            'build_id' => $this->faker->randomNumber(),
            'query_id' => $this->faker->word(),
            'branch' => $this->faker->word(),
            'status' => $this->faker->word(),
            'state' => $this->faker->word(),
            'status_text' => Carbon::now(),
            'queued_date' => Carbon::now(),
            'start_date' => Carbon::now(),
            'finish_date' => Carbon::now(),
            'running_info' => $this->faker->words(),
            'tags' => $this->faker->words(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
