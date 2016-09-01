<?php
function sanitizeString($_db, $str)
{
    $str = strip_tags($str);
    $str = htmlentities($str);
    $str = stripslashes($str);
    return mysqli_real_escape_string($_db, $str);
}


function SavePostToDB($_db, $_user, $_text, $_time, $_file_name, $_img_filter)
{
	/* Prepared statement, stage 1: prepare query */
	if (!($stmt = $_db->prepare("INSERT INTO WALL(USER_USERNAME, STATUS_TEXT, TIME_STAMP, IMAGE_NAME, FILTER) VALUES (?, ?, ?, ?, ?)")))
	{
		echo "Prepare failed: (" . $_db->errno . ") " . $_db->error;
	}

	/* Prepared statement, stage 2: bind parameters*/
	if (!$stmt->bind_param('sssss', $_user, $_text, $_time, $_file_name, $_img_filter))
	{
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	/* Prepared statement, stage 3: execute*/
	if (!$stmt->execute())
	{
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
}

function getPostcards($_db)
{
    $query = "SELECT USER_USERNAME, STATUS_TEXT, TIME_STAMP, IMAGE_NAME, FILTER FROM WALL ORDER BY TIME_STAMP DESC";

    if(!$result = $_db->query($query))
    {
        die('There was an error running the query [' . $_db->error . ']');
    }

    $output = '';
    while($row = $result->fetch_assoc())
    {
        $epoch = $row['TIME_STAMP'];
        $dt = new DateTime("@$epoch");
        $output = $output . '<div class="col-sm-12 col-md-4"><div class="panel panel-info"><div class="panel-heading"> Posted by ' . $row['USER_USERNAME']
        . ' ' . $dt->format('Y-m-d')
        . '</span></div><div class="panel-body"><img src="' . 'users/' . $row['IMAGE_NAME'] . '" width="100%" style="-webkit-filter:' . $row['FILTER'] . ';"><br /><p>' . $row['STATUS_TEXT'] . '</p></div></div></div>' ;
    }

    return $output;
}
?>
