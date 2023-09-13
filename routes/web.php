<?php


use App\Http\Livewire\Admin\AdminAddAttributeComponent;
use App\Http\Livewire\Admin\AdminAddCategoryComponent;
use App\Http\Livewire\Admin\AdminAddCouponsComponent;
use App\Http\Livewire\Admin\AdminAddHomeSliderComponent;
use App\Http\Livewire\Admin\AdminAddProductComponent;
use App\Http\Livewire\Admin\AdminAttributesComponent;
use App\Http\Livewire\Admin\AdminCategoryComponent;
use App\Http\Livewire\Admin\AdminContactComponent;
use App\Http\Livewire\Admin\AdminCouponsComponent;
use App\Http\Livewire\Admin\AdminDashboardComponent;
use App\Http\Livewire\Admin\AdminEditAttributeComponent;
use App\Http\Livewire\Admin\AdminEditCategoryComponent;
use App\Http\Livewire\Admin\AdminEditCouponsComponent;
use App\Http\Livewire\Admin\AdminEditHomeSliderComponent;
use App\Http\Livewire\Admin\AdminEditProductComponent;
use App\Http\Livewire\Admin\AdminHomeCategoryComponent;
use App\Http\Livewire\Admin\AdminHomeSliderComponent;
use App\Http\Livewire\Admin\AdminOrdeDetailsComponent;
use App\Http\Livewire\Admin\AdminOrderComponent;
use App\Http\Livewire\Admin\AdminProuctComponent;
use App\Http\Livewire\Admin\AdminSaleComponent;
use App\Http\Livewire\Admin\AdminSettingComponent;
use App\Http\Livewire\ShopComponent;
use App\Http\Livewire\CartComponent;
use App\Http\Livewire\CategoryComponent;
use App\Http\Livewire\CheckoutComponent;
use App\Http\Livewire\ContactComponent;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\SearchComponent;
use App\Http\Livewire\ThankyouComponent;
use App\Http\Livewire\User\UserChangePasswordComponent;
use App\Http\Livewire\User\UserDashboardComponent;
use App\Http\Livewire\User\UserEditProfileComponent;
use App\Http\Livewire\User\UserOrderComponent;
use App\Http\Livewire\User\UserOrderDetailsComponent;
use App\Http\Livewire\User\UserProfileComponent;
use App\Http\Livewire\User\UserReviewComponent;
use App\Http\Livewire\WishListComponent;
use App\Models\Contact;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',HomeComponent::class);

Route::get('/shop',ShopComponent::class)->name('product.shop');

Route::get('/cart',CartComponent::class)->name('product.cart');

Route::get('/checkout',CheckoutComponent::class)->name('checkout');

Route::get('/product/{slug}',App\Http\Livewire\DetailsComponent::class)->name('product.details');

Route::get('/product-category/{category_slug}/{scategory_slug?}',CategoryComponent::class)->name('product.category');

Route::get('/search',SearchComponent::class)->name('product.search');

Route::get('wishlist',WishListComponent::class)->name('product.wishlist');

Route::get('/thanku-you',ThankyouComponent::class)->name('thankyou');

Route::get('/Contact-us',ContactComponent::class)->name('contact');

//Route::post('/storedata',Controller::class,'addtodata')->name('addc');
Route::post('/projects', [App\Http\Controllers\Controller::class, 'index'])->name('addc');
Route::post('/sortind', [App\Http\Controllers\Controller::class, 'sorting'])->name('sortingproduct');
Route::post('/addwishlist', [App\Http\Controllers\Controller::class, 'addwishlist'])->name('add_wishlist');
Route::post('/removewishlist', [App\Http\Controllers\Controller::class, 'removewishlist'])->name('remove_wishlist');
Route::post('/wish_heart', [App\Http\Controllers\Controller::class, 'heartadd'])->name('wish_heart');

// Route::get('/product/{slug}',DetailsComponent::class)->name('product.details');

Route::middleware(['auth:sanctum','verified'])->group(function () {
   Route::get('/user/dashboard',UserDashboardComponent::class)->name('user.dashboard');
   Route::get('/user/orers',UserOrderComponent::class)->name('user.orders');
   Route::get('/user/orders/{order_id}',UserOrderDetailsComponent::class)->name('user.ordersdetails');
   Route::get('/user/review/{order_item_id}',UserReviewComponent::class)->name('user.review');
   Route::get('/user/Change-password',UserChangePasswordComponent::class)->name('user.changepassword');
   Route::get('/user/Profile',UserProfileComponent::class)->name('user.profile');
   Route::get('/user/Profile/Edit',UserEditProfileComponent::class)->name('user.editprofile');
});

Route::middleware(['auth:sanctum','verified','authadmin'])->group(function () {
   Route::get('/admin/dashboard',AdminDashboardComponent::class)->name('admin.dashboard');
   Route::get('/admin/categories',AdminCategoryComponent::class)->name('admin.categories');
   Route::get('/admin/category/add',AdminAddCategoryComponent::class)->name('admin.addcategory');
   Route::get('/admin/category/edit/{category_slug}/{scategory_slug?}',AdminEditCategoryComponent::class)->name('admin.editcategory');
   Route::get('/admin/products',AdminProuctComponent::class)->name('admin.products');
   Route::get('/admin/products/add',AdminAddProductComponent::class)->name('admin.addproducts');
   Route::get('/admin/products/edit/{product_slug}',AdminEditProductComponent::class)->name('admin.editproducts');


   
   Route::get('/admin/slider',AdminHomeSliderComponent::class)->name('admin.homeslider');
   Route::get('/admin/slider/add',AdminAddHomeSliderComponent::class)->name('admin.addhomeslider');
   Route::get('/admin/slider/edit/{slide_id}',AdminEditHomeSliderComponent::class)->name('admin.edithomeslider');


   Route::get('/admin/home-categories',AdminHomeCategoryComponent::class)->name('admin.homecategories');
   Route::get('/admin/sales',AdminSaleComponent::class)->name('admin.sale');

   Route::get('/admin/coupons',AdminCouponsComponent::class)->name('admin.coupons');
   Route::get('/admin/coupons/add',AdminAddCouponsComponent::class)->name('admin.addcoupons');
   Route::get('/admin/coupons/edit/{coupon_id}',AdminEditCouponsComponent::class)->name('admin.editcoupons');

   Route::get('/admin/orders',AdminOrderComponent::class)->name('admin.orders');
   Route::get('/admin/orders/{order_id}',AdminOrdeDetailsComponent::class)->name('admin.ordersdetails');

   Route::get('/admin/Contact-us',AdminContactComponent::class)->name('admin.contact'); 
   Route::get('/admin/Setting',AdminSettingComponent::class)->name('admin.setting'); 


   Route::get('/admin/attributes',AdminAttributesComponent::class)->name('admin.attributes'); 
   Route::get('/admin/attribute/add',AdminAddAttributeComponent::class)->name('admin.add_attributes'); 
   Route::get('/admin/attribute/edit/{attribute_id}',AdminEditAttributeComponent::class)->name('admin.edit_attributes'); 
   
}); 
