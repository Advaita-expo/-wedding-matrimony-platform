// Clear all stored data
function clearAllData() {
    if (confirm('⚠️ This will DELETE all blog posts, services, and other data!\n\nAre you sure?')) {
        if (confirm('Double-check: Are you REALLY sure? This cannot be undone.')) {
            localStorage.removeItem('weddingCMS_data');
            alert('✓ All data cleared!');
            location.reload();
        }
    }
}

// Export data as JSON file
function exportData() {
    const data = localStorage.getItem('weddingCMS_data');
    if (!data) {
        alert('No data to export');
        return;
    }
    
    const element = document.createElement('a');
    element.setAttribute('href', 'data:text/json;charset=utf-8,' + encodeURIComponent(data));
    element.setAttribute('download', `wedding-cms-backup-${new Date().getTime()}.json`);
    element.style.display = 'none';
    document.body.appendChild(element);
    element.click();
    document.body.removeChild(element);
    alert('✓ Data exported successfully!');
}

// Import data from JSON file
function importData() {
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = '.json';
    fileInput.onchange = (e) => {
        const file = e.target.files[0];
        const reader = new FileReader();
        reader.onload = (event) => {
            try {
                const data = JSON.parse(event.target.result);
                localStorage.setItem('weddingCMS_data', JSON.stringify(data));
                alert('✓ Data imported successfully!');
                location.reload();
            } catch (error) {
                alert('Error importing data: ' + error.message);
            }
        };
        reader.readAsText(file);
    };
    fileInput.click();
}

// Get storage size info
function getStorageInfo() {
    let total = 0;
    for (let key in localStorage) {
        if (localStorage.hasOwnProperty(key)) {
            total += localStorage[key].length + key.length;
        }
    }
    const mb = (total / 1024 / 1024).toFixed(2);
    const percent = ((total / 5242880) * 100).toFixed(1); // 5MB limit
    alert(`Storage Used: ${mb} MB (${percent}% of 5MB limit)`);
}
