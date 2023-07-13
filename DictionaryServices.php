<?php

require_once './dao/DictionaryDao.class.php';

class DictionaryServices {
    private $dictionaryDao;

    public function __construct() {
        $this->dictionaryDao = new DictionaryDao();
    }

    public function addDictionary($signLanguage, $word, $phrase, $image) {
        $result = $this->dictionaryDao->addDictionary($signLanguage, $word, $phrase, $image);
        return $result;
    }

    public function deleteDictionary($dictionaryId) {
        $result = $this->dictionaryDao->deleteDictionary($dictionaryId);
        return $result;
    }

    public function getAllDictionaries() {
        $result = $this->dictionaryDao->getAllDictionaries();
        return $result;
    }

    public function updateDictionaryImage($dictionaryId, $image) {
        $result = $this->dictionaryDao->updateDictionaryImage($dictionaryId, $image);
        return $result;
    }
}

?>