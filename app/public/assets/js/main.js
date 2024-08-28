import { initializeArticlesList } from './components/articlesList.js';
import {logout} from "./api/logoutApi.js";

document.addEventListener('DOMContentLoaded', () => {
    initializeArticlesList();

    const logoutBtn = document.getElementById('logout-btn');

    if (logoutBtn) {
        logoutBtn.addEventListener('click', async (event) => {
            event.preventDefault();
            try {
                const response = await logout();
                if (response.message) {
                    window.location.href = '/login';
                }
            } catch (error) {
                console.error('Error during logout:', error);
            }
        });
    }
});