<?php

namespace Afaqy\Core\Actions\Helpers;

use Afaqy\Core\Actions\Action;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class GenerateImageAction extends Action
{
    /** @var string */
    protected $path;

    public function __construct(string $path = 'default')
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        if (! Storage::exists($this->path)) {
            throw new FileNotFoundException;
        }

        $file = [
            'file' => Storage::get($this->path),
            'type' => \File::mimeType(Storage::path($this->path)),
        ];


        if ($this->is_image($file['type'])) {
            return Image::make($file['file'])->response();
        }

        return response()->download($file['file']);
    }

    /**
     * @param string $type
     * @return bool
     */
    private function is_image(string $type)
    {
        $allowedMimeTypes = ['image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/svg+xml'];

        return in_array($type, $allowedMimeTypes);
    }
}
