<!DOCTYPE html>
<html lang=en>

<head>
    <meta charset=utf-8>
    <meta http-equiv=X-UA-Compatible content="IE=edge">
    <meta name=viewport content="width=device-width,initial-scale=1">
    <link rel=icon href=/favicon.png> <meta name=robots content="noindex, nofollow, noarchive, nosnippet, noodp">
    <title>𝗦𝗧𝐈𝐈𝗠𝗘</title>
    <meta name="description" content="Social network for video games">
    <meta name="author" content="Ada">
    <link rel="stylesheet" href="/lib/bootstrap.min.css">
    <script src="/lib/jquery-3.4.1.min.js"></script>
    <script src="/lib/popper.min.js"></script>
    <script src="/lib/bootstrap.min.js"></script>
    <script src="/lib/fontawesome.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@700&display=swap" rel="stylesheet">
    <script src="/lib/twemoji.min.js"></script>
    <script src="/lib/typeahead.bundle.min.js"></script>
    <script src="/lib/emoji-button.min.js"></script>
    <script>
        $(function() {
            twemoji.parse(document.body)
        })

        window.addEventListener('DOMContentLoaded', () => {
            const btnInput = document.querySelector('.btn-emoji-input');
            const pickerInput = new EmojiButton({
                style: "twemoji",
                position: "auto-start",
                theme: "dark"
            });
            pickerInput.on('emoji', emoji => {
                document.querySelector('textarea').value += $(emoji).attr("alt");
            });
            btnInput.addEventListener('click', () => {
                pickerInput.togglePicker(document.querySelector(".navbar"))
            });

            const btnReact = document.querySelectorAll('.btn-emoji-react');
            const pickerReact = new EmojiButton({
                style: "twemoji",
                position: "auto-start",
                theme: "dark"
            });
            pickerReact.on('emoji', emoji => {
                console.log($(emoji).attr("alt"));
            });
            for (btn of btnReact) btn.addEventListener('click', () => {
                pickerReact.togglePicker(document.querySelector(".navbar"))
            });
        });
    </script>
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/typeahead.css" rel="stylesheet">
    <script src="/js/script.js"></script>
</head>