<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

use GrottoPress\Jentil\IdentityTrait;

class AbstractThemeMod
{
    use IdentityTrait;

    /**
     * @var mixed
     */
    protected $default;

    protected function getDefault()
    {
        return $this->default;
    }

    public function get()
    {
        if (!$this->id) {
            \settype($value, \gettype($this->default));

            return $value;
        }

        return \get_theme_mod($this->id, $this->default);
    }

    public function update($newValue): bool
    {
        if (!$this->id) {
            return false;
        }

        return \set_theme_mod($this->id, $newValue);
    }

    public function delete()
    {
        if (!$this->id) {
            return;
        }

        \remove_theme_mod($this->id);
    }
}
