import { fetchData } from './fetch.js';

const BASE_URL = '/api/articles';

export function getArticles() {
    return fetchData(BASE_URL);
}

export function createArticle(article) {
    return fetchData(BASE_URL, {
        method: 'POST',
        body: JSON.stringify(article),
    });
}

export function updateArticle(id, article) {
    return fetchData(`${BASE_URL}/${id}`, {
        method: 'PUT',
        body: JSON.stringify(article),
    });
}

export function deleteArticle(id) {
    return fetchData(`${BASE_URL}/${id}`, {
        method: 'DELETE',
    });
}