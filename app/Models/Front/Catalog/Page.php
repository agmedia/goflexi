<?php

namespace App\Models\Front\Catalog;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Page extends Model
{

    /**
     * @var string
     */
    protected $table = 'pages';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var Request
     */
    private $request;


    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->locale = current_locale();
    }


    /**
     * @param null  $lang
     * @param false $all
     *
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasOne|object|null
     */
    public function translation($lang = null, bool $all = false)
    {
        if ($lang) {
            return $this->hasOne(PageTranslation::class, 'page_id')->where('lang', $lang)->first();
        }

        if ($all) {
            return $this->hasMany(PageTranslation::class, 'page_id');
        }

        return $this->hasOne(PageTranslation::class, 'page_id')->where('lang', $this->locale);
    }

    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate($this->setValidation($request));

        $this->setRequest($request);

        return $this;
    }


    /**
     * @return Page|null
     */
    public function store(): Page|null
    {
        if ( ! $this->request) return null;

        $id = $this->insertGetId($this->getModelArray());

        if ($id) {
            $page = $this->find($id);

            PageTranslation::saveTranslations($this->request, $page);

            return $page;
        }

        return null;
    }


    /**
     * @return Page|$this|null
     */
    public function edit(): Page|null
    {
        if ( ! $this->request) return null;

        $updated = $this->update($this->getModelArray(false));

        if ($updated) {
            PageTranslation::saveTranslations($this->request, $this);

            return $this;
        }

        return null;
    }

    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/

    /**
     * @param bool $insert
     *
     * @return array
     */
    private function getModelArray(bool $insert = true): array
    {
        $response = [
            'group'        => $this->setPageGroup(),
            'image'        => 'media/default-page.jpg',
            'publish_date' => $this->request->publish_date ? Carbon::make($this->request->publish_date) : now(),
            'featured'     => (isset($this->request->featured) and $this->request->featured == 'on') ? 1 : 0,
            'status'       => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'updated_at'   => Carbon::now()
        ];

        if ($insert) {
            $response['created_at'] = Carbon::now();
        }

        return $response;
    }


    /**
     * Set Product Model request variable.
     *
     * @param $request
     */
    private function setRequest($request)
    {
        $this->request = $request;
    }


    /**
     * @param Request $request
     *
     * @return array
     */
    private function setValidation(Request $request): array
    {
        $response = [];

        foreach (ag_lang() as $lang) {
            $response['title.' . $lang->code] = 'required';
        }

        return $response;
    }


    /**
     * @return string|null
     */
    private function setPageGroup(): string|null
    {
        if ( ! $this->request) return null;

        if ($this->request->page_group) {
            return $this->request->page_group;
        }

        if ( ! $this->request->page_group && $this->request->new_page_group) {
            return $this->request->new_page_group;
        }

        return null;
    }


    private function setTranslations()
    {
        if ( ! $this->request) return null;


    }

}