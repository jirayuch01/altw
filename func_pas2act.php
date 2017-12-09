        <?php 
                
        function toActive($sent, $toBeIdx) {
            require('config.php');
            $textdesc = $sent;
            $sentence = explode(' ', $sent);
            $countSentence = count($sentence);
            $sentence_pos = 0;
            $fullStopPosition = 0;
            $rowCount = '';
            $foundVerbDo = 'Not found';
            $foundNot = 'Not found';
            $foundVerbCan = 'Not found';
            $foundVerbMust = 'Not found';
            $foundVerbMay = 'Not found';
            $foundVerbMight = 'Not found';
            $foundVerbShould = 'Not found';
            $verbAfterNum = '';
            $finalResult = '';
            $subjPassive = '';
            $subjPos = 0;
            $verbPos = 0;
            $tense = '';
            // Search dot (fullstop) to be known each sentence end.
            while (substr($sentence[$fullStopPosition], -1) <> '.') {
                $fullStopPosition++;
                if ($sentence[$fullStopPosition] == 'can') {
                    $foundVerbCan = 'Found';
                }
                if ($sentence[$fullStopPosition] == 'must') {
                    $foundVerbMust = 'Found';
                }
                if ($sentence[$fullStopPosition] == 'may') {
                    $foundVerbMay = 'Found';
                }
                if ($sentence[$fullStopPosition] == 'might') {
                    $foundVerbMight = 'Found';
                }
                if ($sentence[$fullStopPosition] == 'should') {
                    $foundVerbShould = 'Found';
                }
            }
            // Query verb from DB
            // Present tense
            $i = $sentence_pos;
            while ($i < $fullStopPosition) {
                // Subject section
                $sql = "SELECT subject,object,verb_to_be FROM pronouns WHERE subject='$sentence[$sentence_pos]'";
                $result = $link->query($sql);
                if ($result->num_rows == 0) {
                    // First word is not I,You,We,They,He,She,It (perhaps article A, An, The or numbers as Two, Three)
                    // Find subject on second word
                    $subjPos = 1;
                    $subjPassive = ucfirst($sentence[$sentence_pos]);
                    if ($sentence[$sentence_pos] == 'A' || $sentence[$sentence_pos] == 'An' || $sentence[$sentence_pos] == 'The') {
                        
                        $subjPassive .= ' '.$sentence[$sentence_pos + 1];                        
                        while($subjPos < $toBeIdx-1)
                        { 
                            $subjPassive .= ' '.$sentence[$sentence_pos + $subjPos + 1];                        
                            $subjPos++;
                        }
                        // echo $subjPos . " 1is " . $subjPassive;
                    } else {                        
                        
                        // echo $subjPos . " 2is " . $subjPassive . ' '.
                        while($subjPos < $toBeIdx-1)
                        { 
                            $subjPassive .= ' '.$sentence[$sentence_pos + $subjPos + 1];                        
                            $subjPos++;
                        }
                        $verbAfterNum = $sentence[$sentence_pos + 1];
                    }
                } else {
                    // Found I,You,We,They,He,She,It
                    while ($row = $result->fetch_assoc()) {
                        $subjPassive = $row['object'];
                        $verb_to_be = $row['verb_to_be'] . ' ';
                    }
                    $subjPos = 1;
                }

                $foundVerb = 'No';
                $foundNot = 'Not found';
                // Find verb
                for ($j = $subjPos; $j <= $fullStopPosition - 1; $j++) {
                    if ($foundVerb == 'No') {
                        if ($sentence[$j] == 'not') {
                            $foundNot = 'Found';
                        }
                        if ($sentence[$j] == 'do' || $sentence[$j] == 'does') {
                            $foundVerbDo = $sentence[$j];
                            $sentence[$j] = 'doo';
                        }
                        if ($sentence[$j] == "don't" || $sentence[$j] == "doesn't") {
                            $foundVerbDo = $sentence[$j];
                            $foundNot = 'Found';
                            $sentence[$j] = 'dooNot';
                        }
                        $sql2 = "SELECT verb_one,verb_two,verb_three,verb_s,verb_ing FROM verbs WHERE verb_three='" . $sentence[$j] . "'";
                        $result2 = $link->query($sql2);
                        if ($result2->num_rows > 0) {
                            // Found base form
                            $verbPos = $j;
                            while ($row2 = $result2->fetch_assoc()) {
                                if ($foundNot == 'Found' && $foundVerbDo <> 'Not found') {
                                    // $verb = 'not ' . $row2['verb_one'];
                                    $verb = $row2['verb_one'];
                                } else {
                                    $verb = $row2['verb_one'];
                                }
                            }
                            $foundVerb = 'Yes';
                        } else {
                            $sql2 = "SELECT verb_one,verb_two,verb_three,verb_s,verb_ing FROM verbs WHERE verb_two='$sentence[$j]'";
                            $result2 = $link->query($sql2);
                            if ($result2->num_rows > 0) {
                                return null;
                                // Found past form
//                                $verbPos = $j;
//                                while ($row2 = $result2->fetch_assoc()) {
//                                    $verb = $row2['verb_two'];
//                                }
//                                $foundVerb = 'Yes';
                                //Past Tense
                            } else {
                                $sql2 = "SELECT verb_one,verb_two,verb_three,verb_s,verb_ing FROM verbs WHERE verb_s='$sentence[$j]'";
                                $result2 = $link->query($sql2);
                                if ($result2->num_rows > 0) {
                                    // Present Phural form
                                    $verbPos = $j;
                                    while ($row2 = $result2->fetch_assoc()) {
                                        if ($sentence[$j] == 'do' || $sentence[$j] == 'does' || $sentence[$j] == "don't" || $sentence[$j] == "doesn't" || $sentence[$j] == 'do not' || $sentence[$j] == 'does not') {
                                            $verb = 'not ' . $rows['verb_one'];
                                        } else {
                                            $verb = $row2['verb_one'];
                                        }
                                    }
                                    $foundVerb = 'Yes';
                                } else {
                                    $sql2 = "SELECT verb_one,verb_two,verb_three,verb_s,verb_ing FROM verbs WHERE verb_ing='$sentence[$j]'";
                                    $result2 = $link->query($sql2);
                                    if ($result2->num_rows > 0) {
                                        // Present Continous form
                                        $verbPos = $j;
                                        while ($rows = $result2->fetch_assoc()) {
                                            $verb = $row2['verb_ing'];
                                        }
                                        $foundVerb = 'Yes';
                                    } else {
                                        $verb = 'Not found verb';
                                    }
                                }
                            }
                        }
                    }
                }
                // Find noun
                $obj = rtrim($sentence[$fullStopPosition], '.');
                // echo $obj;
                $subj = '';
                $sql = "SELECT subject,object,verb_to_be FROM pronouns WHERE object='$obj'";
                $result = $link->query($sql);
                if ($result->num_rows > 0) {
                    // Found me,you,us,them,him,her,it
                    while ($row = $result->fetch_assoc()) {
                        $subj = $row['subject'];
                    }
                }
                $noun = '';
                /*
                  if ($subj<>'') {
                  $noun=$subj.' ';
                  }
                 */
                for ($k = $verbPos + 1; $k <= $fullStopPosition; $k++) {
                    $noun .= $sentence[$k] . ' '; // .= is add "by" **** remove By in sentence result.
                    // echo "sentence_k  ".$sentence[$k]; //-----------------------------------------------------------------------
                }
                // echo "<br>Before ".$noun; //-----------------------------------------------------------------------
                $noun = rtrim($noun, '. ');
                // echo "<br>After ".$noun; //-----------------------------------------------------------------------
                if ($sentence[$verbPos + 1] == 'a' ||
                        $sentence[$verbPos + 1] == 'an' ||
                        $sentence[$verbPos + 1] == 'the' ||
                        $sentence[$verbPos + 1] == 'this' ||
                        $sentence[$verbPos + 1] == 'that') {
                    $verb_to_be = ' is ';
                    /*
                      echo $foundVerbCan.'<br>';
                      echo $foundVerbMust.'<br>';
                      echo $foundVerbMay.'<br>';
                      echo $foundVerbMight.'<br>';
                      echo $foundVerbShould.'<br>';
                     */
                    if ($foundVerbCan == 'Found') {
                        if ($foundNot == 'Found') {
                            $verb = ' can not be ' . $verb;
                            $verb_to_be = '';
                        } else {
                            $verb = ' can be ' . $verb;
                            $verb_to_be = '';
                        }
                    } else {
                        if ($foundVerbMust == 'Found') {
                            if ($foundNot == 'Found') {
                                $verb = ' must not be ' . $verb;
                                $verb_to_be = '';
                            } else {
                                $verb = ' must be ' . $verb;
                                $verb_to_be = '';
                            }
                        } else {
                            if ($foundVerbMay == 'Found') {
                                if ($foundNot == 'Found') {
                                    $verb = ' may not be ' . $verb;
                                    $verb_to_be = '';
                                } else {
                                    $verb = ' may be ' . $verb;
                                    $verb_to_be = '';
                                }
                            } else {
                                if ($foundVerbMight == 'Found') {
                                    if ($foundNot == 'Found') {
                                        $verb = ' might not be ' . $verb;
                                        $verb_to_be = '';
                                    } else {
                                        $verb = ' might be ' . $verb;
                                        $verb_to_be = '';
                                    }
                                } else {
                                    if ($foundVerbShould == 'Found') {
                                        if ($foundNot == 'Found') {
                                            $verb = ' should not be ' . $verb;
                                            $verb_to_be = '';
                                        } else {
                                            $verb = ' should be ' . $verb;
                                            $verb_to_be = '';
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $finalResult = ucfirst(substr($noun,3)) . $verb_to_be . $verb . ' ' . $subjPassive . ".";
                } else {


                    if(substr($noun,3) == 'me') $noun = 'I';
                    else if(substr($noun,3) == 'him') $noun = "he";
                    else if(substr($noun,3) == 'her') $noun = "she";
                    else if(substr($noun,3) == 'us') $noun = "we";
                    else if(substr($noun,3) == 'them') $noun = "they";

                    if ($foundNot == 'Found' ) {
                        if($noun == "I" || $noun == "i" || $noun == "You" || $noun == "by you" || $noun == "you" || $noun == "We" || $noun == "we" || $noun == "They" || $noun == "they"){
                          $verb = "don't " . $verb;
                        }else {
                          $verb = "doesn't " . $verb;
                        }
                    }

                    if ($foundVerbCan == 'Found' ) {
                          $verb = "can " . $verb;
                    }

                    if ($foundVerbMust == 'Found' ) {
                        $verb = "must be " . $verb;
                    }

                    if ($foundVerbMay == 'Found' ) {
                        $verb = "may " . $verb;
                    }

                    if ($foundVerbMight == 'Found' ) {
                        $verb = "might " . $verb;
                    }

                    if ($foundVerbShould == 'Found' ) {
                        $verb = "should " . $verb;
                    }

                    //marking

                    // else $noun = substr($noun,3);
                    // echo "Noun : " . $noun;
                    // echo "<br>Verb : " . $verb;
                    // echo "<br>Object : " . $obj;
                    // echo "<br>Verb After Number : " . $verbAfterNum;
                    // echo "<br>Found Not : " . $foundNot;
                    // echo "<br>Found Can : " . $foundVerbCan;
                    // echo "<br>Found Object : " . $obj;
                    // echo "<br>Found Subject Pos : " .$subjPos;
                    // echo "<br>Found Subject : " . $subj;
                    // echo "<br>Subject Passive : " . $subjPassive;

                    if (substr($noun, 0, 2) == 'by'){
                        $noun = substr($noun, 3);
                    }
                    //echo "<br>Noun after : " . $noun;
                    
                    if($verbAfterNum == "are" || $verbAfterNum == "is") {
                        $verbAfterNum = "";
                    }

                    if (substr($noun, -1) == 's') {
                        // Phural nouns                                                
                        if($verbAfterNum == "") $finalResult = ucfirst($noun) . ' ' . $verb . ' ' . lcfirst($subjPassive) . ".";
                        else $finalResult = ucfirst($noun) . ' ' . $verb . ' ' . lcfirst($subjPassive) . " " . $verbAfterNum . ".";
                    } elseif ($noun == 'I') {
                        if($verbAfterNum == "") $finalResult = ucfirst($noun) . ' ' . $verb . ' ' . lcfirst($subjPassive) . ".";
                        else $finalResult = ucfirst($noun) . ' ' . $verb . ' ' . lcfirst($subjPassive) . " " . $verbAfterNum . ".";
                        
                    } elseif ($noun == 'you' || $noun == 'we' || $noun == 'they') {
                        if($verbAfterNum == "") $finalResult = ucfirst($noun) . ' ' . $verb . ' ' . lcfirst($subjPassive) . ".";
                        else $finalResult = ucfirst($noun) . ' ' . $verb . ' ' . lcfirst($subjPassive) . " " . $verbAfterNum . ".";
                    } elseif ($noun == 'he' || $noun == 'she' || $noun == 'it') {
                        if($verbAfterNum == "") $finalResult = ucfirst($noun) . ' ' . $verb . ' ' . lcfirst($subjPassive) . ".";
                        else $finalResult = ucfirst($noun) . ' ' . $verb . 's ' . lcfirst($subjPassive) . " " . $verbAfterNum . ".";
                    } else {
                        // Sigular noun
                        if($verbAfterNum == "is")
                        {
                          if($verb == "do"){
                            if($noun != "I" && $noun != "You" && $noun != "He" && $noun !=  "She" && $noun != "It" && $noun != "We" && $noun != "They"){
                              $finalResult = ucfirst(substr($noun,3)) . ' ' . $verb . 'es ' . lcfirst($subjPassive) . ".";
                            }else{
                              $finalResult = ucfirst($noun) . ' ' . $verb . 's ' . lcfirst($subjPassive) . ".";
                            }
                          }else {
                            $finalResult = ucfirst(substr($noun,3)) . ' ' . $verb . 's ' . $subjPassive . ".";
                          }
                        }
                        else {
                          if($verb == "do"){
                            if($noun != "I" && $noun != "You" && $noun != "He" && $noun !=  "She" && $noun != "It" && $noun != "We" && $noun != "They")
                            {
                              $finalResult = ucfirst(substr($noun,3)) . ' ' . $verb . 'es ' . lcfirst($subjPassive) . ".";
                            }else{
                              $finalResult = ucfirst($noun) . ' ' . $verb . 's ' . lcfirst($subjPassive) . ".";
                            }
                          }else {
                            $finalResult = $noun . ' ' . $verb . 's ' . lcfirst($subjPassive) . ".";
                          }
                        }
                    }
                }
                $i = $i + $fullStopPosition;
            }            
            return $finalResult;
        }
        ?>