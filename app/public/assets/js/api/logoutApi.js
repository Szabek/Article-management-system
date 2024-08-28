import { fetchData } from './fetch.js';

const LOGOUT_URL = '/api/logout';

export function logout() {
    return fetchData(LOGOUT_URL, {
        method: 'POST',
    });
}