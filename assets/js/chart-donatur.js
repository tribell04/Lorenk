document.addEventListener('DOMContentLoaded', function() {
    fetch(base_url + 'user/get_donasi_growth')
        .then(response => response.json())
        .then(data => {
            createDonasiChart(data);
        })
        .catch(error => {
            console.error('Error fetching donasi data:', error);
            const dummyData = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                values: [5, 8, 10, 15, 12, 20, 18, 25, 22, 30, 28, 35]
            };
            createDonasiChart(dummyData);
        });
});

function createDonasiChart(data) {
    const ctx = document.getElementById('donasiChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Jumlah Transaksi Donasi',
                data: data.values,
                backgroundColor: 'rgba(78, 115, 223, 0.2)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true,
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        font: { size: 10 }
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Transaksi',
                        font: { size: 12 }
                    }
                },
                x: {
                    ticks: {
                        font: { size: 10 }
                    },
                    grid: { display: false }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        boxWidth: 15,
                        font: { size: 11 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' transaksi';
                        }
                    }
                }
            }
        }
    });
}
