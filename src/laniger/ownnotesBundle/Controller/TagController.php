<?php

namespace laniger\ownnotesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use laniger\ownnotesBundle\Entity\Tag;
use laniger\ownnotesBundle\Form\TagType;

/**
 * Tag controller.
 *
 * @Route("/tag")
 */
class TagController extends Controller
{

    /**
     * Lists all Tag entities.
     *
     * @Route("/", name="tag")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('lanigerownnotesBundle:Tag')->findAll();

        return [
            'entities' => $entities,
        ];
    }
    /**
     * Creates a new Tag entity.
     *
     * @Route("/", name="tag_create")
     * @Method("POST")
     * @Template("lanigerownnotesBundle:Tag:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Tag();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tag_show', ['id' => $entity->getId()]));
        }

        return [
            'entity' => $entity,
            'form'   => $form->createView(),
        ];
    }

    /**
     * Creates a form to create a Tag entity.
     *
     * @param Tag $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Tag $entity)
    {
        $form = $this->createForm(new TagType(), $entity, [
            'action' => $this->generateUrl('tag_create'),
            'method' => 'POST',
        ]);

        $form->add('submit', 'submit', ['label' => 'label.save']);

        return $form;
    }

    /**
     * Displays a form to create a new Tag entity.
     *
     * @Route("/new", name="tag_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Tag();
        $form   = $this->createCreateForm($entity);

        return [
            'entity' => $entity,
            'form'   => $form->createView(),
        ];
    }

    /**
     * Finds and displays a Tag entity.
     *
     * @Route("/{id}", name="tag_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('lanigerownnotesBundle:Tag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('error.entity.not.found');
        }

        $deleteForm = $this->createDeleteForm($id);

        return [
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing Tag entity.
     *
     * @Route("/{id}/edit", name="tag_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('lanigerownnotesBundle:Tag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('error.entity.not.found');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return [
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
    * Creates a form to edit a Tag entity.
    *
    * @param Tag $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Tag $entity)
    {
        $form = $this->createForm(new TagType(), $entity, [
            'action' => $this->generateUrl('tag_update', ['id' => $entity->getId()]),
            'method' => 'PUT',
        ]);

        $form->add('submit', 'submit', ['label' => 'label.save']);

        return $form;
    }
    /**
     * Edits an existing Tag entity.
     *
     * @Route("/{id}", name="tag_update")
     * @Method("PUT")
     * @Template("lanigerownnotesBundle:Tag:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('lanigerownnotesBundle:Tag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('error.entity.not.found');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tag_edit', ['id' => $id]));
        }

        return [
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }
    /**
     * Deletes a Tag entity.
     *
     * @Route("/{id}", name="tag_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('lanigerownnotesBundle:Tag')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('error.entity.not.found');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tag'));
    }

    /**
     * Creates a form to delete a Tag entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tag_delete', ['id' => $id]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', ['label' => 'label.delete'])
            ->getForm()
        ;
    }
}
