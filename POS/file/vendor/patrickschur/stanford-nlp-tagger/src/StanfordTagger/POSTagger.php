<?php
declare(strict_types = 1);

namespace StanfordTagger;

use LanguageDetection\Language;

/**
 * Class POSTagger
 *
 * @author Patrick Schur <patrick_schur@outlook.de>
 * @package StanfordTagger
 */
class POSTagger extends StanfordTagger {

    /**
     * @var Language
     */
    private $lang;

    /**
     * @var string The path of the model
     */
    private $model;

    /**
     * @var string
     */
    private $separator = '_';

    public function __construct() {
        $this->lang = new Language(['ar', 'de', 'en', 'es', 'fr', 'zh-Hans', 'zh-Hant']);
    }

    /**
     * @param string $str
     * @return null|string
     */
    public function tag(string $str) {
        $str = trim($str);

        if (empty($str)) {
            return null;
        }

        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator('.'));

        if (empty($this->getModel())) {
            $lookupTable = [
                'ar' => 'arabic.tagger',
                'de' => 'german-hgc.tagger',
                'en' => 'english-left3words-distsim.tagger',
                'es' => 'spanish.tagger',
                'fr' => 'french.tagger',
                'zh-Hans' => 'chinese-distsim.tagger',
                'zh-Hant' => 'chinese-distsim.tagger',
            ];

            $lang = $this->lang->detect($str)->bestResults()->close();

            if (1 === count($lang)) {
                $lang = $lookupTable[array_keys($lang)[0]];
            } else {
                $lang = $lookupTable['en'];
            }

            $regex = new \RegexIterator($it, '/^.+\.tagger$/i', \RecursiveRegexIterator::GET_MATCH);

            foreach ($regex as $value) {
                if (stripos($value[0], $lang) !== false) {
                    $this->setModel($value[0]);
                    break;
                }
            }

            if (empty($this->getModel())) {
                //throw new \RuntimeException('Could not found any models!');
                echo '<div id="selectedTarget"><div>';
            }
        }

        if (empty($this->getJarArchive())) {
            $regex = new \RegexIterator($it, '/^.+stanford-postagger\.jar$/i', \RecursiveRegexIterator::GET_MATCH);

            foreach ($regex as $value) {
                $this->setJarArchive($value[0]);
                break;
            }

            if (empty($this->getJarArchive())) {
                //throw new \RuntimeException('Could not found any .jar files!');
                echo '<div id="selectedTarget"><div>';
            }
        }

        $cmd = escapeshellcmd(
                $this->getJavaPath()
                . ' -mx' . $this->getMaxMemoryUsage()
                . ' -cp "' . $this->getJarArchive() . PATH_SEPARATOR . '" edu.stanford.nlp.tagger.maxent.MaxentTagger'
                . ' -model ' . $this->getModel()
                . ' -textFile ' . $this->getTmpFile($str)
                . ' -outputFormat ' . $this->getOutputFormat()
                . ' -tagSeparator ' . $this->getSeparator()
        );

        $descriptorspec = [
            0 => ["pipe", "r"],
            1 => ["pipe", "w"],
            2 => ["pipe", "r"]
        ];

        $process = proc_open($cmd, $descriptorspec, $pipes);

        $output = null;

        if (is_resource($process)) {
            fclose($pipes[0]);

            $output = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            fclose($pipes[2]);

            proc_close($process);
        }

        return trim($output);
    }

    public function setModel(string $model) {
        if (!file_exists($model)) {
            //throw new \InvalidArgumentException('Could not found any models!');
            echo '<div id="selectedTarget"><div>';
        }

        $this->model = $model;
    }

    public function getModel() {
        return $this->model;
    }

    public function setSeparator(string $separator) {
        $this->separator = $separator;
    }

    public function getSeparator() {
        return $this->separator;
    }

}
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <head>
        <title>Alternative Word Suggestion System for English Writings</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel="shortcut icon" type="image/ico" href="assets/icon/favicons.ico">
        <link rel="apple-touch-icon" href="assets/icon/apple-touch-icon.png">
        <script type="text/javascript" src="assets/js/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#selectedTarget').load('error.php');
            });
        </script>   
    </head>
</html>