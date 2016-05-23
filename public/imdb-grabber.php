<?php

    function search_subtext($node){
        
        global $result;

        if ($node->nodeType == 1){
            foreach ($node->childNodes as $child){
                if ($child->tagName == 'div' && $child->getAttribute('class') == 'subtext'){
                    $subtext = explode("|", $child->nodeValue);
                    $result['runtime'] = trim($subtext[1]);
                    $result['genre'] = preg_replace('/\s{2,}|\n/i', '', trim($subtext[2]));
                }
                else if ($child->tagName == 'span' && $child->getAttribute('itemprop') == 'ratingValue'){
                    $result['imdb-rating'] = trim($child->nodeValue);
                }
                else if ($child->tagName == 'img' && stripos($child->getAttribute('title'), "poster") !== false){
                    $result['poster'] = $child->getAttribute('src');
                }
                else
                    search_subtext($child);
            }
        }
    }
    
    function search_plot($node){
        
        global $result;
        
        if ($node->nodeType == 1){
            foreach ($node->childNodes as $child){
                if ($child->tagName == 'div' && $child->getAttribute('itemprop') == 'description'){
                    $result['plot'] = preg_replace('/\s{2,}|\n/i', ' ', trim(strip_tags($child->textContent)));
                    return true;
                }
                else
                    search_plot($child);
            }
        }
    }
    
    $dom = new DOMDocument('1.0', 'UTF-8');
    
    @ $dom->loadHTMLFile('http://www.imdb.com/title/' . $_GET['imdb_id'] . '/');
    
    $year_span = $dom->getElementByID('titleYear');
    $result['year'] = $year_span->childNodes->item(1)->textContent;
    
    $title_div = $dom->getElementByID('title-overview-widget');
    search_subtext($title_div);
    
    $story_div = $dom->getElementByID('titleStoryLine');
    search_plot($story_div);
    
    // print_r($result);
    
    print(json_encode($result, JSON_PRETTY_PRINT));
?>