<?php
require_once '../includes/auth.php';
checkLogin();
require_once '../config/db.php';

// Form submission handle karna (Database mein request daalna)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_request'])) {
    $title = $_POST['book_title'];
    $cat = $_POST['category'];
    $u_id = $_SESSION['user_id'];

    $sql = "INSERT INTO book_requests (user_id, book_title, category, status) VALUES (:u_id, :title, :cat, 'pending')";
    $pdo->prepare($sql)->execute(['u_id' => $u_id, 'title' => $title, 'cat' => $cat]);
    header("Location: dashboard.php?msg=Request Submitted");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request a Book</title>
</head>
<body>
    <h2>Request a New Book</h2>
    <a href="dashboard.php">Back to Dashboard</a><br><br>

    <form method="POST" action="">
        <label>Username:</label><br>
        <input type="text" value="<?php echo $_SESSION['username']; ?>" readonly><br><br>

        <label>Select Category:</label><br>
        <select name="category" id="category_select" onchange="fetchBooks(this.value)">
            <option value="">-- Select --</option>
            <option value="App Development">App Development</option>
            <option value="Mobile Development">Mobile Development</option>
            <option value="AI">AI</option>
        </select><br><br>

        <label>Select Book:</label><br>
        <select name="book_title" id="book_list" required>
            <option value="">Select category first</option>
        </select><br><br>

        <button type="submit" name="submit_request">Submit Book Request</button>
    </form>

    <script>
    // JavaScript function jo background mein API ko call karegi
    function fetchBooks(category) {
        if (!category) return;

        let bookList = document.getElementById('book_list');
        bookList.innerHTML = '<option>Loading books...</option>';

        let formData = new FormData();
        formData.append('category', category);

        // PHP handler ko request bhejna
        fetch('../api/fetch_books.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                bookList.innerHTML = '<option value="">' + data.error + '</option>';
            } else {
                bookList.innerHTML = '<option value="">-- Choose a Book --</option>';
                data.forEach(book => {
                    let option = document.createElement('option');
                    option.value = book.title;
                    option.text = book.title;
                    bookList.appendChild(option);
                });
            }
        });
    }
    </script>
</body>
</html>