<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Helpers\StringHelper;

class StringHelperTest extends TestCase
{
    public function testUpperCase()
    {
        $helper = new StringHelper;
        $text = 'luis rosas';
        $out = $helper->toUpperCase($text);

        $this->assertEquals('LUIS ROSAS', $out);
    }

    public function testLowerCase()
    {
        $helper = new StringHelper;
        $text = 'LUIS ROSAS';
        $out = $helper->toLowerCase($text);

        $this->assertEquals('luis rosas', $out);
    }

    public function testPruebas()
    {
        $helper = new StringHelper;
        $texto = 'PruEBas DE soFtWare';
        $out = $helper->toLowerCase($texto);

        $this->assertEquals($out, 'pruebas de software');
    }
}
