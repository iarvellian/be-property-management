<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::get('/email/verify/{id}', [AuthController::class, 'verifyEmail'])
    ->name('verification.verify');
Route::post('/email/resend', [AuthController::class, 'resendVerificationEmail']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('/profile')->group(function () {
        Route::get('/', [UserController::class, 'getProfile']);
        Route::put('/update/{id}', [UserController::class, 'updateProfile']);
    });
    
});

Route::middleware(['auth:sanctum', 'role:ALL'])->group(function () {
    
});

Route::middleware(['auth:sanctum', 'role:OWNER|ADMIN'])->group(function () {
    Route::prefix('/type')->group(function () {
        Route::get('/list/{propertyId}', [TypeController::class, 'getTypeByPropertyId']);
        Route::post('/create', [TypeController::class, 'storeType']);
        Route::get('/detail/{id}', [TypeController::class, 'getDetailType']);
        Route::put('/update/{id}', [TypeController::class, 'updateType']);
        Route::delete('/delete/{id}', [TypeController::class, 'destroyType']);
        Route::get('/search/{propertyId}', [TypeController::class, 'searchType']);
    });

    Route::prefix('/room')->group(function () {
        Route::get('/list/{propertyId}', [RoomController::class, 'getRoomByPropertyId']);
        Route::post('/create', [RoomController::class, 'storeRoom']);
        Route::get('/detail/{id}', [RoomController::class, 'getDetailRoom']);
        Route::put('/update/{id}', [RoomController::class, 'updateRoom']);
        Route::delete('/delete/{id}', [RoomController::class, 'destroyRoom']);
        Route::get('/search/{propertyId}', [RoomController::class, 'searchRoom']);
    });

    Route::prefix('/facility')->group(function () {
        Route::get('/list', [FacilityController::class, 'getAllFacility']);
        Route::get('/list/{propertyId}', [FacilityController::class, 'getFacilityByPropertyId']);
        Route::post('/create', [FacilityController::class, 'storeFacility']);
        Route::get('/detail/{id}', [FacilityController::class, 'getDetailFacility']);
        Route::put('/update/{id}', [FacilityController::class, 'updateFacility']);
        Route::delete('/delete/{id}', [FacilityController::class, 'destroyFacility']);
        Route::get('/search/{propertyId}', [FacilityController::class, 'searchFacility']);
    });
});

Route::middleware(['auth:sanctum', 'role:OWNER'])->group(function () {
    Route::prefix('/property-owner')->group(function () {
        Route::get('/list', [PropertyController::class, 'getAllProperty']);
        Route::post('/create', [PropertyController::class, 'storeProperty']);
        Route::get('/detail/{id}', [PropertyController::class, 'getDetailProperty']);
        Route::put('/update/{id}', [PropertyController::class, 'updateProperty']);
        Route::delete('/delete', [PropertyController::class, 'destroyProperty']);
        Route::get('/search', [PropertyController::class, 'searchProperty']);
        Route::post('/assign-admin', [PropertyController::class, 'assignAdminToProperty']);
        Route::delete('/remove-admin', [PropertyController::class, 'deleteAdminFromProperty']);
    });

    Route::prefix('/admin')->group(function () {
        Route::get('/list', [AdminController::class, 'getAllAdmin']);
        Route::get('/list/{propertyId}', [AdminController::class, 'getAdminByPropertyId']);
        Route::post('/create', [AdminController::class, 'storeAdmin']);
        Route::delete('/delete/{id}', [AdminController::class, 'destroyAdmin']);
    });
    
});

Route::middleware(['auth:sanctum', 'role:ADMIN'])->group(function () {
    Route::prefix('/property-admin')->group(function () {
        Route::get('/list/{adminId}', [PropertyController::class, 'getAllPropertyManageByAdmin']);
        Route::get('/detail/{adminId}/{propertyId}', [PropertyController::class, 'getDetailPropertyManageByAdmin']);
        Route::get('/detail/by-code/{adminId}/{code}', [PropertyController::class, 'getDetailPropertyByCodeManagedByAdmin']);
        Route::put('/update/{adminId}/{propertyId}', [PropertyController::class, 'updatePropertyManageByAdmin']);
        Route::get('/search/{adminId}', [PropertyController::class, 'searchPropertyManagedByAdmin']);
    });

});

Route::middleware(['auth:sanctum', 'role:CUSTOMER'])->group(function () {
    
});

