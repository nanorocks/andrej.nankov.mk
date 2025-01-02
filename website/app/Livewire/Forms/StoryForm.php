<?php

namespace App\Livewire\Forms;

use App\Models\Story;
use Livewire\Form;

class StoryForm extends Form
{
    public ?Story $storyModel;
    
    public $slug = '';
    public $title = '';
    public $content = '';
    public $excerpt = '';
    public $author_id = '';
    public $tags = '';
    public $category_id = '';
    public $published_at = '';
    public $is_published = '';
    public $is_draft = '';
    public $views_count = '';
    public $likes_count = '';
    public $comments_count = '';
    public $featured_image = '';
    public $media = '';
    public $seo_page_id = '';

    public function rules(): array
    {
        return [
			'slug' => 'required|string',
			'title' => 'required|string',
			'content' => 'required|string',
			'excerpt' => 'string',
			'author_id' => 'required',
			'is_published' => 'required',
			'is_draft' => 'required',
			'views_count' => 'required',
			'likes_count' => 'required',
			'comments_count' => 'required',
			'featured_image' => 'string',
        ];
    }

    public function setStoryModel(Story $storyModel): void
    {
        $this->storyModel = $storyModel;
        
        $this->slug = $this->storyModel->slug;
        $this->title = $this->storyModel->title;
        $this->content = $this->storyModel->content;
        $this->excerpt = $this->storyModel->excerpt;
        $this->author_id = $this->storyModel->author_id;
        $this->tags = $this->storyModel->tags;
        $this->category_id = $this->storyModel->category_id;
        $this->published_at = $this->storyModel->published_at;
        $this->is_published = $this->storyModel->is_published;
        $this->is_draft = $this->storyModel->is_draft;
        $this->views_count = $this->storyModel->views_count;
        $this->likes_count = $this->storyModel->likes_count;
        $this->comments_count = $this->storyModel->comments_count;
        $this->featured_image = $this->storyModel->featured_image;
        $this->media = $this->storyModel->media;
        $this->seo_page_id = $this->storyModel->seo_page_id;
    }

    public function store(): void
    {
        $this->storyModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->storyModel->update($this->validate());

        $this->reset();
    }
}
