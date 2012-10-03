<?php
namespace Universibo\Bundle\LegacyBundle\Entity;
use Doctrine\DBAL\Driver\Connection;

/**
 * Facolta repository
 *
 * @author Davide Bellettini <davide.bellettini@gmail.com>
 * @license GPL v2 or later
 */
class FacoltaRepository extends DoctrineRepository
{
    /**
     * @var CanaleRepository
     */
    private $canaleRepository;

    public function __construct(Connection $db, CanaleRepository $canaleRepository)
    {
        parent::__construct($db);

        $this->canaleRepository = $canaleRepository;
    }

    /**
     * @return Facolta
     */
    public function find($id)
    {
        $db = $this->getConnection();

        $query = 'SELECT tipo_canale, nome_canale, immagine, visite, ultima_modifica, permessi_groups, files_attivo, news_attivo, forum_attivo, id_forum, group_id, links_attivo, files_studenti_attivo, a.id_canale, cod_fac, desc_fac, url_facolta FROM canale a , facolta b WHERE a.id_canale = b.id_canale AND a.id_canale = '
                . $db->quote($id) . ' ORDER BY 16';
        $res = $db->executeQuery($query);

        if ($res->rowCount() === 0) {
            return array();
        }

        $facolta = null;

        if (false !== ($row = $res->fetch(\PDO::FETCH_NUM))) {
            $facolta = new Facolta($row[13], $row[5], $row[4], $row[0],
                    $row[2], $row[1], $row[3], $row[7] == 'S', $row[6] == 'S',
                    $row[8] == 'S', $row[9], $row[10], $row[11] == 'S',
                    $row[12] == 'S', $row[14], $row[15], $row[16]);
        }

        return $facolta;
    }

    /**
     * @return Facolta[]
     */
    public function findAll()
    {
        $db = $this->getConnection();

        $query = 'SELECT tipo_canale, nome_canale, immagine, visite, ultima_modifica, permessi_groups, files_attivo, news_attivo, forum_attivo, id_forum, group_id, links_attivo, files_studenti_attivo, a.id_canale, cod_fac, desc_fac, url_facolta FROM canale a , facolta b WHERE a.id_canale = b.id_canale ORDER BY 16';
        $res = $db->executeQuery($query);

        if ($res->rowCount() === 0) {
            return array();
        }

        $facolta = array();

        while (false !== ($row = $res->fetch(\PDO::FETCH_NUM))) {
            $facolta[] = new Facolta($row[13], $row[5], $row[4], $row[0],
                    $row[2], $row[1], $row[3], $row[7] == 'S', $row[6] == 'S',
                    $row[8] == 'S', $row[9], $row[10], $row[11] == 'S',
                    $row[12] == 'S', $row[14], $row[15], $row[16]);
        }

        return $facolta;
    }

    public function update(Facolta $facolta)
    {
        $db = $this->getConnection();

        $query = 'UPDATE facolta SET cod_fac = '
                . $db->quote($facolta->getCodiceFacolta()) . ', desc_fac = '
                . $db->quote($facolta->getNome()) . ', url_facolta = '
                . $db->quote($facolta->getUri()) . ' WHERE id_canale = '
                . $db->quote($facolta->getIdCanale());

        $res = $db->executeQuery($query);

        $this->canaleRepository->update($facolta);
    }

    public function insert(Facolta $facolta)
    {
        $db = $this->getConnection();

        if ($this->canaleRepository->insert($facolta) != true) {
            $this->throwError('_ERROR_CRITICAL',
                    array('msg' => 'Errore inserimento Canale',
                            'file' => __FILE__, 'line' => __LINE__));

            return false;
        }

        $query = 'INSERT INTO facolta (cod_fac, desc_fac, url_facolta, id_canale) VALUES ('
        . $db->quote($facolta->getCodiceFacolta()) . ' , '
        . $db->quote($facolta->getNome()) . ' , '
        . $db->quote($facolta->getUri()) . ' , '
        . $db->quote($facolta->getIdCanale()) . ' )';
        $res = $db->executeQuery($query);

        return true;
    }

/**
     * @return Facolta
     */
    public function findOneByCodiceFacolta($codiceFacolta)
    {
        $db = $this->getConnection();

        $query = 'SELECT tipo_canale, nome_canale, immagine, visite, ultima_modifica, permessi_groups, files_attivo, news_attivo, forum_attivo, id_forum, group_id, links_attivo, files_studenti_attivo, a.id_canale, cod_fac, desc_fac, url_facolta FROM canale a , facolta b WHERE a.id_canale = b.id_canale AND b.cod_fac = '
                . $db->quote($codiceFacolta) . ' ORDER BY 16';
        $res = $db->executeQuery($query);

        if ($res->rowCount() === 0) {
            return array();
        }

        $facolta = null;

        if (false !== ($row = $res->fetch(\PDO::FETCH_NUM))) {
            $facolta = new Facolta($row[13], $row[5], $row[4], $row[0],
                    $row[2], $row[1], $row[3], $row[7] == 'S', $row[6] == 'S',
                    $row[8] == 'S', $row[9], $row[10], $row[11] == 'S',
                    $row[12] == 'S', $row[14], $row[15], $row[16]);
        }

        return $facolta;
    }
}
