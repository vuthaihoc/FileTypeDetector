<?php
namespace Dok123\test\FileTypeDetector;

use PHPUnit\Framework\TestCase;
use Dok123\FileTypeDetector\Detector;

class DetectorTest extends TestCase {
    /**
     * @dataProvider filenamesWithTypes()
     */
    public function testDetectionByFilename($filename, $expectedType) {
        $this->assertEquals($expectedType, Detector::detectByFilename($filename));
    }

    public function filenamesWithTypes() {
        return array(
            array('image.jpg', array(Detector::IMAGE, Detector::JPEG, 'image/jpeg')),
            array('music.mp3', array(Detector::AUDIO, Detector::MP3, 'audio/mpeg'))
        );
    }

    /**
     * @dataProvider streamsWithTypes()
     */
    public function testDetectionByContent($binary, $expectedType) {
        $fp = fopen('php://temp', 'r+');
        if (is_array($binary)) $binary = implode(null, array_map(function ($code) { return chr($code); }, $binary));
        fwrite($fp, $binary);
        rewind($fp);
        $this->assertEquals($expectedType, Detector::detectByContent($fp));
        fclose($fp);
    }

    public function streamsWithTypes() {
        return array(
            array(array(0x89, 0x50, 0x4E, 0x47, 0x0D, 0x0A, 0x1A, 0x0A), array(Detector::IMAGE, Detector::PNG, 'image/png')),
            array(array(0x1F, 0x8B), array(Detector::ARCHIVE, Detector::GZIP, 'application/gzip'))
        );
    }

    /**
     * @dataProvider filenamesWithTypes()
     */
    public function testMimetypeGeneration($filename, $expectedType) {
        $this->assertEquals($expectedType[2], Detector::getMimeType($filename));
    }
	
	public function testDetectionByPngUrl() {
		$source = "http://img.vth8.com:9981/images/2017/12/24/Videos.png";
		$file = __DIR__ . "/image_test.png";
		$actual = Detector::detectByContent( $source);
		$expected = Detector::detectByContent( $file);
		$this->assertEquals( $expected, $actual);
	}
}
