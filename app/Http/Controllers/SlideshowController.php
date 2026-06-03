<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Inertia\Inertia;
use Inertia\Response;

class SlideshowController extends Controller
{
    public function __invoke(): Response
    {
        $directory = public_path('assets/slides');
        $slides = [];

        if (File::exists($directory)) {
            $slides = collect(File::files($directory))
                ->filter(function ($file) {
                    $extension = strtolower($file->getExtension());

                    return in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], true);
                })
                ->sortBy(function ($file) {
                    $name = pathinfo($file->getFilename(), PATHINFO_FILENAME);

                    if (is_numeric($name)) {
                        return (int) $name;
                    }

                    if (preg_match('/\d+/', $name, $matches)) {
                        return (int) $matches[0];
                    }

                    return $name;
                })
                ->map(fn ($file) => asset('assets/slides/'.$file->getFilename()))
                ->values()
                ->all();
        }

        return Inertia::render('Slideshow', [
            'slides' => $slides,
        ]);
    }
}
