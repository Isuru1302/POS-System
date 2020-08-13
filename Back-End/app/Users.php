<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    //
    /**
     * @var mixed
     */
    private $name;
    /**
     * @var mixed
     */
    private $userName;
    /**
     * @var mixed|string
     */
    private $password;
}
