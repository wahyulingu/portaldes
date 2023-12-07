<?php

namespace App\Abstractions\Action\Content;

use App\Contracts\Action\PaginatedIndexContract;

abstract class ContentPaginateByUserAction extends ContentIndexByUserAction implements PaginatedIndexContract
{
}
