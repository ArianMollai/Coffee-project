<?php

namespace App\Repositories\Table;

use Illuminate\Support\Collection;
use App\Models\Table;
use App\Repositories\Table\Contract\TableRepositoryInterface;

class TableRepository implements TableRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(){}

    public function viewTables(): Collection
    {
        return Table::with("Prices")->latest()->get();
    }

    public function ViewTable(int $id): ?Table
    {
        return Table::with('Prices')->findOrFail($id);
    }

    public function CreateTable(array $data): Table
    {
        return Table::create($data);
    }

    public function UpdateTable(Table $table, array $data): Table
    {
        $table->update($data);

        return $table;
    }

    public function DeleteTable(Table $table)
    {
        return $table->delete();
    }

    public function FindTablePrice(Table $table)
    {
        return $table->Prices;
    }
}
