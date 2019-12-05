<?php
    namespace App\Controller;

    use App\Entity\Article; 
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    Class ArticleController extends Controller {
        /**
         * @Route("/", name="article_list")
         */
        public function index() {
            $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

            return $this->render('Articles/BaseArticle.html.twig', array('articles' => $articles));
        }
        
        /**
         * @Route("/article/{id}", name="article_show")
         */
        public function mostraArticolo($id) {
            $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

            return $this->render('Articles/show.html.twig', array('article' => $article) );
        }

        /**
         * @Route("/new", name="article_new")
         */
        public function new() {
            return $this->render('Articles/newArticle.html.twig', array('stato' => 'carica qualcosa'));
        }

        /**
         * @Route("/save", name="article_save")
         */
        public function salva() {
            $titolo = $_GET['titolo'];
            $contenuto = $_GET['contenuto'];

            $entityManager = $this->getDoctrine()->getManager();
            $article = new Article();

            $article->setTitle($titolo);
            $article->setBody($contenuto);

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->render('Articles/newArticle.html.twig', array('stato' => 'caricato!'));
        }

        /**
         * @Route("/delete/{id}", name="article_delete")
         */
        public function delete($id) {
            $entityManager = $this->getDoctrine()->getManager();
            $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

            $entityManager->remove($article);
            $entityManager->flush();

            $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
            
            return $this->render('Articles/BaseArticle.html.twig', array('articles' => $articles));
        }
        
    }