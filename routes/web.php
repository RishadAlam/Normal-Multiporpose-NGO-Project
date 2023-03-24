<?php

use App\Http\Controllers\accounts\AccountsController;
use App\Http\Controllers\accounts\LoanProfileController;
use App\Http\Controllers\accounts\SavingProfileController;
use App\Http\Controllers\AnalyticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\ClosingController;
use App\Http\Controllers\VolumeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Employee\EmployeePermissionController;
use App\Http\Controllers\Withdrawal\WithdrawalController;
use App\Http\Controllers\Collections\CollectionController;
use App\Http\Controllers\Collections\Reports\CollectionReportPrintController;
use App\Http\Controllers\Collections\Reports\PendingCollectionReportController;
use App\Http\Controllers\Collections\Reports\RegularCollectionReportController;
use App\Http\Controllers\summary\CenterSummaryController;
use App\Http\Controllers\summary\LoanTypeSummaryController;
use App\Http\Controllers\summary\SavingTypeSummaryController;
use App\Http\Controllers\summary\VolumeSummaryController;
use App\Http\Controllers\transaction\forms\SavingsToLoanSavingsTransactionController;
use App\Http\Controllers\transaction\forms\LoanSavingsToLoanSavingsTransactionController;
use App\Http\Controllers\transaction\forms\LoanSavingsToSavingsTransactionController;
use App\Http\Controllers\transaction\forms\SavingsToSavingsTransactionController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Withdrawal\Reports\LoanSavingsWithdrawalPendingReportController;
use App\Http\Controllers\Withdrawal\Reports\SavingsWithdrawalPendingReportController;
use App\Models\SavingsProfile;

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


