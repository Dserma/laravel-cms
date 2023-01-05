<?php
namespace App\Traits\Sistema;

use Exception;

trait PresentableTrait
{
    protected $presenterInstance;

    public function present()
    {
        if (! $this->presenter or ! class_exists($this->presenter)) {
            throw new Exception('Please set the Presenter path to your Presenter FQN');
        }

        if (! $this->presenterInstance) {
            $this->presenterInstance = new $this->presenter($this);
        }

        return $this->presenterInstance;
    }
}
