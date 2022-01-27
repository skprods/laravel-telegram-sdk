<?php

namespace SKprods\Telegram\Objects\InputMedia;

use SKprods\Telegram\Objects\MessageEntity;

/**
 * @property string $type                           Type of the result, must be photo.
 * @property string $media                          File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
 * @property string|null $caption                   Optional. Caption of the photo to be sent, 0-200 characters
 * @property string|null $parseMode                 Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @property MessageEntity[]|null $captionEntities  Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode
 *
 * @link https://core.telegram.org/bots/api#inputmediaphoto
 */
class InputMediaPhoto extends InputMedia
{
    protected function casts(): array
    {
        return [
            'caption_entities' => [ MessageEntity::class ],
        ];
    }
}
