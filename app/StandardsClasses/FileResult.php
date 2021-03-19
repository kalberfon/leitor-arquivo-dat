<?php


namespace App\StandardsClasses;


/**
 * Class FileResult
 * @package App\StandardsClasses
 */
class FileResult
{
    /**
     * @var Client
     */
    public $client;
    /**
     * @var Sale
     */
    public $sale;
    /**
     * @var SalesMan
     */
    public $salesman;

    public function __construct()
    {
        $this->client = new Client();
        $this->sale = new Sale();
        $this->salesman = new SalesMan();
    }
}

/**
 * Class Count
 * @package App\StandardsClasses
 */
class Count
{
    /**
     * @var int
     */
    private $count = 0;
    /**
     * @var \Illuminate\Support\Collection
     */
    private $row;

    /**
     * Count constructor.
     */
    public function __construct()
    {
        $this->row  = collect();
    }

    /**
     * @param $row
     */
    public function addRow($row): void
    {
        $this->row->add($row);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getRow(): \Illuminate\Support\Collection
    {
        return $this->row;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return void
     */
    public function addCount(): void
    {
        $this->count ++;
    }
    /**
     * @param $name
     * @param $value
     */
    public function setCount($value): void
    {
        $this->count = $value;
    }
}

/**
 * Class Client
 * @package App\StandardsClasses
 */
class Client extends Count
{
// ...
}

/**
 * Class Sale
 * @package App\StandardsClasses
 */
class Sale extends Count
{
    /**
     * @var array
     */
    private $moreexpresive = [];
    /**
     * @var array
     */
    private $lessexpresive = [];

    /**
     * @return array
     */
    public function getMoreexpresive(): array
    {
        return $this->moreexpresive;
    }

    /**
     * @param array $moreexpresive
     */
    public function setMoreexpresive(array $moreexpresive): void
    {
        $this->moreexpresive = $moreexpresive;
    }

    /**
     * @return array
     */
    public function getLessexpresive(): array
    {
        return $this->lessexpresive;
    }

    /**
     * @param array $lessexpresive
     */
    public function setLessexpresive(array $lessexpresive): void
    {
        $this->lessexpresive = $lessexpresive;
    }
}

/**
 * Class SalesMan
 * @package App\StandardsClasses
 */
class SalesMan extends Count
{
    /**
     * @var array
     */
    private $saleList = [];

    /**
     * @return array
     */
    public function getSaleList(): array
    {
        return $this->saleList;
    }

    /**
     * @param array $saleList
     */
    public function setSaleList(array $saleList): void
    {
        $this->saleList = $saleList;
    }
}
