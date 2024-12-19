<?php

namespace App\Livewire\Forms;

use App\Models\Video;
use Livewire\Form;

class VideoForm extends Form
{
    public ?Video $videoModel;
    
    public $title = '';
    public $slug = '';
    public $description = '';
    public $video_url = '';
    public $thumbnail_url = '';
    public $author_id = '';
    public $tags = '';
    public $views_count = '';
    public $likes_count = '';
    public $comments_count = '';
    public $is_published = '';
    public $published_at = '';

    public function rules(): array
    {
        return [
			'title' => 'required|string',
			'slug' => 'required|string',
			'description' => 'string',
			'video_url' => 'required|string',
			'thumbnail_url' => 'string',
			'author_id' => 'required',
			'views_count' => 'required',
			'likes_count' => 'required',
			'comments_count' => 'required',
			'is_published' => 'required',
        ];
    }

    public function setVideoModel(Video $videoModel): void
    {
        $this->videoModel = $videoModel;
        
        $this->title = $this->videoModel->title;
        $this->slug = $this->videoModel->slug;
        $this->description = $this->videoModel->description;
        $this->video_url = $this->videoModel->video_url;
        $this->thumbnail_url = $this->videoModel->thumbnail_url;
        $this->author_id = $this->videoModel->author_id;
        $this->tags = $this->videoModel->tags;
        $this->views_count = $this->videoModel->views_count;
        $this->likes_count = $this->videoModel->likes_count;
        $this->comments_count = $this->videoModel->comments_count;
        $this->is_published = $this->videoModel->is_published;
        $this->published_at = $this->videoModel->published_at;
    }

    public function store(): void
    {
        $this->videoModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->videoModel->update($this->validate());

        $this->reset();
    }
}
