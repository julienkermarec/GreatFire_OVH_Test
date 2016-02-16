<?php

/* BY JULIEN KERMAREC */
/* contact@julienkermarec.com */
/* FOR COLLATERAL FREDDOM */
/* AND RSF */
/* IN ANDAOLVRAS */
/* # 0. Configure the proxy */
/*
stream_context_set_default(
	array("http" => array(
			"proxy" => "tcp://your.proxy.com:8080",
			"request_fulluri" => TRUE,
			),
	)
);
*/

print_r($post);

/* 1. Check the URL to retrieve */
if(isset($_POST["dst"])){
    $url = $_POST["dst"];
}
else
{
    $url = "http://rkn.gov.ru/";
}

/* 2. Init language */
$content_type = get_headers($url, 1);
//echo $content_type["Content-Type"];
header("Content-Type:" . $content_type["Content-Type"]);

/* 4. Retrieve the remote data */
$ret = file_get_contents($url, FALSE);
if( FALSE === $ret ) {
        error("Cannot get $url .");
}


/* 4. Show */


echo "<base href='{$url}' />";

echo $ret;

echo '<div style="position: fixed;     top: 0px;     left: 0px; right: 0px; background: #2d2d2d;     z-index: 99999999;     padding: 10px 10px">
        <form method="POST" action="" style="margin : 0px;">
            <input type="text" name="dst" value="' . $url . '" style="padding: 5px;     border: 1px solid #858585;     font-size: 15px; width: calc(100% - 80px);"/>
            <button type="submit" style="position: relative;     width: 75px;     background: #FFF;     border: 1px solid grey;     padding: 8px 10px 7px;     top: -1px;">Go</button>
        </form>
    </div>
    <style>
        body {
            top: 51px !important;
            position: relative;
        }
    </style>
    </body>
    </html>';

?>
