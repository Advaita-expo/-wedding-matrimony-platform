// Simple JSON-based data storage (works without PHP/MySQL)
class DataStore {
    constructor() {
        this.storageKey = 'weddingCMS_data';
        this.data = this.loadData();
    }

    loadData() {
        const stored = localStorage.getItem(this.storageKey);
        return stored ? JSON.parse(stored) : this.initializeData();
    }

    initializeData() {
        return {
            blogPosts: [],
            services: [],
            gallery: [],
            contacts: [],
            lastPostId: 0,
            lastServiceId: 0,
            lastGalleryId: 0,
            lastContactId: 0
        };
    }

    saveData() {
        localStorage.setItem(this.storageKey, JSON.stringify(this.data));
    }

    // Blog Posts
    createBlogPost(post) {
        this.data.lastPostId++;
        const newPost = {
            id: this.data.lastPostId,
            ...post,
            created_at: new Date().toISOString(),
            updated_at: new Date().toISOString()
        };
        this.data.blogPosts.unshift(newPost);
        this.saveData();
        return newPost;
    }

    getBlogPosts() {
        return this.data.blogPosts;
    }

    getBlogPost(id) {
        return this.data.blogPosts.find(post => post.id === parseInt(id));
    }

    updateBlogPost(id, post) {
        const index = this.data.blogPosts.findIndex(p => p.id === parseInt(id));
        if (index !== -1) {
            this.data.blogPosts[index] = {
                ...this.data.blogPosts[index],
                ...post,
                updated_at: new Date().toISOString()
            };
            this.saveData();
            return this.data.blogPosts[index];
        }
        return null;
    }

    deleteBlogPost(id) {
        this.data.blogPosts = this.data.blogPosts.filter(p => p.id !== parseInt(id));
        this.saveData();
        return true;
    }

    // Services
    createService(service) {
        this.data.lastServiceId++;
        const newService = {
            id: this.data.lastServiceId,
            ...service,
            created_at: new Date().toISOString()
        };
        this.data.services.push(newService);
        this.saveData();
        return newService;
    }

    getServices() {
        return this.data.services;
    }

    updateService(id, service) {
        const index = this.data.services.findIndex(s => s.id === parseInt(id));
        if (index !== -1) {
            this.data.services[index] = { ...this.data.services[index], ...service };
            this.saveData();
            return this.data.services[index];
        }
        return null;
    }

    deleteService(id) {
        this.data.services = this.data.services.filter(s => s.id !== parseInt(id));
        this.saveData();
        return true;
    }

    // Gallery
    createGalleryImage(image) {
        this.data.lastGalleryId++;
        const newImage = {
            id: this.data.lastGalleryId,
            ...image,
            created_at: new Date().toISOString()
        };
        this.data.gallery.push(newImage);
        this.saveData();
        return newImage;
    }

    getGalleryImages() {
        return this.data.gallery;
    }

    updateGalleryImage(id, image) {
        const index = this.data.gallery.findIndex(g => g.id === parseInt(id));
        if (index !== -1) {
            this.data.gallery[index] = { ...this.data.gallery[index], ...image };
            this.saveData();
            return this.data.gallery[index];
        }
        return null;
    }

    deleteGalleryImage(id) {
        this.data.gallery = this.data.gallery.filter(g => g.id !== parseInt(id));
        this.saveData();
        return true;
    }

    // Contacts
    createContact(contact) {
        this.data.lastContactId++;
        const newContact = {
            id: this.data.lastContactId,
            ...contact,
            created_at: new Date().toISOString()
        };
        this.data.contacts.push(newContact);
        this.saveData();
        return newContact;
    }

    getContacts() {
        return this.data.contacts;
    }

    updateContact(id, contact) {
        const index = this.data.contacts.findIndex(c => c.id === parseInt(id));
        if (index !== -1) {
            this.data.contacts[index] = { ...this.data.contacts[index], ...contact };
            this.saveData();
            return this.data.contacts[index];
        }
        return null;
    }

    deleteContact(id) {
        this.data.contacts = this.data.contacts.filter(c => c.id !== parseInt(id));
        this.saveData();
        return true;
    }

    // Export data
    exportData() {
        return JSON.stringify(this.data, null, 2);
    }

    // Import data
    importData(jsonData) {
        try {
            this.data = JSON.parse(jsonData);
            this.saveData();
            return true;
        } catch (e) {
            console.error('Import failed:', e);
            return false;
        }
    }
}

// Create global instance
const cmsData = new DataStore();
