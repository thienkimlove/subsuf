<?php
namespace App\Repositories;

use App\StaticContent;

class StaticContentRepository
{
    protected $staticContent;

    public function __construct(StaticContent $staticContent)
    {
        $this->staticContent = $staticContent;
    }

    public function find($id, $language = 'en')
    {
        return $this->staticContent->where('id', $id)
            ->where('language', $language)
            ->with('language_ref')
            ->first();
    }

    public function findPolicies()
    {
        return $this->staticContent->where('id', get_policy())
            ->with('language_ref')
            ->orderBy('language', 'asc')
            ->get();
    }

    public function findTerms()
    {
        return $this->staticContent->where('id', get_term())
            ->with('language_ref')
            ->orderBy('language', 'asc')
            ->get();
    }

    public function findAbouts()
    {
        return $this->staticContent->where('id', get_about())
            ->with('language_ref')
            ->orderBy('language', 'asc')
            ->get();
    }

    public function insert($data)
    {
        $this->staticContent->insert($data);
    }

    public function update($id, $language, $data)
    {
        $this->staticContent->where('id', $id)
            ->where('language', $language)
            ->update($data);
    }
}