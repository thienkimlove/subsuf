<?php
namespace App\Repositories;

use App\Language;

class LanguageRepository
{
    protected $language;

    public function __construct(Language $language)
    {
        $this->language = $language;
    }

    public function getAll()
    {
        return $this->language->orderBy('language_code', 'asc')->get();
    }

    public function find($language_code)
    {
        return $this->language->find($language_code);
    }

    public function insert($data)
    {
        $this->language->insert($data);
    }

    public function update($language_code, $data)
    {
        $this->language->where('language_code', $language_code)->update($data);
    }

    public function delete($language_code)
    {
        return $this->language->destroy($language_code);
    }
}