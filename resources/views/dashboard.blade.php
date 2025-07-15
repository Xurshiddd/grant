@extends('layouts.admin')

@section('content')
<div class="container overflow-y-scroll max-w-full">
    <h2 class="text-xl font-semibold mb-4">Dashboard</h2>
    <a href="{{ route('students.export') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
        Export to Excel
    </a>
    
    {{-- Foydalanuvchilar: bakalavr vs magistr --}}
    <div id="educationChart" class="mb-10"></div>
    
    {{-- Petitions statistikasi (o‘zgarishsiz) --}}
    <div id="petitionsChart"></div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    /* ---------------- Education type chart ---------------- */
    Highcharts.chart('educationChart', {
        chart: { type: 'column' },
        title: { text: 'Foydalanuvchilar (Bakalavr/Magistr)' },
        xAxis: {
            categories: [
            @foreach (['Bakalavr' => 'Bakalavr', 'Magistr' => 'Magistr'] as $key => $label)
            "{{ $label }}",
            @endforeach
            ]
        },
        yAxis: { title: { text: 'Foydalanuvchilar soni' } },
        series: [{
            name: 'Foydalanuvchilar',
            data: [
            {{ $usersByEducation['Bakalavr'] ?? 0 }},
            {{ $usersByEducation['Magistr']  ?? 0 }}
            ]
        }]
    });
    
    /* ---------------- Petitions chart (o‘zgarishsiz) ---------------- */
    Highcharts.chart('petitionsChart', {
        chart: { type: 'pie' },
        title: { text: 'Yuklamalar bo‘linishi (mezonlar bo‘yicha)' },
        series: [{
            name: 'Fayllar',
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
