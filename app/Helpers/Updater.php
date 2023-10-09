<?php
/**
 * Универсальная класс управления записями коллекций
 */

namespace App\Helpers;


use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Updater
{
    protected string $deleted_at = 'deleted_at';
    protected int $create = 0;
    protected int $update = 0;
    protected int $skip = 0;
    protected int $restore = 0;
    protected int $iterations = 0;
    protected int $startCount = 0;
    protected int $delete = 0;
    protected int $error = 0;
    protected int $no_change = 0;
    protected int $startTime = 0;
    protected $total;
    protected $msg = [];

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public ?Model $instance;

    // Проверка на использование SoftDeletes
    public bool $SoftDeletes = false;

    public function iterate(Model $model)
    {
        $this->reset();
        $this->instance = $model;
        $this->SoftDeletes = method_exists($model, 'getDeletedAtColumn');
    }

    public function reset()
    {
        $this->startTime = microtime(true);
        $this->instance = null;
        $this->msg = [];
        $this->SoftDeletes = false;
        $this->total = null;
        $this->no_change = $this->error = $this->startCount = $this->iterations = $this->create = $this->update = $this->skip = $this->restore = $this->delete = 0;

    }

    public function newInstance()
    {
        return $this->instance->newInstance();
    }

    public bool $_show_diff = false;

    public function showDiff()
    {
        $this->_show_diff = true;
    }

    public function isShowDiff()
    {
        return $this->_show_diff;
    }

    /**
     * Функция для обновления моделей
     * - Создает новые записи
     * - Обновляет существующие
     * - Восстанавливает удаленные
     * - Удаляет из коллекции ключ записи для последующего удаление в методе @param \Illuminate\Database\Eloquent\Collection $Collection
     * @param Collection $Collection - коллекция
     * @param string|int $key - ключ записи в коллекции
     * @param array $data - данные для заполнения модели
     * @param bool $is_forget - true удалить из коллекции ключ записи
     * @param bool $is_add - true добавить в коллекцию вновь созданную запись
     * @return \Illuminate\Database\Eloquent\Model
     * @link deleted
     */
    public function update(Collection $Collection, string|int $key, array $data, bool $forgetCollection = true, bool $addCollection = false)
    {
        $this->iterations++;
        /* @var Model $Model */
        if ($Model = $Collection->get($key)) {
            // Заполение модели
            $Model->fill($data);

            // Проверка на удаление
            if ($this->SoftDeletes) {

                if (is_object($Model->deleted_at)) {
                    $this->restore++;
                }
            }

            $Model->isDirty() ? $this->update++ : $this->no_change++;

            if ($this->isShowDiff()) {
                dd($Model->getDirty());
            }

            // Сохраняет или восстанавливает запись если она была удалена
            $this->SoftDeletes ? $Model->restore() : $Model->save();

            if ($forgetCollection) {
                $Collection->forget($key);
            }
            return $Model;
        }

        $this->create++;

        $Model = $this->instance::create($data);

        // Добавляем в коллекцию вновь созданную запись
        if ($addCollection) {
            // Пишем в коллекцию по ключу
            $Collection->put($key,$Model);
        }

        return $Model;
    }


    /**
     *  Удаляем записи которые не были переданы в ответе
     * Все записи которые не были обновлены будут помечены на удаление
     */
    public function deleted(Collection $collection): void
    {
        $collection->each(function (Model $item) {

            // Если запись не помечена на удаление, то удаляем
            if ($this->SoftDeletes) {
                if (!is_object($item->deleted_at)) {
                    $item->delete();
                    $this->delete++;
                }
            } else {
                $item->delete();
                $this->delete++;
            }

        });
    }

    public function stat(): \Illuminate\Support\Collection
    {

        return collect([
            'total' => is_numeric($this->total) ? $this->total : 'not set',
            'startCount' => $this->startCount,
            'iterations' => $this->iterations,
            'create' => $this->create,
            'update' => $this->update,
            'error' => $this->error,
            'no_change' => $this->no_change,
            'skip' => $this->skip,
            'restore' => $this->restore,
            'delete' => $this->delete,
            'Execution time' => ((microtime(true) - $this->startTime)) . ' sec.',
        ]);
    }

    public function stats(Command $command): void
    {
        $this->stat()->each(function ($v, $k) use ($command) {
            if ($k === 'error' && !empty($v)) {
                $command->error("-- {$k}: {$v}");
            } else {
                $command->info("-- {$k}: {$v}");
            }
            return true;
        });
        // Обнуляем все
        $this->reset();
    }


    public function skip(): void
    {
        $this->skip++;
    }


    public function error(string $msg): void
    {
        $this->msg[] = $msg;
        $this->error++;
    }

    public function getErrors(): array
    {
        return $this->msg;
    }

    public function isError(): bool
    {
        return $this->error > 0;
    }

    public function startCount(int $count): void
    {
        $this->startCount = $count;
    }

    public function total(int $total): void
    {
        $this->total = $total;
    }

    public function collection(Model $model, Collection $collection, array $arrays, string $key, callable $callback, bool $deleted = true, bool $forgetCollection = true, bool $addCollection = false): Updater
    {

        $this->iterate($model);
        $this->total(count($arrays));
        $this->startCount($collection->count());

        foreach ($arrays as $i => $array) {
            $row = $callback($array, $i, $collection);
            if ($row === false) {
                $this->skip();
                continue;
            }

            if (!is_array($row)) {
                $this->error('Callback must return array');
                continue;
            }

            if (!isset($row[$key])) {
                throw new \Exception('Key not found');
            }
            $this->update($collection, $row[$key], $row, $forgetCollection, $addCollection);
        }

        if ($deleted) {
            $this->deleted($collection);
        }
        return $this;
    }

}
