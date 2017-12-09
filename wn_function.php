<?php

function sql($dbname) {
    return new PDO("mysql:dbname=$dbname;host=" . DBHOST, DBUSER, DBPW);
}

function word($lemma, $type) {
    global $sqlResources;
    // $queryLemma = $sqlResources->prepare("select `offset`, `pos` from `index` where lemma = \"$lemma\"");
    $queryLemma = $sqlResources->prepare("select `offset`, `pos` from `index` where lemma = \"$lemma\" and pos = \"$type\" ");
    $queryLemma->execute();
    $lemmaResults = $queryLemma->fetchAll(PDO::FETCH_OBJ);
    $countLemma = count($lemmaResults);
    $results = new stdClass;
    $results->lemma = $lemma;
    if ($countLemma == 0) {
        $results->msg = 'not found';
    } else {
        $results->msg = 'success';
        for ($i = 0; $i < $countLemma; $i++) {
            $offset = $lemmaResults[$i]->offset;
            $offset = json_decode($offset);
            $pos = $lemmaResults[$i]->pos;
            $countOffset = count($offset);
            for ($j = 0; $j < $countOffset; $j++) {                
                $queryWord = $sqlResources->query("select `ss_type`, `word`, `definition`, `sentence` from `data` where offset = \"$offset[$j]\" ");
                // $queryWord = $sqlResources->query("select `ss_type`, `word`, `definition`, `sentence` from `data` where offset = \"$offset[$j]\" ");
                $wordResults = $queryWord->fetchAll(PDO::FETCH_OBJ);                
                $word = oneWord($wordResults, $pos, $lemma);                
                if(isset($word->word)) //not empty object
                    $results->words[] = $word;                
            }
        }        
        if(json_encode($results->words) == 'null') 
        {
            $results->msg = 'not found';            
            //have duplicate word like lemma
        }        
        
    }
    // return json_encode($results);
    return $results;
}

function oneWord($results, $pos, $lemma) {
    $result = new stdClass;
    $countWord = count($results);
     
    if ($countWord == 1) {                
        //change word = [[0,1],[0,1],...,[0,1]]
        $w = json_decode($results[0]->word);                                
        $n = count($w);
        for($idx = 0;$idx<$n;$idx++)
        {
            if(strtoupper($w[$idx][0]) == strtoupper($lemma) || strpos($w[$idx][0], '(') !== FALSE )
            {
                unset($w[$idx]);                 
            }
            else
            {
                $w[$idx][0] = str_replace("_", " ", $w[$idx][0]);//delet _
            }            
        }                    
        //                
        $w_ = array_values($w);
        if(count($w_) > '0')
        {
            $result->word = $w_;     
            $result->type = $results[0]->ss_type;
            $result->definition = json_decode($results[0]->definition); 
            $result->sentence = json_decode($results[0]->sentence);
        }
        
    } else {
        for ($i = 0; $i < $countWord; $i++) {
            if ($results[$i]->ss_type === $pos) {                                                
                //change word = [[0,1],[0,1],...,[0,1]]
                $w = json_decode($results[$i]->word);                                
                $n = count($w);
                for($idx = 0;$idx<$n;$idx++)
                {
                    if(strtoupper($w[$idx][0]) == strtoupper($lemma) || strpos($w[$idx][0], '(') !== FALSE) //delete word (a) ...
                    {
                        unset($w[$idx]);                        
                    }        
                    else
                    {
                        $w[$idx][0] = str_replace("_", " ", $w[$idx][0]);//delet _
                    }            
                }                                
                $w_ = array_values($w);
                if(count($w_) > '0')
                {
                    $result->word = $w_;  
                    $result->type = $pos;                
                    $result->definition = json_decode($results[$i]->definition);
                    $result->sentence = json_decode($results[$i]->sentence);          
                }   
            }
        }
    }

    // echo "<script>console.log(".json_encode($result).");</script>";    
    //word: {}        
    return $result;
}

function wordList($length) {
    global $sqlResources;
    $queryList = $sqlResources->prepare("select distinct lemma from `index` where length(lemma)=$length");
    $queryList->execute();
    $listResults = $queryList->fetchAll(PDO::FETCH_OBJ);
    $results = new stdClass;
    $results->length = $length;
    $results->msg = (count($listResults) == 0) ? 'not found' : 'success';
    $listLength = count($listResults);
    for ($i = 0; $i < $listLength; $i++) {
        $results->lemmas[] = $listResults[$i]->lemma;
    }
    $results->total = $listLength;
    return json_encode($results);
}
