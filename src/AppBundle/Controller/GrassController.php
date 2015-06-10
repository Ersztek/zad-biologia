<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Grass;
use AppBundle\Form\GrassType;

/**
 * Grass controller.
 *
 * @Route("/admin/grass")
 */
class GrassController extends Controller
{

    /**
     * Lists all Grass entities.
     *
     * @Route("/", name="admin_grass")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Grass')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Grass entity.
     *
     * @Route("/", name="admin_grass_create")
     * @Method("POST")
     * @Template("AppBundle:Grass:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Grass();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_grass_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Grass entity.
     *
     * @param Grass $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Grass $entity)
    {
        $form = $this->createForm(new GrassType(), $entity, array(
            'action' => $this->generateUrl('admin_grass_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Grass entity.
     *
     * @Route("/new", name="admin_grass_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Grass();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Grass entity.
     *
     * @Route("/{id}", name="admin_grass_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Grass')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Grass entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Grass entity.
     *
     * @Route("/{id}/edit", name="admin_grass_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Grass')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Grass entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Grass entity.
    *
    * @param Grass $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Grass $entity)
    {
        $form = $this->createForm(new GrassType(), $entity, array(
            'action' => $this->generateUrl('admin_grass_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Grass entity.
     *
     * @Route("/{id}", name="admin_grass_update")
     * @Method("PUT")
     * @Template("AppBundle:Grass:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Grass')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Grass entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_grass_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Grass entity.
     *
     * @Route("/{id}", name="admin_grass_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Grass')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Grass entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_grass'));
    }

    /**
     * Creates a form to delete a Grass entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_grass_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
