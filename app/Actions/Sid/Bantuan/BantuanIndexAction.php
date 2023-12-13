<?php

namespace App\Actions\Sid\Bantuan;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\SidBantuanRepository;
use Illuminate\Support\Collection;

class BantuanIndexAction extends IndexAction
{
    public function __construct(SidBantuanRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(Collection $payload): array
    {
        $filters = [];

        if ($payload->has('keyword')) {
            $filters['or'] = [
                ['like' => ['nama|keterangan' => '%'.$payload->get('keyword').'%']],

                ['has' => ['penduduk' => ['like' => ['nama|nik' => '%'.$payload->get('keyword').'%']]]],

                ['has' => [
                    'kelompok' => [
                        'or' => [
                            ['has' => ['ketua' => ['like' => ['nama|nik' => '%'.$payload->get('keyword').'%']]]],
                            ['has' => ['penduduk' => ['like' => ['nama|nik' => '%'.$payload->get('keyword').'%']]]],
                        ],
                    ],
                ]],
            ];
        }

        return $filters;
    }
}
