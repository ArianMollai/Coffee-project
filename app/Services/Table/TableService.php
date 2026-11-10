<?php

namespace App\Services\Table;

use App\Repositories\Table\Contract\TableRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Table;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Table\Contract\TableServiceInterface;
use App\Repositories\Price\Contract\PriceRepositoryInterface;
use App\Services\Price\Contract\PriceServiceInterface;


class TableService implements TableServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private TableRepositoryInterface $tableRepository,
        private PriceServiceInterface $priceService
    ){}


    public function ViewTables(): Collection
    {
        return $this->tableRepository->viewTables();
    }

    public function ViewTable(int $id): ?Table
    {
        return $this->tableRepository->ViewTable($id) ?? throw new ModelNotFoundException("Table not found");
    }

    public function CreateTable(array $data): Table
    {
        $table = $this->tableRepository->CreateTable($data);

        $this->priceService->CreatePrice([
            'table_id' => $table->id,
            'price' => $data['price'],
            'discount' => $data['discount'],
            'inventory' => 1
        ]);

        return $table->load('Prices');
    }

    public function UpdateTable(int $id, array $data): ?Table
    {
        $table=$this->ViewTable($id) ?? throw new ModelNotFoundException("Table not found");

        $this->tableRepository->UpdateTable($table, $data);

        $this->priceService->UpdatePrice($table->Prices->id, [
            'price' => $data['price'],
            'discount' => $data['discount'],
            'inventory' => 1
        ]);

        return $table->load('Prices');
    }

    public function DeleteTable(int $id){
        $table=$this->ViewTable($id) ?? throw new ModelNotFoundException("Table not found");

        return $this->tableRepository->DeleteTable($table);
    }

    public function FindTablePrice(int $tableId){
        $table=$this->ViewTable($tableId) ?? throw new ModelNotFoundException("Table not found");

        return $this->tableRepository->FindTablePrice($table);
    }
}
