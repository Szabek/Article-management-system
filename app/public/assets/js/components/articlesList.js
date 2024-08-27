import {addArticle, editArticle, loadArticles, removeArticle} from '../services/articleService.js';
import {renderArticleList, showMessage} from '../utils/domUtils.js';

export function initializeArticlesList() {
    loadArticles()
        .then(renderArticleList)
        .then(initializeEventHandlers)
        .catch(error => showMessage('Error loading articles.', 'red'));
}

function initializeEventHandlers() {
    document.querySelectorAll('.edit-article').forEach(button => {
        const newButton = button.cloneNode(true);
        button.replaceWith(newButton);
        newButton.addEventListener('click', function (event) {
            event.preventDefault();
            enterEditMode(newButton.dataset.id, newButton.dataset.title, newButton.dataset.description);
        });
    });

    document.querySelectorAll('.delete-article').forEach(button => {
        const newButton = button.cloneNode(true);
        button.replaceWith(newButton);
        newButton.addEventListener('click', async function (event) {
            event.preventDefault();
            const articleId = newButton.dataset.id;
            await removeArticle(articleId)
                .then(initializeArticlesList);
        });
    });

    const form = document.getElementById('article-form');
    const newForm = form.cloneNode(true);
    form.replaceWith(newForm);

    newForm.addEventListener('submit', async function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        const article = {
            title: formData.get('title'),
            description: formData.get('description')
        };

        const method = this.dataset.method || 'POST';

        if (method === 'POST') {
            await addArticle(article);
            showMessage('Article created successfully!', 'green');
        } else if (method === 'PUT') {
            const articleId = this.action.split('/').pop();
            await editArticle(articleId, article);
            showMessage('Article updated successfully!', 'green');
        }

        this.reset();
        exitEditMode();
        initializeArticlesList();
    });

    const cancelEditButton = document.getElementById('cancel-edit-button');
    const newCancelEditButton = cancelEditButton.cloneNode(true);
    cancelEditButton.replaceWith(newCancelEditButton);

    newCancelEditButton.addEventListener('click', (event) => {
        event.preventDefault();
        exitEditMode();
    });
}

function enterEditMode(articleId, title, description) {
    document.getElementById('title').value = title;
    document.getElementById('description').value = description;

    const form = document.getElementById('article-form');
    form.action = `/api/articles/${articleId}`;
    form.dataset.method = 'PUT';

    document.querySelector('#form-header span').innerText = 'Edit News';
    document.getElementById('form-submit-button').innerText = 'Save';
    document.getElementById('cancel-edit-button').style.display = 'flex';
}

function exitEditMode() {
    const form = document.getElementById('article-form');
    form.reset();
    form.action = '/api/articles';
    form.dataset.method = 'POST';

    document.querySelector('#form-header span').innerText = 'Create News';
    document.getElementById('form-submit-button').innerText = 'Create';
    document.getElementById('cancel-edit-button').style.display = 'none';
}
