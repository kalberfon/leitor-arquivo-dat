<?php

namespace Tests\Feature;

use App\Adapters\FileDatAdapter;
use App\Managers\DatManager;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReadDatFileTest extends TestCase
{
    /**
     * Test file read metrics
     *
     * @return void
     */
    public function test_metrics_files()
    {

        Storage::disk('dat')->put('/in/test_metrics_files.dat',
            "001,1234567891234,Steve,80000
                    001,3245678865434,Elias,60000.99
                    002,2345675434544345,Rita Ruggs,Rural
                    002,2345675433444345,Dianne Bragg,Rural
                    003,10,[1-10­100, 2­30­2. 50, 3­40­3. 10] ,Steve
                    003,08,[1­34­10, 2­33­1. 50, 3­40­0. 10] ,Elias");
        $fileDat = new FileDatAdapter(Storage::disk('dat')->get('in/test_metrics_files.dat'));
        $fileResult = $fileDat->analyze();

        // Teste de quantidade
        $this->assertTrue($fileResult->sale->getCount() === 2);
        $this->assertTrue($fileResult->salesman->getCount() === 2);
        $this->assertTrue($fileResult->client->getCount() === 2);

        // Testar a maior compra
        $moreExpressive = $fileResult->sale->getMoreexpresive();
        $this->assertArrayHasKey('id', $moreExpressive);
        $this->assertArrayHasKey('salesman', $moreExpressive);
        $this->assertArrayHasKey('items', $moreExpressive);
        $this->assertArrayHasKey('total', $moreExpressive);
        $this->assertTrue((float)$moreExpressive['total'] === 1199.0);
        $this->assertTrue((int)$moreExpressive['id'] === 10);

        // Testar a menor compra
        $lessexpressive = $fileResult->sale->getLessexpresive();
        $this->assertArrayHasKey('id', $lessexpressive);
        $this->assertArrayHasKey('salesman', $lessexpressive);
        $this->assertArrayHasKey('items', $lessexpressive);
        $this->assertArrayHasKey('total', $lessexpressive);
        $this->assertTrue((float)$lessexpressive['total'] === 393.5);
    }
    /**
     * Test file output
     *
     * @return void
     */
    public function test_datManager()
    {
        Storage::disk('dat')->put('/in/test_datManager.dat',
            "001,1234567891234,Steve,80000
                    001,3245678865434,Elias,60000.99
                    002,2345675434544345,Rita Ruggs,Rural
                    002,2345675433444345,Dianne Bragg,Rural
                    003,10,[1-10­100, 2­30­2. 50, 3­40­3. 10] ,Steve
                    003,08,[1­34­10, 2­33­1. 50, 3­40­0. 10] ,Elias
                    ");
        (new DatManager())->processIn();
        $this->assertTrue(Storage::disk('dat')->exists('out/test_datManager.done.dat'));
    }
}
