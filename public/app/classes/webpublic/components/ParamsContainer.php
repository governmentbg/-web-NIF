<?php

declare(strict_types=1);

namespace webpublic\components;

use vakata\files\File;
use vakata\kvstore\Storage;
use base\components\files\Files;

class ParamsContainer extends Storage
{
    protected ?Files $files = null;

    public function __construct(array &$data, ?Files $files = null)
    {
        parent::__construct($data);
        $this->files = $files;
    }
    public function getString(string $key, ?string $default = null): ?string
    {
        $val = $this->get($key, chr(0));
        if ($val === chr(0) || !is_scalar($val)) {
            return $default;
        }
        return trim((string)$val);
    }
    public function getNonEmptyString(string $key, ?string $default = null): ?string
    {
        $val = $this->getString($key, chr(0));
        if ($val === chr(0)) {
            return $default;
        }
        return strlen($val ?? '') ? $val : $default;
    }
    public function getInt(string $key, ?int $default = null): ?int
    {
        $val = $this->get($key, chr(0));
        if ($val === chr(0) || !is_scalar($val)) {
            return $default;
        }
        return (int)$val;
    }
    public function getBool(string $key, bool $default = false): bool
    {
        $val = $this->get($key, chr(0));
        if ($val === chr(0) || !is_scalar($val)) {
            return $default;
        }
        return (bool)$val;
    }
    public function getArray(string $key, array $default = []): array
    {
        $val = $this->get($key, chr(0));
        if (!is_array($val)) {
            return $default;
        }
        return $val;
    }
    public function getFile(string $key): ?File
    {
        if (!isset($this->files)) {
            return null;
        }
        $file = $this->getNonEmptyString($key);
        if (!isset($file)) {
            return null;
        }
        try {
            return $this->files->get($file);
        } catch (\Throwable) {
            return null;
        }
    }
}
