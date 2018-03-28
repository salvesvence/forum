<?php

namespace App\Inspections;


class Spam
{
    public function detect($body)
    {
        $this->detectInvalidKeywords($body);
        $this->detectKeyHeldDown($body);

        return false;
    }

    /**
     * @param $body
     * @throws \Exception
     */
    protected function detectInvalidKeywords($body)
    {
        $invalidKeywords = [
            'yahoo customer support'
        ];

        foreach ($invalidKeywords as $keyword) {
            if(stripos($body, $keyword) !== false) {
                throw new \Exception('Your reply contains spam.');
            }
        }
    }

    /**
     * @param $body
     * @throws \Exception
     */
    protected function detectKeyHeldDown($body)
    {
        if(preg_match('/(.)\\{4,}/', $body)) {
            throw new \Exception('Your reply contains spam');
        }
    }
}