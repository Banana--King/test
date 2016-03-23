<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Core\HTML\BootstrapForm;
use Core\Auth\DBAuth;
use \App;

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
		$posts = $this->Post->all();

		$this->render('admin.posts.index', compact('posts'));
	}

	public function add()
	{
		if (!empty($_POST)) {
			$result = $this->Post->create([
				'titre' => $_POST['titre'],
				'contenu' => $_POST['contenu'],
				'category_id' => $_POST['category_id'],
			]);

			if ($result) {
				return $this->index();
			}
		}

		$categories = $this->Category->extract('id', 'titre');
		$form = new BootstrapForm($_POST);

		$this->render('admin.posts.edit', compact('categories', 'form'));
	}

	public function edit()
	{
		if (!empty($_POST)) {
			$result = $this->Post->update($_GET['id'], [
				'titre' => $_POST['titre'],
				'contenu' => $_POST['contenu'],
				'category_id' => $_POST['category_id'],
			]);

			if ($result) {
				return $this->index();
			}
		}
		$post = $this->Post->findWithCategory($_GET['id']);
		$categories = $this->Category->extract('id', 'titre');
		$form = new BootstrapForm($post);

		$this->render('admin.post.edit', compact('post', 'categories', 'form'));
	}

	public function delete()
	{
		if (!empty($_POST)) {
			$result = $this->Post->delete($_POST['id']);
			return $this->index();
		}
	}

}