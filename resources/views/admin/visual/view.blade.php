@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Visualizzazioni per l'appartamento</h1>

    <canvas id="viewsChart"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('viewsChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($months), // Passiamo i mesi dal controller
                    datasets: [{
                        label: 'Visualizzazioni Mensili',
                        data: @json($views),  // Passiamo i dati delle visualizzazioni
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</div>

@endsection

