<?php

namespace App\Services;

use App\Interfaces\Services\ITranslationService;
use App\Models\TranslationModel;

class TranslationService extends BaseService implements ITranslationService
{
    protected object $redis;

    /** @var TranslationModel  */
    protected object $translationModel;

    public function __construct()
    {
        $this->redis = service('redisService');
        $this->translationModel = model("TranslationModel");
        $this->modelName = $this->translationModel->getModelName();
    }

    public function getTranslation(string $key, string $locale): object
    {
        $translationKey = "languages:$locale:$key";
        $translation = $this->redis->hgetall($translationKey);

        if (!$translation) {
            $translations = $this->fetchTranslationsFromDatabase($locale);
            foreach ($translations as $translation => $value) {
                $redisKey = "languages:$locale:$translation";

                $this->redis->hset($redisKey, 'key_name',      $value->key_name); //
                $this->redis->hset($redisKey, 'language_code', $value->language_code); //
                $this->redis->hset($redisKey, 'value',         $value->value); //
                $this->redis->hset($redisKey, 'status_code',   $value->status_code);
                $this->redis->hset($redisKey, 'created_at',    strtotime($value->created_at));
                $this->redis->hset($redisKey, 'updated_at',    strtotime($value->updated_at));
            }
            if (isset($translations[$key])) {
                return (object) $translations[$key];
            }
            return (object) ['value' => $key];
        }
        return (object) $translation;
    }

    public function reValidation(string $locale): array
    {
        $translations = $this->fetchTranslationsFromDatabase($locale);
        $updatedData = [];

        foreach ($translations as $keyName => $value) {
            $redisKey = "languages:$locale:$keyName";
            $redisTime = $this->redis->hget($redisKey, 'updated_at');
            $redisValue = $this->redis->hget($redisKey, 'value');

            $dbUpdatedTime = strtotime($value->updated_at);

            if (!$redisTime || $redisTime < $dbUpdatedTime) {
                $this->redis->hset($redisKey, 'value', $value->value);
                $this->redis->hset($redisKey, 'updated_at', $dbUpdatedTime);

                $updatedData[$keyName] = [
                    'old_time'  => $redisTime ? date('Y-m-d H:i:s', $redisTime) : null,
                    'new_time'  => date('Y-m-d H:i:s', $dbUpdatedTime),
                    'old_value' => $redisValue,
                    'new_value' => $value->value
                ];
            }
        }
        return $updatedData;
    }

    public function fetchTranslationsFromDatabase(string $locale): array
    {
        $translations = $this->translationModel->findAll();
        $result = [];

        foreach ($translations as $translation) {
            if ($translation->language_code === $locale) {
                $result[$translation->key_name] = (object)[
                    'key_name'      => $translation->key_name,
                    'language_code' => $translation->language_code,
                    'value'         => $translation->value,
                    'status_code'   => $translation->status_code,
                    'created_at'    => $translation->created_at,
                    'updated_at'    => $translation->updated_at,
                ];
            }
        }
        return $result;
    }
}
