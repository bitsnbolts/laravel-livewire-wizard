<?php

namespace Spatie\LivewireWizard\Components\Concerns;

use Livewire\Livewire;
use Spatie\LivewireWizard\Enums\StepStatus;
use Spatie\LivewireWizard\Support\Step;

trait StepAware
{
    public function bootedStepAware()
    {
        $currentFound = false;

        $currentStepName = $this->stepName;

        $this->steps = collect($this->allStepNames)
            ->map(function (string $stepName) use (&$currentFound, $currentStepName) {
                $className = $this->allStepClasses[$stepName];

                $info = (new $className())->stepInfo();

                $status = $currentFound ? StepStatus::Next : StepStatus::Previous;


                if ($stepName === $currentStepName) {
                    $currentFound = true;
                    $status = StepStatus::Current;
                }

                return new Step($stepName, $className, $info, $status);
            })
            ->toArray();
    }
}
