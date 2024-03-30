// Function to get IP address using a free API
function getIPAddress() {
    fetch('https://api64.ipify.org?format=json')
        .then(response => response.json())
        .then(data => {
            const ipAddress = data.ip;
            saveIPAddress(ipAddress);
        })
        .catch(error => console.error('Error fetching IP:', error));
}

// Function to send IP address to server
function saveIPAddress(ipAddress) {
    fetch('save_ip.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ ip: ipAddress }),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(data => console.log('IP saved:', data))
    .catch(error => console.error('Error saving IP:', error));
}

// Call the function to get IP address when the page loads
getIPAddress();
