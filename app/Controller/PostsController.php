<?php
namespace App\Controller;

use Core\Controller\Controller;

class PostsController extends AppController
{

	public function __construct()
	{
		parent::__construct();
		$this->loadModel('Post');
		$this->loadModel('Category');
	}

	public function index()
	{
		$posts = $this->Post->last();
		$categories = $this->Category->all();

		$this->render('posts.index', compact('posts', 'categories'));
	}

	public function category()
	{
		$categorie = $this->Category->find($_GET['id']);
		if($categorie === false){
			$this->notFound();
		}
		$articles = $this->Post->lastByCategory($_GET['id']);
		$categories = $this->Category->all();

		$this->render('posts.category', compact('categorie', 'articles', 'categories'));
	}

	public function show()
	{	
		$post = $this->Post->findWithCategory($_GET['id']);
		if($post === false){
		  $this->notFound();
		}

		$this->render('posts.show', compact('post'));
	}

}