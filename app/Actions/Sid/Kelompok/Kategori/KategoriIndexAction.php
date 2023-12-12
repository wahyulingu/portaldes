<?php

namespace App\Actions\Sid\Kelompok\Kategori;

use App\Abstractions\Action\IndexAction;
use App\Contracts\Action\RuledActionContract;
use App\Repositories\Sid\Kelompok\SidKelompokKategoriRepository;
use Illuminate\Support\Collection;

class KategoriIndexAction extends IndexAction implements RuledActionContract
{
    public function __construct(SidKelompokKategoriRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(Collection $payload): array
    {
        $filters = [];

        if ($payload->has('keyword')) {
            $filters['like'] = ['nama|keterangan' => '%'.$payload->get('keyword').'%'];
        }

        return $filters;
    }
}
