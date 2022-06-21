<?php

namespace App\Repositories;

use App\Rental\Repositories\Contracts\InvoiceInterface;
use App\Rental\Repositories\Contracts\InvoiceItemInterface;
use App\Rental\Repositories\Contracts\JournalInterface;
use App\Rental\Repositories\Contracts\ExpenseInterface;
use App\Models\Payment;
use App\Models\Expense;
use App\Rental\Repositories\Contracts\TransactionInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpenseRepository extends BaseRepository implements ExpenseInterface {

    protected $model, $journalRepository, $transactionRepository, $invoiceItemRepository, $invoiceRepository;

    /**
     * PaymentRepository constructor.
     * @param Payment $model
     * @param JournalInterface $journalInterface
     * @param TransactionInterface $transactionInterface
     * @param InvoiceItemInterface $invoiceItemInterface
     * @param InvoiceInterface $invoiceRepository
     */
    function __construct(Expense $model)
    {
        $this->model = $model;
       
    }
 
 
}
