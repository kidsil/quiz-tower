<?php
require_once( 'functions.php' );
$questions_db_path = '../data/questions.json';
if ( isset( $_POST['category'] ) && count( $_POST['category'] ) ) {
	$questions_db = new stdClass();
	foreach ( $_POST['category'] as $category ) {
		$questions_db->$category['name'] = $category['questions'];
		foreach ( $category['questions'] as $key => $question ) {
			$answer_num = $questions_db->{ $category['name'] }[ $key ]['correct'];
			$questions_db->{ $category['name'] }[ $key ]['answers'][ $answer_num ]['correct'] = true;
			unset( $questions_db->{ $category['name'] }[ $key ]['correct'] );
		}
	}
	$questions_db = prettyPrint( json_encode( $questions_db ) );
	saveQuestionsDatabase( $questions_db, $questions_db_path );
}
if ( isset( $questions_db ) ) {
	$message = 'Database Saved Successfully!';
}

$questions_db = importQuestionsDatabase( $questions_db_path );


?>
<!doctype html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="main.css">
		<script type="text/javascript" src="jquery-2.1.3.min.js"></script>
		<script type="text/javascript" src="main.js"></script>
	</head>
	<body>
		<h1>Questions Database Editor</h1>
		<?php if ( isset( $message ) ): ?>
			<div class="message"><?php echo $message ?></div>	
		<?php endif; ?>
		<form method="POST" class="question_db">
		<?php $cat_num = 0; ?>
		<?php foreach ( $questions_db as $key => $category ): ?>
			<div class="category_wrapper">
				<label class="category">
					Category: <input type="text" name="category[<?php echo $cat_num ?>][name]" value="<?php echo $key ?>" />
				</label>
				<div class="questions_table_wrapper">
					<table class="questions_table">
						<tr>
							<td class="question">Question</td>
							<td>Answer 1</td>
							<td>Answer 2</td>
							<td>Answer 3</td>
						</tr>
						<?php $q_num = 0; foreach ( $category as $question ): ?>
							<tr>
								<td class="question"><input type="text" name="category[<?php echo $cat_num ?>][questions][<?php echo $q_num ?>][question]" value="<?php echo $question->question ?>" /></td>
								<?php $a_num = 0; foreach ( $question->answers as $a_key => $answer ): ?>
									<td>
										<input type="text" name="category[<?php echo $cat_num ?>][questions][<?php echo $q_num ?>][answers][<?php echo $a_num ?>][value]" value="<?php echo $answer->value ?>" />
										<input type="radio" name="category[<?php echo $cat_num ?>][questions][<?php echo $q_num ?>][correct]" value="<?php echo $a_num ?>" class="hint--top" data-hint="correct answer" <?php echo property_exists( $answer, 'correct' ) && $answer->correct ? 'checked="checked"' : '' ?> /> 
									</td>
								<?php $a_num++; endforeach; ?>
							</tr>
						<?php $q_num++; endforeach; ?>
					</table>
					<input type="button" value="Add Question" class="add_question" />
				</div>
			</div>
		<?php $cat_num++; endforeach; ?>
		<input type="button" value="Add Category" class="add_category" /> <br /> <br />
		<input type="submit" value="Save" />
		</form>
	</body>
</html>