<?php

namespace App\Models\Rules;

use App\Models\Rules\BaseRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class SocketRule extends BaseRule implements FilterRule
{
    public function appliesTo(string $category): bool
    {
        return in_array($category, ['cpu', 'motherboard', 'cpu-cooler']);
    }

    public function apply(Builder $query, string $category): void
    {
        match ($category) {
            'cpu'         => $this->filterCpu($query),
            'motherboard' => $this->filterMotherboard($query),
            'cpu-cooler'  => $this->filterCooler($query),
        };
    }

    private function filterCpu(Builder $query): void
    {
        if ($this->build->hasItem('motherboard')) {
            $query->where('socket', $this->build->getField('motherboard', 'socket'));
            return;
        }
        if ($this->build->hasItem('cpu-cooler')) {
            $sockets = $this->build->getField('cpu-cooler', 'socket');
            $query->whereIn('socket', $sockets);
        }
    }

    private function filterMotherboard(Builder $query): void
    {
        if ($this->build->hasItem('cpu')) {
            $query->where('socket', $this->build->getField('cpu', 'socket'));
            return;
        }
        if ($this->build->hasItem('cpu-cooler')) {
            $sockets = $this->build->getField('cpu-cooler', 'socket');
            $query->whereIn('socket', $sockets);
        }
    }

    private function filterCooler(Builder $query): void
    {
        // collect socket from cpu or motherboard, whichever is selected
        $socket = null;
        if ($this->build->hasItem('cpu')) {
            $socket = $this->build->getField('cpu', 'socket');
        } elseif ($this->build->hasItem('motherboard')) {
            $socket = $this->build->getField('motherboard', 'socket');
        }

        if (!$socket) return;

        $query->whereExists(function ($sub) use ($socket) {
            $sub->select(DB::raw(1))
                ->from('cooler_sockets')
                ->whereColumn('cooler_sockets.cooler_id', 'cpu_cooler_specs.product_id')
                ->where('cooler_sockets.socket', $socket);
        });
    }
}
