class Cookie {

    /*
    *   @param {String} key
    *   @param {Object} value
    *   @param Integer} expiry
    */
    static set (key, value, expiry = null) {

        // Check the validity of key, value
        if (!key || !value) return;

        // Prepare value to store
        value = JSON.stringify(value);

        // Convert the expiry to UTC date string if exist
        if (expiry) {

            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expiry = "; expires=" + date.toUTCString();

        } else {

            expiry = "";

        }

        document.cookie = key + "=" + (value || "")  + expiry + "; path=/";

    }

    static unset (key) {

        document.cookie = key +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';

    }

    static has (key) {

        const _cookies = document.cookie.split(';');

        for (let i = 0; i < _cookies.length; i++){

            const _cookie = _cookies[i].split('=');

            if (_cookie[0].trim() == key) return true;
        }

        return false;

    }

    static get (key) {

        const _cookies = document.cookie.split(';');

        for (let i = 0; i < _cookies.length; i++){

            const _cookie = _cookies[i].split('=');

            if (_cookie[0].trim() == key) return JSON.parse(_cookie[1]);
        }

        return null;

    }

}