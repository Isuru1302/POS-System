<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class items extends Model
{

    /**
     * @var mixed
     */
    private $itemName;
    /**
     * @var mixed
     */
    private $itemCode;
    /**
     * @var mixed|string
     */
    private $itemImage;
    /**
     * @var mixed
     */
    private $itemPrice;
    /**
     * @var mixed
     */
    private $itemWarranty;
    /**
     * @var mixed|string
     */
    private $itemBarcode;
    /**
     * @var mixed
     */
    private $itemCategory;
    /**
     * @var int|mixed
     */
    private $itemQty;
    /**
     * @var int|mixed
     */
    private $itemStatus;
    /**
     * @var mixed
     */
    private $itemDescription;
}
