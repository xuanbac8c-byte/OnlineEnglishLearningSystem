<?php

namespace App\Services\Interfaces;

use App\Models\Language;
use Illuminate\Support\Collection;

interface ILanguageService
{
    public function getAll(): Collection;
    public function findById(int $id): Language;
    public function findByCode(string $code): Language;
    public function create(array $data): Language;
    public function update(int $id, array $data): Language;
    public function delete(int $id): bool;
}

?>