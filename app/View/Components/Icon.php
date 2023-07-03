<?php

namespace BandManager\App\View\Components;

use BandManager\App\Exceptions\StaticAssetsException;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;

class Icon extends Component
{
    private const PROTECTED_ATTRIBUTES = ['type', 'name'];

    private readonly Repository $cache;

    public function __construct(
        private readonly string $name,
        CacheManager $cacheManager,
        private readonly string $type = 'solid',
    )
    {
        $this->cache = $cacheManager->driver('file');
    }

    public function render(): \Closure
    {
        $filePath = resource_path("icons/{$this->type}/{$this->name}.svg");
        if (!file_exists($filePath)) {
            throw new StaticAssetsException("Icon {$this->type}/{$this->name} not found!");
        }

        return function ($data) use ($filePath) {
            /** @var ComponentAttributeBag $attributes */
            $attributes = $data['attributes'];

            $cacheKey = 'svgicon-'.$this->type.'-'.$this->name.'-'.md5(serialize($attributes->getAttributes()));
            $cacheValue = $this->cache->get($cacheKey);

            if (is_string($cacheValue)) {
                return $cacheValue;
            }

            $attrsToExpand = $attributes
                ->filter(fn ($_, $name) => !in_array($name, self::PROTECTED_ATTRIBUTES))
                ->getAttributes();

            $icon = file_get_contents($filePath);

            if (count($attrsToExpand) < 1) {
                return $icon;
            }

            $doc = new \DOMDocument();
            $doc->loadXML($icon);

            /** @var \DOMElement $svg */
            $svg = $doc->getElementsByTagName('svg')->item(0);

            /** @var \DOMElement $path */
            $path = $doc->getElementsByTagName('path')->item(0);
            foreach ($attrsToExpand as $name => $value) {
                if (str_starts_with($name, 'path-')) {
                    $path->setAttribute(explode('-', $name)[1], $value);
                    continue;
                }

                $svg->setAttribute($name, $value);
            }

            $icon = (string) $doc->saveHTML();
            $this->cache->set($cacheKey, $icon);

            return $icon;
        };
    }
}
