<?php

namespace BandManager\App\View\Components;

use BandManager\UglifyJS;
use Closure;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;

class Script extends Component
{
    private readonly Repository $cache;

    public function __construct(
        CacheManager $cache,
        private readonly UglifyJS $uglify,
        private readonly ?string $cacheKey = null)
    {
        $this->cache = $cache->store('file');
    }

    private function parseAttributes(array $data): string
    {
        $attributes = $data['attributes'];

        $type = $attributes['type'] ?? 'text/javascript';
        $attrs = "type=\"$type\"";

        if ($attributes['defer'] ?? false) {
            $attrs .= ' defer';
        }

        if ($attributes['async'] ?? false) {
            $attrs .= ' async';
        }

        return $attrs;
    }


    public function render(): string|Closure
    {
        if (config('view.uglify') && !empty($this->cacheKey)) {
            $cachedResult = $this->cache->get($this->cacheKey);

            if (is_string($cachedResult)) {
                return $cachedResult;
            }
        }

        return function (array $data) {
            $attributes = $this->parseAttributes($data);

            /** @var ComponentAttributeBag $attrs */
            $attrs = $data['attributes'];

            $jsDataAttrs = $attrs->filter(fn ($_, $key) => str_starts_with($key, 'jsdata-'));
            $hasJsProps = count($jsDataAttrs->getAttributes()) > 0;

            $props = $hasJsProps ? 'let ' : '';
            foreach ($jsDataAttrs as $name => $value) {
                $name = explode('-', $name)[1];

                $props .= $name.'='.$value.',';
            }

            if ($hasJsProps) {
                $props[strlen($props) - 1] = ';';
                $data['slot'] = $props.$data['slot'];
            }

            if (config('view.uglify') && $this->uglify->check()) {
                $result = "<script $attributes>".$this->uglify->uglify($data['slot']).'</script>';

                if (!empty($this->cacheKey)) {
                    $this->cache->set($this->cacheKey, $result, now()->addDay());
                }

                return $result;
            }

            return "<script $attributes>".$data['slot'].'</script>';
        };
    }
}