Auth::routes(['verify' => true, 'register' => false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/permission', [App\Http\Controllers\HomeController::class, 'permission'])->name('permission');
Route::POST('/permission', [App\Http\Controllers\HomeController::class, 'store'])->name('registration.create');

// Registration Routes
Route::prefix('/registrations')->group(function () {
    /**
     * Clients Account Registration Routes
     * Protected Routes
     */
    Route::group(['middleware' => ['can:New Client Registration']], function () {
        // Create New Client
        Route::GET('/create-new-client', [RegistrationController::class, 'clientRegistration'])->name('registration.newCustomer');
        Route::POST('/create-new-client/store', [RegistrationController::class, 'clientRegistrationStore'])->name('registration.newCustomer.store');
    });

    // Get Centers / Account Register / Register Information routes
    Route::GET('/create-new-client/get/center/{id}', [RegistrationController::class, 'clientRegistrationGetCenter'])->name('registration.newCustomer.get.center');
    Route::GET('/create-saving-account/get/account/{volID}/{centerID}', [RegistrationController::class, 'savingsRegistrationGetAccount'])->name('registration.newSavings.get.account');
    Route::GET('/create-saving-account/account/info/{id}', [RegistrationController::class, 'savingsRegistrationGetAccountInfo'])->name('registration.newSavings.get.account.info');

    Route::group(['middleware' => ['can:Loan Account Registration']], function () {
        // Create Saving Account
        Route::GET('/create-loan-account', [RegistrationController::class, 'loansRegistration'])->name('registration.newLoans');
        Route::POST('/create-loan-account/account/store', [RegistrationController::class, 'loansRegistrationStore'])->name('registration.newLoans.store');
    });

    Route::group(['middleware' => ['can:Saving Account Registration']], function () {
        // Create Saving Account
        Route::GET('/create-saving-account', [RegistrationController::class, 'savingsRegistration'])->name('registration.newSavings');
        Route::POST('/create-saving-account/account/store', [RegistrationController::class, 'savingsRegistrationStore'])->name('registration.newSavings.store');
    });

    /**
     * Volume Center Type Registration
     * Protected Routes
     */
    Route::POST('/volume/create', [RegistrationController::class, 'volumeCreate'])->name('registration.volume.create')->middleware(['can:Volume Create']);
    Route::POST('/center/create', [RegistrationController::class, 'centerCreate'])->name('registration.center.create')->middleware(['can:Center Create']);
    Route::POST('/type/create', [RegistrationController::class, 'typeCreate'])->name('registration.type.create')->middleware(['can:Type Create']);

    /**
     * Employe Registration Routes
     * Protected Routes
     */
    Route::group(['middleware' => ['can:Employee Registration']], function () {
        Route::GET('/create-employee', [RegistrationController::class, 'employeeRegistration'])->name('registration.employee');
        Route::POST('/create-employee', [RegistrationController::class, 'employeeCreate'])->name('registration.employee.create');
    });
});

// Collection Routes
Route::prefix('/collection')->group(function () {

    /**
     * Savings Account Load
     * Loan Accounts Load
     */
    Route::POST('/saving/accounts/load', [CollectionController::class, 'savingsAccountsLoad'])->name('collectionForm.savingsForm.accLoad');
    Route::POST('/loans/accounts/load', [CollectionController::class, 'loansAccountsLoad'])->name('collectionForm.loansForm.accLoad');

    /**
     * Saving Form Routes
     * Protected Routes
     */
    Route::group(['middleware' => ['can:Savings Collection'], 'prefix' => '/saving'], function () {
        Route::GET('/', [CollectionController::class, 'showSavingsCollectionForm'])->name('collectionForm.savingsForm');
        Route::POST('/accounts/info/load', [CollectionController::class, 'savingsAccountsInfoLoad'])->name('collectionForm.savingsForm.accInfoLoad');
        Route::POST('/store', [CollectionController::class, 'savingsCollectionStore'])->name('collectionForm.savingsForm.collection.store');
    });

    /**
     * Loan Form Routes
     * Protected Route
     */
    Route::group(['middleware' => ['can:Loans Collection'], 'prefix' => '/loan'], function () {
        Route::GET('/', [CollectionController::class, 'showLoanCollectionForm'])->name('collectionForm.loansForm');
        Route::POST('/account/info/load', [CollectionController::class, 'loansAccountsInfoLoad'])->name('collectionForm.loansForm.accInfoLoad');
        Route::POST('/store', [CollectionController::class, 'loansCollectionStore'])->name('collectionForm.loansForm.collection.store');
    });

    /**
     * Collection Report Routes
     */
    Route::prefix('/reports')->group(function () {

        // Regular Collections
        Route::group(['middleware' => ['can:Regular Collections'], 'prefix' => '/regular-collection'], function () {
            Route::GET('/', [RegularCollectionReportController::class, 'showRegularCollectionReport'])->name('collectionsReport.regularCollection');

            // Savings
            Route::prefix('/saving/volume')->group(function () {
                // Savings Report Routes
                Route::GET('/{type_id}', [RegularCollectionReportController::class, 'showRegularCollectionReportSavingsVolumes'])->name('collectionsReport.regularCollection.savings.volumes');
                Route::GET('/center/report/{type_id}/{volume_id}', [RegularCollectionReportController::class, 'showRegularCollectionReportSavingsReports'])->name('collectionsReport.regularCollection.savings.reports');
                Route::GET('/center/report/print/{type_id}/{volume_id}/{officer}', [CollectionReportPrintController::class, 'regularSavingsPrint'])->name('collectionsReport.regularCollection.savings.reports.print');

                // Collection CRUD Operation
                Route::DELETE('/center/report/collection/delete', [RegularCollectionReportController::class, 'deleteSavingCollection'])->name('collectionsReport.regularCollection.savings.reports.delete')->middleware(['can:Collection Delete']);
                Route::POST('/center/report/collection/edit', [RegularCollectionReportController::class, 'editSavingCollection'])->name('collectionsReport.regularCollection.savings.reports.edit')->middleware(['can:Collection Edit']);
                Route::POST('/center/report/collection/update', [RegularCollectionReportController::class, 'updateSavingCollection'])->name('collectionsReport.regularCollection.savings.reports.update')->middleware(['can:Collection Edit']);
                Route::POST('/center/report/collection/approve', [RegularCollectionReportController::class, 'approveSavingCollection'])->name('collectionsReport.regularCollection.savings.reports.approve')->middleware(['can:Collection Edit']);
            });

            // Loans
            Route::prefix('/loan/volume')->group(function () {
                // Loans Report Routes
                Route::GET('/{type_id}', [RegularCollectionReportController::class, 'showRegularCollectionReportLoansVolumes'])->name('collectionsReport.regularCollection.loans.volumes');
                Route::GET('/center/report/{type_id}/{volume_id}', [RegularCollectionReportController::class, 'showRegularCollectionReportLoansReports'])->name('collectionsReport.regularCollection.loans.reports');
                Route::GET('/center/report/print/{type_id}/{volume_id}/{officer}', [CollectionReportPrintController::class, 'regularLoanPrint'])->name('collectionsReport.regularCollection.loans.reports.print');

                // Collection CRUD Operation
                Route::DELETE('/center/report/collection/delete', [RegularCollectionReportController::class, 'deleteLoanCollection'])->name('collectionsReport.regularCollection.loans.reports.delete')->middleware(['can:Collection Delete']);
                Route::POST('/center/report/collection/edit', [RegularCollectionReportController::class, 'editLoanCollection'])->name('collectionsReport.regularCollection.loans.reports.edit')->middleware(['can:Collection Edit']);
                Route::POST('/center/report/collection/update', [RegularCollectionReportController::class, 'updateLoansCollection'])->name('collectionsReport.regularCollection.loans.reports.update')->middleware(['can:Collection Edit']);
                Route::POST('/center/report/collection/approve', [RegularCollectionReportController::class, 'approveLoanCollection'])->name('collectionsReport.regularCollection.loans.reports.approve')->middleware(['can:Collection Edit']);
            });
        });

        // Pending Collections
        Route::group(['middleware' => ['can:Pending Collections'], 'prefix' => '/pending-collection'], function () {
            Route::GET('/', [PendingCollectionReportController::class, 'showPendingCollectionReport'])->name('collectionsReport.pendingCollection');

            // Savings
            Route::prefix('/saving/volume')->group(function () {
                // Savings Report Routes
                Route::GET('/{type_id}', [PendingCollectionReportController::class, 'showPendingCollectionReportSavingsVolumes'])->name('collectionsReport.pendingCollection.savings.volumes');
                Route::GET('/center/report/{type_id}/{volume_id}', [PendingCollectionReportController::class, 'showPendingCollectionReportSavingsReports'])->name('collectionsReport.pendingCollection.savings.reports');
                Route::GET('/center/report/print/{type_id}/{volume_id}/{officer}/{start_date}/{end_date}', [CollectionReportPrintController::class, 'pendingSavingsPrint'])->name('collectionsReport.pendingCollection.savings.reports.print');

                // // Collection CRUD Operation
                Route::DELETE('/center/report/collection/delete', [PendingCollectionReportController::class, 'deleteSavingCollection'])->name('collectionsReport.pendingCollection.savings.reports.delete')->middleware(['can:Collection Delete']);
                Route::POST('/center/report/collection/edit', [PendingCollectionReportController::class, 'editSavingCollection'])->name('collectionsReport.pendingCollection.savings.reports.edit')->middleware(['can:Collection Edit']);
                Route::POST('/center/report/collection/update', [PendingCollectionReportController::class, 'updateSavingCollection'])->name('collectionsReport.pendingCollection.savings.reports.update')->middleware(['can:Collection Edit']);
                Route::POST('/center/report/collection/approve', [PendingCollectionReportController::class, 'approveSavingCollection'])->name('collectionsReport.pendingCollection.savings.reports.approve')->middleware(['can:Collection Edit']);
            });

            // Loans
            Route::prefix('/loan/volume')->group(function () {
                // Loans Report Routes
                Route::GET('/{type_id}', [PendingCollectionReportController::class, 'showPendingCollectionReportLoansVolumes'])->name('collectionsReport.pendingCollection.loans.volumes');
                Route::GET('/center/report/{type_id}/{volume_id}', [PendingCollectionReportController::class, 'showPendingCollectionReportLoansReports'])->name('collectionsReport.pendingCollection.loans.reports');
                Route::GET('/center/report/print/{type_id}/{volume_id}/{officer}/{start_date}/{end_date}', [CollectionReportPrintController::class, 'pendingLoanPrint'])->name('collectionsReport.pendingCollection.loans.reports.print');

                // Collection CRUD Operation
                Route::DELETE('/center/report/collection/delete', [PendingCollectionReportController::class, 'deleteLoanCollection'])->name('collectionsReport.pendingCollection.loans.reports.delete')->middleware(['can:Collection Delete']);
                Route::POST('/center/report/collection/edit', [PendingCollectionReportController::class, 'editLoanCollection'])->name('collectionsReport.pendingCollection.loans.reports.edit')->middleware(['can:Collection Edit']);
                Route::POST('/center/report/collection/update', [PendingCollectionReportController::class, 'updateLoansCollection'])->name('collectionsReport.pendingCollection.loans.reports.update')->middleware(['can:Collection Edit']);
                Route::POST('/center/report/collection/approve', [PendingCollectionReportController::class, 'approveLoanCollection'])->name('collectionsReport.pendingCollection.loans.reports.approve')->middleware(['can:Collection Edit']);
            });
        });
    });
});

// Withdrawal Routes
Route::prefix('/withdrawal')->group(function () {
    /**
     * Regular Savings Withdrawal
     * Protected Route
     */
    Route::group(['middleware' => ['can:Savings Withdrawal'], 'prefix' => '/regular-savings'], function () {
        Route::GET('/', [WithdrawalController::class, 'showSavingsWithdrawalForm'])->name('withdrawalForm.savingsForm');
        Route::POST('/accounts/info/load', [WithdrawalController::class, 'savingsAccountsInfoLoad'])->name('withdrawalForm.savingsForm.accInfoLoad');
        Route::POST('/accounts/store', [WithdrawalController::class, 'savingsWithdrawalStore'])->name('withdrawalForm.savingsForm.store');
    });

    /**
     * Loan Savings Withdrawal
     * Protected Route
     */
    Route::group(['middleware' => ['can:Loan Savings Withdrawal'], 'prefix' => '/loan-savings'], function () {
        Route::GET('/', [WithdrawalController::class, 'showLoanSavingsWithdrawalForm'])->name('withdrawalForm.loanSavingsForm');
        Route::POST('/accounts/info/load', [WithdrawalController::class, 'loanSavingsAccountsInfoLoad'])->name('withdrawalForm.loanSavingsForm.accInfoLoad');
        Route::POST('/accounts/store', [WithdrawalController::class, 'loanSavingsWithdrawalStore'])->name('withdrawalForm.loanSavingsForm.store');
    });

    // Pending Withdrawal Reports
    Route::prefix('/pending-report')->group(function () {

        /*
         * Saving Withdrawal Reports
         * Protected Route
         */
        Route::group(['middleware' => 'can:Regular Savings Withdrawal Report', 'prefix' => '/savings'], function () {
            Route::GET('/', [SavingsWithdrawalPendingReportController::class, 'index'])->name('withdrawalReports.savings');
            Route::GET('/report/{type_id}', [SavingsWithdrawalPendingReportController::class, 'report'])->name('withdrawalReports.savings.report');
            Route::DELETE('/report/delete', [SavingsWithdrawalPendingReportController::class, 'delete'])->name('withdrawalReports.savings.report.delete')->middleware(['can:Withdrawal Delete']);
            Route::POST('/report/edit', [SavingsWithdrawalPendingReportController::class, 'edit'])->name('withdrawalReports.savings.report.edit')->middleware(['can:Withdrawal Edit']);
            Route::POST('/report/update', [SavingsWithdrawalPendingReportController::class, 'update'])->name('withdrawalReports.savings.report.update')->middleware(['can:Withdrawal Edit']);
            Route::PUT('/report/approve', [SavingsWithdrawalPendingReportController::class, 'approve'])->name('withdrawalReports.savings.report.approve')->middleware(['can:Withdrawal Approval']);
        });

        /*
         * Loan Saving Withdrawal Reports
         * Protected Route
         */
        Route::group(['middleware' => 'can:Loan Savings Withdrawal Report', 'prefix' => '/loan-savings'], function () {
            Route::GET('/', [LoanSavingsWithdrawalPendingReportController::class, 'index'])->name('withdrawalReports.loanSavings');
            Route::GET('/report/{type_id}', [LoanSavingsWithdrawalPendingReportController::class, 'report'])->name('withdrawalReports.loanSavings.report');
            Route::DELETE('/report/delete', [LoanSavingsWithdrawalPendingReportController::class, 'delete'])->name('withdrawalReports.loanSavings.report.delete')->middleware(['can:Withdrawal Delete']);
            Route::POST('/report/edit', [LoanSavingsWithdrawalPendingReportController::class, 'edit'])->name('withdrawalReports.loanSavings.report.edit')->middleware(['can:Withdrawal Edit']);
            Route::POST('/report/update', [LoanSavingsWithdrawalPendingReportController::class, 'update'])->name('withdrawalReports.loanSavings.report.update')->middleware(['can:Withdrawal Edit']);
            Route::PUT('/report/approve', [LoanSavingsWithdrawalPendingReportController::class, 'approve'])->name('withdrawalReports.loanSavings.report.approve')->middleware(['can:Withdrawal Approval']);
        });
    });
});

// Transaction Routes
Route::prefix('/transaction')->group(function () {

    // Savings to Savings Transaction
    Route::group(['prefix' => '/savings-to-savings'], function () {

        // Transaction Form Protected Routes
        Route::group(['middleware' => 'can:Savings to Savings'], function () {
            Route::GET('/', [SavingsToSavingsTransactionController::class, 'index'])->name('transactionForms.SavingstoSavings');
            Route::POST('/', [SavingsToSavingsTransactionController::class, 'store'])->name('transactionForms.SavingstoSavings.store');
        });

        // Transaction Report Protected Routes
        Route::group(['middleware' => 'can:Savings to Savings Report', 'prefix' => '/report'], function () {
            Route::GET('/', [SavingsToSavingsTransactionController::class, 'report'])->name('transactionReports.SavingstoSavings');
            Route::DELETE('/destroy/{id}', [SavingsToSavingsTransactionController::class, 'destroy'])->name('transactionReports.SavingstoSavings.destroy')->middleware(['can:Transaction Delete']);
            Route::POST('/edit/{id}', [SavingsToSavingsTransactionController::class, 'edit'])->name('transactionReports.SavingstoSavings.edit')->middleware(['can:Transaction Edit']);
            Route::PUT('/update/{id}', [SavingsToSavingsTransactionController::class, 'update'])->name('transactionReports.SavingstoSavings.update')->middleware(['can:Transaction Edit']);
            Route::POST('/approve', [SavingsToSavingsTransactionController::class, 'approve'])->name('transactionReports.SavingstoSavings.approve')->middleware(['can:Transaction Approval']);
        });
    });

    // Savings to Loans Savings Transaction
    Route::group(['prefix' => '/savings-to-loan-savings'], function () {

        // Transaction Form Protected Routes
        Route::group(['middleware' => 'can:Savings to Loan Savings'], function () {
            Route::GET('/', [SavingsToLoanSavingsTransactionController::class, 'index'])->name('transactionForms.SavingstoLoans');
            Route::POST('/', [SavingsToLoanSavingsTransactionController::class, 'store'])->name('transactionForms.SavingstoLoans.store');
        });

        // Transaction Report Protected Routes
        Route::group(['middleware' => 'can:Savings to Loan Savings Report', 'prefix' => '/report'], function () {
            Route::GET('/', [SavingsToLoanSavingsTransactionController::class, 'report'])->name('transactionReports.SavingstoLoans');
            Route::DELETE('/destroy/{id}', [SavingsToLoanSavingsTransactionController::class, 'destroy'])->name('transactionReports.SavingstoLoans.destroy')->middleware(['can:Transaction Delete']);
            Route::POST('/edit/{id}', [SavingsToLoanSavingsTransactionController::class, 'edit'])->name('transactionReports.SavingstoLoans.edit')->middleware(['can:Transaction Edit']);
            Route::PUT('/update/{id}', [SavingsToLoanSavingsTransactionController::class, 'update'])->name('transactionReports.SavingstoLoans.update')->middleware(['can:Transaction Edit']);
            Route::POST('/approve', [SavingsToLoanSavingsTransactionController::class, 'approve'])->name('transactionReports.SavingstoLoans.approve')->middleware(['can:Transaction Approval']);
        });
    });

    // Loan Loan Savings to Loan Savings Transaction
    Route::group(['prefix' => '/loan-savings-to-loan-savings'], function () {

        // Transaction Form Protected Routes
        Route::group(['middleware' => 'can:Loan Savings to Loan Savings'], function () {
            Route::GET('/', [LoanSavingsToLoanSavingsTransactionController::class, 'index'])->name('transactionForms.loanSavingstoLoanSavings');
            Route::POST('/', [LoanSavingsToLoanSavingsTransactionController::class, 'store'])->name('transactionForms.loanSavingstoLoanSavings.store');
        });

        // Transaction Report Protected Routes
        Route::group(['middleware' => 'can:Loan Savings to Loan Savings Report', 'prefix' => '/report'], function () {
            Route::GET('/', [LoanSavingsToLoanSavingsTransactionController::class, 'report'])->name('transactionReports.loanSavingstoLoanSavings');
            Route::DELETE('/destroy/{id}', [LoanSavingsToLoanSavingsTransactionController::class, 'destroy'])->name('transactionReports.loanSavingstoLoanSavings.destroy')->middleware(['can:Transaction Delete']);
            Route::POST('/edit/{id}', [LoanSavingsToLoanSavingsTransactionController::class, 'edit'])->name('transactionReports.loanSavingstoLoanSavings.edit')->middleware(['can:Transaction Edit']);
            Route::PUT('/update/{id}', [LoanSavingsToLoanSavingsTransactionController::class, 'update'])->name('transactionReports.loanSavingstoLoanSavings.update')->middleware(['can:Transaction Edit']);
            Route::POST('/approve', [LoanSavingsToLoanSavingsTransactionController::class, 'approve'])->name('transactionReports.loanSavingstoLoanSavings.approve')->middleware(['can:Transaction Approval']);
        });
    });

    // Loan Loan Savings to Savings Transaction
    Route::group(['prefix' => '/loan-savings-to-savings'], function () {

        // Transaction Form Protected Routes
        Route::group(['middleware' => 'can:Loan Savings to Savings'], function () {
            Route::GET('/', [LoanSavingsToSavingsTransactionController::class, 'index'])->name('transactionForms.loanSavingstoSavings');
            Route::POST('/', [LoanSavingsToSavingsTransactionController::class, 'store'])->name('transactionForms.loanSavingstoSavings.store');
        });

        // Transaction Report Protected Routes
        Route::group(['middleware' => 'can:Loan Savings to Savings Report', 'prefix' => '/report'], function () {
            Route::GET('/', [LoanSavingsToSavingsTransactionController::class, 'report'])->name('transactionReports.loanSavingstoSavings');
            Route::DELETE('/destroy/{id}', [LoanSavingsToSavingsTransactionController::class, 'destroy'])->name('transactionReports.loanSavingstoSavings.destroy')->middleware(['can:Transaction Delete']);
            Route::POST('/edit/{id}', [LoanSavingsToSavingsTransactionController::class, 'edit'])->name('transactionReports.loanSavingstoSavings.edit')->middleware(['can:Transaction Edit']);
            Route::PUT('/update/{id}', [LoanSavingsToSavingsTransactionController::class, 'update'])->name('transactionReports.loanSavingstoSavings.update')->middleware(['can:Transaction Edit']);
            Route::POST('/approve', [LoanSavingsToSavingsTransactionController::class, 'approve'])->name('transactionReports.loanSavingstoSavings.approve')->middleware(['can:Transaction Approval']);
        });
    });
});

// Closings Forms
Route::prefix('/closing-form')->group(function () {
    Route::middleware('can:Saving Account Closing')->group(function () {
        Route::GET('/saving', [ClosingController::class, 'savingsFormShown'])->name('closing.Savings');
        Route::POST('/saving', [ClosingController::class, 'savingsClosing'])->name('closing.Savings.closing');
    });

    Route::middleware('can:Loan Account Closing')->group(function () {
        Route::GET('/loan', [ClosingController::class, 'loanFormShown'])->name('closing.Loan');
        Route::POST('/loan', [ClosingController::class, 'loanClosing'])->name('closing.Loan.closing');
    });
});

// Monthly Collections Summary Routes
Route::prefix('/summary')->group(function () {
    // Volume Summary Routes
    Route::prefix('/volume-analysis/{name}')->group(function () {
        Route::GET('/{id}', [VolumeSummaryController::class, 'index'])->name('volumeSummary');
        Route::GET('/active-savings-accounts/{id}', [VolumeSummaryController::class, 'activeSavingsAccounts'])->name('volumeSummary.activeSavingsAccounts');
        Route::GET('/deactive-savings-accounts/{id}', [VolumeSummaryController::class, 'deactiveSavingsAccounts'])->name('volumeSummary.deactiveSavingsAccounts');
        Route::GET('/active-loan-accounts/{id}', [VolumeSummaryController::class, 'activeloanAccounts'])->name('volumeSummary.activeloanAccounts');
        Route::GET('/deactive-loan-accounts/{id}', [VolumeSummaryController::class, 'deactiveloanAccounts'])->name('volumeSummary.deactiveloanAccounts');
    });

    // Center Summary Routes
    Route::prefix('/center-analysis/{name}')->group(function () {
        Route::GET('/{id}', [CenterSummaryController::class, 'index'])->name('centerSummary');
        Route::GET('/active-savings-accounts/{id}', [CenterSummaryController::class, 'activeSavingsAccounts'])->name('centerSummary.activeSavingsAccounts');
        Route::GET('/deactive-savings-accounts/{id}', [CenterSummaryController::class, 'deactiveSavingsAccounts'])->name('centerSummary.deactiveSavingsAccounts');
        Route::GET('/active-loan-accounts/{id}', [CenterSummaryController::class, 'activeloanAccounts'])->name('centerSummary.activeloanAccounts');
        Route::GET('/deactive-loan-accounts/{id}', [CenterSummaryController::class, 'deactiveloanAccounts'])->name('centerSummary.deactiveloanAccounts');
    });

    // Saving Type Summary Routes
    Route::prefix('/savings-type-analysis/{name}')->group(function () {
        Route::GET('/{id}', [SavingTypeSummaryController::class, 'index'])->name('savingsTypeSummary');
        Route::GET('/active-savings-accounts/{id}', [SavingTypeSummaryController::class, 'activeSavingsAccounts'])->name('savingsTypeSummary.activeSavingsAccounts');
        Route::GET('/active-savings-accounts/print/{id}', [CollectionReportPrintController::class, 'activeSavingsAccountsPrint'])->name('savingsTypeSummary.activeSavingsAccounts.print');
        Route::GET('/deactive-savings-accounts/{id}', [SavingTypeSummaryController::class, 'deactiveSavingsAccounts'])->name('savingsTypeSummary.deactiveSavingsAccounts');
    });

    // loan Type Summary Routes
    Route::prefix('/loan-type-analysis/{name}')->group(function () {
        Route::GET('/{id}', [LoanTypeSummaryController::class, 'index'])->name('loanSavingsTypeSummary');
        Route::GET('/active-loan-accounts/{id}', [LoanTypeSummaryController::class, 'activeloanAccounts'])->name('loanSavingsTypeSummary.activeloanAccounts');
        Route::GET('/active-loan-accounts/print/{id}', [CollectionReportPrintController::class, 'activeloanAccountsPrint'])->name('loanSavingsTypeSummary.activeloanAccounts.print');
        Route::GET('/deactive-loan-accounts/{id}', [LoanTypeSummaryController::class, 'deactiveloanAccounts'])->name('loanSavingsTypeSummary.deactiveloanAccounts');
    });
});

// Accounts Routes
Route::prefix('/accounts')->group(function () {
    Route::GET('/{name}/{id}', [AccountsController::class, 'index'])->name('accounts');
    // Live Search
    Route::GET('/search', [AccountsController::class, 'search'])->name('accounts.search');
    Route::POST('/live-search', [AccountsController::class, 'liveSearch'])->name('accounts.search.live');

    // Register Edit update
    Route::group(['middleware' => 'can:Client Register Edit'], function () {
        Route::GET('/register/edit/{name}/{id}', [AccountsController::class, 'registerEdit'])->name('accounts.register.edit');
        Route::PUT('/register/update/{id}', [AccountsController::class, 'registerUpdate'])->name('accounts.register.update');
        Route::PUT('/register/credentials/update/{id}', [AccountsController::class, 'registerCredentialsUpdate'])->name('accounts.register.credentials.update');
    });

    // Active Savings Account Edit Update
    Route::group(['middleware' => 'can:Client Saving Account Edit'], function () {
        Route::GET('/active-savings-account/edit/{name}/{id}', [AccountsController::class, 'activeSavingsEdit'])->name('accounts.activeSavings.edit');
        Route::PUT('/active-savings-account/update/{id}', [AccountsController::class, 'activeSavingsUpdate'])->name('accounts.activeSavings.update');
        Route::PUT('/active-savings-account/nominee/update/{id}', [AccountsController::class, 'activeSavingsNomineeUpdate'])->name('accounts.activeSavingsNominee.update');
    });

    // Active Loan Account Edit Update
    Route::group(['middleware' => 'can:Client Loan Account Edit'], function () {
        Route::GET('/active-loan-account/edit/{name}/{id}', [AccountsController::class, 'activeLoansEdit'])->name('accounts.activeLoans.edit');
        Route::PUT('/active-loan-account/update/{id}', [AccountsController::class, 'activeLoansUpdate'])->name('accounts.activeLoans.update');
        Route::PUT('/active-loan-account/guarantor/update/{id}', [AccountsController::class, 'activeLoansGuarantorUpdate'])->name('accounts.activeLoansGuarantor.update');
    });

    // Savings Profile
    Route::GET('/saving-profile/{name}/{id}', [SavingProfileController::class, 'index'])->name('accounts.savingProfile');
    Route::POST('/saving-profile/edit', [SavingProfileController::class, 'edit'])->name('accounts.savingProfile.edit')->middleware(['can:Account Collection Edit']);
    Route::PUT('/saving-profile/update/{id}/{saving_id}', [SavingProfileController::class, 'update'])->name('accounts.savingProfile.update')->middleware(['can:Account Collection Edit']);
    Route::DELETE('/saving-profile/delete/{id}', [SavingProfileController::class, 'destroy'])->name('accounts.savingProfile.delete')->middleware(['can:Account Collection Delete']);
    Route::POST('/saving-profile/check/{id}', [SavingProfileController::class, 'accCheck'])->name('accounts.savingProfile.check')->middleware(['can:Check Account']);

    // Loan Profile
    Route::GET('/loan-profile/{name}/{id}', [LoanProfileController::class, 'index'])->name('accounts.loanProfile');
    Route::POST('/loan-profile/edit', [LoanProfileController::class, 'edit'])->name('accounts.loanProfile.edit')->middleware(['can:Account Collection Edit']);
    Route::PUT('/loan-profile/update/{id}/{loan_id}', [LoanProfileController::class, 'update'])->name('accounts.loanProfile.update')->middleware(['can:Account Collection Edit']);
    Route::DELETE('/loan-profile/delete/{id}', [LoanProfileController::class, 'destroy'])->name('accounts.loanProfile.delete')->middleware(['can:Account Collection Delete']);
    Route::POST('/loan-profile/check/{id}', [LoanProfileController::class, 'accCheck'])->name('accounts.loanProfile.check')->middleware(['can:Check Account']);
});

// Analytics Routes
Route::group(['middleware' => 'can:Analytics View', 'prefix' => 'analytics'], function () {
    Route::GET('/', [AnalyticsController::class, 'index'])->name('analytics');
});

// Volume Routes
Route::prefix('/volume')->group(function () {
    Route::GET('/', [VolumeController::class, 'index'])->name('volume')->middleware(['can:Volume View']);
    Route::GET('/status/switch/{id}', [VolumeController::class, 'statusSwitch'])->name('volume.status.switch')->middleware(['can:Volume Status Edit']);

    // Protected Routes
    Route::group(['middleware' => ['can:Volume Edit']], function () {
        Route::GET('/edit/{id}', [VolumeController::class, 'edit'])->name('volume.edit');
        Route::PUT('/update', [VolumeController::class, 'update'])->name('volume.update');
    });
});

// Center Routes
Route::prefix('/center')->group(function () {
    Route::GET('/', [CenterController::class, 'index'])->name('center')->middleware(['can:Center View']);
    Route::GET('/status/switch/{id}', [CenterController::class, 'statusSwitch'])->name('center.status.switch')->middleware(['can:Center Status Edit']);

    // Protected Routes
    Route::group(['middleware' => ['can:Center Edit']], function () {
        Route::GET('/edit/{id}', [CenterController::class, 'edit'])->name('center.edit');
        Route::PUT('/update', [CenterController::class, 'update'])->name('center.update');
    });
});

// Type Routes
Route::prefix('/type')->group(function () {
    Route::GET('/', [TypeController::class, 'index'])->name('type')->middleware(['can:Type View']);
    Route::GET('/status/switch/{id}', [TypeController::class, 'statusSwitch'])->name('type.status.switch')->middleware(['can:Type Status Edit']);

    // Protected Routes
    Route::group(['middleware' => ['can:Type Edit']], function () {
        Route::GET('/edit/{id}', [TypeController::class, 'edit'])->name('type.edit');
        Route::PUT('/update', [TypeController::class, 'update'])->name('type.update');
    });
});

// Employee Routes
Route::prefix('/employee')->group(function () {
    Route::GET('/', [EmployeeController::class, 'index'])->name('employee')->middleware(['can:Employee View']);
    Route::GET('/status/switch/{id}', [EmployeeController::class, 'statusSwitch'])->name('employee.status.switch')->middleware(['can:Employee Status Edit']);

    // Protected Routes
    Route::group(['middleware' => ['can:Employee Edit']], function () {
        Route::GET('/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::PUT('/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
    });

    /**
     * Employee Permission Routes
     * Protected Routes
     */
    Route::group(['middleware' => ['can:Employee Permissions']], function () {
        Route::GET('/permissions', [EmployeePermissionController::class, 'permissions'])->name('employee.permissions');
        Route::PUT('/permissions/update/{id}', [EmployeePermissionController::class, 'PermissionUpdate'])->name('employee.permissions.update');
    });
});

// User Profile
Route::prefix('/profile')->group(function () {
    Route::GET('/', [UserProfileController::class, 'index'])->name('userProfile');
    Route::GET('/edit', [UserProfileController::class, 'edit'])->name('userProfile.edit');
    Route::PUT('/update', [UserProfileController::class, 'update'])->name('userProfile.update');
    Route::POST('/change-password', [UserProfileController::class, 'passwordChenge'])->name('userProfile.passwordChenge');
});

/**
 * Settings Routes
 * Protected Routes
 */
Route::group(['middleware' => ['can:Settings']], function () {
    Route::prefix('/settings')->group(function () {
        Route::GET('/', [SettingController::class, 'index'])->name(('settings'));
        Route::PUT('/update', [SettingController::class, 'update'])->name(('settings.update'));
    });
});
