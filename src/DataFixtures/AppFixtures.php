<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Writer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;
use App\Kernel;

class AppFixtures extends Fixture
{

    /**
     * @var string
     */
    private $baseDir;

    public function load(ObjectManager $manager)
    {
        $this->baseDir = substr(__DIR__,0, strrpos(__DIR__, '/'));
        $this->baseDir = substr($this->baseDir, 0, strrpos($this->baseDir, '/'));

        $writer = $this->generateWriter();
        $manager->persist($writer);
        $manager->flush();

        //create 3 articles
        for ($i = 0; $i < 3; $i++) {

            $article = $this->generateArticle($i, $manager);
            $manager->persist($article);
        }

        $manager->flush();
    }

    /**
     * @param int $i
     * @return Article
     */
    private function generateArticle($i, ObjectManager $manager)
    {
        $article = new Article();

        $articleTitle = 'News Headline no.' . ($i+1);
        $article->setTitle($articleTitle);
        $article->setSlug(str_replace(" ", "-", strtolower($articleTitle)));

        $articleAuthor = $manager->getRepository(Writer::class)
            ->findOneBy(['name' => 'Amanda Jones']);
        $article->setAuthor($articleAuthor);

        $article->setTimestamp(new \DateTime());

        $articleContent = "Far far away, behind the word mountains, far from the countries Vokalia and 
            Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of
            the Semantics, a large language ocean. A small river named Duden flows by their place and supplies
            it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences
            fly into your mouth.";
        $article->setContent($articleContent);

        switch ($i) {
            case 1:
                $path = 'images/asteroid.jpeg';
                break;
            case 2:
                $path = 'images/lightspeed.png';
                break;
            case 0:
            default:
                $path = 'images/meteor-shower.jpg';
                break;
        }
        $article->setImage($path);

        $comment = $this->generateComment('Jenny C.');
        $article->addComment($comment);

        return $article;

    }

    /**
     * @return Writer
     */
    private function generateWriter()
    {
        $writer = new Writer();
        $writer->setName('Amanda Jones');
        $writer->setEmail('amandaj001@mailinator.com');
        $writer->setDescription('Professional traveller with a questionable sense of humor.');
        $writer->setAvatar('images/alien-profile.png');

        return $writer;
    }

    /**
     * @return Comment
     */
    private function generateComment($authorName)
    {
        $comment = new Comment();
        $comment->setAuthor($authorName);
        $comment->setEmail('commenter@awesomesaucer.com');
        $msg = "Hooray for bulldogs!";
        $comment->setMessage($msg);
        $comment->setTimestamp(new \DateTime());

        return $comment;
    }

}