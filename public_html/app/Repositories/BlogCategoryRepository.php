<?php


namespace App\Repositories;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use App\Models\BlogCategory;
use Illuminate\Support\Collection;

class BlogCategoryRepository extends CoreRepository
{

    protected function getModelClass()
    {
//        return Model::class;
        return BlogCategory::class;
    }

    /**
     * Получить модель для редактирования в админке.
     *
     * @param int $id
     *
     * @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * Получить список категорий для вывода в выпадающем списке.
     *
     * @return Collection
     */
    public function getForComboBox()
    {
        $columns = implode(', ', [
            'id',
            'CONCAT (id, ". ", title) AS id_title'
        ]);

        /** @var Collection $result */
        $result = $this
        ->startConditions()
        ->selectRaw($columns)
            ->toBase()
            ->get();

        return $result;
    }

    /**
     * Получить категории для вывода пагинатором
     *
     * @param int|null $perPage
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginate($perPage = null) {
        $columns = ['id', 'title', 'parent_id'];

        /** @var LengthAwarePaginator $result */
        $result = $this
            ->startConditions()
            ->select($columns)
            ->paginate($perPage);

        return $result;
    }
}
