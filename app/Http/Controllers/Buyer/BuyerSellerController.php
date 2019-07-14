<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerSellerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $this->allowedAdminAction();
       $sellers = $buyer->transactions()
                ->with('product.user')
                ->get()
                ->pluck('product.user')
                ->unique('id')
                ->values();

        return $this->showAll($sellers);
    }
}
