<?php namespace Lio\Accounts;

use Lio\Core\EloquentBaseRepository;
use Lio\Core\Exceptions\EntityNotFoundException;

class UserRepository extends EloquentBaseRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getByGithubId($id)
    {
        return $this->model->where('github_id', '=', $id)->first();
    }

    public function requireByName($name)
    {
        $model = $this->getByName($name);

        if ( ! $model) {
            throw new EntityNotFoundException("User with name {$name} could not be found.");
        }

        return $model;
    }

    public function getByName($name)
    {
        return $this->model->where('name', '=', $name)->first();
    }

    public function getFirstX($count)
    {
        return $this->model->take($count)->get();
    }
}
