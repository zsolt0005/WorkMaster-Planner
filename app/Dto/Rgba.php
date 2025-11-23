<?php declare(strict_types=1);

namespace App\Dto;

readonly class Rgba
{
    public function __construct(
        public int $r,
        public int $g,
        public int $b,
        public float $a = 1.0,
    ) {}

    /**
     * Automatically adjust this color based on another color.
     *
     * - If the reference color is light, this color is darkened.
     * - If the reference color is dark, this color is lightened.
     */
    public function autoAdjust(float $amount, self $reference): self
    {
        if ($reference->isLight()) {
            return $this->darken($amount);
        }

        return $this->lighten($amount);
    }

    /**
     * Darken the color by a given factor (0.0–1.0).
     *
     * 0.0 = no change, 1.0 = fully black.
     */
    public function darken(float $amount): self
    {
        $factor = $this->clamp01($amount);

        $r = (int) round($this->r * (1.0 - $factor));
        $g = (int) round($this->g * (1.0 - $factor));
        $b = (int) round($this->b * (1.0 - $factor));

        return new self(
            r: $this->clampChannel($r),
            g: $this->clampChannel($g),
            b: $this->clampChannel($b),
            a: $this->a,
        );
    }

    /**
     * Lighten the color by a given factor (0.0–1.0).
     *
     * 0.0 = no change, 1.0 = fully white.
     */
    public function lighten(float $amount): self
    {
        $factor = $this->clamp01($amount);

        $r = (int) round($this->r + (255 - $this->r) * $factor);
        $g = (int) round($this->g + (255 - $this->g) * $factor);
        $b = (int) round($this->b + (255 - $this->b) * $factor);

        return new self(
            r: $this->clampChannel($r),
            g: $this->clampChannel($g),
            b: $this->clampChannel($b),
            a: $this->a,
        );
    }

    /**
     * Determine if this color is visually "light" based on perceived luminance.
     */
    private function isLight(): bool
    {
        // Perceived luminance formula (ITU-R BT.601)
        $luminance = (
            0.299 * $this->r +
            0.587 * $this->g +
            0.114 * $this->b
        ) / 255;

        return $luminance >= 0.5;
    }

    private function clamp01(float $value): float
    {
        if ($value < 0.0) {
            return 0.0;
        }
        if ($value > 1.0) {
            return 1.0;
        }

        return $value;
    }

    private function clampChannel(int $value): int
    {
        if ($value < 0) {
            return 0;
        }
        if ($value > 255) {
            return 255;
        }

        return $value;
    }

    public function __toString(): string
    {
        return "rgba({$this->r}, {$this->g}, {$this->b}, {$this->a})";
    }
}
