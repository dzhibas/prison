<?php
namespace Prison\Controller;


use Prison\Entity\ProjectKey;
use Prison\Service\ProjectService;
use Zend\Http\Response;

class KeyController extends AbstractController
{
    public function newAction()
    {
        $r = $this->loginRequired();
        if ($r instanceof Response) return $r;

        $teamSlug = $this->params()->fromRoute('team');
        $projectSlug = $this->params()->fromRoute('project');
        $ps = new ProjectService($this->serviceLocator);
        $project = $ps->getProjectBySlug($projectSlug);

        // add new key can only project owner
        if (!$project && $project->getOwner() != $this->getIdentity()) return $this->redirect()->toRoute('prison');

        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->serviceLocator->get('Doctrine\ORM\EntityManager');

        $projectKey = new ProjectKey();
        $projectKey->setProject($project);
        $projectKey->setUserAdded($this->getIdentity());
        $projectKey->setUser($this->getIdentity());
        $projectKey->setDateAdded(new \DateTime('now'));

        $projectKey->generateKeys();

        $em->persist($projectKey);
        $em->flush();

        return $this->redirect()->toRoute('prison/project/keys', array('project' => $projectSlug, 'team' => $teamSlug));
    }

    public function revokeAction()
    {
        $key = $this->params()->fromRoute('key', null);
        if (!$key) return $this->redirect()->toRoute('prison');

        /** @var \Prison\Entity\ProjectKey $key */
        $key = $this->getEm()->getRepository('Prison\Entity\ProjectKey')->find($key);
        if (!$key || $key->getUser() != $this->getIdentity()) return $this->redirect()->toRoute('prison');

        $project = $key->getProject();

        // remove can only project owner
        if ($project->getOwner() != $this->getIdentity()) {
            return $this->redirect()->toRoute('prison');
        }

        $team = $project->getTeam();

        $this->getEm()->remove($key);
        $this->getEm()->flush();

        return $this->redirect()->toRoute('prison/project/keys',
            array('project' => $project->getSlug(), 'team' => $team->getSlug()));
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEm()
    {
        return $this->serviceLocator->get('Doctrine\ORM\EntityManager');
    }
}