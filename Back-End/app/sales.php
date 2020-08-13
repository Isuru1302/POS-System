<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sales extends Model
{
    //
    /**
     * @var mixed
     */
    private $customerName;
    /**
     * @var mixed
     */
    private $paidAmount;
    /**
     * @var mixed
     */
    private $soldBy;
    /**
     * @var mixed
     */
    private $invoiceId;
}
