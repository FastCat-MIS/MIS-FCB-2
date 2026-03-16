<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Actions\Marketing\Promo\CreatePromoAction;
use App\Actions\Marketing\Promo\GetPromoAction;
use App\Actions\Marketing\Promo\GetPromosAction;
use App\Actions\Marketing\Promo\UpdatePromoAction;
use App\Actions\Marketing\Promo\DeletePromoAction;

use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index(GetPromosAction $action)
    {
        return $action->execute();
    }

    public function show($promoId, GetPromoAction $action)
    {
        return $action->execute($promoId);
    }

    public function store(Request $request, CreatePromoAction $action)
    {
        return $action->execute($request->all());
    }

    public function update($promoId, Request $request, UpdatePromoAction $action)
    {
        return $action->execute($promoId, $request->all());
    }

    public function destroy($promoId, DeletePromoAction $action)
    {
        return $action->execute($promoId);
    }
}
