<?php
namespace App\SuperNews\Frontend\Modules\News;

use \OCFram\BackController;
use \OCFram\HTTPRequest;

class NewsController extends BackController{

    public function executeIndex(HTTPRequest $request){
        $nombreNews = $this->app->config()->get('nombre_news');
        $nombreCaracteres = $this->app->config()->get('nombre_caracteres');

        $this->page->addVar('title', 'liste des '.$nombreNews.' dernières news');

        $manager = $this->managers->getManagerOf('News');

        $listeNews = $manager->getlist(0, $nombreNews);

        foreach($listeNews as $news){
            if(strlen($news->contenu()) > $nombreCaracteres){
                $debut = substr($news->contenu(), 0,$nombreCaracteres);
                $debut = substr($debut, 0, strrpos($debut, '')).'...';

                $news->setContenu($debut);
            }
        }

        $this->page->addVar('listeNews', $listeNews);
    }
}