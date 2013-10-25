<?php
namespace Prison\Controller;

use Prison\Filter\Slugify;
use Prison\Service\ProjectService;
use Zend\Http\Response;
use Prison\Form;
use Prison\Entity;
use Zend\View\Model\ViewModel;

class ProjectController extends AbstractController
{
    public function newAction()
    {
        $r = $this->loginRequired();
        if ($r instanceof Response) return $r;

        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->serviceLocator->get('Doctrine\ORM\EntityManager');

        $teamSlug = $this->params()->fromRoute("teamslug", null);
        if (!$teamSlug) return $this->redirect()->toRoute("prison/team");
        /** @var Entity\Team $team */
        $team = $em->getRepository('Prison\Entity\Team')->findOneBy(array("slug" => $teamSlug));
        if (!$team) return $this->redirect()->toRoute("prison/team");

        $projectForm = new Form\Project($this->serviceLocator);

        if ($this->request->isPost())
        {
            $projectForm->setData($this->request->getPost());
            if ($projectForm->isValid()) {
                $slugify = new Slugify();

                $project = $em->getRepository('Prison\Entity\Project')->findOneBy(array('name' => $projectForm->get('name')->getValue()));

                if (!$project) {

                    $project = new Entity\Project();
                    $project->setName($projectForm->get("name")->getValue());
                    $project->setDateAdded(new \DateTime("now"));
                    $project->setPlatform($projectForm->get("platform")->getValue());
                    $project->setSlug($slugify->filter($project->getName()));
                    $project->setOwner($this->getIdentity());
                    $project->setTeam($team);

                    $em->persist($project);

                    $projectKey = new Entity\ProjectKey();
                    $projectKey->setProject($project);
                    $projectKey->setUser($this->getIdentity());
                    $projectKey->setUserAdded($this->getIdentity());
                    $projectKey->setDateAdded(new \DateTime("now"));
                    $projectKey->generateKeys();

                    $em->persist($projectKey);

                    $em->flush();

                    return $this->redirect()->toRoute("prison/project-doc", array(
                        "team" => $team->getSlug(),
                        "project" => $project->getSlug(),
                        "platform" => "php",
                    ));
                } else {
                    $this->flashMessenger()->addErrorMessage("Such project name already exists");
                }
            } else {
                $this->flashMessenger()->addErrorMessage("Please fill in all required fields");
            }
        }

        return new ViewModel(
            array(
                "form" => $projectForm
            )
        );
    }

    public function indexAction()
    {
        $r = $this->loginRequired();
        if ($r instanceof Response) return $r;

        $teamSlug = $this->params()->fromRoute('teamslug', null);

        if (!$teamSlug) return $this->redirect()->toRoute('prison/team');

        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
        /** @var Entity\Team $team */
        $team = $em->getRepository('Prison\Entity\Team')->findOneBy(array('slug' => $teamSlug));

        if (!$team) return $this->redirect()->toRoute('prison/team');

        $projects = $team->getProjects();

        if (sizeof($projects) == 0)
            return $this->redirect()->toRoute('prison/project-new', array('teamslug' => $team->getSlug()));

        return new ViewModel(array(
            'projects' => $projects,
            'team' => $team,
        ));
    }

    public function docsAction()
    {
        $r = $this->loginRequired();
        if ($r instanceof Response) return $r;

        $teamSlug = $this->params()->fromRoute("team", null);
        $projectSlug = $this->params()->fromRoute("project", null);
        $platformName = $this->params()->fromRoute("platform", null);

        $config = $this->serviceLocator->get("config");

        // specified platform is not in our list
        if (!in_array($platformName, $config['prison']['platforms'])) {
            return $this->redirect()->toRoute("prison");
        }

        $projectService = new ProjectService($this->serviceLocator);
        $project = $projectService->getProjectBySlug($projectSlug);

        if (!$project) return $this->redirect()->toRoute('prison');

        $keys = $project->getKeys()->toArray();

        $vm = new ViewModel(array("key" => array_pop($keys)));
        $vm->setTemplate("prison/docs/php.twig");
        $test = $this->serviceLocator->get('ZfcTwigRenderer')->render($vm);

        $context = array(
            'team' => $project->getTeam(),
            'project' => $project,
            'platform' => $platformName,
            'documentation' => $test
        );

        return new ViewModel($context);
    }
}