<?php

namespace Afaqy\Core\Actions\Helpers;

use Afaqy\Core\Actions\Action;
use Illuminate\Http\UploadedFile;

class UploadFileAction extends Action
{
    /** @var mixed */
    protected $file;

    /** @var string */
    protected $path;

    /**
     * @param mixed $file
     * @param string $path
     * @return void
     */
    public function __construct($file, string $path = 'default')
    {
        $this->file = $file;
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        if ($this->file instanceof UploadedFile) {
            return $this->file->store($this->path);
        }

        return $this->file;
    }
}
