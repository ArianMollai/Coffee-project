<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TableController;
use App\Http\Controllers\Api\AttributeController;
use App\Http\Controllers\Api\AttributeValueController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\UnitConversionController;
use App\Http\Controllers\Api\IngridientController;
use App\Http\Controllers\Api\IngridientPurchaseController;
use App\Http\Controllers\Api\ExtraController;
use App\Http\Controllers\Api\ProductController;

Route::middleware('jwt')->group(function (){
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/admin/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::get('/admin/roles/{id}', [RoleController::class, 'show'])->name('roles.show');
    Route::put('/admin/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/admin/roles/delete/{id}', [RoleController::class, 'destroy'])->name('roles.delete');

    Route::get('/admin/categories', [CategoryController::class, 'Index']);
    Route::get('/admin/categories/{id}', [CategoryController::class, 'ViewOne']);
    Route::post('/admin/categories/create', [CategoryController::class, 'Create']);
    Route::put('/admin/categories/update/{id}', [CategoryController::class, 'update']);
    Route::delete('/admin/categories/delete/{id}', [CategoryController::class, 'Delete']);

    Route::get('/admin/tables', [TableController::class, 'ViewTables']);
    Route::get('/admin/tables/{id}', [TableController::class, 'ViewTable']);
    Route::post('/admin/tables/create', [TableController::class, 'CreateTable']);
    Route::put('/admin/tables/update/{id}', [TableController::class, 'UpdateTable']);
    Route::delete('/admin/tables/delete/{id}', [TableController::class, 'DeleteTable']);

    Route::get('/admin/attributes', [AttributeController::class, 'index']);
    Route::get('/admin/attribute/{id}', [AttributeController::class, 'show']);
    Route::post('/admin/attribute/create', [AttributeController::class, 'store']);
    Route::put('/admin/attribute/update/{id}', [AttributeController::class, 'update']);
    Route::delete('/admin/attribute/delete/{id}', [AttributeController::class, 'destroy']);

    Route::get('/admin/attribute_value/{attributeValue_id}', [AttributeValueController::class, 'ViewAttributeValue']);
    Route::post('/admin/attribute_value/{attribute_id}/create', [AttributeValueController::class, 'CreateAttributeValue']);
    Route::put('/admin/attribute/{attribute_id}/value/{attributeValue_id}', [AttributeValueController::class, 'UpdatedAttributeValue']);
    Route::delete('/admin/attribute_value/{attributeValue_id}/delete', [AttributeValueController::class, 'DeleteAttributeValue']);

    Route::get('/admin/units', [UnitController::class, 'index']);
    Route::get('/admin/units/{unit_id}', [UnitController::class, 'show']);
    Route::post('/admin/units/create', [UnitController::class, 'store']);
    Route::put('/admin/units/update/{unit_id}', [UnitController::class, 'update']);
    Route::delete('/admin/units/delete/{unit_id}', [UnitController::class, 'destroy']);

    Route::get('/unit/conversions', [UnitConversionController::class, 'ViewUnitConversions']);
    Route::get('/unit/conversions/byunit', [UnitConversionController::class, 'ViewConversionByUnits']);
    Route::get('/unit/conversions/{unitconversion_id}', [UnitConversionController::class, 'ViewConversion']);
    Route::post('/unit/conversions/create', [UnitConversionController::class, 'CreateConversion']);
    Route::put('/unit/conversions/update/{unitconversion_id}', [UnitConversionController::class, 'UpdateConversion']);
    Route::delete('/unit/conversions/delete/{unitconversion_id}', [UnitConversionController::class, 'DeleteUnitConversion']);

    Route::get('/admin/ingridients', [IngridientController::class, 'ViewIngridients']);
    Route::get('/admin/ingridients/{ingridient_id}', [IngridientController::class, 'ViewIngridient']);
    Route::post('/admin/ingridients/create', [IngridientController::class, 'CreateIngridient']);
    Route::put('/admin/ingridients/update/{ingridient_id}', [IngridientController::class, 'UpdateIngridient']);
    Route::delete('/admin/ingridients/delete/{ingridient_id}', [IngridientController::class, 'DeleteIngridient']);

    Route::get('/admin/ingridient/purchases', [IngridientPurchaseController::class, 'ViewIngridientPurchases']);
    Route::get('/admin/ingridient/purchases/{ingridientPurchase_id}', [IngridientPurchaseController::class, 'ViewIngridientPurchase']);
    Route::post('/admin/ingridient/purchases/create/{ingridient_id}', [IngridientPurchaseController::class, 'CreateIngridientPurchase']);
    Route::put('/admin/ingridient/purchases/update/{ingridientPurchase_id}', [IngridientPurchaseController::class, 'UpdateIngridientPurchase']);
    Route::delete('/admin/ingridient/purchases/delete/{ingridientPurchase_id}', [IngridientPurchaseController::class, 'DeleteIngridientPurchase']);

    Route::get('/admin/extras', [ExtraController::class, 'ViewExtras']);
    Route::get('/admin/extras/{extra_id}', [ExtraController::class, 'ViewExtra']);
    Route::post('/admin/extras/create', [ExtraController::class, 'CreateExtra']);
    Route::put('/admin/extras/update/{extra_id}', [ExtraController::class, 'UpdateExtra']);
    Route::delete('/admin/extras/delete/{extra_id}', [ExtraController::class, 'DeleteExtra']);

    Route::get('/admin/products', [ProductController::class, 'ViewProducts']);
    Route::get('/admin/products/{product_id}', [ProductController::class, 'ViewProduct']);
    Route::post('/admin/products/create', [ProductController::class, 'CreateProduct']);
    Route::put('/admin/products/update/{product_id}', [ProductController::class, 'UpdateProduct']);
    Route::delete('/admin/products/delete/{product_id}', [ProductController::class, 'DeleteProduct']);
});