<?php
/**
 * Created by PhpStorm.
 * User: Sirius
 * Date: 2019/2/25
 * Time: 14:20
 */

namespace App\Service;


use Illuminate\Support\Facades\Log;
use Throwable;

class ServiceException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        Log::error("{$this->file} at {$code}:{$this->getLine()}".PHP_EOL."message:{$message}");
    }
}
