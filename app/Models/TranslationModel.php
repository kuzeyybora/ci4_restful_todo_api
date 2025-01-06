<?php

namespace App\Models;

use CodeIgniter\Model;

class TranslationModel extends BaseModel
{
    protected $table = 'translations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['key_name', 'language_code', 'value', 'status_code'];
    protected $returnType = "object";

    public function getTranslation(string $key, string $languageCode): ?array
    {
        return $this->where('key_name', $key)->where('language_code', $languageCode)->first();
    }

    public function getLastUpdatedAt(string $key, string $languageCode): ?string
    {
        $translation = $this->getTranslation($key, $languageCode);
        return $translation['updated_at'] ?? null;
    }
}
