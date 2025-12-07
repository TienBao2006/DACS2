    <!DOCTYPE html>
<html>
<head>
    <title>Upload Ảnh</title>
</head>
<body>
    <h1>Upload Ảnh Từ Máy</h1>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form action="{{ route('upload.image') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <label>Chọn ảnh:</label><br>
        <input type="file" name="image" accept="image/*" required><br><br>
        <label >Nhập title</label>
        <input type="text" name="title" required><br><br>
        <label >Nhập content</label>
        <input type="text" name="content" required><br><br>

        <button type="submit">Upload</button>
</form>
    
    <table border="1" style="margin-top:20px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Image Name</th>
                
            </tr>
        </thead>
        <tbody>
           @foreach($posts as $post)
           
                <tr>
                    <td>{{ $post->postID }}</td> 
                    
                    <td>{{ $post->title }}</td>
                    
                    <td>{{ $post->content }}</td>
                    
                    <td><img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" width="100"></td>
                </tr>

                    @endforeach

        </tbody>
    </table>
    <script>
        const button = document.querySelector('button');
        button.addEventListener('click', () => {
            alert('Ảnh đã được tải lên thành công!');
            window.location.href = "{{ route('animation.img') }}";
        });
    </script>
   
</body>
</html>
