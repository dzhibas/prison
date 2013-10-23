<?php
namespace Prison\Controller;

use Prison\Entity;
use Prison\Form;
use Prison\Filter;
use Zend\View\Model\ViewModel;

class TeamController extends AbstractController
{
    public function newAction()
    {
        $this->loginRequired();

        $form = new Form\Team();

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $name = $form->get("name")->getValue();

                /** @var \Doctrine\ORM\EntityManager $em */
                $em = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
                $team = $em->getRepository('Prison\Entity\Team')->findOneBy(array("name" => $name));

                if (!$team) {
                    $team = new Entity\Team();

                    $team->setName($name);
                    $slugifyFilter = new Filter\Slugify();
                    $team->setSlug($slugifyFilter->filter($name));
                    $team->setDateAdded(new \DateTime("now"));
                    $team->setOwner($this->getIdentity());

                    $em->persist($team);
                    $em->flush();

                    return $this->redirect()->toRoute("prison/team", array("slug" => $team->getSlug()));
                } else {
                    $this->flashMessenger()->addMessage("This team already exists");
                    return $this->redirect()->toRoute("prison/team", array("slug" => $team->getSlug()));
                }
            } else {
                $this->flashMessenger()->addMessage("Please provide name");
            }
        }

        return new ViewModel(array(
            "form" => $form
        ));
    }

    public function indexAction()
    {
        $this->loginRequired();

        $teamSlug = $this->params()->fromRoute("slug", null);

        if (!$teamSlug) {
            // check if user has team created
            if ($this->hasIdentity() && sizeof($this->getIdentity()->getTeams()) > 0)
            {
                /** @var \Prison\Entity\Team $team */
                $team = array_pop($this->getIdentity()->getTeams()->toArray());
                return $this->redirect()->toRoute("prison/team", array("slug" => $team->getSlug()));
            }
        } else {
            /** @var \Doctrine\ORM\EntityManager $em */
            $em = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
            $team = $em->getRepository('Prison\Entity\Team')->findOneBy(array("slug" => $teamSlug, "owner" => $this->getIdentity()));
        }

        if (!$team) {
            $this->redirect()->toRoute("prison/team-new");
        }

        return new ViewModel(array("team" => $team));
    }
} 