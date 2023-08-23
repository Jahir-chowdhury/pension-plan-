    <?php

    use App\Http\Controllers\RoleController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\Admin\ClaimsController;
    use App\Http\Controllers\Admin\CollectionsController;
    use App\Http\Controllers\Admin\ContractController;
    use App\Http\Controllers\Admin\MembersController;
    use App\Http\Controllers\Admin\OrganizationsController;
    use App\Http\Controllers\Admin\PaymentMethodsController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\DashboardController;
    use Illuminate\Support\Facades\Auth;
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

    // Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard.main');

    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
        Route::get('', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('main');
        Route::get('/report', [DashboardController::class, 'search'])->middleware(['auth', 'verified'])->name('report');
        Route::GET('/download/{id}', [DashboardController::class, 'download'])->name('download');
        Route::GET('/download-org/{id}', [DashboardController::class, 'downloadOrg'])->name('download.org');
    });
    Route::group(['middleware' => 'auth'], function () {
        Route::resource('role', RoleController::class);
        Route::resource('user', UserController::class);
        Route::get('user/{id}/change-password', [UserController::class, 'change_password'])->name('user.change.password');
        Route::patch('user/{id}/update-password', [UserController::class, 'password_update'])->name('user.update.password');
        Route::get('user/{id}/status', [UserController::class, 'status'])->name('user.status');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->middleware(['auth', 'verified'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->middleware(['auth', 'verified'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->middleware(['auth', 'verified'])->name('profile.destroy');
    });

    // Organization
    Route::group(['prefix' => 'org', 'as' => 'organization.'], function () {
        Route::GET('search', [OrganizationsController::class, 'search'])->middleware(['auth', 'verified'])->name('search'); //
        Route::GET('create-form', [OrganizationsController::class, 'showOrganizationCreateForm'])->middleware(['auth', 'verified'])->name('create_form');
        Route::POST('create', [OrganizationsController::class, 'createOrganization'])->middleware(['auth', 'verified'])->name('create'); //
        Route::PUT('update', [OrganizationsController::class, 'update'])->name('update');

        //Route::resource('members' , [MemberController::class]);

        Route::GET('contract-show', [ContractController::class, 'index'])->name('contract.index');
        Route::GET('contract-create', [ContractController::class, 'create'])->name('contract.create');
        Route::POST('contract-store', [ContractController::class, 'store'])->name('contract.store');
        Route::GET('download/{id}', [ContractController::class, 'download'])->name('contract.download');

        //Contacts
        Route::GET('contacts', 'OrganizationsController@getAllContacts')->name('contacts');
        Route::POST('create-contact', 'OrganizationsController@createContact')->name('contact.create');
        Route::POST('update-contact', 'OrganizationsController@updateContact')->name('contact.update');

        // Members
        Route::GET('members-show', [MembersController::class, 'index'])->name('members.show');
        Route::get('members-create', [MembersController::class, 'create'])->name('members.create');
        Route::POST('members-store', [MembersController::class, 'store'])->name('members.store');
        Route::PUT('members-update', [MembersController::class, 'update'])->name('members.update');

        Route::match(['GET', 'POST'], 'bulk-upload-field-mapping', [MembersController::class, 'memberBulkUploadFieldmapping'])->name('members.bulkUploadFieldmapping');
        Route::match(['GET', 'POST'], 'bulk-upload-form', [MembersController::class, 'showBulkUploadForm'])->name('members.bulkUploadForm');
        Route::post('bulk-upload', [MembersController::class, 'memberBulkUpload'])->name('members.bulkUpload');
        Route::get('bulk-download', [MembersController::class, 'memberBulkDownload'])->name('members.bulkDownloadForm');
        Route::get('member-export/{id}', [MembersController::class, 'memberExport'])->name('members.export');
    });

    // Collection
    Route::group(['prefix' => 'collection', 'as' => 'collection.'], function () {
        Route::match(['GET', 'POST'], 'make-payment', [CollectionsController::class, 'advise'])->name('advise');
        Route::match(['GET', 'POST'], 'make-report', [CollectionsController::class, 'report'])->name('report');
        Route::match(['GET', 'POST'], 'download-advise', [CollectionsController::class, 'adviseDownload'])->name('advise.download');
        Route::match(['GET', 'POST'], 'eft-return', [CollectionsController::class, 'eftReturn'])->name('eft.return');
        Route::match(['GET', 'POST'], 'add', [CollectionsController::class, 'addCollectionView'])->name('add');
        Route::match(['GET', 'POST'], 'due', [CollectionsController::class, 'dueCollectionView'])->name('due');
        Route::match(['GET', 'POST'], 'history', [CollectionsController::class, 'collectionHistory'])->name('history');
        Route::match(['GET', 'POST'], 'due-death-payment-list', [CollectionsController::class, 'dueDeathPayment'])->name('due.death.payment');
        Route::match(['GET', 'POST'], 'due-planA-payment-list', [CollectionsController::class, 'duePlanAPayment'])->name('due.planA.payment');
        Route::match(['GET', 'POST'], 'total-death-payment-list', [CollectionsController::class, 'totalDeathPayment'])->name('total.death.payment');
        Route::match(['GET', 'POST'], 'total-planA-payment-list', [CollectionsController::class, 'totalPlanAPayment'])->name('total.planA.payment');
        Route::match(['GET', 'POST'], 'approved-EFT-return-list', [CollectionsController::class, 'approvedClaims'])->name('claim.approved');
        Route::match(['GET', 'POST'], 'underprocess-EFT-return-list', [CollectionsController::class, 'underprocess'])->name('eft.underprocess');
        Route::match(['GET', 'POST'], 'claim-payment/{id}', [CollectionsController::class, 'claimPayment'])->name('claim.payment');
        Route::match(['GET', 'POST'], 'claim-payment-store', [CollectionsController::class, 'claimPaymentStore'])->name('claim_payment.store');

        // START :: AJAX
        Route::get('org-payment-details/{id}', [CollectionsController::class, 'ajaxGetOrganizationDetailsForCollectionForm'])
            ->name('collectionOrganizationDetails');
        // END :: AJAX

    });

    // Claim
    Route::group(['prefix' => 'claims', 'as' => 'claims.'], function () {
        Route::get('index', [ClaimsController::class, 'index'])->name('index');
        Route::POST('store', [ClaimsController::class, 'store'])->name('store');
        Route::get('update', [ClaimsController::class, 'update'])->name('update');
        Route::get('document-required-index', [ClaimsController::class, 'docRequiredIndex'])->name('doc_required_index');
        // Route::get('document-process', [ClaimsController::class, 'documentIndex'])->name('doc_index');
        Route::get('process', [ClaimsController::class, 'processIndex'])->name('process');
        Route::get('process-form/{id}', [ClaimsController::class, 'createProcess'])->name('process_create');
        Route::POST('process-store', [ClaimsController::class, 'storeProcess'])->name('process_store');
        Route::get('pending', [ClaimsController::class, 'claimPending'])->name('pending');
        Route::get('rivew', [ClaimsController::class, 'claimRivew'])->name('rivew');
        Route::get('underprocessing', [ClaimsController::class, 'underprocessing'])->name('underprocessing');
        Route::get('document-required', [ClaimsController::class, 'docRequired'])->name('document.required');
        Route::get('eft-return', [ClaimsController::class, 'eftReturn'])->name('eft.return');
        Route::get('eft-return-edit/{id}', [ClaimsController::class, 'eftReturnEdit'])->name('eft.edit');
        Route::get('eft-return-cancel', [ClaimsController::class, 'eftReturnCancel'])->name('eft.cancel');
        Route::get('report', [ClaimsController::class, 'report'])->name('report');
        Route::get('approve/{id}', [ClaimsController::class, 'claimApprove'])->name('approve');
    });

    // Settings
    Route::group(['prefix' => 'settings', 'as' => 'setting.'], function () {
        Route::get('payment-methods_index', [PaymentMethodsController::class, 'index'])->name('payment-methods.index');
        Route::POST('payment-methods_store', [PaymentMethodsController::class, 'store'])->name('payment-methods.store');
        Route::PUT('payment-methods_update', [PaymentMethodsController::class, 'update'])->name('payment-methods.update');
    });

    // User Manage
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::GET('search', 'UsersController@search')->name('search');
        Route::GET('create-form', 'UsersController@showUserCreateForm')->name('create_form');

        Route::POST('create', 'UsersController@createUser')->name('create');
    });

    Auth::routes();
    Route::redirect('/', '/login');
    Route::redirect('/register', '/login');
?>