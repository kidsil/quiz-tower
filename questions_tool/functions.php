<?php
function prettyPrint( $json ) {
	$result = '';
	$level = 0;
	$in_quotes = false;
	$in_escape = false;
	$ends_line_level = NULL;
	$json_length = strlen( $json );

	for( $i = 0; $i < $json_length; $i++ ) {
		$char = $json[$i];
		$new_line_level = NULL;
		$post = "";
		if( $ends_line_level !== NULL ) {
			$new_line_level = $ends_line_level;
			$ends_line_level = NULL;
		}
		if ( $in_escape ) {
			$in_escape = false;
		} else if( $char === '"' ) {
			$in_quotes = !$in_quotes;
		} else if( ! $in_quotes ) {
			switch( $char ) {
				case '}': case ']':
					$level--;
					$ends_line_level = NULL;
					$new_line_level = $level;
					break;

				case '{': case '[':
					$level++;
				case ',':
					$ends_line_level = $level;
					break;

				case ':':
					$post = " ";
					break;

				case " ": case "\t": case "\n": case "\r":
					$char = "";
					$ends_line_level = $new_line_level;
					$new_line_level = NULL;
					break;
			}
		} else if ( $char === '\\' ) {
			$in_escape = true;
		}
		if( $new_line_level !== NULL ) {
			$result .= "\n".str_repeat( "\t", $new_line_level );
		}
		$result .= $char.$post;
	}

	return $result;
}

function importQuestionsDatabase( $path ) {
	if ( file_exists( $path ) ) {
		$questions_db = file_get_contents( $path ); //we're not using fopen because it's a JSON file, it won't make much sense when we split it.
		$questions_db = json_decode( $questions_db );
		return $questions_db;
	}
	return 'FILE DOESNT EXIST';
}

function saveQuestionsDatabase( $questions_db, $path ) {
	file_put_contents( $path, $questions_db );
}