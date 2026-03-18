<?php

function generateLink($url, $label, $class) {
    
    echo '<a href="' . $url . '" class="' . $class . '">' . $label . '</a>';

}


function outputPostRow($number)  {

    include("travel-data.inc.php");

    $postId = ${"postId" . $number};
    $userId = ${"userId" . $number};
    $userName = ${"userName" . $number};
    $date = ${"date" . $number};
    $thumb = ${"thumb" . $number};
    $title = ${"title" . $number};
    $excerpt = ${"excerpt" . $number};
    $reviewsNum = ${"reviewsNum" . $number};
    $reviewsRating = ${"reviewsRating" . $number};

    echo '<div class="row">';
        echo '<div class="col-md-4">';
            generateLink(
                "post.php?id=" . $postId,
                '<img src="images/' . $thumb . '" alt="' . $title . '" class="img-responsive">',
                ""
            );
        echo '</div>';

        echo '<div class="col-md-8">';
            echo '<h2>' . $title . '</h2>';
            echo '<div class="details">';
                echo 'Posted by ';
                generateLink("user.php?id=" . $userId, $userName, "");
                echo '<span class="pull-right">' . $date . '</span>';
                echo '<p class="ratings">' . constructRating($reviewsRating) . ' ' . $reviewsNum . ' Reviews</p>';
            echo '</div>';
            echo '<p class="excerpt">' . $excerpt . '</p>';
            echo '<p>';
                generateLink("post.php?id=" . $postId, "Read more", "btn btn-primary btn-sm");
            echo '</p>';
        echo '</div>';
    echo '</div>';
    echo '<hr>';

}

/*
  Function constructs a string containing the <img> tags
  necessary to display star images that reflect a rating 
   out of 5
*/
function constructRating($rating) {

    $output = "";

    for ($i = 0; $i < $rating; $i++) {
        $output .= '<img src="images/star-gold.svg" width="16">';
    }

    for ($i = $rating; $i < 5; $i++) {
        $output .= '<img src="images/star-white.svg" width="16">';
    }

    return $output;

}

?>