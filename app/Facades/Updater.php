<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 05.05.2023
 * Time: 16:57
 */

namespace App\Facades;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * Class Updater
 * @package App\Facades
 * @method static void iterate(Model $model)
 * @method static void deleted(Collection $collection)
 * @method static Model update(Collection $Collection, string|int $key, array $data, bool $is_forget = true, bool $is_add = true)
 * @method static \Illuminate\Support\Collection stat()
 * @method static void stats(Command $command)
 * @method static void skip()
 * @method static void error(string $message)
 * @method static bool isError()
 * @method static bool getErrors()
 * @method static void showDiff()
 * @method static void total(int $total)
 * @method static void startCount(int $count)
 * @method static \App\Helpers\Updater collection(Model $model, Collection $collection, array $results, string $key, callable $callback, bool $deleted = true, bool $is_forget = true, bool $addCollection = false) : Updater
 *
 * @see \App\Helpers\Updater
 */
class Updater extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'updater_helper';
    }
}
