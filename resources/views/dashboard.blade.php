@extends('layouts.admin')
@section('content')
<div class="container">
    <h2 class="text-xl font-semibold mb-4">Dashboard</h2>
    
    {{-- Foydalanuvchilar statistikasi --}}
    <div id="usersChart" class="mb-10"></div>
    
    {{-- Petitions statistikasi --}}
    <div id="petitionsChart"></div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    // Userlar diagrammasi
    Highcharts.chart('usersChart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Oylik foydalanuvchilar'
        },
        xAxis: {
            categories: ['Yanvar', 'Fevral', 'Mart', 'Aprel', 'May', 'Iyun', 'Iyul', 'Avgust', 'Sentabr', 'Oktabr', 'Noyabr', 'Dekabr']
        },
        yAxis: {
            title: {
                text: 'Foydalanuvchilar soni'
            }
        },
        series: [{
            name: 'Foydalanuvchilar',
            data: [
            @for ($i = 1; $i <= 12; $i++)
            {{ $monthlyUsers[str_pad($i, 2, '0', STR_PAD_LEFT)] ?? 0 }},
            @endfor
            ]
            
        }]
    });
    
    // Petitions diagrammasi
    Highcharts.chart('petitionsChart', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Petitions bo‘linishi (kategoriya bo‘yicha)'
        },
        series: [{
            name: 'Petitions',
            colorByPoint: true,
            data: [
            @foreach ($petitionsByCategory as $item)
            {
                name: "{{ $item->category->name ?? 'Nomaʼlum' }}",
                y: {{ $item->total }}
            },
            @endforeach
            ]
        }]
    });
</script>
@endsection