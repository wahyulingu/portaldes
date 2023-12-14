<?php

namespace App\Abstractions\Repository;

use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Str;

/**
 * Beberapa baris dari file ini atau
 * potongan kode ini diambil dari internal laravel,
 * kalau saya tidak salah ingat, sepertinya dari Factory,
 * saya ambil dan sesuaikan untuk melakukan hal yang kurang lebih
 * mirip untuk melakukan pemanggilan Repository, Hahahaha :p.
 */

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
abstract class Repository
{
    protected Builder $builder;

    /**
     * The name of the repository's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model;

    /**
     * The default namespace where factories reside.
     *
     * @var string
     */
    protected static $namespace;

    /**
     * The default model name resolver.
     *
     * @var callable
     */
    protected static $modelNameResolver;

    /**
     * The repository name resolver.
     *
     * @var callable
     */
    protected static $repositoryNameResolver;

    protected function model(callable $action = null)
    {
        $resolver = static::$modelNameResolver ?? function (self $repository) {
            $namespacedRepositoryBasename = Str::replaceLast(
                'Repository',
                '',
                Str::replaceFirst(static::namespace(), '', get_class($repository))
            );

            $repositoryBasename = Str::replaceLast('Repository', '', class_basename($repository));

            $appNamespace = static::appNamespace();

            return class_exists($appNamespace.'Models\\'.$namespacedRepositoryBasename)
                ? $appNamespace.'Models\\'.$namespacedRepositoryBasename
                : $appNamespace.$repositoryBasename;
        };

        if (isset($action)) {
            return $action($this->model ?? $resolver($this));
        }

        return $this->model ?? $resolver($this);
    }

    /**
     * Specify the callback that should be invoked to guess model names based on repository names.
     *
     * @param callable(self): class-string<\Illuminate\Database\Eloquent\Model|TModel> $callback
     *
     * @return void
     */
    public static function guessModelNamesUsing(callable $callback)
    {
        static::$modelNameResolver = $callback;
    }

    /**
     * Specify the default namespace that contains the application's model factories.
     *
     * @return void
     */
    public static function useNamespace(string $namespace)
    {
        static::$namespace = $namespace;
    }

    /**
     * Get a new repository instance for the given attributes.
     *
     * @return static
     */
    public static function new()
    {
        return new static();
    }

    /**
     * Get a new repository instance for the given model name.
     *
     * @param class-string<\Illuminate\Database\Eloquent\Model> $modelName
     *
     * @return Repository
     */
    public static function repositoryForModel(string $modelName)
    {
        return static::resolveRepositoryName($modelName)::new();
    }

    /**
     * Get the repository name for the given model name.
     *
     * @param class-string<\Illuminate\Database\Eloquent\Model> $modelName
     *
     * @return class-string<Repository<TModel>>
     */
    public static function resolveRepositoryName(string $modelName)
    {
        $resolver = static::$repositoryNameResolver ?? function (string $modelName) {
            $appNamespace = static::appNamespace();

            $modelName = Str::startsWith($modelName, $appNamespace.'Models\\')
                ? Str::after($modelName, $appNamespace.'Models\\')
                : Str::after($modelName, $appNamespace);

            return static::namespace().$modelName.'Repository';
        };

        return $resolver($modelName);
    }

    /**
     * Get the application namespace for the application.
     *
     * @return string
     */
    protected static function appNamespace()
    {
        try {
            return Container::getInstance()
                ->make(Application::class)
                ->getNamespace();
        } catch (\Throwable) {
            return 'App\\';
        }
    }

    protected static function namespace()
    {
        return static::$namespace ?? static::appNamespace().'Repositories\\';
    }

    public function all($columns = ['*']): Collection
    {
        return $this->model()::all($columns);
    }

    public function getAll($columns = ['*']): Collection
    {
        return $this->all($columns);
    }

    /**
     * @return TModel|null
     */
    public function find($key, $columns = ['*'], array $realations = [])
    {
        if (!empty($realations)) {
            return $this->model()::with($realations)->find($key, $columns);
        }

        return $this->model()::find($key, $columns);
    }

    /**
     * @return TModel
     */
    public function store(SupportCollection|array $attributes)
    {
        if ($attributes instanceof SupportCollection) {
            return $this->model()::create($attributes->toArray());
        }

        return $this->model()::create($attributes);
    }

    public function update($key, SupportCollection|array $attributes): bool
    {
        if ($attributes instanceof SupportCollection) {
            return $this->model()::find($key)->update($attributes->toArray());
        }

        return $this->model()::find($key)->update($attributes);
    }

    public function delete($key): bool
    {
        return $this->model()::whereKey($key)->delete();
    }

