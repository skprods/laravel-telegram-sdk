<?php

namespace SKprods\Telegram\Api;

class InputFile
{
    public const PHOTO_TYPE = 'photo';
    public const AUDIO_TYPE = 'audio';
    public const DOCUMENT_TYPE = 'document';
    public const VIDEO_TYPE = 'video';
    public const ANIMATION_TYPE = 'photo';
    public const VOICE_TYPE = 'photo';
    public const VIDEO_NOTE_TYPE = 'photo';

    public const FILE_TYPES = [
        self::PHOTO_TYPE,
        self::AUDIO_TYPE,
        self::DOCUMENT_TYPE,
        self::VIDEO_TYPE,
        self::ANIMATION_TYPE,
        self::VOICE_TYPE,
        self::VIDEO_NOTE_TYPE,
    ];

    protected mixed $contents;

    protected ?string $filename;

    protected ?string $type;

    /**
     * @param string|resource $contents - url или ресурс локального файла
     * @param string|null $filename     - название файла
     * @param string|null $type         - тип файла, должен быть одним из self::FILE_TYPES
     */
    public function __construct(mixed $contents, string $filename = null, string $type = null)
    {
        $this->contents = $contents;
        $this->filename = $filename;
        $this->type = $type;
    }

    /**
     * @param string|resource $file     - url или ресурс локального файла
     * @param string|null $filename     - название файла
     * @param string|null $type         - тип файла, должен быть одним из self::FILE_TYPES
     */
    public static function create(mixed $file, string $filename = null, string $type = null): self
    {
        return new static($file, $filename, $type);
    }

    public function prepareToRequest(): array
    {
        return [
            'contents' => $this->contents,
            'filename' => $this->filename,
        ];
    }

    /**
     * @return string|resource
     */
    public function getContents(): mixed
    {
        return $this->contents;
    }

    public function getType(): ?string
    {
        return $this->type;
    }
}
