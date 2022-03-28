<?php

namespace App\Repositories;

use App\Models\ShortLink;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Validator;

/**
 * Class ShortLinkRepository
 * @package App\Repositories
 * @version March 19, 2022, 8:46 am UTC
*/

class ShortLinkRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'full_path',
        'short_path',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ShortLink::class;
    }

    /**
     * @param array $input
     */
    public function store($input)
    {
        if (isset($input['link']) && !empty($input['link'])) {
            $fullPath = $input['link'];

            $checkIfExist = $this->getDataByParam(['full_path' => $fullPath]);

            if (isset($checkIfExist->short_path)) {
                return $checkIfExist->short_path;
            } else {
                $shortLink = $this->generateShortLink($fullPath);

                if (!$shortLink) {
                    return false;
                }

                $validate = Validator::make(['short_path' => $shortLink], $this->model->getRules());

                if ($validate->fails()) {
                    return false;
                }

                $save = $this->create([
                    'full_path' => $fullPath,
                    'short_path' => $shortLink,
                ]);

                if ($save) {
                    return $save->short_path;
                }
            }
        }

        return false;
    }

    /**
     * @param $param
     * @return false|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public function getDataByParam($param)
    {
        $data = $this->allQuery($param)->first();

        if (!$data) {
            return false;
        }
        return $data;
    }

    /**
     * @param $shortPath
     * @return false|\Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
     */
    public function getFullByShortPath($shortPath)
    {
        $data = $this->getDataByParam(['short_path' => $shortPath]);

        if (!$data) {
            return false;
        }

        $this->updateRedirection($data);

        return $data->full_path;
    }

    /**
     * @param $model
     * @return mixed
     */
    public function updateRedirection($model)
    {
        $model->redirection_count += 1;

        return $model->save();
    }

    /**
     * @param $link
     * @return string
     */
    private function generateShortLink($link): string
    {
        $domain = $this->getDomain($link);

        if (!$domain) {
            return false;
        }

        return substr($domain, 0, 2) . strlen($link) . substr($domain, -1);
    }

    /**
     * @param $link
     * @return mixed
     */
    private function getDomain($link): string
    {
        try{
            preg_match("/[a-z0-9\-]{1,63}\.[a-z\.]{2,6}$/", parse_url($link, PHP_URL_HOST), $_domain_tld);

            return $_domain_tld[0];
        } catch (\Exception $exception) {
            return false;
        }
    }
}
