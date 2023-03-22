<?php
/******** IMPORTS ********/

require "./src/services/post/index.php";
require "./src/services/repository/post/index.php";
require "./src/services/database/sqlite/index.php";
require "./src/services/database/sqlite/seed-sql.php";

/******** CONSTANTS ********/

const APPLICATION_CONFIG_FILE = "./src/config.json";

/******** SERVICES ********/

$seed_sql = $sql_config->get_SQL();
$sqlite_client = new SQLite_Client(APPLICATION_CONFIG_FILE);
$sqlite_client->seed_database($seed_sql);

$post_repository = new Post_Repository($sqlite_client);
$post_service = new Post_Service($post_repository);

?>

<html>

<head>
  <title>Nicely | A nice social network for nice people</title>
  <meta charset="utf-8">
  <!-- Sets initial viewport load and disables zooming  -->
  <meta name="viewport" content="initial-scale=1, maximum-scale=1">
  <!-- Makes your prototype chrome-less once bookmarked to your phone's home screen -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
  <style>
    .post-body {
      display: block;
      margin: 0px 0px 15px 0px;
    }
  </style>
</head>

<body>
  <div class="ui menu">
    <a class="item active">
      Home
    </a>
    <a class="item">
      Messages
    </a>
    <a class="item">
      Friends
    </a>
	<div id="create-post-form" class="item">
		<!--<form class="" action="./src/echo.php" method="POST">-->
			<div class="ui action input">
				<input id="create-post-input" type="text" name="post" placeholder="Say something nice...">
				<input type="hidden" id="user-id" name="user-id" value="cebca450-45ec-4f2e-9202-2e6a132ba2fe">
				<input type="hidden" id="rel-id" name="rel" value="create-post">
				<button id="create-post-btn" class="ui button" type="button">Quick Post</button>
			</div>
		<!--</form>-->
	</div>
	
    <div class="right menu">
      <a class="ui item">
        Logout
      </a>
    </div>
  </div>
  <br>
  <div id="nicely" class="ui three column grid container">
	<div class="column"></div>
	<div id="user-post-list" class="column">
		<?php 
			$post_list = array_reverse($post_service->get_all_posts());
			// $comment_list = array_reverse($post_service->get_comments_by_user($user);

			foreach($post_list as $post) {
				list(
					"id" => $id,
					"user_id" => $user_id,
					"handle" => $handle, 
					"display_name" => $display_name,
					"has_image" => $has_image,
					"image_url" => $image_url,
					"body" => $post_body, 
					"comment_count" => $comment_count,
					"like_count" => $like_count,
					"created_date" => $created_date
				) = $post;

				echo "<div class='ui card centered'>
					<div class='content' data-post-id=$id>
						<div class='right floated meta'>
							<span data-publish-date=$created_date>14h</span>
						</div>
						<img class='ui avatar image' src='https://placehold.it/50' data-user-avatar-image> 
						<span data-user-handle=$handle>$handle</span>
					</div>";

				if ($has_image) {
					echo "<div class='image'>
						<img src='$image_url'>
					</div>";
				} 
					
				echo "<div class='content'>
					<a class='header' data-user-display-name='$display_name'>$display_name</a>
					<div class='description'>$post_body</div>
				</div>

				<div class='content' data-post-stats='$id'>
					<span class='right floated'>
						<i data-post-id='$id' class='heart outline like icon'></i>
						<span data-like-count>
							$like_count likes 
						</span> 
					</span>
					<i class='comment icon'></i>
					<span data-comment-count>$comment_count comments</span>
				</div>

				<div class='extra content'>
					<div class='ui large transparent left icon input'>
						<i class='heart outline icon'></i>
						<input type='text' class='comment-input' placeholder='Add Comment...' data-post-id='$id' data-rel='add-comment' data-commenter-id='$user_id'>
					</div>
				</div>
			</div>";
			}
		?>
	</div>
	<div class="column"></div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script type="module" src="./dist/js/nicely.js"></script>
</body>

</html>