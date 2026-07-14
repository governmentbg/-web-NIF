<?php

declare(strict_types=1);

namespace webpublic\components;

class TemplateConfig
{
    /** @var array<WidgetConfig> $widgets */
    protected array $widgets = [];
    /** @var array<string,mixed> $params */
    protected array $params = [];

    /**
     * @param integer $template
     * @param string $base
     * @param array<string> $zones
     * @param array<string,array<string,mixed>> $widgets
     */
    public function __construct(
        protected int $template,
        protected string $base,
        protected array $zones = [],
        array $widgets = []
    ) {
        $this->zones[] = 'main';
        $this->zones[] = 'before-main';
        $this->zones[] = 'after-main';
        $this->zones = array_unique($this->zones);
        $this->addWidgets($widgets, true);
    }
    public function id(): int
    {
        return $this->template;
    }
    public function name(): string
    {
        return $this->base;
    }
    /**
     * @param string|null $zone
     * @param boolean $hidden
     * @return array<WidgetConfig>
     */
    public function widgets(?string $zone = null, bool $hidden = false): array
    {
        $widgets = $this->widgets;
        if (!$hidden) {
            $widgets = array_filter($widgets, function ($widget) {
                return !$widget->hidden();
            });
        }
        if ($zone) {
            $zones = [];
            $zones[] = $zone;
            if ($zone === 'main') {
                $zones[] = 'before-main';
                $zones[] = 'after-main';
            }
            $widgets = array_filter($widgets, function ($widget) use ($zones) {
                return in_array($widget->zone(), $zones);
            });
        }
        return $widgets;
    }

    /**
     * @param array<string,array<string,mixed>> $widgets
     * @param boolean $checkZones
     * @return void
     */
    public function addWidgets(array $widgets, bool $checkZones = false): void
    {
        $defaultZone = 'before-main';
        foreach ($widgets as $key => $widget) {
            $base = explode('__', preg_replace('(^widget_)', '', $key) ?? '');
            if ($base[0] === 'main') {
                $defaultZone = 'after-main';
                continue;
            }
            $zone = ($widget['__zone'] ?? 'main');
            if ($checkZones && !in_array($zone, $this->zones)) {
                continue;
            }
            if ($zone === 'main') {
                $zone = $defaultZone;
            }
            $widget['__zone'] = $zone;
            $this->widgets[$key] = new WidgetConfig(
                $base[0],
                $widget
            );
        }
    }
    /**
     * @param array<string,mixed> $params
     * @return void
     */
    public function addParams(array $params): void
    {
        $this->params = array_merge($this->params, $params);
    }
    /**
     * @return array<string,mixed>
     */
    public function params(): array
    {
        return $this->params;
    }
    /**
     * @return array<string>
     */
    public function zones(): array
    {
        return $this->zones;
    }
}
