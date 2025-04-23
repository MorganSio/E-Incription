<?php

namespace App\Service;

class CloudService
{
    private string $sofficePath;

    public function __construct(string $sofficePath)
    {
        $this->sofficePath = $sofficePath;
    }

    public function convert(string $docxPath, string $outputDir): string
    {
        if (!file_exists($docxPath)) {
            throw new \Exception("Fichier DOCX introuvable : $docxPath");
        }

        $outputDir = rtrim($outputDir, '\\/');
        $command = sprintf(
            '"%s" --headless --convert-to pdf --outdir "%s" "%s"',
            $this->sofficePath,
            $outputDir,
            $docxPath
        );

        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            throw new \Exception("Erreur conversion : " . implode("\n", $output));
        }

        $outputFilename = pathinfo($docxPath, PATHINFO_FILENAME) . '.pdf';
        return $outputDir . DIRECTORY_SEPARATOR . $outputFilename;
    }
}