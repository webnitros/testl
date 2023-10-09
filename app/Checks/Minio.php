<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 07.10.2023
 * Time: 15:55
 */

namespace App\Checks;


use Illuminate\Support\Facades\Storage;
use Spatie\Health\Checks\Result;

class Minio extends \Spatie\Health\Checks\Check
{

    public function process()
    {

    }

    public function run(): Result
    {
        $result = Result::make();
        try {
            Storage::directories();
            return $result->ok('Minio connected');
        } catch (\Exception $e) {
            return $result->failed('Minio:' . $e->getMessage());
        }
    }
}
