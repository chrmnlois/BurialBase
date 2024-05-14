new DataTable('#example');

$(document).ready(function() {
    $('#yourDataTable').DataTable({
        "columnDefs": [
            {
                "targets": 0, // Assuming you want to apply this ordering to the first column
                "orderData": [0, 'asc'], // Sort this column
                "type": "custom", // Use a custom sorting function
                "render": function(data) {
                    return customOrder(data); // Use a function to determine the custom order
                }
            }
        ]
    });
});

function customOrder(data) {
    // Define a custom sorting function based on your desired ordering
    // Split the value (assuming it starts with 'A') into 'A' and the number
    let parts = data.match(/([A-Za-z]+)(\d+)/);
    if (parts && parts.length === 3) {
        let letter = parts[1]; // Extract the letter part
        let number = parseInt(parts[2]); // Extract the number part
        // Pad the number to ensure proper sorting (e.g., A1, A2, ..., A14)
        return letter + ('000' + number).slice(-3);
    }
    return data;
}