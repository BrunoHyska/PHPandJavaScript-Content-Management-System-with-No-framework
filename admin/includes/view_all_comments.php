<table class="table table-bordered table-hover">
    <tr>
        <th>Id</th>
        <th>Author</th>
        <th>Comment</th>
        <th>Email</th>
        <th>Status</th>
        <th>In Response to</th>
        <th>Date</th>
        <th>Approved: </th>
        <th>Un-Approve</th>
        <th>Delete</th>
        
    </tr>
    <tbody>
        <?php  
$user_role = $_SESSION['user_role'];
if ($user_role === 'admin') {
    $query = "SELECT * FROM comments";
} elseif ($user_role === 'subscriber') {
    $comment_author = $_SESSION['username'];
    $query = "SELECT * FROM comments WHERE comment_author = '{$comment_author}'";
} else {
    echo "Unknown user role.";
}
        $select_comments = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_comments)){
        $comment_id = $row['comment_id']; 
        $comment_post_id = $row['comment_post_id']; 
        $comment_author = $row['comment_author']; 
        $comment_email = $row['comment_email'];
        $comment_content = $row['comment_content'];
        $comment_status = $row['comment_status'];
        $comment_date = $row['comment_date'];

        echo "<tr>";
        echo "<td>$comment_id</td>";
        echo "<td>$comment_author</td>";
        echo "<td>$comment_content</td>";
        echo "<td>$comment_email</td>";
        echo "<td>$comment_status</td>";
            
            
            


        $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
        $select_post_id_query = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_post_id_query)){
        $the_post_id = $row['post_id'];     
        $the_post_title = $row['post_title'];    
            
            
        echo "<td><a href='../post.php?p_id={$the_post_id}'>{$the_post_title}</a></td>";   
        }
   
        
        echo "<td>$comment_date</td>";
        echo "<td><a href='comments.php?approve=$comment_id'>Approve</a></td>";
        echo "<td><a href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
        echo "<td><a href='comments.php?delete=$comment_id'>Delete</a></td>";
            

        echo "</tr>";
        }

        ?>
        
        <?php 
        
        
        if(isset($_GET['unapprove'])){
           $the_comment_id = $_GET['unapprove'];
           $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $the_comment_id ";
           $delete_query=mysqli_query($connection, $query);
           header('Location: comments.php');
        }
        
        
        
        if(isset($_GET['approve'])){
           $the_comment_id = $_GET['approve'];
           $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $the_comment_id ";
           $delete_query=mysqli_query($connection, $query);
           header('Location: comments.php');
        }
        
        
        
        if(isset($_GET['delete'])){
           $the_comment_id = $_GET['delete'];
           $query = "DELETE FROM comments WHERE comment_id={$the_comment_id}";
           $delete_query=mysqli_query($connection, $query);
           header('Location: comments.php');
        }
        
        
        ?>

</tbody>
</table>