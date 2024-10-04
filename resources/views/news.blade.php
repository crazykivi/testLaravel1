<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новости</title>
</head>
<body>
    <header>
        <h1>Выбранный город: {{ $selectedCity ?? 'Не выбран' }}</h1>
    </header>
    <main>
        <h2>Список городов</h2>
        <ul>
            @foreach ($cities as $city)
                <li>
                    <a href="{{ url($city) }}" 
                       style="{{ $selectedCity === $city ? 'font-weight: bold;' : '' }}">
                        {{ ucfirst($city) }}
                    </a>
                </li>
            @endforeach
        </ul>
    </main>
</body>
</html>
