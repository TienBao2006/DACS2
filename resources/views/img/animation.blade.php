<!DOCTYPE html>
<html>
<head>
    <title>Ảnh động full screen</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body, html {
            width: 100%;
            height: 100%;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        .slider {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .slide {
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            animation: slideAnim 10s infinite alternate;
        }

        .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .slide-content {
            position: absolute;
            bottom: 50px;
            left: 50px;
            color: white;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
            animation: fadeIn 2s forwards;
            opacity: 0;
        }

        .slide-content h2 {
            font-size: 48px;
            background: linear-gradient(270deg, #ff0000, #00ff00, #0000ff, #ff0000);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientAnim 5s ease infinite;
        }

        .slide-content p {
            font-size: 24px;
            margin-top: 10px;
            background: linear-gradient(270deg, #ffff00, #ff00ff, #00ffff, #ffff00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientAnim 5s ease infinite;
            animation-delay: 2s;
        }

        @keyframes slideAnim {
            0% { transform: translateX(100%); }
            50% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes gradientAnim {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body>

<div class="slider">
    @if($posts)
    <div class="slide">
        <img src="{{ asset('storage/' . $posts->image) }}" alt="{{ $posts->title }}">
        <div class="slide-content">
            <h2>{{ $posts->title }}</h2>
            <p>{{ $posts->content }}</p>
        </div>
    </div>
    @else
    <p style="color:white; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);">Chưa có ảnh nào trong database.</p>
    @endif
</div>

</body>
</html>
