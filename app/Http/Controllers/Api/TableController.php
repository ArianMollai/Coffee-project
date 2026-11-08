<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Table\Contract\TableServiceInterface;
use App\Http\Resources\TableResource;
use App\Http\Requests\Table\CreateTableRequest;
use App\Http\Requests\Table\UpdateTableRequest;
use App\Policies\TablePolicy;
use App\models\User;
use App\models\Table;
use App\Http\Requests\Price\CreatePriceRequest;

class TableController extends Controller
{
    public function __construct(private TableServiceInterface $tableService){}

    public function ViewTables(){
        $this->authorize('viewAny', Table::class);

        return TableResource::collection($this->tableService->ViewTables());
    }

    public function ViewTable(int $id){
        $this->authorize('viewAny', Table::class);

        return new TableResource($this->tableService->ViewTable($id));
    }

    public function CreateTable(CreateTableRequest $tableRequest){
        $this->authorize('create', Table::class);

        $tableValidated=$tableRequest->validated();

        return new TableResource($this->tableService->CreateTable($tableValidated));
    }

    public function UpdateTable(int $id, UpdateTableRequest $request){
        $this->authorize('update', Table::class);

        $validated=$request->validated();

        return new TableResource($this->tableService->UpdateTable($id, $validated));
    }

    public function DeleteTable(int $id){
        $this->authorize('delete', Table::class);

        $this->tableService->DeleteTable($id);

        return response()->json([
            'message' => "Table deleted successfully"
        ]);
    }
}
