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


    public function quotes()
    {
        return json_decode(Http::get($this->domain . WpApiMapper::QUOTES['All Quotes'])->body());
    }

    /**
     * @return mixed
     */
    public function goals()
    {
        return json_decode(Http::get($this->domain . WpApiMapper::GOALS['All Goals'])->body());
    }

    public function profile()
    {
        return json_decode(Http::get($this->domain . WpApiMapper::PROFILE['Single Profile'])->body());
    }

    public function posts()
    {
        return json_decode(Http::get($this->domain . WpApiMapper::POSTS['All Projects & Limit'])->body());
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function singlePost(string $slug)
    {
        return json_decode(Http::get($this->domain . WpApiMapper::POSTS['Filter by attribute Post'] . $slug)->body())[0];
    }

    /**
     * @return mixed
     */
    public function projects()
    {
        return json_decode(Http::get($this->domain . WpApiMapper::PROJECTS['All Projects'])->body());
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function singleProject(string $slug)
    {
        return json_decode(Http::get($this->domain . WpApiMapper::PROJECTS['Filter by attribute'] . $slug)->body())[0];
    }

    /**
     * @param $projects
     * @return array
     */
    public function projectsStatus($projects): array
    {
        $statuses = [];
        foreach ($projects as $project) {
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
        foreach ($data as $section) {
            $mapper[$section->title->rendered] = $section->content->rendered;
        }

        return $mapper;
    }
}
