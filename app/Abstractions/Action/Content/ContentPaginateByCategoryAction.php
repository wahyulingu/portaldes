<?php

namespace App\Abstractions\Action\Content;

use App\Contracts\Action\PaginatedIndexContract;

abstract class ContentPaginateByCategoryAction extends ContentIndexByCategoryAction implements PaginatedIndexContract
{
}