    public function latest(): self
    {
        $this

            ->builder
            ->latest();

        return $this;
    }

    public function with(array $realations = []): self
    {
        return tap($this, fn (self $repository) => $repository->builder->with($realations));
    }

    public function withCount(array $realations = []): self
    {
        return tap($this, fn (self $repository) => $repository->builder->withCount($realations));
    }

    public function oldest(): self
    {
        $this

            ->builder
            ->oldest();

        return $this;
    }

    public function get(array $columns = ['*']): Collection
    {
        return $this

            ->builder
            ->get($columns);
    }

    public function limit(int $limit = 0): self
    {
        $this

            ->builder
            ->limit($limit);

        return $this;
    }

    public function offset(int $offset = 0): self
    {
        $this

            ->builder
            ->offset($offset);

        return $this;
    }

    public function paginate(
        int $limit = 0,
        array $columns = ['*'],
        string $pageName = 'page',
        int $page = null
    ): LengthAwarePaginator {
        return $this

            ->builder
            ->paginate($limit, $columns, $pageName, $page);
    }

    protected function filterHasSolver($filter, Builder $builder)
    {
        if (is_string($filter)) {
            if (($explodedFilter = collect(explode('.', $filter)))->count() > 1) {
                return $builder->whereHas(
                    $explodedFilter->shift(),
                    fn (Builder $builder) => $this->filterHasSolver($explodedFilter->implode('.'), $builder)
                );
            }

            return $builder->whereHas($filter);
        }

        collect($filter)->each(
            function ($value, string $key) use ($builder) {
                if (intval($key) == $key) {
                    return $this->filterHasSolver($value, $builder);
                }

                if (($explodedKey = collect(explode('.', $key)))->count() > 1) {
                    return $builder->whereHas(
                        $explodedKey->shift(),
                        fn (Builder $builder) => $this->filterHasSolver([$explodedKey->implode('.') => $value], $builder),

                        $builder
                    );
                }

                if (is_array($value)) {
                    return $builder->whereHas($key, fn (Builder $builder) => $this->filterSolver(collect($value), $builder));
                }
            }
        );
    }

    protected function filterOrSolver($filter, Builder $builder)
    {
        collect($filter)->each(function ($value, string $key) use ($builder) {
            if (is_string($value)) {
                return $builder->orWhere($key, $value);
            }

            return $builder->orWhere(fn (Builder $builder) => $this->filterSolver(collect([$key => $value]), $builder));
        });
    }

    protected function filterModelSolver(string $key, Model $model, Builder $builder)
    {
        $builder->whereHas($key, fn ($builder) => $builder->where(
            $model->getKeyName(),
            $model->getKey()
        ));

        return $this;
    }

    protected function filterLikeSolver($filter, Builder $builder)
    {
        return collect($filter)->each(function ($value, string $key) use ($builder) {
            if (($explodedKey = collect(explode('|', $key)))->count() > 1) {
                return $this->filterOrSolver($explodedKey->map(fn ($key) => ['like' => [$key => $value]]), $builder);
            }

            $builder->where($key, 'LIKE', $value);
        });
    }

    protected function filterSolver(SupportCollection $filters, Builder $builder = null): Builder
    {
        if (empty($builder)) {
            return $this->model(
                fn (string $model) => $model::where(
                    fn (Builder $builder) => $this->filterSolver($filters, $builder)
                )
            );
        } else {
            $solver = collect([
                'has' => fn ($value, Builder $builder) => $this->filterHasSolver($value, $builder),
                'or' => fn ($value, Builder $builder) => $this->filterOrSolver($value, $builder),
                'like' => fn ($value, Builder $builder) => $this->filterLikeSolver($value, $builder),
            ]);

            $filters->each(function ($value, string $key) use ($builder, $solver) {
                if (intval($key) == $key) {
                    return $this->filterSolver(collect($value), $builder);
                }

                if ($solver->has($key)) {
                    return call_user_func($solver->get($key), $value, $builder);
                }

                if (($explodedKey = collect(explode('|', $key)))->count() > 1) {
                    return $this->filterOrSolver($explodedKey->map(fn ($key) => [$key => $value]), $builder);
                }

                if ($value instanceof Model) {
                    return $this->filterModelSolver($key, $value, $builder);
                }

                if (is_array($value)) {
                    return $this->filterSolver(collect(['has' => [$key => $value]]), $builder);
                }

                if (is_string($value)) {
                    return $builder->where($key, '=', $value);
                }
            });

            return $builder;
        }
    }

    public function filter(array $filters = [])
    {
        return $this->builder = $this->filterSolver(collect($filters));
    }
}
