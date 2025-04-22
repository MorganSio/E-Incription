<?php

namespace App\Service;

use CloudConvert\CloudConvert;
use CloudConvert\Models\Job;
use CloudConvert\Models\Task;

class CloudService
{
    private CloudConvert $cloudconvert;

    public function __construct(string $cloudconvertApiKey)
    {
        $this->cloudconvert = new CloudConvert([
            'api_key' => $cloudconvertApiKey,
            'sandbox' => false
        ]);
    }

    public function convertDocxToPdf(string $filePath): string
    {
        $job = new Job();

        $job->addTask(new Task('import/upload', 'upload-task'));
        $job->addTask(
            (new Task('convert', 'convert-task'))
                ->set('input', 'upload-task')
                ->set('input_format', 'docx')
                ->set('output_format', 'pdf')
        );
        $job->addTask(
            (new Task('export/url', 'export-task'))
                ->set('input', 'convert-task')
        );

        $job = $this->cloudconvert->jobs()->create($job);

        $uploadTask = $job->getTasks()->whereName('upload-task')[0];
        $this->cloudconvert->tasks()->upload($uploadTask, fopen($filePath, 'r'));

        $exportTask = $this->cloudconvert->tasks()->wait(
            $job->getTasks()->whereName('export-task')[0]
        );        

        return $exportTask->getResult()->files[0]->url;
    }
}