<?php

namespace App\Libs\Treasury;

use Generator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;
use Orchestra\Parser\Xml\Facade as XmlParser;


class Client
{
    private string $endpoint;

    public function __construct(array $config)
    {
        if (empty($config['endpoint'])) {
            throw new \Exception('Invalid config');
        }

        $this->endpoint = $config['endpoint'];
    }

    public function getOfacSdn(): ?array
    {
        try {
            $res = Http::get($this->endpoint);
            $xml = simplexml_load_string($res->body());

            $res = [];
            foreach ($xml->sdnEntry as $entity) {
                $res[] = [
                    'uid' => (int)$entity?->uid,
                    'first_name' => (string)$entity?->firstName,
                    'last_name' => (string)$entity?->lastName,
                ];
            }

            return $res;
        } catch (Throwable $e) {
            Log::error($e);
        }

        return null;
    }
}
