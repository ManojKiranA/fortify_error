<?php

namespace Database\Factories;

use App\Models\User;
use Config;
use Carbon\Carbon;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class TagFactory extends Factory
{
//    use Sluggable;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title_word= $this->faker->unique()->word;
        $slugValue = SlugService::createSlug(Tag::class, 'slug', $title_word);

        return [
            'title' => ucwords($slugValue),
            'slug' => $slugValue,
            'active' => true,
        ];
    }

}
