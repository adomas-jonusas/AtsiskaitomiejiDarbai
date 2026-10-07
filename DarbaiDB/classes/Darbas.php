<?php

class Darbas
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function gautiVisus(): array
    {
        $statement = $this->connection->prepare(
            'SELECT *, (atliktas = 0 AND laikas IS NOT NULL AND laikas < NOW()) AS paveluotas
             FROM darbai
             ORDER BY atliktas ASC, laikas IS NULL ASC, laikas ASC, id ASC'
        );
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function prideti(string $darbas, ?string $laikas): void
    {
        $statement = $this->connection->prepare(
            'INSERT INTO darbai (darbas, laikas) VALUES (?, ?)'
        );
        $statement->execute([$darbas, $laikas]);
    }

    public function pazymetiAtlikta(int $id): void
    {
        $statement = $this->connection->prepare(
            'UPDATE darbai SET atliktas = 1 WHERE id = ?'
        );
        $statement->execute([$id]);
    }
}
