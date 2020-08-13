<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lend extends Model
{
    //
    /**
     * @var mixed
     */
    private $invoiceId;
    /**
     * @var mixed
     */
    private $remaining;
    /**
     * @var mixed
     */
    private $paid;
    /**
     * @var mixed
     */
    private $total;
    /**
     * @var mixed
     */
    private $NIC;
    /**
     * @var mixed
     */
    private $fullName;
}
