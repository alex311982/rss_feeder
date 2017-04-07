<?php

namespace ComponentBundle\Response;

class DataResponse
{
   protected $data;

   protected $total;

    /**
     * DataResponse constructor.
     * @param $data
     * @param $total
     */
    public function __construct(array $data, int $total)
    {
        $this->data = $data;
        $this->total = $total;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return count($this->data);
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }
}
