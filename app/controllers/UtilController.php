<?php

class UtilController extends BaseController
{
    /**
     * @see http://www.webgeekly.com/tutorials/php/how-to-create-an-image-thumbnail-on-the-fly-using-php/
     */
    public function thumb()
    {

        // Try to serve from cache first
        $cachedThumb = public_path() . '/photos/thumbs/'. md5($_SERVER['QUERY_STRING']);
        $this->_serveCached($cachedThumb);

        $sImagePath = public_path() .DS. Input::get("file");
        // dd($sImagePath);

        // If you want exact dimensions, you will pass 'width' and 'height'
        $iThumbnailWidth = (int)Input::get('width');
        $iThumbnailHeight = (int)Input::get('height');

        // If you want proportional thumbnails, you will pass 'maxw' and 'maxh'
        $iMaxWidth = (int)Input::get("maxw");
        $iMaxHeight = (int)Input::get("maxh");

        if ($iMaxWidth && $iMaxHeight) $sType = 'scale';
        else if ($iThumbnailWidth && $iThumbnailHeight) $sType = 'exact';
        else $sType = "exact";

        $img = NULL;

        $sExtensionParts = explode('.', $sImagePath);
        $sExtension = strtolower(end($sExtensionParts));
        if ($sExtension == 'jpg' || $sExtension == 'jpeg') {

            $img = @imagecreatefromjpeg($sImagePath)
                or die("Cannot create new JPEG image");

        } else if ($sExtension == 'png') {

            $img = @imagecreatefrompng($sImagePath)
                or die("Cannot create new PNG image");

        } else if ($sExtension == 'gif') {

            $img = @imagecreatefromgif($sImagePath)
                or die("Cannot create new GIF image");

        }

        if ($img) {

            $iOrigWidth = imagesx($img);
            $iOrigHeight = imagesy($img);

            if ($sType == 'scale') {

                // Get scale ratio

                $fScale = min($iMaxWidth/$iOrigWidth,
                    $iMaxHeight/$iOrigHeight);

                if ($fScale < 1) {

                    $iNewWidth = floor($fScale*$iOrigWidth);
                    $iNewHeight = floor($fScale*$iOrigHeight);

                    $tmpimg = imagecreatetruecolor($iNewWidth,
                        $iNewHeight);

                    imagecopyresampled($tmpimg, $img, 0, 0, 0, 0,
                        $iNewWidth, $iNewHeight, $iOrigWidth, $iOrigHeight);

                    imagedestroy($img);
                    $img = $tmpimg;
                }

            } else if ($sType == "exact") {

                $fScale = max($iThumbnailWidth/$iOrigWidth,
                    $iThumbnailHeight/$iOrigHeight);

                if ($fScale < 1) {

                    $iNewWidth = floor($fScale*$iOrigWidth);
                    $iNewHeight = floor($fScale*$iOrigHeight);

                    $tmpimg = imagecreatetruecolor($iNewWidth,
                        $iNewHeight);
                    $tmp2img = imagecreatetruecolor($iThumbnailWidth,
                        $iThumbnailHeight);

                    imagecopyresampled($tmpimg, $img, 0, 0, 0, 0,
                        $iNewWidth, $iNewHeight, $iOrigWidth, $iOrigHeight);

                    if ($iNewWidth == $iThumbnailWidth) {

                        $yAxis = ($iNewHeight/2)-
                            ($iThumbnailHeight/2);
                        $xAxis = 0;

                    } else if ($iNewHeight == $iThumbnailHeight)  {

                        $yAxis = 0;
                        $xAxis = ($iNewWidth/2)-
                            ($iThumbnailWidth/2);

                    }

                    imagecopyresampled($tmp2img, $tmpimg, 0, 0,
                        $xAxis, $yAxis,
                        $iThumbnailWidth,
                        $iThumbnailHeight,
                        $iThumbnailWidth,
                        $iThumbnailHeight);

                    imagedestroy($img);
                    imagedestroy($tmpimg);
                    $img = $tmp2img;
                }

            }

            $this->_sendThumbHeaders();

            imagejpeg($img, $cachedThumb);// Cache for future
            header('Content-Length: '. filesize($cachedThumb));
            imagejpeg($img);
            die;
        }

    }

    private function _serveCached($cachedThumb)
    {
        if(file_exists($cachedThumb)) {
            $this->_sendThumbHeaders();
            header('Content-Length:'. filesize($cachedThumb));
            readfile($cachedThumb);
            die;
        }

        if(! file_exists(public_path() . '/photos/thumbs')) {
            mkdir(public_path() . '/photos/thumbs', 0777);
        }
    }

    private function _sendThumbHeaders()
    {
        header("Content-type: image/jpeg");
        header('Content-Transfer-Encoding', 'binary');
        header('Cache-Control', 'public, max-age=10800, pre-check=10800');
        header('Pragma', 'public');
        header('Expires: ' . date(DATE_RFC822, strtotime('12 hour')));
    }

}