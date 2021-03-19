<?php


namespace App\StandardsClasses;


/**
 * Class SaleItem
 * @package App\StandardsClasses
 */
class SaleItem
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var float
     */
    public $qtd = 0;
    /**
     * @var float
     */
    public $value = 0;

    /**
     * @var float
     */
    public $total = 0;

    /**
     * SaleItem constructor.
     * @param array $sale
     */
    public function __construct(array $sale)
    {
        $this->id = (float)$sale[0] ?? 0;
        $this->qtd = (float)$sale[1] ?? 0;
        $this->value  = (float)$sale[2] ?? 0;

        $this->total = (float)($this->qtd * $this->value);
    }
}
