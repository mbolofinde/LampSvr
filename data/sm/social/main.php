<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media Database Interface</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }
        .container {
            max-width: 900px;
            margin: auto;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Social Media Database Interface</h2>
        <form method="post">
            <div class="mb-3">
                <label for="query" class="form-label">Select Query:</label>
                <select name="query" id="query" class="form-select">
                    <option value="">-- Select --</option>
                    <option value="1">Location of User</option>
                    <option value="2">Most Followed Hashtag</option>
                    <option value="3">Most Used Hashtags</option>
                    <option value="4">Most Inactive User</option>
                    <option value="5">Most Liked Posts</option>
                    <option value="6">Average Post per User</option>
                    <option value="7">Number of Logins per User</option>
                    <option value="8">User who liked every single post (Bot Check)</option>
                    <option value="9">User Never Comment</option>
                    <option value="10">User who commented on every post (Bot Check)</option>
                    <option value="11">User Not Followed by anyone</option>
                    <option value="12">User Not Following Anyone</option>
                    <option value="13">Posted more than 5 times</option>
                    <option value="14">Followers > 40</option>
                    <option value="15">Any specific word in comment</option>
                    <option value="16">Longest captions in post</option>
                </select>
            </div>
            <div class="">
                <button type="submit" name="submit" class="btn btn-dark">Execute</button>
            </div>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // Connect to your MySQL database
            $conn = mysqli_connect("localhost", "padmin", "vagrant", "social_media");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Get the selected query from the form
            $selectedQuery = $_POST['query'];

            // Execute the selected query
            switch ($selectedQuery) {
                case '1':
                    $sql = "SELECT * FROM post WHERE location IN ('agra', 'maharashtra', 'west bengal')";
                    break;
                case '2':
                    $sql = "SELECT hashtag_name AS 'Hashtags', COUNT(hashtag_follow.hashtag_id) AS 'Total Follows' FROM hashtag_follow, hashtags WHERE hashtags.hashtag_id = hashtag_follow.hashtag_id GROUP BY hashtag_follow.hashtag_id ORDER BY COUNT(hashtag_follow.hashtag_id) DESC LIMIT 5";
                    break;
                case '3':
                    $sql = "SELECT hashtag_name AS 'Trending Hashtags', COUNT(post_tags.hashtag_id) AS 'Times Used' FROM hashtags, post_tags WHERE hashtags.hashtag_id = post_tags.hashtag_id GROUP BY post_tags.hashtag_id ORDER BY COUNT(post_tags.hashtag_id) DESC LIMIT 10";
                    break;
                case '4':
                    $sql = "SELECT user_id, username AS 'Most Inactive User' FROM users WHERE user_id NOT IN (SELECT user_id FROM post)";
                    break;
                case '5':
                    $sql = "SELECT post_likes.user_id, post_likes.post_id, COUNT(post_likes.post_id) FROM post_likes, post WHERE post.post_id = post_likes.post_id GROUP BY post_likes.post_id ORDER BY COUNT(post_likes.post_id) DESC";
                    break;
                case '6':
                    $sql = "SELECT ROUND((COUNT(post_id) / COUNT(DISTINCT user_id) ),2) AS 'Average Post per User' FROM post";
                    break;
                case '7':
                    $sql = "SELECT user_id, email, username, login.login_id AS login_number FROM users NATURAL JOIN login";
                    break;
                case '8':
                    $sql = "SELECT username, Count(*) AS num_likes FROM users INNER JOIN post_likes ON users.user_id = post_likes.user_id GROUP BY post_likes.user_id HAVING num_likes = (SELECT Count(*) FROM post)";
                    break;
                case '9':
                    $sql = "SELECT user_id, username AS 'User Never Comment' FROM users WHERE user_id NOT IN (SELECT user_id FROM comments)";
                    break;
                case '10':
                    $sql = "SELECT username, Count(*) AS num_comment FROM users INNER JOIN comments ON users.user_id = comments.user_id GROUP BY comments.user_id HAVING num_comment = (SELECT Count(*) FROM comments)";
                    break;
                case '11':
                    $sql = "SELECT user_id, username AS 'User Not Followed by anyone' FROM users WHERE user_id NOT IN (SELECT followee_id FROM follows)";
                    break;
                case '12':
                    $sql = "SELECT user_id, username AS 'User Not Following Anyone' FROM users WHERE user_id NOT IN (SELECT follower_id FROM follows)";
                    break;
                case '13':
                    $sql = "SELECT user_id, COUNT(user_id) AS post_count FROM post GROUP BY user_id HAVING post_count > 5 ORDER BY COUNT(user_id) DESC";
                    break;
                case '14':
                    $sql = "SELECT followee_id, COUNT(follower_id) AS follower_count FROM follows GROUP BY followee_id HAVING follower_count > 40 ORDER BY COUNT(follower_id) DESC";
                    break;
                case '15':
                    $sql = "SELECT * FROM comments WHERE comment_text REGEXP 'good|beautiful'";
                    break;
                case '16':
                    $sql = "SELECT user_id, caption, LENGTH(caption) AS caption_length FROM post ORDER BY caption_length DESC LIMIT 5";
                    break;
                default:
                    echo "<div class='alert alert-danger mt-3' role='alert'>Invalid query selected</div>";
                    return;
            }

            // Execute the SQL query
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data in a table
                echo "<h3 class='mt-4'>Query Results:</h3>";
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered table-hover mt-2'>";
                echo "<thead class='table-dark'>";
                echo "<tr>";
                while ($fieldinfo = $result->fetch_field()) {
                    echo "<th scope='col'>" . $fieldinfo->name . "</th>";
                }
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>{$value}</td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            } else {
                echo "<div class='alert alert-info mt-3' role='alert'>No results found</div>";
            }

            // Close the database connection
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
