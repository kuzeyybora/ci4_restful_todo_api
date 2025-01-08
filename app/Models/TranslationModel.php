<?php

namespace App\Models;

use CodeIgniter\Model;

class TranslationModel extends BaseModel
{
    protected $table = 'translations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['key_name', 'language_code', 'value', 'status_code'];
    protected $returnType = "object";

    /**
     * Retrieves a translation for a specific key and language code.
     *
     * @param string $key The translation key.
     * @param string $languageCode The language code (e.g., 'en', 'fr').
     * @return array|null The translation data if found, otherwise null.
     */
    public function getTranslation(string $key, string $languageCode): ?array
    {
        return $this->where('key_name', $key)->where('language_code', $languageCode)->first();
    }

    /**
     * Retrieves the last updated timestamp for a specific translation.
     *
     * @param string $key The translation key.
     * @param string $languageCode The language code (e.g., 'en', 'tr').
     * @return string|null The timestamp of when the translation was last updated, or null if not found.
     */
    public function getLastUpdatedAt(string $key, string $languageCode): ?string
    {
        $translation = $this->getTranslation($key, $languageCode);
        return $translation['updated_at'] ?? null;
    }
}
