export class Translator {
    translations = {};

    set(key, value) {
        this.translations[key] = value;

        return this;
    }

    get(key) {
        return this.translations[key] ?? key;
    }
}
