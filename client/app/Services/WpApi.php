<?php

namespace App\Services;

use App\Helpers\WpApiMapper;
use Illuminate\Support\Facades\Http;

class WpApi
{

    /**
     * @var mixed
     */
    private $domain;

    public function __construct()
    {
        $this->domain = env('WP_DOMAIN');
    }


    public function counter()
    {

    }

    public function goals()
    {
        return Http::get($this->domain . WpApiMapper::GOALS['All Goals'])->body();
    }

    public function profile()
    {
        return json_decode(Http::get($this->domain . WpApiMapper::PROFILE['Single Profile'])->body(), true);
    }

    public function posts()
    {
        return Http::get($this->domain . WpApiMapper::POSTS['All Projects & Limit'])->body();
    }

    /**
     * @return mixed
     */
    public function projects()
    {
        return json_decode(Http::get($this->domain . WpApiMapper::PROJECTS['All Projects'])->body());
    }

    /**
     * @param $projects
     * @return array
     */
    public function projectsStatus($projects): array
    {
        $statuses = [];
        foreach ($projects as $project)
        {
            $statuses[] = $project->acf->status;
        }

        return array_unique($statuses);
    }

    /**
     * @return mixed
     */
    public function highlights()
    {
        return json_decode(Http::get($this->domain . WpApiMapper::HIGHLIGHTS['All Highlights'])->body());
    }

    /**
     * @return mixed
     */
    public function devTools()
    {
        return json_decode(Http::get($this->domain . WpApiMapper::DEV_TOOLS['All devTools & filter fields'])->body());
    }

    /**
     * @return mixed
     */
    public function socMedias()
    {
        return json_decode(Http::get($this->domain . WpApiMapper::SOC_MEDIAS['All socMedias & filter fields'])->body());
    }

    /**
     * @return array
     */
    public function metas(): array
    {
        $data =  json_decode(Http::get($this->domain . WpApiMapper::METAS['All Meta for the page'])->body());
        $mapper = [];
        foreach ($data as $section)
        {
            $mapper[$section->title->rendered] = $section->content->rendered;
        }

        return $mapper;
    }

}
