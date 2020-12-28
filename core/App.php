<?php
namespace Framework;

use Psr\Http\Message\ServerRequestInterface;
use Framework\config\Config;
use Framework\Entity;
use Framework\Router\Router;
use Framework\Router\RouterTwigExtention;
use GuzzleHttp\Psr7\ServerRequest;

class App
{
    /**
     * Mysql instance
     *
     * @var Object
     */
    protected $bdd;
    /**
     * Config instance
     *
     * @var Object
     */
    private $router;

    public $container;

    public function __construct(ServerRequestInterface $request)
    {
        $this->container = new Container();
        
        $this->container->set($this->container);
        $this->request = $this->container->set($request);
        $this->router =  $this->container->get(Router::class);

        $this->initRouter();
    }

    public function run()
    {
        $this->router->run();
    }
   
    public function initRouter()
    {
        $this->router->get('/', "Home:index", 'home.index');
        $this->router->get('/posts', "Posts:index", 'posts.index');
        $this->router->get('/post/:slug-:id', "Posts:show", 'post.show')->with('slug', '[a-z-0-9]+')->with('id', '[0-9]+');
        $this->router->post('/post-new-comme/:slug-:id', "Posts:newComment", 'post.comment')->with('slug', '[a-z-0-9]+')->with('id', '[0-9]+');
        
        $this->router->get('/admin', "Admin:index", 'admin.index');
        $this->router->get('/admin/post/edit-:id', "PostsAdmin:edit", 'admin.editPost')->with('id', '[0-9]+');
        $this->router->post('/admin/post/edit-:id', "PostsAdmin:edit", 'admin.editPost')->with('id', '[0-9]+');
    }
}
