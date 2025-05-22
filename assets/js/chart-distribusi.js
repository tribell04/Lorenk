// File: chart-distribusi.js
// Fungsi untuk membuat chart distribusi dana program

document.addEventListener('DOMContentLoaded', function() {
    // Fetch data distribusi dana dari server
    fetch(base_url + 'user/get_distribusi_dana')
        .then(response => response.json())
        .then(data => {
            createDistribusiChart(data);
        })
        .catch(error => {
            console.error('Error fetching distribusi data:', error);
            // Tampilkan data dummy jika ada error
            const dummyData = {
                labels: ['Pendidikan', 'Kesehatan', 'Pangan', 'Infrastruktur'],
                values: [35, 25, 20, 20]
            };
            createDistribusiChart(dummyData);
        });
});

function createDistribusiChart(data) {
    const ctx = document.getElementById('distribusiChart').getContext('2d');
    
    // Warna untuk masing-masing kategori program
    const backgroundColors = [
        'rgba(255, 99, 132, 0.7)',   // Merah untuk Pendidikan
        'rgba(54, 162, 235, 0.7)',   // Biru untuk Kesehatan
        'rgba(255, 206, 86, 0.7)',   // Kuning untuk Pangan
        'rgba(75, 192, 192, 0.7)'    // Hijau untuk Infrastruktur
    ];
    
    // Buat chart distribusi dana
    const distribusiChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: data.labels,
            datasets: [{
                data: data.values,
                backgroundColor: backgroundColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false  // Legend dihilangkan karena sudah ada list di bawah chart
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return label + ': ' + percentage + '%';
                        }
                    }
                }
            }
        }
    });
}