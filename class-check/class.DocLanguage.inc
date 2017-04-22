<?php
class DocLanguage extends ParseHtml{
    public $nodeHtml;
    public $nodeLang;

    public function __construct($html){
        parent::__construct($html);
        $this->nodeHtml = $this->dom->getElementsByTagName('html')[0];
        $this->nodeLang = $this->setLangDoc();
    }

    public function setLangDoc(){
        $checkXml = $this->dom->saveHTML($this->nodeHtml);
        $re = '/<html(.+?)xmlns="(.+?)>/';
        if (preg_match($re, $checkXml)){
            $langNode = array(
                'docType' =>'xml',
                'line' => $this->nodeHtml->getLineNo(),
                'langVal' => $this->nodeHtml->getAttribute('lang'),
                'xmlLangVal' => $this->nodeHtml->getAttribute('xml:lang'),
            );
        } else {
            $langNode = array(
                'docType' => 'html',
                'line' => $this->nodeHtml->getLineNo(),
                'langVal' => $this->nodeHtml->getAttribute('lang'),
            );
        }
        return $langNode;
    }

}

/***
 * Using regular expression in this class is a trick, should avoid when parsing HTML, next we can use Xpath which reqiure to learn first
 * https://www.w3.org/International/questions/qa-html-language-declarations
 * Use the lang attribute for pages served as HTML, and the xml:lang attribute
 * for pages served as XML. For XHTML 1.x and HTML5 polyglot documents, use both together.
 * <html lang="fr">
 * <html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
 * more about HTML5 polyglot https://en.wikipedia.org/wiki/Polyglot_markup
 */

/***
PSEUDO CODE
===================
1. Set all information regarding doc language (Explanation, Instruction, WCAG technique, Official guidelines)
2. Prompt user to insert HTML/Web address and hit check button.
3. Save inserted data to $html.
4. Create object Dom from $html.
5. From object Dom select element by tag name “html”.
6. Check selected element, if the element doesn’t have “alt” attribute.
7. True: Save -> (full tag of img, the line number) to array with name $imgWithNoAlt.
8. Iterate every $imgWithNoAlt index to function formCorrect();
9. Display -> (img tag, line number, more info button and the form) for user to insert alt value, as error.
10. Display all information for img tag, after more info button clicked.
11. Prompt user to insert alt value and hit submit button.
12. Save inserted value to $word.
13. Using Php Dom setAttribute “alt” equal to $word and convert it to new object dom
14. Replace the old dom to new object dom which have alt attribute.
15. Open file newfile.html
16. Write new the object Dom to file.
17. Close file.

 */
?>