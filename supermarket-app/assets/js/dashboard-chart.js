Chart.register(ChartDataLabels);

document.addEventListener("DOMContentLoaded", () => {

    if (typeof Chart === "undefined") {
        console.error("Chart.js belum terload");
        return;
    }

    if (typeof productLabels === "undefined") {
        console.warn("Data produk belum dikirim dari PHP");
        return;
    }

    /* BAR CHART - STOK PRODUK */
    const stockCanvas = document.getElementById("stockChart");
    if (stockCanvas) {
        new Chart(stockCanvas, {
            type: "bar",
            data: {
                labels: productLabels,
                datasets: [{
                    label: "Jumlah Stok",
                    data: productStocks,
                    backgroundColor: "#4a6cf7"
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }

    /* PIE CHART - STATUS STOK */
    const statusCanvas = document.getElementById("statusChart");
        if (statusCanvas) {
            new Chart(statusCanvas, {
                type: "pie",
                data: {
                    labels: ["Available", "Out of Stock"],
                    datasets: [{
                        data: [availableCount, outOfStockCount],
                        backgroundColor: ["#2ecc71", "#e74c3c"]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        datalabels: {
                            color: '#fff',
                            font: {
                                weight: 'bold',
                                size: 14
                            },
                            formatter: (value, ctx) => {
                                const data = ctx.chart.data.datasets[0].data;
                                const total = data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return percentage + "%";
                            }
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }


    const categoryCanvas = document.getElementById('categoryChart');
        if (categoryCanvas && categoryLabels.length > 0) {
            new Chart(categoryCanvas, {
                type: 'pie',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryValues,
                        backgroundColor: [
                            '#4CAF50',
                            '#2196F3',
                            '#FFC107',
                            '#9C27B0',
                            '#FF5722',
                            '#009688'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        datalabels: {
                            color: '#fff',
                            font: {
                                weight: 'bold',
                                size: 13
                            },
                            formatter: (value, ctx) => {
                                const data = ctx.chart.data.datasets[0].data;
                                const total = data.reduce((a, b) => a + b, 0);
                                return ((value / total) * 100).toFixed(1) + "%";
                            }
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

});

