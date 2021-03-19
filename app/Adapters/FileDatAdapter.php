<?php


namespace App\Adapters;


use App\Interfaces\FileTypeInterface;
use App\StandardsClasses\FileResult;
use App\StandardsClasses\SaleItem;

class FileDatAdapter implements FileTypeInterface
{
    /**
     * @var string
     */
    const CLIENT_DAT = "002";
    /**
     * @var string
     */
    const SALE_DAT = "003";
    /**
     * @var string
     */
    const SALESMAN_DAT = "001";
    /**
     * @var string
     */
    private $file;

    /**
     * @var array
     */
    private $vendedores;

    /**
     * @var FileResult
     */
    private $objResult;

    /**
     * FileDat constructor.
     * @param $file
     */
    public function __construct($file = "")
    {
        $this->file = $file;
        $this->vendedores = collect([]);
        $this->objResult = new FileResult();
    }

    /**
     * @param $fileContent
     */
    public function setFile($fileContent)
    {
        $this->file = $fileContent;
    }

    /**
     * @return FileResult
     */
    public function analyze(): FileResult
    {
        $rows = explode("\n", $this->file);
        foreach ($rows as $row) {
            $this->processLine($row);
        }
        /**
         * Ordena as vendas pelo valor total
         */
        $sales = $this->orderSales();
        if ($sales->count() > 0) {
            /**
             * Primeira é a maior venda
             */
            $this->objResult->sale->setMoreexpresive($sales->first());
            /**
             * Ultima sera a pior venda, excluindo casos com vendas em mesmo valor
             */
            if ($sales->count() > 1)
                $this->objResult->sale->setLessexpresive($sales->last());
        }

        return $this->objResult;
    }

    /**
     * @param $row
     */
    private function processLine($row)
    {
        $m = explode(",", $row);
        if (!empty($m[0])) {
            $id = $m[0];
            switch ($id) {
                case self::CLIENT_DAT:
                    $this->objResult->client->addCount();
                    $this->objResult->client->addRow($m);
                    break;
                case self::SALE_DAT:
                    $this->objResult->sale->addCount();
                    $row = $this->filterSaleItem($row);
                    $this->objResult->sale->addRow($row);
                    break;
                case self::SALESMAN_DAT:
                    $this->objResult->salesman->addCount();
                    $this->objResult->salesman->addRow($m);
                    break;
            }
        }
    }

    /**
     * @param $row
     */
    private function filterSaleItem($row)
    {
        $patterItems = "/\[(.*?)\]/";
        /**
         * Separa os dados da venda removendo os items da venda
         */
        $venda = explode(",", preg_replace($patterItems, "", $row));
        preg_match($patterItems, $row, $mat);

        $returnArray = [
            "id" => $venda[1],
            "salesman" => end($venda),
            "items" => collect()
        ];

        if (count($mat) > 1 && !empty($sales = last($mat))) {
            /**
             * Transformando a string em um array com explode
             * Convertendo todas as linhas em objetos
             *
             */
            $sales = explode(",", $sales);
            $salesTable = array_map(function ($sale) {
                $sale = preg_split("/([^.0-9]+)/",
                    preg_replace("/\s+/", "", $sale));
                return new SaleItem($sale);
            }, $sales);
            $salesTable = collect($salesTable);
            $returnArray["items"] = $salesTable;
            $returnArray["total"] = $salesTable->sum("total");
        }

        return $returnArray;
    }

    /**
     * - First is the more expressive sale
     * - Last is the less expressive sale
     */
    private function orderSales()
    {
        return $this->objResult->sale->getRow()->sortBy("total", SORT_REGULAR, true);
    }

    /**
     * @return array
     */
    public function fileToArray(): array
    {
        return [
            "salesman" => [
                "count" => $this->objResult->salesman->getCount(),
                "avarage_wage" => $this->objResult->salesman->getRow()->avg(fn ($it) => ($it[3] ?? 0)),
                "worst_seller" => $this->objResult->salesman->getRow()
                    ->filter(fn ($salesman) =>
                    ($salesman[2] == ($this->objResult->sale->getLessexpresive()['salesman']?? "")))
                    ->first()
            ],
            "customer" => [
                "count" => $this->objResult->client->getCount()
            ],
            "sale" => [
                "most_expensive" => $this->objResult->sale->getMoreexpresive()['id'] ?? null
            ]
        ];
    }
}
