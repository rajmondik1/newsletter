<?php

namespace App\Util;

class FileHandler
{
    private const FILENAME = 'data.json';

    private string $fileDir;

    public function __construct(string $dataDir)
    {
        $this->fileDir = $dataDir . '/' . self::FILENAME;
    }

    /**
     * Append contents to file
     *
     * @param array $contents Actual file contents
     * @return array|null
     * @throws \JsonException
     */
    public function append(array $contents): ?array
    {
        $array = json_decode($this->read(), true, 512, JSON_THROW_ON_ERROR);

        if (!$array) {
            $array = [];
        }

        $array[] = $contents;

        return $this->write($array);
    }

    /**
     * Overwrite file
     *
     * @param array $contents
     * @return array|null
     * @throws \JsonException
     */
    public function write(array $contents): ?array
    {
        try {
            $json = json_encode($contents, JSON_THROW_ON_ERROR);
        } catch (\Exception $e) {
            throw $e;
        } finally {
            file_put_contents($this->fileDir, $json);
            return $contents;
        }
    }

    public function read(): ?string
    {
        return file_get_contents($this->fileDir);
    }
}