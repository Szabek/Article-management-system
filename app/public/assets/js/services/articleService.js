import { getArticles, createArticle, updateArticle, deleteArticle } from '../api/articlesApi.js';

export let articlesData = [];

export async function loadArticles() {
    articlesData = await getArticles();
    return articlesData.data;
}

export async function addArticle(article) {
    const newArticle = await createArticle(article);
    articlesData.data.push(newArticle);
    return newArticle;
}

export async function editArticle(id, article) {
    const updatedArticle = await updateArticle(id, article);
    const index = articlesData.data.findIndex(art => art.id === id);
    if (index !== -1) {
        articlesData.data[index] = updatedArticle;
    }
    return updatedArticle;
}

export async function removeArticle(id) {
    await deleteArticle(id);
    articlesData.data = articlesData.data.filter(art => art.id !== id);
}