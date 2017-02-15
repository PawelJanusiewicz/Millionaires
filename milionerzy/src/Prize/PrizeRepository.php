<?php


namespace Sda\Millionaires\Prize;


use Sda\Millionaires\Db\DbConnection;

class PrizeRepository
{
    /**
     * @var DbConnection
     */
    private $dbConnection;

    /**
     * PrizeRepsitory constructor.
     * @param DbConnection $dbConnection
     */
    public function __construct(DbConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /**
     * @param $actualPrize
     * @return PrizeCollection
     * @throws \InvalidArgumentException
     */
    public function getAllPrizes($actualPrize, $sort = 'ASC')
    {
        $query = $this->dbConnection->getConnection()->createQueryBuilder();

        $query
            ->select('*')
            ->from('prizes')
            ->orderBy('value', $sort)
        ;

        $sth = $query->execute();

        $data = $sth->fetchAll(\PDO::FETCH_ASSOC);

        $collection = new PrizeCollection();

        foreach ($data as $prize) {
            $collection->add(
                PrizeFactory::buildPrize($prize, $actualPrize)
            );
        }

        return $collection;
    }

}