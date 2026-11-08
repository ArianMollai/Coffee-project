<?php

namespace App\Repositories\Table\Contract;

use Illuminate\Support\Collection;
use App\Models\Table;

interface TableRepositoryInterface
{
    public function viewTables(): Collection;
    public function ViewTable(int $id): ?Table;
    public function CreateTable(array $data): Table;
    public function UpdateTable(Table $table, array $data): ?Table;
    public function DeleteTable(Table $table);
}
