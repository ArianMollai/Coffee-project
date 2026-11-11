<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use App\Services\Auth\Contracts\AuthServiceInterface;
use App\Services\Auth\JwtAuthService;
use App\Repositories\Auth\Contracts\AuthRepository;
use App\Repositories\Auth\EloquentAuthRepository;
use App\Repositories\Users\Contracts\UserRepository;
use App\Repositories\Users\EloquentUserRepository;
use App\Services\Authentication\Contracts\AuthenticationServiceInterface;
use App\Services\Authentication\AuthenticationService;
use App\Repositories\Role\Contract\RoleRepositoryInterface;
use App\Repositories\Role\RoleRepository;
use App\Services\Role\Contract\RoleServiceInterface;
use App\Services\Role\RoleService;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Repositories\Category\Contract\CategoryRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Services\Category\Contract\CategoryServiceInterface;
use App\Services\Category\CategoryService;
use App\Repositories\Cart\Contract\CartRepositoryInterface;
use App\Repositories\Cart\CartRepository;
use App\Services\Cart\Contract\CartServiceInterface;
use App\Services\Cart\CartService;
use App\Repositories\Table\Contract\TableRepositoryInterface;
use App\Repositories\Table\TableRepository;
use App\Services\Table\Contract\TableServiceInterface;
use App\Services\Table\TableService;
use App\Repositories\Price\Contract\PriceRepositoryInterface;
use App\Repositories\Price\PriceRepository;
use App\Services\Price\Contract\PriceServiceInterface;
use App\Services\Price\PriceService;
use App\Repositories\Attribute\Contracts\AttributeRepositoryInterface;
use App\Repositories\Attribute\AttributeRepository;
use App\Services\Attribute\Contract\AttributeServiceInterface;
use App\Services\Attribute\AttributeService;
use App\Repositories\AttributeValue\Contract\AttributeValueRepositoryInterface;
use App\Repositories\AttributeValue\AttributeValueRepository;
use App\Services\AttributeValue\Contract\AttributeValueServiceInterface;
use App\Services\AttributeValue\AttributeValueService;
use App\Repositories\Unit\Contract\UnitRepositoryInterface;
use App\Repositories\Unit\UnitRepository;
use App\Services\Unit\Contract\UnitServiceInterface;
use App\Services\Unit\UnitService;
use App\Services\UnitConversion\Contract\UnitConversionServiceInterface;
use App\Services\UnitConversion\UnitConversionService;
use App\Repositories\UnitConversion\Contract\UnitConversionRepositoryInterface;
use App\Repositories\UnitConversion\UnitConversionRepository;
use App\Repositories\Ingridient\Contract\IngridientRepositoryInterface;
use App\Repositories\Ingridient\IngridientRepository;
use App\Services\Ingridient\Contract\IngridientServiceInterface;
use App\Services\Ingridient\IngridientService;
use App\Repositories\IngridientPurchas\Contract\IngridientPurchaseInterface;
use App\Repositories\IngridientPurchas\IngridientPurchase;
use App\Services\IngridientPurchase\Contract\IngridientPurchaseServiceInterface;
use App\Services\IngridientPurchase\IngridientPurchaseService;
use App\Repositories\Extra\Contract\ExtraRepositoryInterface;
use App\Repositories\Extra\ExtraRepository;
use App\Services\Extra\Contract\ExtraServiceInterface;
use App\Services\Extra\ExtraService;
use App\Repositories\Product\Contract\ProductRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Services\Product\Contract\ProductServiceInterface;
use App\Services\Product\ProductService;
use App\Services\Image\Contract\ImageServiceInterface;
use App\Services\Image\ImageService;
use App\Repositories\Image\Contract\ImageRepositoryInterface;
use App\Repositories\Image\ImageRepository;
use App\Services\Users\Contracts\UserServiceInterface;
use App\Services\Users\UserServices;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, JwtAuthService::class);
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(UserServiceInterface::class, UserServices::class);
        $this->app->bind(AuthRepository::class, EloquentAuthRepository::class);
        $this->app->bind(AuthenticationServiceInterface::class, AuthenticationService::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(CartServiceInterface::class, CartService::class);
        $this->app->bind(TableRepositoryInterface::class, TableRepository::class);
        $this->app->bind(TableServiceInterface::class, TableService::class);
        $this->app->bind(PriceRepositoryInterface::class, PriceRepository::class);
        $this->app->bind(PriceServiceInterface::class, PriceService::class);
        $this->app->bind(AttributeRepositoryInterface::class, AttributeRepository::class);
        $this->app->bind(AttributeServiceInterface::class, AttributeService::class);
        $this->app->bind(AttributeValueRepositoryInterface::class, AttributeValueRepository::class);
        $this->app->bind(AttributeValueServiceInterface::class, AttributeValueService::class);
        $this->app->bind(UnitRepositoryInterface::class, UnitRepository::class);
        $this->app->bind(UnitServiceInterface::class, UnitService::class);
        $this->app->bind(UnitConversionServiceInterface::class, UnitConversionService::class);
        $this->app->bind(UnitConversionRepositoryInterface::class, UnitConversionRepository::class);
        $this->app->bind(IngridientRepositoryInterface::class, IngridientRepository::class);
        $this->app->bind(IngridientServiceInterface::class, IngridientService::class);
        $this->app->bind(IngridientPurchaseInterface::class, IngridientPurchase::class);
        $this->app->bind(IngridientPurchaseServiceInterface::class, IngridientPurchaseService::class);
        $this->app->bind(ExtraRepositoryInterface::class, ExtraRepository::class);
        $this->app->bind(ExtraServiceInterface::class, ExtraService::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ImageServiceInterface::class, ImageService::class);
        $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);

        Relation::enforceMorphMap([
            'product' => \App\Models\Product::class
        ]);

        RateLimiter::for('api', function (Request $request){
            return Limit::perMinute(60)->by($request->ip());
        });

        RateLimiter::for('login' , function(Request $request){
            return Limit::perMinute(5)->by(strtolower($request->input('credential'). '|' .$request->ip()));
        });
    }
}
