export function renderArticleList(articles) {
    const articlesContainer = document.getElementById('article-list');
    const allNewsHeader = document.getElementById('all-news-header');
    articlesContainer.innerHTML = '';

    if (articles.length > 0) {
        allNewsHeader.style.display = 'block';
        articles.forEach(article => {
            const articleElement = `
                <li>
                    <span class="article-title">${article.title}</span>
                    <span class="article-description">${article.description}</span>
                    <a href="#" class="edit-article" data-id="${article.id}" data-title="${article.title}" data-description="${article.description}">
                        <img src="/assets/images/pencil.svg" alt="Edit">
                    </a>
                    <a href="#" class="delete-article" data-id="${article.id}">
                        <img src="/assets/images/close.svg" alt="Delete">
                    </a>
                </li>
            `;
            articlesContainer.insertAdjacentHTML('beforeend', articleElement);
        });
    } else {
        allNewsHeader.style.display = 'none';
    }
}

export function showMessage(message, color) {
    const messageDiv = document.getElementById('message');
    messageDiv.innerText = message;
    messageDiv.style.color = color;
}