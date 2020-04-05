<?php
/*
 * The MIT License
 *
 * Copyright 2020 Jayson Fong <fong.jayson@gmail.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
class RestrictExtImgs_Base extends XFCP_RestrictExtImgs_Base {
    /*
    * Render Image BbCode
    * If the image host is known, display image.
    * Else, render as a URL.
    * @param array $tag BbCode Tag
    * @param array $rendererStates Renderer States
    * @return Tag Rendering of Image or Url
    */
    public function renderImage(array $tag, array $rendererStates) {
        $whitelist = getWhitelist();
        $imageHost = getImageHost($tag);
        if (in_array($imageHost, $whitelist)) {
            return parent::renderTagImage($tag, $rendererStates);
        }
        return parent::renderTagUrl($tag, $rendererStates);
    }
    protected function getWhitelist() {
        $opts = XenForo_Application::get('options');
        $whitelist = explode("\n", $opts->rei_whitelisted_image_hosts);
        $whitelist[] = parse_url($opts->boardUrl)['host'];
        return $whitelist;
    }
    protected function getImageHost(tag) {
        $elements = parse_url($tag['children'][0]);
        if (isset($elements['host'])) {
            return $elements['host'];
        }
        return null;
    }
}