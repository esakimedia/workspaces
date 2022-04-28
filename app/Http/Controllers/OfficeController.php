<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Http\Resources\OfficeResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OfficeController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $offices = Office::query()
            ->where('approval_status', Office::APPROVAL_APPROVED)
            ->where('hidden', false)
            ->when(
                request('host_id'),
                fn ($builder)
                => $builder->whereUserId(request('host_id'))
            )
            ->when(
                request('user_id'),
                fn (Builder $builder)
                => $builder->whereRelation('reservations', 'user_id', '=', request('user_id'))
            )
            ->latest('id')
            ->paginate(20);

        return OfficeResource::collection(
            $offices
        );
    }
}
