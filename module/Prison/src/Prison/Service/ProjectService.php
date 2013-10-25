<?php
namespace Prison\Service;

class ProjectService extends ServiceAbstract
{
    /**
     * returns project by slug
     *
     * @param $slug
     * @return \Prison\Entity\Project
     */
    public function getProjectBySlug($slug)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        return $em->getRepository('Prison\Entity\Project')->findOneBy(array('slug' => $slug));
    }
} 