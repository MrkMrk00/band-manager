<?php

declare(strict_types=1);

namespace BandManager;

class UglifyJS
{
    private static string $pathToUglify;

    public function __construct()
    {
        if (!isset(self::$pathToUglify)) {
            self::$pathToUglify = base_path('scripts/UglifyJS/bin/uglifyjs');
        }
    }

    /**
     * @return bool Whether UglifyJS can be used in current environment.
     */
    public function check(): bool
    {
        exec('/usr/bin/env node -v', result_code: $resultCode);

        return ((int) $resultCode === 0) && file_exists(self::$pathToUglify);
    }

    public function uglify(string $javascript): ?string
    {
        $spec = [
            ['pipe', 'r'],  // stdin
            ['pipe', 'w'],  // stdout
        ];

        $p = proc_open([self::$pathToUglify, '--mangle', '--compress'], $spec, $pipes);
        if (!$p) {
            return null;
        }

        fwrite($pipes[0], $javascript);
        fclose($pipes[0]);

        $uglified = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        proc_close($p);

        return $uglified ?: null;
    }
}
