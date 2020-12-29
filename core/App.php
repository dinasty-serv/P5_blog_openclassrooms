<?php
namespace Framework;

use Psr\Http\Message\ServerRequestInterface;
use Framework\Router\Router;

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
    /**
     * Init container
     *
     * @var ContainerInterface
     */
    public $container;
    /**
     * Init app
     *
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->container = new Container();
        
        $this->container->set($this->container);
        $this->request = $this->container->set($request);
        $this->router =  $this->container->get(Router::class);

        $this->initRouter();
    }
    /**
     * Run App
     *
     * @return void
     */
    public function run()
    {
        $this->router->run();
    }
    /**
     * Init router
     *
     * @return void
     */
    public function initRouter()
    {
        $this->router->get('/', "Home:index", 'home.index');
        $this->router->get('/posts', "Posts:index", 'posts.index');
        $this->router->get('/post/:slug-:id', "Posts:show", 'post.show')->with('slug', '[a-z-0-9]+')->with('id', '[0-9]+');
        $this->router->post('/post-new-comme/:slug-:id', "Posts:newComment", 'post.comment')->with('slug', '[a-z-0-9]+')->with('id', '[0-9]+');
        
        $this->router->get('/admin', "Admin:index", 'admin.index');
        $this->router->get('/admin/post/edit-:id', "PostsAdmin:edit", 'admin.editPost')->with('id', '[0-9]+');
        $this->router->post('/admin/post/edit-:id', "PostsAdmin:edit", 'admin.editPost')->with('id', '[0-9]+');
        
        $this->router->get('/admin/deleteOrApproveComment/:id/:action', "CommentsAdmin:appouvOrDelete", 'admin.appouvOrDelete')->with('id', '[0-9]+')->with('action', '[a-z-0-9]+');
    }
}
