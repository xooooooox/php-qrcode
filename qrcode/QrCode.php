<?php

namespace xooooooox\qrcode;

use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

/**
 * Class QrCode
 * @package xooooooox\qrcode
 */
class QrCode
{

    /**
     * QR code file save path prefix
     * @var string
     */
    public string $QrCodePrefixDirectory = '/var/images/';

    /**
     * Saving path of QR code file
     * @var string
     */
    public string $QrCodeDirectory = '/qrcode/';

    /**
     * Suffix of QR code file
     * @var string
     */
    public string $QrCodeFileSuffix = '.png';

    /**
     * QrCode constructor.
     * @param string $QrCodePrefixDirectory
     * @param string $QrCodeDirectory
     */
    public function __construct(string $QrCodePrefixDirectory = '', string $QrCodeDirectory = '') {
        if ($QrCodePrefixDirectory !== ''){
            if (!self::StringHasSuffix($QrCodePrefixDirectory,DIRECTORY_SEPARATOR)){
                $QrCodePrefixDirectory = $QrCodePrefixDirectory.DIRECTORY_SEPARATOR;
            }
            $this->QrCodePrefixDirectory = $QrCodePrefixDirectory;
        }
        if ($QrCodeDirectory !== ''){
            if (!self::StringHasSuffix($QrCodeDirectory,DIRECTORY_SEPARATOR)){
                $QrCodeDirectory = $QrCodeDirectory.DIRECTORY_SEPARATOR;
            }
            $this->QrCodeDirectory = $QrCodeDirectory;
        }
        $this->VerifyDirectoryExist();
    }

    /**
     * String Has Suffix
     * @param string $Str
     * @param string $Suffix
     * @return bool
     */
    public static function StringHasSuffix(string $Str, string $Suffix) : bool {
        $length = strlen($Suffix);
        if ($length === 0){
            return true;
        }
        return (substr($Str,-$length) === $Suffix);
    }

    /**
     * Verify Directory
     * @param string $Directory
     * @return string
     */
    public function VerifyDirectory(string $Directory) : string {
        return str_replace(DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR,DIRECTORY_SEPARATOR,$Directory);
    }

    /**
     * Verify Directory Exist
     */
    public function VerifyDirectoryExist() {
        $dir = $this->QrCodePrefixDirectory.$this->QrCodeDirectory;
        $dir = $this->VerifyDirectory($dir);
        if (!is_dir($dir)){
            mkdir($dir,0755,true);
        }
    }

    /**
     * New QrCode
     * @param string $QrCodePrefixDirectory
     * @param string $QrCodeDirectory
     * @return QrCode
     */
    public static function Newer(string $QrCodePrefixDirectory = '', string $QrCodeDirectory = '') : QrCode {
        return new self($QrCodePrefixDirectory,$QrCodeDirectory);
    }

    /**
     * Create QrCode
     * @param string $Content
     * @param string $Filename
     * @return string
     */
    public function Create(string $Content, string $Filename) : string {
        $this->VerifyDirectoryExist();
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);
        $dir = $this->VerifyDirectory($this->QrCodePrefixDirectory.$this->QrCodeDirectory);
        $file = $dir.$Filename.$this->QrCodeFileSuffix;
        $writer->writeFile($Content, $file);
        return $this->QrCodeDirectory.$Filename.$this->QrCodeFileSuffix;
    }

    /**
     * Remove QrCode
     * @param string $Filename
     * @return bool
     */
    public function Remove(string $Filename) : bool {
        $dir = $this->VerifyDirectory($this->QrCodePrefixDirectory.$this->QrCodeDirectory);
        $file = $dir.$Filename.$this->QrCodeFileSuffix;
        if (is_file($file)){
            return unlink($file);
        }
        return false;
    }

}