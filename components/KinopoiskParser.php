<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use Yii;
use \yii\base\Object;

/**
 * Description of KinopoiskParser
 *
 * @author Anton Balovnev <an43.bal@gmail.com>
 */
class KinopoiskParser extends Object {
    
    /**
     * @var string Resulting model class.
     */
    public $resultsModelClass = '\app\models\Film';
    
    /**
     * @var string Source url template. Substring "#year#" will be replaced to queried year.
     */
    public $urlTemplate = '';
    
    /**
     * @var string Xpath to find all film containers.
     */
    public $filmContainersXpath = '';
    
    /**
     * @var array Array of attributes XPath queries to fill the film model, keyed by
     *  attribute name. These expressions will be evaluated in context of the film container.
     */
    public $fieldsXpath = [];
    
    /**
     * @var string HTTP request headers.
     */
    public $requestHeader = 'Host: www.kinopoisk.ru
User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:46.0) Gecko/20100101 Firefox/46.0
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: en-US,en;q=0.5
Accept-Encoding: identity
Referer: https://www.kinopoisk.ru/index.php?level=7&from=forma&result=adv&m_act%5Bfrom%5D=forma&m_act%5Bwhat%5D=content&m_act%5Byear%5D=2010
Connection: keep-alive
Cache-Control: max-age=0';
    
    /**
     * Gets kinopoisk page contents for given year.
     * 
     * @param int $year
     * @return string|FALSE Server response or FALSE on failture.
     */
    protected function getPage($year) {
        return file_get_contents(
                str_replace('#year#', intval($year), $this->urlTemplate),
                FALSE,
                stream_context_create([
                    'http' => ['header' => $this->requestHeader]
                ])
        );
    }
    
    /**
     * Creates DOMDocument from given HTML.
     * 
     * @param string $data HTML page contents.
     * @return \DOMDocument Created DOMDocument.
     */
    protected function createDomDocument($data) {
        $dom = new \DOMDocument();
	libxml_use_internal_errors(true);
        if ($dom->loadHTML($data)) {
            Yii::info(Yii::t('app', 'Create DomDocument'));
	} else {
            Yii::warning(Yii::t('app', 'An error occurred when creating an object of class DOMDocument'));
                
            $errors = libxml_get_errors();
            foreach ($errors as $error) {
                Yii::warning(Yii::t('app', 'XML error "{message}" [{level}] (Code {code}) in {file} on line {line} column {column}',
                        get_object_vars($error)));
            }
            libxml_clear_errors();
            return NULL;
	}
        return $dom;
    }

    /**
     * Creates and fills resulting model object.
     * 
     * @param \DOMXPath $xpath Xpath.
     * @param \DOMNode $filmContainer Film container node.
     * @return \yii\base\Model Film object.
     */
    protected function parseFilm(\DOMXPath $xpath, \DOMNode $filmContainer) {
        $resultsClass = $this->resultsModelClass;
        /* @var $film \yii\base\Model */
        $film = new $resultsClass;
        foreach (array_keys($this->fieldsXpath) as $field) {
            $film[$field] = $xpath->evaluate($this->fieldsXpath[$field], $filmContainer);
        }
        return $film;
    }
    
    /**
     * Parses page for given year, creates, saves and returns Model objects for
     *   parsed films.
     * 
     * @param int $year Year to parse.
     * @return \yii\base\Model[] Array of films.
     */
    public function parsePage($year) {
        $year = intval($year);
        $data = $this->getPage($year);
        //echo $data;
        $dom = $this->createDomDocument($data);
        if (!$dom) {
            Yii::warning(Yii::t('app', 'Error loading data for year {year}.', ['year' => $year]));
            return [];
        }
        $xpath = new \DOMXPath($dom);
        $containers = $xpath->query($this->filmContainersXpath);
        if (empty($containers)) {
            Yii::warning(Yii::t('app', 'No films found for year {year}.', ['year' => $year]));
        }
        $films = [];
        foreach ($containers as $container) {
            $film = $this->parseFilm($xpath, $container);
            $film['year'] = $year;
            if ($film->save()) {
                $films[] = $film;
            } else {
                Yii::warning(Yii::t('app', "Unable to validate parsed film. Errors: \n{errors}",
                        ['errors' => var_export($film->getErrors(), TRUE)]));
            }
        }
        return $films;
    }
}
