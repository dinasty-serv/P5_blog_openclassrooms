<?php
namespace Framework;

use Psr\Http\Message\ServerRequestInterface;
use Framework\Router\Router;
use Framework\Session\Session;
use Framework\Session\SessionFlash;

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
        $this->container->get(Mailer::class);
        


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
    {   //FRONT
        $this->router->get('/', "Home:index", 'home.index');
        $this->router->get('/posts', "Posts:index", 'posts.index');
        $this->router->get('/post/:slug-:id', "Posts:show", 'post.show')->with('slug', '[a-z-0-9]+')->with('id', '[0-9]+');
        $this->router->post('/post-new-comme/:slug-:id', "Posts:newComment", 'post.comment')->with('slug', '[a-z-0-9]+')->with('id', '[0-9]+');
        //FRONT-CONTACT
        $this->router->post('/contact', "Home:contact", 'contact.submit');
        $this->router->get('/contact', "Home:contact", 'contact.page');

        //BACK-INDEX
        $this->router->get('/admin', "Admin:index", 'admin.index');
        
        //BACK-POSTS
        $this->router->get('/admin/post/edit-:id', "PostsAdmin:edit", 'admin.editPost')->with('id', '[0-9]+');
        $this->router->get('/admin/post/delete-:id', "PostsAdmin:delete", 'admin.deletePost')->with('id', '[0-9]+');
        $this->router->post('/admin/post/edit-:id', "PostsAdmin:edit", 'admin.editPost')->with('id', '[0-9]+');
        $this->router->post('/admin/post/add', "PostsAdmin:add", 'admin.addPost');
        $this->router->get('/admin/post/add', "PostsAdmin:add", 'admin.addPost');
        
        //BACK-COMMENTS
        $this->router->get('/admin/comments/', "CommentsAdmin:index", 'admin.comments');
        $this->router->get('/admin/deleteOrApproveComment/:id/:action', "CommentsAdmin:appouvOrDelete", 'admin.appouvOrDelete')->with('id', '[0-9]+')->with('action', '[a-z-0-9]+');
        
        //BACK-CATEGORIES
        $this->router->get('/admin/categories/', "CategoriesAdmin:index", 'admin.categoriesIndex');
        $this->router->get('/admin/categorie/delete-:id', "CategoriesAdmin:delete", 'admin.deleteCategorie')->with('id', '[0-9]+');
        $this->router->get('/admin/categorie/edit-:id', "CategoriesAdmin:edit", 'admin.editCategorie')->with('id', '[0-9]+');
        $this->router->post('/admin/categorie/edit-:id', "CategoriesAdmin:edit", 'admin.editCategorie')->with('id', '[0-9]+');
        $this->router->post('/admin/categorie/add', "CategoriesAdmin:index", 'admin.addCategorie');


        //Users

        $this->router->get('/login-register', "Users:login", 'users.login');
        $this->router->get('/logout', "Users:logout", 'users.logout');

        $this->router->post('/register', "Users:register", 'users.register-post');
        $this->router->post('/login', "Users:login", 'users.login-post');

        $this->router->get('/lost-pasword', "Users:lostPassword", 'users.lostPassword');
        $this->router->post('/lost-pasword', "Users:lostPassword", 'users.lostPassword-post');

        $this->router->get('/reset/:token', "Users:resetPassword", 'users.resetpassword')->with('token', '[a-z-0-9]+');
        $this->router->post('/reset/:token', "Users:resetPassword", 'users.resetpassword-post')->with('token', '[a-z-0-9]+');


        $this->router->get('/profile', "Users:profile", 'users.profile');
        
        $this->router->post('/reset/:token', "Users:resetPassword", 'users.resetpassword-post')->with('token', '[a-z-0-9]+');
    }
}
