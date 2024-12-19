namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/cours", name="admin_cours")
     */
    public function gestionCours(Request $request, CoursRepository $coursRepository): Response
    {
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cours);
            $entityManager->flush();

            return $this->redirectToRoute('admin_cours');
        }

        return $this->render('admin/cours.html.twig', [
            'form' => $form->createView(),
            'cours' => $coursRepository->findAll(),
        ]);
    }
}
