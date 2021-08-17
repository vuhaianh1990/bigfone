<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
        <form action="{{ route('test') }}" method="post" enctype="multipart/form-data">
            @csrf
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">
        </form>

        <form  method="post" id='form_uid' enctype="multipart/form-data">
            <textarea class='text_input' rows='30'></textarea>
            <input type="button" value="scan" class="scan_uid">
        </form>
        <textarea class='text_output' rows='30'></textarea>
</body>
</html>