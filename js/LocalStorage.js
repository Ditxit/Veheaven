class LocalStorage {

    /*
    *   @param {String} key
    *   @param {Object} value
    */
    static set (key, value) {

        // Check the validity of key, value
        if (!key || !value) return;

        // Prepare value to store
        value = JSON.stringify(value);

        // Set key,value
        localStorage.setItem(key, value);

    }

    static unset (key) {

        localStorage.removeItem(key);

    }

    static has (key) {

        return localStorage.getItem(key) !== null;

    }

    static get (key) {

        return JSON.parse(localStorage.getItem(key));

    }

}