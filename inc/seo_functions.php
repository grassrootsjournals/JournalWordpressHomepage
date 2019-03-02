<?php 
/* This file contains functions which optimize the website for search engines and social media. */
?>

<?php 
/* Some Search engine optimization. This function removes often used words from the URL.
A first version of this function comes from: https://fastwp.de/magazin/stoppworter-automatisch-entfernen/ (in German). */
add_filter('sanitize_title', 'remove_false_words');
function remove_false_words( $slug ) {               /* The slug is a first proposal for the filename in the URL. */

    if (!is_admin()) return $slug;
    /* echo( $slug ); */

    if ( strlen( $slug ) < 80 ) return "test-title"; /* $slug; /* If the title is short, no need to do anything. */
    /* if (get_locale() == 'en_US') { */
    if ( TRUE ) {
        $slug = explode('-', $slug);
        foreach ($slug as $k => $word) {      /* Remove the most common and least informative words. */
                    $keys_false = "a,am,an,and,any,are,as,at,be,by,did,do,does,doing,for,from,had,has,have,so,some,such,than,that,the,to,too,was,with";
                    $keys = explode(',', $keys_false);
                    foreach ($keys as $l => $wordfalse) {
                            if ($word==$wordfalse) {
                                    unset($slug[$k]);
                            }
                    }
        }       
        $slug = implode('-', $slug); 
        
        if ( strlen( $slug ) > 120 ) { /* If the title is still long, also remove addational more informative words. */
            $slug = explode('-', $slug);
            foreach ($slug as $k => $word) {
                $keys_false = "about,all,am,an,and,any,are,as,at,be,because,been,before,being,below,between,both,by,could,did,do,does,doing,down,during,each,few,for,from,further,had,has,have,having,he,he'd,he'll,he's,her,here,here's,hers,herslf,him,himself,his,how,how's,i,i'd,i'll,i'm,i've,if,in,into,is,it,it's,its,itself,let's,me,more,most,my,myself,of,on,once,only,other,ought,our,ours,ourselves,out,over,own,same,she,she'd,she'll,she's,should,so,some,such,than,that,that's,the,their,theirs,them,themselves,then,there,there's,these,they,they'd,they'll,they're,they've,this,those,through,to,under,until,up,very,was,we,we'd,we'll,we're,we've,were,what,what's,when,when's,where,where's,which,while,who,who's,whom,why,why's,with,would,you,you'd,you'll,you're,you've,your,yours,yourself,yourselves";
                $keys = explode(',', $keys_false);
                foreach ($keys as $l => $wordfalse) {
                        if ($word==$wordfalse) {
                                unset($slug[$k]);
                        }
                }
            }
            $slug = implode('-', $slug);             
        } /* If the URL is still too long. */        
        return $slug;
    } /* If the language of the site is en_US. */
}?>

