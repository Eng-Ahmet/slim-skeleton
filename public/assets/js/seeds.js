// Function to run seeds and display results
function runSeeds() {
    // Show loader
    var loader = document.getElementById('loader');
    loader.style.display = 'block';
    $('#resultsContainer').empty(); // Clear previous results

    $.ajax({
        url: '/test-seeds', // The URL to send the POST request to
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            loader.style.display = 'none';

            if (response.message) {
                $('#resultsContainer').append('<div class="alert alert-success">' + response.message + '</div>');
            }

            var results = response.results;
            for (var seederName in results) {
                var result = results[seederName];
                var cardClass = result.return_value === 0 ? 'card-no-errors' : 'card-errors';
                var statusText = result.return_value === 0 ? 'Success' : 'Error';
                var details = result.stderr ? '<pre>' + result.stderr + '</pre>' : '<pre>No errors</pre>';

                var cardHTML = `
                <div class="card mb-3 ${cardClass}">
                    <div class="card-header">
                        Seeder: ${seederName} (${statusText})
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Details</h5>
                        ${details}
                        <h5 class="card-title">Standard Output</h5>
                        <pre>${result.stdout}</pre>
                    </div>
                </div>
            `;

                $('#resultsContainer').append(cardHTML);
            }
        },
        error: function () {
            $('#loader').hide();
            $('#resultsContainer').append('<div class="alert alert-danger">Failed to run seeds.</div>');
        }
    });
}

// Run seeds on button click
$('#runSeedBtn').on('click', function () {
    runSeeds();
});

//Optionally, you can run seeds on page load
$(document).ready(function () {
    runSeeds();
});