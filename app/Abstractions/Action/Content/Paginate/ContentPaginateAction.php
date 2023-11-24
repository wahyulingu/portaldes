<?php

namespace App\Abstractions\Action\Content\Paginate;

use App\Abstractions\Action\Content\Index\ContentIndexAction;
use App\Contracts\Action\PaginatedActionContract;

abstract class ContentPaginateAction extends ContentIndexAction implements PaginatedActionContract
{
}
