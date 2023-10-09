<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 09.09.2023
 * Time: 19:19
 */

namespace App\Helpers;


use Livewire\Features\SupportFileUploads\FileUploadConfiguration;

class FileUploadController extends \Livewire\Features\SupportFileUploads\FileUploadController
{
    public function handle()
    {
        if (!auth()->check()) {
            abort(403, 'Доступ запрещен');
            // Из за неправильной проверки подписи, приходится отключать проверку подписи
            #abort_unless(request()->hasValidSignature(), 401);
        }
        $disk = FileUploadConfiguration::disk();
        $filePaths = $this->validateAndStore(request('files'), $disk);
        return ['paths' => $filePaths];
    }
}
