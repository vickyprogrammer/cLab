class Api {
    /**
     * Make an API call
     * @param {string} url API url link
     * @param {string} method GET, POST, PUT, DELETE, etc.
     * @param {object} data Request body data
     * @returns {Promise<*>}
     */
    constructor(url, method, data = null) {
        return new Promise((resolve, reject) => {
            fetch(url, {
                method,
                cache: 'no-cache',
                body: data ? JSON.stringify(data) : null,
                headers: {
                    'Content-Type': 'application/json',
                },
            }).then(res => {
                if (res.ok && res.status < 400) {
                    res.json().then(resolve);
                } else {
                    res.json()
                        .then(error => reject(error.message))
                        .catch(() => {
                            res.text().then(reject);
                        });
                }
            }).catch(reject);
        });
    }
}