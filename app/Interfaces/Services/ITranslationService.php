<?php

namespace App\Interfaces\Services;

interface ITranslationService
{
    public function getTranslation(string $key, string $locale): object;
    public function reValidation(string $locale): array;
    public function fetchTranslationsFromDatabase(string $locale): array;
}
