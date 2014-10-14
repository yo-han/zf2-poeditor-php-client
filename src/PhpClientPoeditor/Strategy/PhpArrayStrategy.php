<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 Maik Schmidt
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace PhpClientPoeditor\Strategy;

/**
 * PhpClientPoeditor\Strategy\PhpArrayStrategy
 */
class PhpArrayStrategy implements StrategyInterface
{
    /** @var string */
    private $savePath;

    /**
     * @param string $savePath
     */
    public function __construct($savePath)
    {
        $this->savePath = (string) $savePath;
    }

    public function getSavePath()
    {
        return $this->savePath;
    }

    public function build($content)
    {
        $tanslationContent = json_decode($content);

        $translations = array();
        /** @var \stdClass $tanslation */
        foreach ($tanslationContent as $tanslation) {
            $translations[$tanslation->term] = $tanslation->definition;
        }

        $content = "<?php\n return array(\n";
        foreach ($translations as $translationKey => $translation) {
            $content .= sprintf(
                '"%s" => "%s",' . "\n",
                $translationKey,
                $translation
            );
        }
        $content .= ');';

        return $content;
    }
}