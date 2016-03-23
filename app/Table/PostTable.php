<?php
namespace App\Table;

use \Core\Table\Table;


class PostTable extends Table
{
	
	protected $table = 'articles';

	/**
	 * Récupère les derniers articles
	 * @return array
	 */
	public function last()
	{
		return $this->query("
			SELECT articles.id, articles.titre, articles.contenu, categories.titre as categorie
			FROM articles
			LEFT JOIN categories
				ON category_id = categories.id
			ORDER BY articles.date DESC
		");
	}



	/**
	 * Récupère un article en liant la catégorie associée
	 * @param $id int -> id de l'article
	 * @return \App\Entity\PostEntity
	 */
	public function findWithCategory($id)
	{
		return $this->query("
			SELECT articles.id, articles.titre, articles.contenu, articles.date, articles.category_id, categories.titre as categorie
			FROM articles
			LEFT JOIN categories
				ON category_id = categories.id
			WHERE articles.id = ?
		", [$id], true);
	}


	/**
	 * Récupère les derniers articles liés à une catégorie associée
	 * @param $category_id int -> id de la categorie
	 * @return array
	 */
	public function lastByCategory($category_id)
	{
		return $this->query("
			SELECT articles.id, articles.titre, articles.contenu, categories.titre as categorie
			FROM articles
			LEFT JOIN categories
				ON category_id = categories.id
			WHERE category_id = ?
			ORDER BY articles.date DESC
		", [$category_id]);
	}

}