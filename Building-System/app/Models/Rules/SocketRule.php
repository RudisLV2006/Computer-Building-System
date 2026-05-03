<?php

namespace App\Models\Rules;

use App\Models\Rules\BaseRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Override;

class SocketRule extends BaseRule implements FilterRule, ValidationRule
{
    #[Override]
    public function appliesTo(string $category): bool
    {
        return in_array($category, ['cpu', 'motherboard', 'cpu-cooler']);
    }
    #[Override]
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

    #[Override]
    public function validate(): array
    {
        $errors = [];

        if ($this->build->hasItem('cpu') && $this->build->hasItem('motherboard')) {
            $cpuSocket  = $this->build->getField('cpu', 'socket');
            $moboSocket = $this->build->getField('motherboard', 'socket');

            if ($cpuSocket !== $moboSocket) {
                $errors[] = "CPU socket ({$cpuSocket}) does not match motherboard socket ({$moboSocket}).";
            }
        }

        if ($this->build->hasItem('cpu-cooler') && $this->build->hasItem('cpu')) {
            $cpuSocket     = $this->build->getField('cpu', 'socket');
            $coolerSockets = $this->build->getField('cpu-cooler', 'socket');

            if (!in_array($cpuSocket, $coolerSockets)) {
                $errors[] = "CPU cooler does not support CPU socket ({$cpuSocket}).";
            }
        }

        if ($this->build->hasItem('cpu-cooler') && $this->build->hasItem('motherboard')) {
            $moboSocket    = $this->build->getField('motherboard', 'socket');
            $coolerSockets = $this->build->getField('cpu-cooler', 'socket');

            if (!in_array($moboSocket, $coolerSockets)) {
                $errors[] = "CPU cooler does not support motherboard socket ({$moboSocket}).";
            }
        }

        return $errors;
    }
}
