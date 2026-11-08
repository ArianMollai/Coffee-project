<?php

namespace App\Services\Table\Contract;

use Illuminate\Support\Collection;
use App\Models\Table;

interface TableServiceInterface
{
    public function ViewTables(): Collection;
    public function ViewTable(int $id): ?Table;
    public function CreateTable(array $tableData): Table;
    public function UpdateTable(int $id, array $data): ?Table;
    public function DeleteTable(int $id);
}
