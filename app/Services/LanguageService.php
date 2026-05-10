<?php

namespace App\Services;

use App\Models\Language;
use App\Services\Interfaces\ILanguageService;
use Illuminate\Support\Collection;

class LanguageService implements ILanguageService
{
    public function getAll(): Collection
    {
        return Language::orderBy('name')->get();
    }

    public function findById(int $id): Language
    {
        return Language::findOrFail($id);
    }

    public function findByCode(string $code): Language
    {
        return Language::where('code', $code)->firstOrFail();
    }

    public function create(array $data): Language
    {
        return Language::create([
            'name' => $data['name'],
            'code' => $data['code'],
        ]);
    }

    public function update(int $id, array $data): Language
    {
        $language = Language::findOrFail($id);
        $language->update([
            'name' => $data['name'],
            'code' => $data['code'],
        ]);
        return $language;
    }

    public function delete(int $id): bool
    {
        return Language::findOrFail($id)->delete();
    }
}

?>