// db.js
import Dexie from 'dexie';

export const db = new Dexie('locations');
db.version(1).stores({
    sites: '++id, name, age, &term_id',
});