<?php

namespace SKprods\Telegram\Objects\InputMedia;

use SKprods\Telegram\Objects\InputFile;
use SKprods\Telegram\Objects\MessageEntity;

/**
 * @property string $type                           Type of the result, must be document.
 * @property string $media                          File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
 * @property InputFile|string $thumb                Optional. Thumbnail of the file sent. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail‘s width and height should not exceed 90. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can’t be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>
 * @property string|null $caption                   Optional. Caption of the document to be sent, 0-200 characters
 * @property string|null $parseMode                 Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @property MessageEntity[]|null $captionEntities  Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode
 * @property bool|null $disableContentTypeDetection Optional. Disables automatic server-side content type detection for files uploaded using multipart/form-data. Always True, if the document is sent as part of an album
 *
 * @link https://core.telegram.org/bots/api#inputmediadocument
 */
class InputMediaDocument extends InputMedia
{
    protected function casts(): array
    {
        return [
            'thumb' => InputFile::class,
        ];
    }
}
