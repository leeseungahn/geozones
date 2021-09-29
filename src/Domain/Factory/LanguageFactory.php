<?php

namespace MyPrm\GeoZones\Domain\Factory;

use MyPrm\GeoZones\Domain\Model\Language;
use MyPrm\GeoZones\Domain\Model\Translation;

class LanguageFactory implements LanguageFactoryInterface
{
    private ?\ArrayIterator $languageList = null;

    public function createListFromIterator(\Iterator $iterator, array $params): \Iterator
    {
        $languages = [];
        for ($iterator->rewind(); $iterator->valid(); $iterator->next()) {
            $array = $iterator->current();
            $name = $array['English'];
            $frenchName  = $array['French'];
            $translation = new Translation('fr', $name, $frenchName);
            $iso639_1 = $array['alpha2'];
            $iso639_2 = $array['alpha3-b'] ?? $array['alpha3-t'];
            if (!array_key_exists($name, $languages)) {
                $languages[$name] = $this->instanciateLanguage($name, '', $iso639_1, $iso639_2, [$translation]);
            }
        }

        return $this->languageList = new \ArrayIterator($languages);
    }

    public function instanciateLanguage(string $name, string $nativeName, ?string $iso639_1, ?string $iso639_2, ?array $translations = []): Language
    {
        return new Language($name, $nativeName, $iso639_1, $iso639_2, $translations);
    }
}
