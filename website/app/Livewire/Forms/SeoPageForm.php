<?php

namespace App\Livewire\Forms;

use App\Models\SeoPage;
use Livewire\Form;

class SeoPageForm extends Form
{
    public ?SeoPage $seoPageModel;
    
    public $slug = '';
    public $keywords = '';
    public $title = '';
    public $description = '';
    public $meta_robots = '';
    public $canonical_url = '';
    public $og_title = '';
    public $og_description = '';
    public $og_image = '';
    public $structured_data = '';
    public $locale = '';
    public $sitemap_priority = '';
    public $sitemap_frequency = '';
    public $last_seo_audit = '';
    public $custom_scripts = '';

    public function rules(): array
    {
        return [
			'slug' => 'required|string',
			'keywords' => 'required',
			'title' => 'required|string',
			'description' => 'required|string',
			'meta_robots' => 'string',
			'canonical_url' => 'string',
			'og_title' => 'string',
			'og_description' => 'string',
			'og_image' => 'string',
			'locale' => 'string',
			'sitemap_frequency' => 'string',
			'custom_scripts' => 'string',
        ];
    }

    public function setSeoPageModel(SeoPage $seoPageModel): void
    {
        $this->seoPageModel = $seoPageModel;
        
        $this->slug = $this->seoPageModel->slug;
        $this->keywords = $this->seoPageModel->keywords;
        $this->title = $this->seoPageModel->title;
        $this->description = $this->seoPageModel->description;
        $this->meta_robots = $this->seoPageModel->meta_robots;
        $this->canonical_url = $this->seoPageModel->canonical_url;
        $this->og_title = $this->seoPageModel->og_title;
        $this->og_description = $this->seoPageModel->og_description;
        $this->og_image = $this->seoPageModel->og_image;
        $this->structured_data = $this->seoPageModel->structured_data;
        $this->locale = $this->seoPageModel->locale;
        $this->sitemap_priority = $this->seoPageModel->sitemap_priority;
        $this->sitemap_frequency = $this->seoPageModel->sitemap_frequency;
        $this->last_seo_audit = $this->seoPageModel->last_seo_audit;
        $this->custom_scripts = $this->seoPageModel->custom_scripts;
    }

    public function store(): void
    {
        $this->seoPageModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->seoPageModel->update($this->validate());

        $this->reset();
    }
}
