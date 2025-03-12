document.addEventListener('DOMContentLoaded', function () {
    const postsContainer = document.getElementById('posts-container');
    const addPostForm = document.getElementById('addPostForm');

    // Function to fetch and display posts from the server
    function loadPosts() {
        fetch('get_posts.php')
            .then(response => response.json())
            .then(posts => {
                postsContainer.innerHTML = '';
                posts.forEach(post => {
                    const postElement = document.createElement('div');
                    postElement.classList.add('post');
                    postElement.innerHTML = `
                        <h2>${post.title}</h2>
                        <p class="author">By ${post.author} on ${post.date}</p>
                        <div class="post-content">${post.content}</div>
                    `;
                    postsContainer.appendChild(postElement);
                });
            });
    }

    // Function to handle form submission (Add new post)
    addPostForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const title = document.getElementById('title').value;
        const content = document.getElementById('content').value;
        const author = document.getElementById('author').value;

        const formData = new FormData();
        formData.append('title', title);
        formData.append('content', content);
        formData.append('author', author);

        fetch('add_post.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);  // You can log it or show a message to the user
            loadPosts();  // Reload the posts
        })
        .catch(error => console.error('Error:', error));
    });

    // Load posts when the page is loaded
    loadPosts();
});
